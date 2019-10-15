<?php

namespace App\Repository;

use App\Entity\Texts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

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

    public function selectRandomText(Request $request, int $duration = 1): Texts
    {
        $minWordsLimit = 120;
        $maxWordsLimit = 600;
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

        $previousPassedTests = $request->getSession()->get('previousPassedTests');
        $response = $this->selectText($minWordsLimit, $maxWordsLimit, $previousPassedTests ?? []);
        if (is_null($response)) {
            $request->getSession()->set('previousPassedTests', []);
            $previousPassedTests = $request->getSession()->get('previousPassedTests');
            $response = $this->selectText($minWordsLimit, $maxWordsLimit, $previousPassedTests ?? []);
        }

        return $response;
    }

    private function selectText(int $minWordsLimit, int $maxWordsLimit, array $exceptOf)
    {
        $qb = $this->createQueryBuilder('t');

        if (!empty($exceptOf)) {
            $qb->where($qb->expr()->notIn('t.id', $exceptOf));
        }

        $qb->andWhere('t.wordsCount > :min_words_limit');
        $qb->setParameter('min_words_limit', $minWordsLimit);
        $qb->andWhere('t.wordsCount <= :max_words_limit');
        $qb->setParameter('max_words_limit', $maxWordsLimit);

        $qb->addSelect('RAND() as HIDDEN rand')
            ->orderBy('rand');
        $qb->setMaxResults(1);

        return $qb->getQuery()->getOneOrNullResult();
    }
}
