<?php

/*
 * This file is part of the TempoSimple project.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TempoSimple\DomainModel\Time;

class Date
{
    const SEPARATOR = '-';

    /** @var integer */
    private $year;

    /** @var integer */
    private $month;

    /** @var integer */
    private $day;

    /**
     * @param integer $year
     * @param integer $month
     * @param integer $day
     */
    public function __construct($year, $month, $day)
    {
        $this->year = $year;
        $this->month = $month;
        $this->day = $day;
    }

    /** @return string */
    public function getMonth()
    {
        $dates = array(
            $this->year,
            $this->month,
        );

        return implode(self::SEPARATOR, $dates);
    }

    /** @return string */
    public function getDay()
    {
        $dates = array(
            $this->year,
            $this->month,
            $this->day,
        );

        return implode(self::SEPARATOR, $dates);
    }
}
