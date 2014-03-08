<?php

/*
 * This file is part of the TempoSimple project.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TempoSimple\DataSource\DoctrineBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * A wrapper for SQL queries against the TimeCard table.
 *
 * Note:
 *
 * + day format: 'Y-m-d' (e.g. '1989-01-25')
 * + month format: 'Y-m' (e.g. '1989-01')
 */
class TimeCardRepository extends EntityRepository
{
    /**
     * @param TimeCard $timeCard
     *
     * @return TimeCard
     */
    public function insert(TimeCard $timeCard)
    {
        $this->getEntityManager()->persist($timeCard);
        $this->getEntityManager()->flush();

        return $timeCard;
    }

    /**
     * @param string $day
     *
     * @return array of TimeCard
     */
    public function findForDay($day)
    {
        return $this->findForDays(array($day));
    }

    /**
     * @param array $days
     *
     * @return array of TimeCard
     */
    public function findForDays(array $days)
    {
        $query = $this->createQueryBuilder('t')
            ->where('t.date IN (:days)')

            ->orderBy('t.projectName', 'ASC')
            ->orderBy('t.taskTitle', 'ASC')

            ->setParameter('days', $days)

            ->getQuery()
        ;

        return $query->getResult();
    }

    /**
     * @param string $month
     * @param string $project
     *
     * @return array of TimeCard
     */
    public function findForMonthAndProject($month, $project)
    {
        $monthExpr = $month.'-%';

        $query = $this->createQueryBuilder('t')
            ->where('t.date LIKE :monthExpr')
            ->andWhere('t.projectName = :project')

            ->orderBy('t.projectName', 'ASC')
            ->orderBy('t.taskTitle', 'ASC')

            ->setParameter('monthExpr', $monthExpr)
            ->setParameter('project', $project)

            ->getQuery()
        ;

        return $query->getResult();
    }

    /**
     * @param string $month
     *
     * @return array of TimeCard
     */
    public function findForMonth($month)
    {
        $monthExpr = $month.'-%';

        $query = $this->createQueryBuilder('t')
            ->where('t.date LIKE :monthExpr')

            ->orderBy('t.date', 'ASC')

            ->setParameter('monthExpr', $monthExpr)

            ->getQuery()
        ;

        return $query->getResult();
    }

    /**
     * @param string $day
     *
     * @return TimeCard
     */
    public function findLastOneForDay($day)
    {
        $query = $this->createQueryBuilder('t')
            ->where('t.date = :day')

            ->orderBy('t.endHour', 'DESC')

            ->setParameter('day', $day)

            ->setMaxResults(1)

            ->getQuery()
        ;

        $timeCards = $query->getResult();
        if (empty($timeCards)) {
            return '09:00';
        }
        $endHour = $timeCards[0]->getEndHour();
        if ('12:00' === $endHour) {
            return '13:00';
        }

        return $endHour;
    }
}
