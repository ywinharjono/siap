<?php

/*
 * This file is part of the Sistim Informasi Antar Paroki (SIAP) project.
 *
 * (c) Anthonius Munthi <me@itstoni.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace SIAP\Reference\Services;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager;
use SIAP\Reference\Entity\Paroki;
use Symfony\Component\HttpFoundation\JsonResponse;

class SearchService
{
    /**
     * @var EntityManager
     */
    private $manager;

    /**
     * SearchService constructor.
     *
     * @param $manager
     */
    public function __construct(
        ObjectManager $manager
    ) {
        $this->manager = $manager;
    }

    /**
     * @param $terms
     *
     * @return JsonResponse
     */
    public function searchParoki($terms)
    {
        $terms   = strtolower($terms);
        $builder = $this->manager->createQueryBuilder();
        $expr    = $builder->expr();

        $builder
            ->select('p')
            ->from(Paroki::class, 'p')
            ->innerJoin('p.keuskupan', 'k')
            ->orWhere($expr->like($expr->lower('p.nama'), $expr->literal($terms.'%')))
            ->orWhere($expr->like($expr->lower('p.nama'), $expr->literal('%'.$terms)))
            ->orWhere($expr->like($expr->lower('p.nama'), $expr->literal('%'.$terms.'%')))
            ->orWhere($expr->like($expr->lower('p.namaGereja'), $expr->literal($terms.'%')))
            ->orWhere($expr->like($expr->lower('p.namaGereja'), $expr->literal('%'.$terms)))
            ->orWhere($expr->like($expr->lower('p.namaGereja'), $expr->literal('%'.$terms.'%')))
            ->setMaxResults(10)
            ->setFirstResult(0);

        return $builder->getQuery()->getResult(AbstractQuery::HYDRATE_OBJECT);
    }
}
