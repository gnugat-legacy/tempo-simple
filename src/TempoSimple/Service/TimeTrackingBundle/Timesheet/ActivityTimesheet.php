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
use TempoSimple\Service\TimeTrackingBundle\Factory\TimeCardFactory;
use TempoSimple\Service\TimeTrackingBundle\Query\ActivityQuery;
use TempoSimple\Service\TimeTrackingBundle\TaskCollection\ByDayTaskCollection;

class ActivityTimesheet
{
    /** @var TimeCardRepository */
    private $timeCardRepository;

    /** @var TimeCardFactory */
    private $timeCardFactory;

    /**
     * @param TimeCardRepository $timeCardRepository
     * @param TimeCardFactory    $timeCardFactory
     */
    public function __construct(
        TimeCardRepository $timeCardRepository,
        TimeCardFactory $timeCardFactory
    )
    {
        $this->timeCardRepository = $timeCardRepository;
        $this->timeCardFactory = $timeCardFactory;
    }

    /**
     * @param ActivityQuery $activityQuery
     *
     * @return ByDayTaskCollection
     */
    public function match(ActivityQuery $activityQuery)
    {
        $byDayTaskCollection = new ByDayTaskCollection();

        $rawTimeCards = $this->timeCardRepository->findForMonth($activityQuery->getMonth());
        foreach ($rawTimeCards as $rawTimeCard) {
            $timeCard = $this->timeCardFactory->make($rawTimeCard);

            $task = $byDayTaskCollection->getTask($rawTimeCard);
            $task->addTimeCard($timeCard);
        }

        return $byDayTaskCollection;
    }
}
