<?php

namespace App\Repository;

use App\Entity\TestsHistory;
use App\Entity\Texts;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\ORMException;

/**
 * @method TestsHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method TestsHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method TestsHistory[]    findAll()
 * @method TestsHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TestsHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TestsHistory::class);
    }

    /**
     * @param User $user
     * @return array
     */
    public function getWpmDataForChart(User $user): array
    {
        $history = $this->_em->getRepository(TestsHistory::class)->findBy(
            ['user' => $user],
            ['id' => 'ASC'],
            10
        );

        $response = [];
        /** @var TestsHistory $testHistory */
        foreach ($history as $testHistory) {
            $response['wpm'][] = $testHistory->getWordsPerMinute();
            $response['cpm'][] = $testHistory->getCharsPerMinute();
            $response['datetime'][] = $testHistory->getCreatedAt();
        }

        return $response;
    }

    /**
     * @param User $user
     * @param Texts $text
     * @param int $testDuration
     * @param int $wpm
     * @param int $cpm
     * @param int $accuracy
     * @return array
     */
    public function save(User $user, Texts $text, int $testDuration, int $wpm, int $cpm, int $accuracy): array
    {
        try {
            $testHistory = new TestsHistory();
            $testHistory->setUser($user);
            $testHistory->setText($text);
            $testHistory->setTestDuration($testDuration);
            $testHistory->setWordsPerMinute($wpm);
            $testHistory->setCharsPerMinute($cpm);
            $testHistory->setAccuracy($accuracy);
            $testHistory->setCreatedAt(new \DateTime());

            $this->_em->persist($testHistory);

            $this->_em->flush();
        } catch (ORMException $exception) {
            return [
                'status' => 'fail',
                'error' => $exception->getMessage()
            ];
        } catch (\Exception $exception) {
            return [
                'status' => 'fail',
                'error' => $exception->getMessage()
            ];
        }

        return [
            'status' => 'success'
        ];
    }
}