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
    public function testExecute()
    {
        $parameters = array();

        $timeCardRepositoryClass = 'TempoSimple\Bundle\SpaghettiBundle\Entity\TimeCardRepository';
        $timeCardRepository = $this->prophet->prophesize($timeCardRepositoryClass);
        $timeCardRepository->findBillable(date('Y-m'), 'Project 1')->willReturn(array());

        $templatingClass = 'Symfony\Component\Templating\EngineInterface';
        $templating = $this->prophet->prophesize($templatingClass);

        $command = new GenerateBillableReportCommand(
            $timeCardRepository->reveal(),
            $templating->reveal()
        );

        $this->givenThisCommand($command);
        $this->whenItIsRun($parameters);
        $this->thenItShouldSuceed();
    }
}
