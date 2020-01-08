<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\LiqpaySubscriptions;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * @method LiqpaySubscriptions|null find($id, $lockMode = null, $lockVersion = null)
 * @method LiqpaySubscriptions|null findOneBy(array $criteria, array $orderBy = null)
 * @method LiqpaySubscriptions[]    findAll()
 * @method LiqpaySubscriptions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LiqPaySubscriptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LiqpaySubscriptions::class);
    }

    public function create(User $user, string $orderId): bool
    {
        $liqPaySubscription = new LiqpaySubscriptions();
        $liqPaySubscription->setUser($user);
        $liqPaySubscription->setOrderId($orderId);
        $liqPaySubscription->setStatus(LiqpaySubscriptions::STATUS_CREATED_REQUEST);
        $liqPaySubscription->setCreatedAt(new \DateTime());

        $this->_em->persist($liqPaySubscription);
        $this->_em->flush();

        return true;
    }

    public function subscribe(array $data): array
    {
        try {
            /** @var LiqpaySubscriptions $liqPaySubscription */
            $liqPaySubscription = $this->getLiqPaySubscription($data['order_id']);

            $liqPaySubscription->setStatus(LiqpaySubscriptions::STATUS_SUBSCRIBED);
            if (strlen($data['end_date']) > 10) {
                $data['end_date'] = substr($data['end_date'], 0, 10);
            }

            $endSubscriptionDate = new \DateTime();
            $endSubscriptionDate->setTimestamp($data['end_date']);
            $endSubscriptionDate->add(new \DateInterval('P1M'));

            $liqPaySubscription->setExpiredAt($endSubscriptionDate);

            $user = $liqPaySubscription->getUser();
            $user->setIsPremium(User::IS_PREMIUM);

            $this->_em->persist($liqPaySubscription);
            $this->_em->persist($user);
            $this->_em->flush();

            return [
                'status' => true,
                'error' => ''
            ];
        } catch (\Exception $exception) {
            return [
                'status' => false,
                'error' => $exception->getMessage()
            ];
        }
    }

    public function unsubscribe(array $data, LiqpaySubscriptions $liqPaySubscription = null): array
    {
        try {
            /** @var LiqpaySubscriptions $liqPaySubscription */
            if (empty($liqPaySubscription)) {
                $liqPaySubscription = $this->getLiqPaySubscription($data['order_id']);
            }

            $liqPaySubscription->setStatus(LiqpaySubscriptions::STATUS_UNSUBSCRIBED);
            $liqPaySubscription->setExpiredAt(new \DateTime("yesterday"));

            //check here if user has another future subscription to prevent issue when unsubscribe request fall after
            //next mont subscription
            $user = $liqPaySubscription->getUser();
            if (empty($this->findNextSubscriptionForUser($user, $liqPaySubscription))) {
                $user->setIsPremium(User::IS_NOT_PREMIUM);
                $this->_em->persist($user);
            }

            $this->_em->persist($liqPaySubscription);
            $this->_em->flush();

            return [
                'status' => true,
                'error' => ''
            ];
        } catch (\Exception $exception) {
            return [
                'status' => false,
                'error' => $exception->getMessage()
            ];
        }
    }

    public function findExpired(): array
    {
        $qb = $this->createQueryBuilder('ls')
            ->where('ls.status != :status')
            ->andWhere('ls.expiredAt < :expiredAt');

        $result = $qb->getQuery()->execute([
            'status' => LiqpaySubscriptions::STATUS_UNSUBSCRIBED,
            'expiredAt' => (new \DateTime())->format('Y-m-d H:i:s')
        ]);

        return $result;
    }

    public function findNextSubscriptionForUser(User $user, LiqpaySubscriptions $subscription): array
    {
        $qb = $this->createQueryBuilder('ls')
            ->where('ls.status = :status')
            ->andWhere('ls.id != :id')
            ->andWhere('ls.expiredAt > :expiredAt')
            ->andWhere('ls.user = :user')
        ;

        $result = $qb->getQuery()->execute([
            'id' => $subscription->getId(),
            'status' => LiqpaySubscriptions::STATUS_SUBSCRIBED,
            'expiredAt' => (new \DateTime())->format('Y-m-d H:i:s'),
            'user' => $user
        ]);

        return $result;
    }

    public function findActiveSubscriptionForUser(User $user): ?LiqpaySubscriptions
    {
        $qb = $this->createQueryBuilder('ls')
            ->where('ls.status = :status')
            ->andWhere('ls.expiredAt > :expiredAt')
            ->andWhere('ls.user = :user')
        ;

        $qb->setParameters([
            'status' => LiqpaySubscriptions::STATUS_SUBSCRIBED,
            'expiredAt' => (new \DateTime())->format('Y-m-d H:i:s'),
            'user' => $user
        ]);

        $result = $qb->getQuery()->getOneOrNullResult();

        return $result;
    }

    /**
     * @param $order_id
     * @return object|null
     * @throws \Exception
     */
    private function getLiqPaySubscription($order_id): ?LiqpaySubscriptions
    {
        $liqPaySubscription = $this->_em->getRepository(LiqpaySubscriptions::class)->findOneBy([
            'orderId' => $order_id
        ]);

        if (empty($liqPaySubscription)) {
            throw new \Exception("No active subscription for order: $order_id");
        }

        return $liqPaySubscription;
    }
}