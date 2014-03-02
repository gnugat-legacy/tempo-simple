<?php

namespace spec\TempoSimple\DomainModel\TimeTracking;

use PhpSpec\ObjectBehavior;
use TempoSimple\DomainModel\TimeTracking\Task;

class ProjectSpec extends ObjectBehavior
{
    const NAME = 'Project 1';

    function let()
    {
        $this->beConstructedWith(self::NAME);
    }

    function it_has_a_name()
    {
        $this->getName()->shouldBe(self::NAME);
    }

    function it_has_a_collection_of_tasks(Task $task)
    {
        $taskTitle = '#1337 - Graceful title';
        $task->getTitle()->willReturn($taskTitle);

        $this->hasTask($taskTitle)->shouldBe(false);
        $this->addTask($task);
        $this->hasTask($taskTitle)->shouldBe(true);
        $this->getTask($taskTitle)->shouldHaveType('TempoSimple\\DomainModel\\TimeTracking\\Task');

        $this->getTasks()->shouldBeArray();
        $this->getTasks()->shouldHaveCount(1);
    }
}
