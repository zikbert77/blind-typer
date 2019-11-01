<?php

namespace App\Repository;

use App\Entity\Courses;
use App\Entity\TestsHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TestsHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method TestsHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method TestsHistory[]    findAll()
 * @method TestsHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoursesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Courses::class);
    }

    public function getFormatted()
    {
        $courses = $this->_em->getRepository(Courses::class)->findAll();

        $response = [];
        /** @var Courses $course */
        foreach ($courses as $course) {
            $response[$course->getGroupId()][] = $course;
        }

        return $response;
    }
}