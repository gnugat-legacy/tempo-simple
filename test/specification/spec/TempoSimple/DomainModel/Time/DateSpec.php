<?php

namespace spec\TempoSimple\DomainModel\Time;

use PhpSpec\ObjectBehavior;

class FullDateSpec extends ObjectBehavior
{
    const RAW_YEAR = '1989';
    const RAW_MONTH = '01';
    const RAW_DAY = '25';

    const MONTH = '1989-01';
    const DAY = '1989-01-25';

    function let()
    {
        $this->beConstructedWith(
            self::RAW_YEAR,
            self::RAW_MONTH,
            self::RAW_DAY
        );
    }

    function it_indicates_the_month()
    {
        $this->getMonth()->shouldBe(self::MONTH);
    }

    function it_indicates_the_day()
    {
        $this->getDay()->shouldBe(self::DAY);
    }
}
