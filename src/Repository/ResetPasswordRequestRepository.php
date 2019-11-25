<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\ORMException;
use App\Entity\ResetPasswordRequests;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class ResetPasswordRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResetPasswordRequests::class);
    }

    public function createForUser(User $user): ?ResetPasswordRequests
    {
        try {
            $today = new \DateTime("now");
            $expireDate = new \DateTime("now + ". ResetPasswordRequests::HOURS_AVAILABLE ." hours");

            $resetPasswordRequest = $this->findValidRequestByUser($user, $today);
            if (empty($resetPasswordRequest)) {
                $hash = md5(uniqid('', true) . microtime(true));

                $resetPasswordRequest = new ResetPasswordRequests();
                $resetPasswordRequest->setUser($user);
                $resetPasswordRequest->setStatus(ResetPasswordRequests::STATUS_UNUSED);
                $resetPasswordRequest->setHash($hash);
                $resetPasswordRequest->setCreatedAt($today);
                $resetPasswordRequest->setValidTo($expireDate);
                $resetPasswordRequest->setUpdatedAt($today);

                $this->_em->persist($resetPasswordRequest);
                $this->_em->flush();
            }

            return $resetPasswordRequest;
        } catch (ORMException $exception) {
            //Log exceptions here
            echo '<pre>';
            var_dump($exception->getMessage());
            echo '</pre>';
            exit;
        }

        return null;
    }
    
    
    public function findValidRequestByUser(User $user, \DateTime $validTo): ?ResetPasswordRequests
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT * FROM reset_password_requests WHERE user_id = ? AND status = ? AND valid_to > ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $user->getId());
        $stmt->bindValue(2, ResetPasswordRequests::STATUS_UNUSED);
        $stmt->bindValue(3, $validTo->format('Y-m-d H:i:s'));
        $stmt->execute();

        $result = $stmt->fetch();
        if (!empty($result)) {
            return $this->find($result['id']);
        }

        return null;
    }

    public function findValidRequestByHash($hash)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.hash = :hash')
            ->setParameter('hash', $hash)
            ->andWhere('DATE(r.validTo) < :validTo')
            ->setParameter('validTo', (new \DateTime("now"))->format('Y-m-d H:i:s'))
            ->andWhere('r.status = :status')
            ->setParameter('status', ResetPasswordRequests::STATUS_UNUSED)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

}