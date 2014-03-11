<?php

/*
 * This file is part of the TempoSimple project.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TempoSimple\Service\TimeTrackingBundle\TaskCollection;

use TempoSimple\DataSource\DoctrineBundle\Entity\TimeCard;
use TempoSimple\DomainModel\TimeTracking\Task;

class ByDayTaskCollection implements TaskCollection
{
    /** @var array */
    private $collection = array();

    /** {@inheritdoc} */
    public function getTask(TimeCard $timeCard)
    {
        $day = $timeCard->getDate();
        if (!isset($this->collection[$day])) {
            $this->collection[$day] = array();
        }

        $taskTitle = $timeCard->getTaskTitle();
        $projectName = $timeCard->getProjectName();
        if (!isset($this->collection[$day][$taskTitle])) {
            $task = new Task($projectName, $taskTitle);
            $this->collection[$day][$taskTitle] = $task;
        }

        return $this->collection[$day][$taskTitle];
    }

    /** {@inheritdoc} */
    public function getHeaders()
    {
        return array('Projet', 'Date', 'Temps', 'Description');
    }

    /** {@inheritdoc} */
    public function getRows()
    {
        $rows = array();
        foreach ($this->collection as $day => $tasks) {
            foreach ($tasks as $taskTitle => $task) {
                $rows[] = array(
                    $task->getProjectName(),
                    $day,
                    $task->getTotalWorkingDays(),
                    $taskTitle,
                );
            }
        }

        return $rows;
    }
}
