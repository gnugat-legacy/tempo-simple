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
     * @param string $date Format: 'Y-m-d' (e.g. '2014-01-23')
     *
     * @return array of TimeCard
     */
    public function findForDate($date)
    {
        $query = $this->createQueryBuilder('t')
            ->where('t.date = :date')

            ->orderBy('t.projectName', 'ASC')
            ->orderBy('t.taskTitle', 'ASC')

            ->setParameter('date', $date)

            ->getQuery()
        ;

        return $query->getResult();
    }

    /** @return array of TimeCard */
    public function findForLastWeek()
    {
        $lastWeek = array();
        $lastWeek[] = date('Y-m-d', strtotime('monday last week'));
        $lastWeek[] = date('Y-m-d', strtotime('tuesday last week'));
        $lastWeek[] = date('Y-m-d', strtotime('wednesday last week'));
        $lastWeek[] = date('Y-m-d', strtotime('thursday last week'));
        $lastWeek[] = date('Y-m-d', strtotime('friday last week'));

        $query = $this->createQueryBuilder('t')
            ->where('t.date IN (:lastWeek)')

            ->orderBy('t.projectName', 'ASC')
            ->orderBy('t.taskTitle', 'ASC')

            ->setParameter('lastWeek', $lastWeek)

            ->getQuery()
        ;

        return $query->getResult();
    }

    /**
     * @param string $month   Format: 'Y-m' (e.g. '2014-01')
     * @param string $project
     *
     * @return array of TimeCard
     */
    public function findBillable($month, $project)
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

    /** @return TimeCard */
    public function findLastOne()
    {
        $today = date('Y-m-d');
        $query = $this->createQueryBuilder('t')
            ->where('t.date = :today')

            ->orderBy('t.endHour', 'DESC')

            ->setParameter('today', $today)

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
