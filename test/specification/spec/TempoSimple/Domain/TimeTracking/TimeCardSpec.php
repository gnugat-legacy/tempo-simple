<?php

namespace spec\TempoSimple\Domain\TimeTracking;

use PhpSpec\ObjectBehavior;

class TimeCardSpec extends ObjectBehavior
{
    function it_computes_working_hours_in_the_same_hour()
    {
        $this->beConstructedWith('09:15', '09:45');

        $this->getWorkingHours()->shouldBe(0.5);
    }

    function it_computes_short_working_hours_astride_many_hours()
    {
        $this->beConstructedWith('13:15', '16:30');

        $this->getWorkingHours()->shouldBe(3.25);
    }
}
