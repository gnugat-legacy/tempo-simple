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
use TempoSimple\Bundle\SpaghettiBundle\Command\GenerateWeeklyReportCommand;

class GenerateWeeklyReportCommandTest extends CommandTestCase
{
    public function testExecute()
    {
        $parameters = array();

        $lastWorkingWeek = array();

        $dateFactoryClass = 'TempoSimple\Service\TimeBundle\Factory\DateFactory';
        $dateFactory = $this->prophet->prophesize($dateFactoryClass);
        $dateFactory->lastWorkingWeek()->willReturn($lastWorkingWeek);

        $weeklyTimesheetClass = 'TempoSimple\Service\TimeTrackingBundle\Timesheet\WeeklyTimesheet';
        $weeklyTimesheet = $this->prophet->prophesize($weeklyTimesheetClass);
        $weeklyTimesheet->find()->willReturn(array());

        $templatingClass = 'Symfony\Component\Templating\EngineInterface';
        $templating = $this->prophet->prophesize($templatingClass);

        $command = new GenerateWeeklyReportCommand(
            $dateFactory->reveal(),
            $weeklyTimesheet->reveal(),
            $templating->reveal()
        );

        $this->givenThisCommand($command);
        $this->whenItIsRun($parameters);
        $this->thenItShouldSuceed();
    }
}
