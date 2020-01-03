<?php

namespace App\Controller;

use App\Component\LiqPay\LiqPay;
use App\Component\Logger;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @Route("/liqpay")
 */
class LiqPayController extends AbstractController
{
    /**
     * @Route("/subscription", name="liqpay_subscription", methods={"GET"})
     */
    public function subscription(): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        if (empty($user) || is_string($user) || $user->getIsPremium()) {
            //fail
            echo "<pre>";
            var_dump("fail");
            echo "</pre>";
            exit;
        }

        $orderId = md5(uniqid(null, true));
        
        $liqPay = new LiqPay('sandbox_i32542018887', 'sandbox_d2G649bGh32sQmY6tc2hcaeWzhgGQuzzXmGeeLXB');
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
            'server_url'            => $this->generateUrl('liqpay_subscription_server_url', ['orderId' => $orderId], UrlGeneratorInterface::ABSOLUTE_URL),
        ];
        $html = $liqPay->cnb_form($data);

        //todo: store record of subscription in the db

        return $this->render('liqpay/subscription.html.twig', [
            'html' => $html
        ]);
    }

    /**
     * @Route("/unsubscribe", name="liqpay_unsubscribe", methods={"GET"})
     */
    public function unsubscribe()
    {
        //todo: implement unsubscribe functionality
    }


    /**
     * @Route("/result", name="liqpay_subscription_result")
     */
    public function result(Request $request)
    {
        //todo: log response for preventing loose
        Logger::log('subscription_result', [
            'get' => $request->query->all(),
            'post' => $request->request->all(),
        ]);

        echo "<pre>";
        var_dump($request->query->all());
        var_dump($request->request->all());
        echo "</pre>";
        exit;
    }

    /**
     * @Route("/serverUrl", name="liqpay_subscription_server_url")
     */
    public function serverUrl(Request $request)
    {
        //todo: log response for preventing loose
        Logger::log('subscription_server', [
            'get' => $request->query->all(),
            'post' => $request->request->all(),
        ]);
        echo "<pre>";
        var_dump($request->query->all());
        var_dump($request->request->all());
        echo "</pre>";
        exit;
    }
}