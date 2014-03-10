<?php

/*
 * This file is part of the TempoSimple project.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\TempoSimple\DomainModel\TimeTracking;

use PhpSpec\ObjectBehavior;
use TempoSimple\DomainModel\Time\Date;

class DayCollectionSpec extends ObjectBehavior
{
    const DAY = '1989-01-25';

    function it_holds_days(Date $date)
    {
        $date->getDay()->willReturn(self::DAY);

        $this->getActivityDay($date)
            ->shouldHaveType('TempoSimple\DomainModel\TimeTracking\ActivityDay')
        ;
    }
}
