<?php

/*
 * This file is part of the TempoSimple project.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TempoSimple\Service\TimeTrackingBundle\Factory;

use TempoSimple\DataSource\DoctrineBundle\Entity\TimeCard as RawTimeCard;
use TempoSimple\DomainModel\TimeTracking\TimeCard;
use TempoSimple\Service\TimeBundle\Factory\TimeOfDayFactory;

class TimeCardFactory
{
    /** @var TimeOfDayFactory */
    private $timeOfDayFactory;

    /** @param TimeOfDayFactory $timeOfDayFactory */
    public function __construct(TimeOfDayFactory $timeOfDayFactory)
    {
        $this->timeOfDayFactory = $timeOfDayFactory;
    }

    /**
     * @param RawTimeCard $rawTimeCard
     *
     * @return TimeCard
     */
    public function make(RawTimeCard $rawTimeCard)
    {
        $startHour = $rawTimeCard->getStartHour();
        $endHour = $rawTimeCard->getEndHour();

        $start = $this->timeOfDayFactory->fromString($startHour);
        $end = $this->timeOfDayFactory->fromString($endHour);

        return new TimeCard($start, $end);
    }
}
