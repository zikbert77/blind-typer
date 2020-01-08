<?php

namespace App\Controller;

use App\Entity\LiqpaySubscriptions;
use App\Entity\User;
use App\Component\Logger;
use App\Component\LiqPay\LiqPay;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

const LIQ_PAY_SUCCESS_STATUSES = [
    'success', 'subscribed'
];

const LIQ_PAY_STATUS_SUBSCRIBE = 'subscribed';
const LIQ_PAY_STATUS_UNSUBSCRIBE = 'unsubscribed';

/**
 * @Route("/liqpay")
 */
class LiqPayController extends AbstractController
{
    private $public_key = 'sandbox_i32542018887';
    private $private_key = 'sandbox_d2G649bGh32sQmY6tc2hcaeWzhgGQuzzXmGeeLXB';

    /**
     * @Route("/subscription", name="liqpay_subscription", methods={"GET"})
     */
    public function subscription(): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        if (empty($user) || is_string($user) || $user->getIsPremium()) {
            return $this->redirectToRoute('index');
        }

        $orderId = md5(uniqid(null, true));
        
        $liqPay = new LiqPay($this->public_key, $this->private_key);
        $data = [
            'action'                => 'subscribe',
            'subscribe_periodicity' => 'month',
            'subscribe_date_start'  => (new \DateTime('now + 1day'))->format('Y-m-d H:i:s'),
            'amount'                => '3.99',
            'currency'              => 'USD',
            'description'           => 'BlindTyper premium subscription',
            'order_id'              => $orderId,
            'version'               => '3',
            'language'              => 'en',
            'result_url'            => $this->generateUrl('liqpay_subscription_result', ['orderId' => $orderId], UrlGeneratorInterface::ABSOLUTE_URL),
            'server_url'            => $this->generateUrl('liqpay_subscription_callback', ['orderId' => $orderId], UrlGeneratorInterface::ABSOLUTE_URL),
        ];
        $html = $liqPay->cnb_form($data);

        if (!$this->getDoctrine()->getRepository(LiqpaySubscriptions::class)->create(
            $user, $orderId
        )) {
            throw new \Exception("Couldn't create new subscription");
        }

        return $this->render('liqpay/subscription.html.twig', [
            'html' => $html
        ]);
    }

    /**
     * @Route("/subscription/unsubscribe", name="liqpay_unsubscribe", methods={"GET"})
     */
    public function unsubscribe(): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        if (empty($user) || is_string($user) || !$user->getIsPremium()) {
            return $this->redirectToRoute('index');
        }

        $subscription = $this->getDoctrine()->getRepository(LiqpaySubscriptions::class)->findActiveSubscriptionForUser($user);
        if (empty($subscription)) {
            throw new \Exception("Couldn't find active subscription for user {$user->getId()}");
        }
        
        $liqPay = new LiqPay($this->public_key, $this->private_key);
        $data = [
            'action'        => 'unsubscribe',
            'version'       => '3',
            'order_id'      => $subscription->getOrderId()
        ];
        $res = $liqPay->api("request", $data);

        Logger::log('subscription_unsubscribe', [
            'request' => $data,
            'response' => $res,
        ]);
        
        if ($res->result == 'ok' && $res->status == LIQ_PAY_STATUS_UNSUBSCRIBE) {
            $unsubscriptionResult = $this->getDoctrine()->getRepository(LiqpaySubscriptions::class)->unsubscribe([], $subscription);
            if ($unsubscriptionResult['status']) {
                return $this->render('liqpay/result.html.twig', [
                    'status' => 'unsubscribed'
                ]);
            } else {
                throw new \Exception($unsubscriptionResult['error']);
            }
        }

        return $this->redirectToRoute('index');
    }

    /**
     * @Route("/result", name="liqpay_subscription_result")
     *
     * @param Request $request
     * @return Response
     */
    public function result(Request $request)
    {
        Logger::log('subscription_result', [
            'get' => $request->query->all(),
            'post' => $request->request->all(),
        ]);

        $status = 'waiting';
        if (!empty($request->get('orderId'))) {
            /** @var LiqpaySubscriptions $subscription */
            $subscription = $this->getDoctrine()->getRepository(LiqpaySubscriptions::class)->findOneByOrderId($request->get('orderId'));
            if (!empty($subscription)) {
                if ($subscription->getStatus() == LiqpaySubscriptions::STATUS_SUBSCRIBED) {
                    $status = 'subscribed';
                }
            } else {
                $status = 'undefined';
            }
        }

        return $this->render('liqpay/result.html.twig', [
            'status' => $status
        ]);
    }

    /**
     * @Route("/callback", name="liqpay_subscription_callback")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function callback(Request $request)
    {
        try {
            $callbackVerification = $this->callbackVerification(
                $request->request->get('data'),
                $request->request->get('signature')
            );
            if (!$callbackVerification) {
                throw new \Exception("Callback verification failed");
            }

            $parsedData = json_decode(base64_decode($request->request->get('data')), true);
            if (empty($parsedData) || !$parsedData) {
                throw new \Exception("Couldn't parse data");
            }

            if (in_array($parsedData['status'], LIQ_PAY_SUCCESS_STATUSES)) {
                $result = $this->getDoctrine()->getRepository(LiqpaySubscriptions::class)->subscribe(
                    $parsedData
                );

                if (!$result['status']) {
                    throw new \Exception($result['error']);
                }
            } elseif ($parsedData['status'] == LIQ_PAY_STATUS_UNSUBSCRIBE) {
                $result = $this->getDoctrine()->getRepository(LiqpaySubscriptions::class)->unsubscribe(
                    $parsedData
                );

                if (!$result['status']) {
                    throw new \Exception($result['error']);
                }
            } else {
                throw new \Exception("Unknown status");
            }

            Logger::log('subscription_callback', [
                'status' => 'success',
                'get' => $request->query->all(),
                'post' => $request->request->all(),
                'callbackVerification' => $callbackVerification,
                'parsedData' => $parsedData
            ]);
        } catch (\Exception $exception) {
            Logger::log('subscription_callback', [
                'status' => 'fail',
                'get' => $request->query->all(),
                'post' => $request->request->all(),
                'error' => $exception->getMessage()
            ]);

            return new JsonResponse([
                'status' => 'failed',
                'error' => $exception->getMessage()
            ], 500);
        }

        return new JsonResponse([
            'status' => 'success'
        ]);
    }

    /**
     * @Route("/checkStatus", name="liqpay_subscription_check_status")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function checkStatus(Request $request)
    {
        $status = (new LiqPay($this->public_key, $this->private_key))->api("request", [
            'action'        => 'status',
            'version'       => '3',
            'order_id'      => $request->get('order_id')
        ]);

        return new JsonResponse([
            'status' => $status
        ]);
    }

    /**
     * @param string|null $data
     * @param string|null $signature
     * @return bool
     */
    private function callbackVerification(?string $data, ?string $signature): bool
    {
        if (empty($data) || empty($signature)) {
            return false;
        }

        $sign = base64_encode(sha1(
            $this->private_key .
            $data .
            $this->private_key
            , 1 ));

        return $sign === $signature;
    }
}