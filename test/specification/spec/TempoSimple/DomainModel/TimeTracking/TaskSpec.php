<?php

namespace spec\TempoSimple\DomainModel\TimeTracking;

use PhpSpec\ObjectBehavior;
use TempoSimple\DomainModel\TimeTracking\TimeCard;

class TaskSpec extends ObjectBehavior
{
    const PROJECT_NAME = 'Project 1';
    const TASK_TITLE = '#4423 - descriptive title';

    const FIRST_WORKING_HOURS = 0.25;
    const SECOND_WORKING_HOURS = 0.5;
    const THIRD_WORKING_HOURS = 1.25;

    const TOTAL_WORKING_DAYS = 0.25;

    function let()
    {
        $this->beConstructedWith(self::PROJECT_NAME, self::TASK_TITLE);
    }

    function it_has_a_title()
    {
        $this->getTitle()->shouldBe(self::TASK_TITLE);
    }

    function it_computes_total_working_days(TimeCard $first, TimeCard $second, TimeCard $third)
    {
        $first->getWorkingHours()->willReturn(self::FIRST_WORKING_HOURS);
        $second->getWorkingHours()->willReturn(self::SECOND_WORKING_HOURS);
        $third->getWorkingHours()->willReturn(self::THIRD_WORKING_HOURS);

        $this->addTimeCard($first);
        $this->addTimeCard($second);
        $this->addTimeCard($third);

        $this->getTotalWorkingDays()->shouldBe(self::TOTAL_WORKING_DAYS);
    }
}
