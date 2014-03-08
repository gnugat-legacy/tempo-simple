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
use TempoSimple\DomainModel\TimeTracking\TimeCard;
use TempoSimple\Service\TimeBundle\Factory\TimeOfDayFactory;

class ActivityTimesheet
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
     * @param string $month Format: 'Y-m' (e.g. '1989-01')
     *
     * @return Project
     */
    public function find($month)
    {
        $days = array();

        $timeCards = $this->timeCardRepository->findForMonth($month);
        foreach ($timeCards as $timeCard) {
            $day = $timeCard->getDate();
            $taskTitle = $timeCard->getTaskTitle();
            $startHour = $timeCard->getStartHour();
            $endHour = $timeCard->getEndHour();

            $start = $this->timeOfDayFactory->fromString($startHour);
            $end = $this->timeOfDayFactory->fromString($endHour);

            $timeCard = new TimeCard($start, $end);
            if (!isset($days[$day])) {
                $days[$day] = array();
            }
            if (!isset($days[$day][$taskTitle])) {
                $days[$day][$taskTitle] = 0.0;
            }
            $days[$day][$taskTitle] += $timeCard->getWorkingHours();
        }

        return $days;
    }
}
