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
use TempoSimple\DomainModel\TimeTracking\Project;
use TempoSimple\DomainModel\TimeTracking\Task;
use TempoSimple\DomainModel\TimeTracking\TimeCard;
use TempoSimple\Service\TimeBundle\Factory\TimeOfDayFactory;

class BillableTimesheet
{
    /** @var TimeCardRepository */
    private $timeCardRepository;

    /** @var TimeOfDayFactory */
    private $timeOfDayFactory;

    /**
     * @param TimeCardRepository $timeCardRepository
     * @param TimeOfDayFactory   $timeOfDayFactory
     */
    public function __construct(TimeCardRepository $timeCardRepository, TimeOfDayFactory $timeOfDayFactory)
    {
        $this->timeCardRepository = $timeCardRepository;
        $this->timeOfDayFactory = $timeOfDayFactory;
    }

    /**
     * @param string $projectName
     * @param string $month       Format: 'Y-m' (e.g. '1989-01')
     *
     * @return Project
     */
    public function find($projectName, $month)
    {
        $project = new Project($projectName);

        $timeCards = $this->timeCardRepository->findForMonthAndProject($month, $projectName);
        foreach ($timeCards as $timeCard) {
            $taskTitle = $timeCard->getTaskTitle();
            $startHour = $timeCard->getStartHour();
            $endHour = $timeCard->getEndHour();

            $start = $this->timeOfDayFactory->fromString($startHour);
            $end = $this->timeOfDayFactory->fromString($endHour);

            $timeCard = new TimeCard($start, $end);

            if (!$project->hasTask($taskTitle)) {
                $task = new Task($taskTitle);
                $project->addTask($task);
            }
            $task = $project->getTask($taskTitle);
            $task->addTimeCard($timeCard);
        }

        return $project;
    }
}
