<?php

namespace spec\TempoSimple\DomainModel\Time;

use PhpSpec\ObjectBehavior;
use TempoSimple\DomainModel\Time\TimeOfDay;

class TimeOfDaySpec extends ObjectBehavior
{
    const HOUR = 12;
    const MINUTES = 5;

    const TIME = '12:05';

    const START_HOUR = 11;
    const START_MINUTES = 23;

    const TIME_SPENT = 0.7;

    function let()
    {
        $this->beConstructedWith(self::HOUR, self::MINUTES);
    }

    function it_indicates_the_hour()
    {
        $this->getHour()->shouldBe(self::TIME);
    }

    function it_computes_the_time_spent()
    {
        $start = new TimeOfDay(self::START_HOUR, self::START_MINUTES);

        $this->getTimeSpentSince($start)->shouldBe(self::TIME_SPENT);
    }
}
