<?php

namespace spec\TempoSimple\DomainModel\TimeTracking;

use PhpSpec\ObjectBehavior;
use TempoSimple\DomainModel\Time\TimeOfDay;

class TimeCardSpec extends ObjectBehavior
{
    const WORKING_HOURS_SPENT = 0.7;

    function it_computes_working_hours_spent(TimeOfDay $start, TimeOfDay $end)
    {
        $end->getTimeSpentSince($start)->willReturn(self::WORKING_HOURS_SPENT);

        $this->beConstructedWith($start, $end);

        $this->getWorkingHours()->shouldBe(self::WORKING_HOURS_SPENT);
    }
}
