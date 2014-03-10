<?php

/*
 * This file is part of the TempoSimple project.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TempoSimple\DomainModel\TimeTracking;

class ActivityDay
{
    /** @var array of Task */
    private $tasks = array();

    /**
     * @param string $projectName
     * @param string $taskTitle
     *
     * @return Task
     */
    public function getTask($projectName, $taskTitle)
    {
        if (!isset($this->tasks[$taskTitle])) {
            $this->tasks[$taskTitle] = new Task($projectName, $taskTitle);
        }

        return $this->tasks[$taskTitle];
    }

    /** @return array of task */
    public function getTasks()
    {
        return $this->tasks;
    }
}
