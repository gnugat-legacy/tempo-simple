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
use TempoSimple\Bundle\SpaghettiBundle\Command\GenerateBillableReportCommand;

class GenerateBillableReportCommandTest extends CommandTestCase
{
    const MONTH = '1989-01';

    public function testExecute()
    {
        $parameters = array();

        $defaultProject = 'Project 1';

        $dateClass = 'TempoSimple\DomainModel\Time\Date';
        $date = $this->prophet->prophesize($dateClass);
        $date->getMonth()->willReturn(self::MONTH);

        $dateFactoryClass = 'TempoSimple\Service\TimeBundle\Factory\DateFactory';
        $dateFactory = $this->prophet->prophesize($dateFactoryClass);
        $dateFactory->today()->willReturn($date->reveal());

        $bytTitleTaskCollectionClass = 'TempoSimple\DomainModel\TimeTracking\Collection\ByTitleTaskCollection';
        $bytTitleTaskCollection = $this->prophet->prophesize($bytTitleTaskCollectionClass);
        $bytTitleTaskCollection->toArray()->willReturn(array());
        $bytTitleTaskCollection->getHeaders()->willReturn(array());

        $billableTimesheetClass = 'TempoSimple\Service\TimeTrackingBundle\Timesheet\BillableTimesheet';
        $billableTimesheet = $this->prophet->prophesize($billableTimesheetClass);
        $billableTimesheet->find($defaultProject, self::MONTH)->willReturn($bytTitleTaskCollection->reveal());

        $command = new GenerateBillableReportCommand(
            $dateFactory->reveal(),
            $billableTimesheet->reveal(),
            $defaultProject
        );

        $this->givenThisCommand($command);
        $this->whenItIsRun($parameters);
        $this->thenItShouldSuceed();
    }
}
