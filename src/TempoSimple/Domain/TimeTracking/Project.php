<?php

/*
 * This file is part of the TempoSimple project.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TempoSimple\Domain\TimeTracking;

class Project
{
    /** @var string */
    private $name;

    /** @var array of Task */
    private $tasks;

    /** @param string $name */
    public function __construct($name)
    {
        $this->name = $name;
        $this->tasks = array();
    }

    /** @return string **/
    public function getName()
    {
        return $this->name;
    }

    /** @return bool **/
    public function hasTask($taskTitle)
    {
        return isset($this->tasks[$taskTitle]);
    }

    /** @param Task $task **/
    public function addTask(Task $task)
    {
        $this->tasks[$task->getTitle()] = $task;
    }

    /** @return Task **/
    public function getTask($taskTitle)
    {
        return $this->tasks[$taskTitle];
    }

    /** @return array of Tasks **/
    public function getTasks()
    {
        return $this->tasks;
    }
}
