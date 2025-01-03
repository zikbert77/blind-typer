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

    public function selectRandomText(Request $request, int $language, int $duration = 1): ?Texts
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

        $previousText = $request->getSession()->get('previousText');
        $response = $this->selectText($minWordsLimit, $maxWordsLimit, $language, $previousText ?? []);
        if (is_null($response)) {
            $request->getSession()->set('previousText', []);
            $previousText = $request->getSession()->get('previousText');
            $response = $this->selectText($minWordsLimit, $maxWordsLimit, $language, $previousText ?? []);
        }

        return $response;
    }

    private function selectText(int $minWordsLimit, int $maxWordsLimit, int $language, array $exceptOf)
    {
        $qb = $this->createQueryBuilder('t');

        if (!empty($exceptOf)) {
            $qb->where($qb->expr()->notIn('t.id', $exceptOf));
        }

        $qb->andWhere('t.isChecked = :isChecked');
        $qb->setParameter('isChecked', Texts::IS_CHECKED);
        $qb->andWhere('t.language = :language');
        $qb->setParameter('language', $language);
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
