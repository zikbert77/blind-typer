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