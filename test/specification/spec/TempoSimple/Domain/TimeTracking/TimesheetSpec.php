<?php

namespace spec\TempoSimple\Domain\TimeTracking;

use PhpSpec\ObjectBehavior;
use TempoSimple\Domain\TimeTracking\TimeCard;

class TimesheetSpec extends ObjectBehavior
{
    const FIRST_WORKING_HOURS = 0.25;
    const SECOND_WORKING_HOURS = 0.5;
    const THIRD_WORKING_HOURS = 1.25;

    const TOTAL_WORKING_DAYS = 0.25;

    function let(TimeCard $first, TimeCard $second, TimeCard $third)
    {
        $first->getWorkingHours()->willReturn(self::FIRST_WORKING_HOURS);
        $second->getWorkingHours()->willReturn(self::SECOND_WORKING_HOURS);
        $third->getWorkingHours()->willReturn(self::THIRD_WORKING_HOURS);

        $this->beConstructedWith(array($first, $second, $third));
    }

    function it_computes_total_working_days()
    {
        $this->getTotalWorkingDays()->shouldBe(self::TOTAL_WORKING_DAYS);
    }
}
