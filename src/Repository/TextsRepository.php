<?php

namespace App\Repository;

use App\Entity\Texts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Texts|null find($id, $lockMode = null, $lockVersion = null)
 * @method Texts|null findOneBy(array $criteria, array $orderBy = null)
 * @method Texts[]    findAll()
 * @method Texts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TextsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Texts::class);
    }

    public function selectRandomText($duration = 1): Texts
    {
        $minWordsLimit = 120;
        $maxWordsLimit = 360;

        $qb = $this->createQueryBuilder('t');
        switch ($duration) {
            case 3:
                $minWordsLimit = 360;
                $maxWordsLimit = 600;
                break;
            case 5:
                $minWordsLimit = 600;
                $maxWordsLimit = 2400;
                break;
        }

        $qb->andWhere('t.wordsCount > :min_words_limit');
        $qb->setParameter('min_words_limit', $minWordsLimit);
        $qb->andWhere('t.wordsCount <= :max_words_limit');
        $qb->setParameter('max_words_limit', $maxWordsLimit);

//        $qb->orderBy('t.id', 'RAND()');
        $qb->setMaxResults(1);

        return $qb->getQuery()->getOneOrNullResult();
    }
}
