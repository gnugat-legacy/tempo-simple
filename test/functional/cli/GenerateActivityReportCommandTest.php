<?php

/*
 * This file is part of the TempoSimple project.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TempoSimple\Test\Functional\Cli;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use TempoSimple\Bundle\SpaghettiBundle\Command\GenerateActivityReportCommand;

class GenerateActivityReportCommandTest extends CommandTestCase
{
    const MONTH = '1989-01';

    public function testExecute()
    {
        $parameters = array();

        $dayCollectionClass = 'TempoSimple\DomainModel\TimeTracking\DayCollection';
        $dayCollection = $this->prophet->prophesize($dayCollectionClass);
        $dayCollection->toArray()->willReturn(array());

        $dateClass = 'TempoSimple\DomainModel\Time\Date';
        $date = $this->prophet->prophesize($dateClass);
        $date->getMonth()->willReturn(self::MONTH);

        $dateFactoryClass = 'TempoSimple\Service\TimeBundle\Factory\DateFactory';
        $dateFactory = $this->prophet->prophesize($dateFactoryClass);
        $dateFactory->today()->willReturn($date->reveal());

        $activityTimesheetClass = 'TempoSimple\Service\TimeTrackingBundle\Timesheet\ActivityTimesheet';
        $activityTimesheet = $this->prophet->prophesize($activityTimesheetClass);
        $activityTimesheet->getHeaders()->willReturn(array());
        $activityTimesheet->find(self::MONTH)->willReturn($dayCollection->reveal());

        $command = new GenerateActivityReportCommand(
            $dateFactory->reveal(),
            $activityTimesheet->reveal()
        );

        $this->givenThisCommand($command);
        $this->whenItIsRun($parameters);
        $this->thenItShouldSuceed();
    }
}
