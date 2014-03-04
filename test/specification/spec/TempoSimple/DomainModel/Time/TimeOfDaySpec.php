<?php

namespace spec\TempoSimple\DomainModel\Time;

use PhpSpec\ObjectBehavior;
use TempoSimple\DomainModel\Time\Hour;

class HourSpec extends ObjectBehavior
{
    const RAW_HOUR = '12';
    const RAW_MINUTES = '05';

    const HOUR = '12:05';

    function let()
    {
        $this->beConstructedWith(self::RAW_HOUR, self::RAW_MINUTES);
    }

    function it_indicates_the_hour()
    {
        $this->getHour()->shouldBe(self::HOUR);
    }
}
