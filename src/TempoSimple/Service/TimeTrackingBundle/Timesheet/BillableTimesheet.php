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
use TempoSimple\DomainModel\TimeTracking\Collection\ByTitleTaskCollection;
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
     * @return ByTitleTaskCollection
     */
    public function find($projectName, $month)
    {
        $byTitleTaskCollection = new ByTitleTaskCollection();

        $rawTimeCards = $this->timeCardRepository->findForMonthAndProject($month, $projectName);
        foreach ($rawTimeCards as $rawTimeCard) {
            $startHour = $rawTimeCard->getStartHour();
            $endHour = $rawTimeCard->getEndHour();
            $taskTitle = $rawTimeCard->getTaskTitle();

            $start = $this->timeOfDayFactory->fromString($startHour);
            $end = $this->timeOfDayFactory->fromString($endHour);

            $task = $byTitleTaskCollection->getTask($projectName, $taskTitle);
            $task->addTimeCard(new TimeCard($start, $end));
        }

        return $byTitleTaskCollection;
    }
}
