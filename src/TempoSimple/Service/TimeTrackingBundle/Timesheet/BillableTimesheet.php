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
use TempoSimple\DomainModel\TimeTracking\Task;
use TempoSimple\DomainModel\TimeTracking\TimeCard;
use TempoSimple\Service\TimeBundle\Factory\TimeOfDayFactory;
use TempoSimple\Service\TimeTrackingBundle\TaskCollection\ByTitleTaskCollection;

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
            $start = $this->timeOfDayFactory->fromString($startHour);
            $endHour = $rawTimeCard->getEndHour();
            $end = $this->timeOfDayFactory->fromString($endHour);
            $timeCard = new TimeCard($start, $end);

            $task = $byTitleTaskCollection->getTask($rawTimeCard);
            $task->addTimeCard($timeCard);
        }

        return $byTitleTaskCollection;
    }
}
