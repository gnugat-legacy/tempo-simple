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

class ActivityDaySpec extends ObjectBehavior
{
    const PROJECT_NAME = 'Project 1';
    const TASK_TITLE = '#4423 - Descriptive title';

    function it_holds_tasks()
    {
        $this->getTask(self::PROJECT_NAME, self::TASK_TITLE)
            ->shouldHaveType('TempoSimple\DomainModel\TimeTracking\Task')
        ;
    }
}
