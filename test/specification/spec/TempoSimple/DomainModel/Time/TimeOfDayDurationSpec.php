<?php

namespace spec\TempoSimple\DomainModel\Time;

use PhpSpec\ObjectBehavior;
use TempoSimple\DomainModel\Time\TimeOfDay;

class TimeOfDayDurationSpec extends ObjectBehavior
{
    const START_HOUR = '11:23';
    const END_HOUR = '12:05';

    const DURATION = 0.7;

    function let(TimeOfDay $start, TimeOfDay $end)
    {
        $start->getHour()->willReturn(self::START_HOUR);
        $end->getHour()->willReturn(self::END_HOUR);

        $this->beConstructedWith($start, $end);
    }

    function it_computes_the_duration()
    {
        $this->inWorkingHours()->shouldReturn(self::DURATION);
    }
}
