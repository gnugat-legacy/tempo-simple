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

class DailyQuery
{
    /** @var string */
    private $day;

    /**
     * @param string $day
     */
    public function __construct($day)
    {
        $this->day = $day;
    }

    /** @return string */
    public function getDay()
    {
        return $this->day;
    }
}
