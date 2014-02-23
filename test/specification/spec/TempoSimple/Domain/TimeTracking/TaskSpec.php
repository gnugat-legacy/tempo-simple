<?php

namespace spec\TempoSimple\Domain\TimeTracking;

use PhpSpec\ObjectBehavior;
use TempoSimple\Domain\TimeTracking\Timesheet;

class TaskSpec extends ObjectBehavior
{
    const TITLE = '#4423 - descriptive title';
    const TOTAL_WORKING_DAYS = 42.0;

    function let(Timesheet $timesheet)
    {
        $timesheet->getTotalWorkingDays()->willReturn(self::TOTAL_WORKING_DAYS);

        $this->beConstructedWith($timesheet, self::TITLE);
    }

    function it_has_a_title()
    {
        $this->getTitle()->shouldBe(self::TITLE);
    }

    function it_has_total_working_days()
    {
        $this->getTotalWorkingDays()->shouldBe(self::TOTAL_WORKING_DAYS);
    }
}
