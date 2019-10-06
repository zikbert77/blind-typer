<?php

namespace App\Repository;

use App\Entity\TestsHistory;
use App\Entity\Texts;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query\ResultSetMapping;

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
    public function getDataForChart(User $user): array
    {
        $history = $this->_em->getRepository(TestsHistory::class)->findBy(
            ['user' => $user],
            ['createdAt' => 'DESC'],
            10
        );

        $response = [];
        /** @var TestsHistory $testHistory */
        foreach ($history as $testHistory) {
            $response['wpm'][] = $testHistory->getWordsPerMinute();
            $response['cpm'][] = $testHistory->getCharsPerMinute();
            $response['accuracy'][] = $testHistory->getAccuracy();
            $response['datetime'][] = $testHistory->getCreatedAt();
        }

        $response['wpm'] = array_reverse($response['wpm']);
        $response['cpm'] = array_reverse($response['cpm']);
        $response['accuracy'] = array_reverse($response['accuracy']);
        $response['datetime'] = array_reverse($response['datetime']);

        return $response;
    }

    public function getForPeriod(\DateTime $startDate, \DateTime $endDate)
    {
        $periodStatistic = $this->createQueryBuilder('th')
            ->select('count(th.id) as count, DATE(th.createdAt) as date')
            ->where('th.createdAt >= :startDate')
            ->andWhere('th.createdAt <= :endDate')
            ->setParameters([
                'startDate' => $startDate->format('Y-m-d'),
                'endDate' => $endDate->format('Y-m-d'),
            ])
            ->groupBy('date')
            ->getQuery()
            ->getResult();
        
        $dailyStatistic = [];
        foreach ($periodStatistic as $daily) {
            $dailyStatistic['count'][] = $daily['count'];
            $dailyStatistic['date'][] = $daily['date'];
        }
        
        return $dailyStatistic;
    }

    /**
     * @param string|User $user
     * @return mixed|object|null
     */
    public function getLast($user)
    {
        if ($user instanceof User) {
            $history = $this->_em->getRepository(TestsHistory::class)->findBy(
                ['user' => $user],
                ['id' => 'DESC'],
                11
            );

            return $history[0] ?? null;
        }

        return null;
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