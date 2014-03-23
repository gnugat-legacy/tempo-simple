<?php

/*
 * This file is part of the TempoSimple project.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TempoSimple\Bundle\SpaghettiBundle\Factory;

use Symfony\Component\Console\Input\InputInterface;
use TempoSimple\Service\TimeTrackingBundle\Query\ActivityQuery;
use TempoSimple\Service\TimeTrackingBundle\Query\BillableQuery;
use TempoSimple\Service\TimeTrackingBundle\Query\DailyQuery;
use TempoSimple\Service\TimeTrackingBundle\Query\PunchQuery;

class ConsoleQueryFactory
{
    /**
     * @param InputInterface $input
     *
     * @return BillableQuery
     */
    public function makeActivity(InputInterface $input)
    {
        $month = $input->getOption('month');

        return new ActivityQuery($month);
    }

    /**
     * @param InputInterface $input
     *
     * @return BillableQuery
     */
    public function makeBillable(InputInterface $input)
    {
        $projectName = $input->getOption('project');
        $month = $input->getOption('month');

        return new BillableQuery($projectName, $month);
    }

    /**
     * @param InputInterface $input
     *
     * @return DailyQuery
     */
    public function makeDaily(InputInterface $input)
    {
        $day = $input->getOption('date');

        return new DailyQuery($day);
    }

    /**
     * @param InputInterface $input
     *
     * @return PunchQuery
     */
    public function makePunch(InputInterface $input)
    {
        $project = $input->getOption('project');
        $task = $input->getArgument('task');
        $date = $input->getOption('date');
        $startHour = $input->getOption('start-hour');
        $endHour = $input->getOption('end-hour');
        $description = $input->getOption('description');

        return new PunchQuery(
            $project,
            $task,
            $date,
            $startHour,
            $endHour,
            $description
        );
    }
}
