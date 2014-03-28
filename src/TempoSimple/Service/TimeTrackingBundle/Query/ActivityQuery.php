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

class ActivityQuery
{
    /** @var string */
    private $month;

    /**
     * @param string $month
     */
    public function __construct($month)
    {
        $this->month = $month;
    }

    /** @return string */
    public function getMonth()
    {
        return $this->month;
    }
}
