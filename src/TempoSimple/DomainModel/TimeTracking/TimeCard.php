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

use TempoSimple\DomainModel\Time\TimeOfDay;

class TimeCard
{
    /** @var TimeOfDay **/
    private $start;

    /** @var TimeOfDay **/
    private $end;

    /**
     * @param TimeOfDay $start
     * @param TimeOfDay $end
     */
    public function __construct(TimeOfDay $start, TimeOfDay $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    /** @return float */
    public function getWorkingHours()
    {
        return $this->end->getTimeSpentSince($this->start);
    }
}
