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

use TempoSimple\DomainModel\Time\Date;

class DayCollection
{
    /** @var array of ActivityDay */
    private $activityDays = array();

    /**
     * @param string $day Format: 'Y-m-d' (e.g. '1989-01-25')
     *
     * @return ActivityDay
     */
    public function getActivityDay(Date $date)
    {
        $day = $date->getDay();

        if (!isset($this->activityDays[$day])) {
            $this->activityDays[$day] = new ActivityDay();
        }

        return $this->activityDays[$day];
    }

    /** @return array */
    public function toArray()
    {
        $rows = array();
        foreach ($this->activityDays as $day => $activityDay) {
            foreach ($activityDay->getTasks() as $task) {
                $rows[] = array(
                    $task->getProjectName(),
                    $day,
                    $task->getTotalWorkingDays(),
                    $task->getTitle()
                );
            }
        }

        return $rows;
    }
}
