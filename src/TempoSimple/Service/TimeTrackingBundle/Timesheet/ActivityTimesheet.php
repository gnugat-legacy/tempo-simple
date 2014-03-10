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
use TempoSimple\DomainModel\TimeTracking\DayCollection;
use TempoSimple\DomainModel\TimeTracking\TimeCard;
use TempoSimple\Service\TimeBundle\Factory\DateFactory;
use TempoSimple\Service\TimeBundle\Factory\TimeOfDayFactory;

class ActivityTimesheet
{
    /** @var TimeCardRepository */
    private $timeCardRepository;

    /** @var DateFactory */
    private $dateFactory;

    /** @var TimeOfDayFactory */
    private $timeOfDayFactory;

    /**
     * @param TimeCardRepository $timeCardRepository
     * @param DateFactory        $dateFactory
     * @param TimeOfDayFactory   $timeOfDayFactory
     */
    public function __construct(
        TimeCardRepository $timeCardRepository,
        DateFactory $dateFactory,
        TimeOfDayFactory $timeOfDayFactory
    )
    {
        $this->timeCardRepository = $timeCardRepository;
        $this->dateFactory = $dateFactory;
        $this->timeOfDayFactory = $timeOfDayFactory;
    }

    /** return array */
    public function getHeaders()
    {
        return array('Projet', 'Date', 'Temps', 'Description');
    }

    /**
     * @param string $month Format: 'Y-m' (e.g. '1989-01')
     *
     * @return DayCollection
     */
    public function find($month)
    {
        $dayCollection = new DayCollection();

        $rawTimeCards = $this->timeCardRepository->findForMonth($month);
        foreach ($rawTimeCards as $rawTimeCard) {
            $project = $rawTimeCard->getProjectName();
            $day = $rawTimeCard->getDate();
            $startHour = $rawTimeCard->getStartHour();
            $endHour = $rawTimeCard->getEndHour();
            $taskTitle = $rawTimeCard->getTaskTitle();

            $start = $this->timeOfDayFactory->fromString($startHour);
            $end = $this->timeOfDayFactory->fromString($endHour);
            $date = $this->dateFactory->fromString($day);

            $activityDay = $dayCollection->getActivityDay($date);
            $task = $activityDay->getTask($project, $taskTitle);
            $task->addTimeCard(new TimeCard($start, $end));
        }

        return $dayCollection;
    }
}
