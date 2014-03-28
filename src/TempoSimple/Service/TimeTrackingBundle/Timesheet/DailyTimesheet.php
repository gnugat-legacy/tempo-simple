<?php

/*
 * This file is part of the TempoSimple project.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TempoSimple\Service\TimeTrackingBundle\Timesheet;

use TempoSimple\DataSource\DoctrineBundle\Entity\TimeCardRepository;
use TempoSimple\Service\TimeTrackingBundle\Query\DailyQuery;

class DailyTimesheet
{
    /** @var TimeCardRepository */
    private $timeCardRepository;

    /**
     * @param TimeCardRepository $timeCardRepository
     */
    public function __construct(TimeCardRepository $timeCardRepository)
    {
        $this->timeCardRepository = $timeCardRepository;
    }

    /**
     * @param DailyQuery $dailyQuery
     *
     * @return array
     */
    public function match(DailyQuery $dailyQuery)
    {
        $tasks = array();

        $timeCards = $this->timeCardRepository->findForDay($dailyQuery->getDay());
        foreach ($timeCards as $timeCard) {
            $task = $timeCard->getTaskTitle();
            if (!isset($tasks[$task])) {
                $tasks[$task] = array();
            }

            $description = $timeCard->getDescription();
            if (!in_array($description, $tasks[$task])) {
                $tasks[$task][] = $description;
            }
        }

        return $tasks;
    }
}
