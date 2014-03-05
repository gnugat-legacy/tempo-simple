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

class BillableTimesheet
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

            $timeCard = new TimeCard($startHour, $endHour);

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
