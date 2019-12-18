<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Courses;
use App\Entity\CoursesHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * @method CoursesHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method CoursesHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method CoursesHistory[]    findAll()
 * @method CoursesHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoursesHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CoursesHistory::class);
    }

    /**
     * @param User $user
     * @param int $limit
     * @return array
     */
    public function getDataForChart(User $user, $limit = 10): array
    {
        $history = $this->_em->getRepository(CoursesHistory::class)->findBy(
            ['user' => $user],
            ['createdAt' => 'DESC'],
            $limit
        );

        $response = [];
        /** @var CoursesHistory $testHistory */
        foreach ($history as $courseHistory) {
            $response['wpm'][] = $courseHistory->getWordsPerMinute();
            $response['cpm'][] = $courseHistory->getCharsPerMinute();
            $response['accuracy'][] = $courseHistory->getAccuracy();
            $response['datetime'][] = $courseHistory->getCreatedAt()->format('Y-m-d');
        }

        $response['wpm'] = array_reverse($response['wpm']);
        $response['cpm'] = array_reverse($response['cpm']);
        $response['accuracy'] = array_reverse($response['accuracy']);
        $response['datetime'] = array_reverse($response['datetime']);

        return $response;
    }

    /**
     * @param User|null $user
     * @param Courses $course
     * @param int $wpm
     * @param int $cpm
     * @param int $accuracy
     * @return array
     */
    public function save(?User $user, Courses $course, int $wpm, int $cpm, int $accuracy): array
    {
        try {
            $courseHistory = new CoursesHistory();
            $courseHistory->setUser($user);
            $courseHistory->setCourse($course);
            $courseHistory->setWordsPerMinute($wpm);
            $courseHistory->setCharsPerMinute($cpm);
            $courseHistory->setAccuracy($accuracy);
            $courseHistory->setCreatedAt(new \DateTime());

            $this->_em->persist($courseHistory);

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