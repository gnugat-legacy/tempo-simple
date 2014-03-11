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

/**
 * A flat collection of tasks which also acts as a converter.
 * TimeCards are used to find a Task. If the Task isn't found, it uses the
 * TimeCard's data to create a new Task.
 *
 * Implementations should specify how to hold the tasks: by day, by title, by
 * project, etc.
 */
interface TaskCollection
{
    /**
     * @param TimeCard $timeCard
     *
     * @return \TempoSimple\DomainModel\TimeTracking\Task
     */
    public function getTask(TimeCard $timeCard);

    /** @return array */
    public function getHeaders();

    /** @return array */
    public function getRows();
}
