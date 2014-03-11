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

class ByTitleTaskCollection implements TaskCollection
{
    /** @var array */
    private $collection = array();

    /** {@inheritdoc} */
    public function getTask(TimeCard $timeCard)
    {
        $projectName = $timeCard->getProjectName();
        $taskTitle = $timeCard->getTaskTitle();

        if (!isset($this->tasks[$taskTitle])) {
            $this->tasks[$taskTitle] = new Task($projectName, $taskTitle);
        }

        return $this->tasks[$taskTitle];
    }

    /** {@inheritdoc} */
    public function getHeaders()
    {
        return array('Tâche', 'Temps passé');
    }

    /** {@inheritdoc} */
    public function getRows()
    {
        $rows = array();
        foreach ($this->tasks as $task) {
            $rows[] = array(
                $task->getTitle(),
                $task->getTotalWorkingDays(),
            );
        }

        return $rows;
    }
}
