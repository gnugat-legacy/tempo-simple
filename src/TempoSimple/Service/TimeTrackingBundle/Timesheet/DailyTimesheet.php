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
     * @param string $day Format: 'Y-m-d' (e.g. '1989-01-25')
     *
     * @return array
     */
    public function find($day)
    {
        $tasks = array();

        $timeCards = $this->timeCardRepository->findForDay($day);
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
