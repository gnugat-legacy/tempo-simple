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
use TempoSimple\Service\TimeBundle\Factory\DateFactory;

class WeeklyTimesheet
{
    /** @var DateFactory */
    private $dateFactory;

    /** @var TimeCardRepository */
    private $timeCardRepository;

    /**
     * @param DateFactory        $dateFactory
     * @param TimeCardRepository $timeCardRepository
     */
    public function __construct(DateFactory $dateFactory, TimeCardRepository $timeCardRepository)
    {
        $this->dateFactory = $dateFactory;
        $this->timeCardRepository = $timeCardRepository;
    }

    /** @return array */
    public function find()
    {
        $dates = $this->dateFactory->lastWorkingWeek();
        $lastWorkingWeek = array();
        foreach ($dates as $date) {
            $lastWorkingWeek[] = $date->getDay();
        }

        $projects = array();

        $timeCards = $this->timeCardRepository->findForDays($lastWorkingWeek);
        foreach ($timeCards as $timeCard) {
            $project = $timeCard->getProjectName();
            if (!isset($projects[$project])) {
                $projects[$project] = array();
            }

            $task = $timeCard->getTaskTitle();
            if (!isset($projects[$project][$task])) {
                $projects[$project][$task] = array();
            }

            $description = $timeCard->getDescription();
            if (!in_array($description, $projects[$project][$task])) {
                $projects[$project][$task][] = $description;
            }
        }

        return $projects;
    }
}
