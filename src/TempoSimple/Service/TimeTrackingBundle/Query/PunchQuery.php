<?php

/*
 * This file is part of the TempoSimple project.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TempoSimple\Service\TimeTrackingBundle\Query;

class PunchQuery
{
    /** @var string */
    private $task;

    /** @var string */
    private $endHour;

    /** @var string */
    private $description;

    /** @var string */
    private $project;

    /** @var string */
    private $startHour;

    /** @var string */
    private $day;

    /**
     * @param string $task
     * @param string $endHour
     * @param string $description
     * @param string $project
     * @param string $startHour
     * @param string $day
     */
    public function __construct(
        $task,
        $endHour,
        $description,
        $project,
        $startHour,
        $day
    )
    {
        $this->task = $task;
        $this->endHour = $endHour;
        $this->description = $description;
        $this->project = $project;
        $this->startHour = $startHour;
        $this->day = $day;
    }

    /** @return string */
    public function getTask()
    {
        return $this->task;
    }

    /** @return string */
    public function getEndHour()
    {
        return $this->endHour;
    }

    /** @return string */
    public function getDescription()
    {
        return $this->description;
    }

    /** @return string */
    public function getProject()
    {
        return $this->project;
    }

    /** @return string */
    public function getStartHour()
    {
        return $this->startHour;
    }

    /** @return string */
    public function getDay()
    {
        return $this->day;
    }
}
