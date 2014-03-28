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
use TempoSimple\Service\TimeTrackingBundle\TaskCollection\ByTitleTaskCollection;

class BillableTimesheet
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
            $timeCard = $this->timeCardFactory->make($rawTimeCard);

            $task = $byTitleTaskCollection->getTask($rawTimeCard);
            $task->addTimeCard($timeCard);
        }

        return $byTitleTaskCollection;
    }
}
