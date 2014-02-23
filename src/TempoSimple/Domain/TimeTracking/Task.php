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

class Task
{
    /** @var Timesheet **/
    private $timesheet;

    /** @var string **/
    private $title;

    /**
     * @param Timesheet $timesheet
     * @param string    $title
     */
    public function __construct(Timesheet $timesheet, $title)
    {
        $this->timesheet = $timesheet;
        $this->title = $title;
    }

    /** @return string **/
    public function getTitle()
    {
        return $this->title;
    }

    /** @param TimeCard $timeCard */
    public function addTimeCard(TimeCard $timeCard)
    {
        $this->timesheet->addTimeCard($timeCard);
    }

    /** @return float **/
    public function getTotalWorkingDays()
    {
        return $this->timesheet->getTotalWorkingDays();
    }
}
