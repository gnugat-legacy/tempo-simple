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
use TempoSimple\Bundle\SpaghettiBundle\Command\GenerateDailyReportCommand;

class GenerateDailyReportCommandTest extends CommandTestCase
{
    const DAY = '1989-01-25';

    public function testExecute()
    {
        $parameters = array();

        $dateClass = 'TempoSimple\DomainModel\Time\Date';
        $date = $this->prophet->prophesize($dateClass);
        $date->getDay()->willReturn(self::DAY);

        $dateFactoryClass = 'TempoSimple\Service\TimeBundle\Factory\DateFactory';
        $dateFactory = $this->prophet->prophesize($dateFactoryClass);
        $dateFactory->today()->willReturn($date->reveal());

        $timeCardRepositoryClass = 'TempoSimple\DataSource\DoctrineBundle\Entity\TimeCardRepository';
        $timeCardRepository = $this->prophet->prophesize($timeCardRepositoryClass);
        $timeCardRepository->findForDay(self::DAY)->willReturn(array());

        $templatingClass = 'Symfony\Component\Templating\EngineInterface';
        $templating = $this->prophet->prophesize($templatingClass);

        $command = new GenerateDailyReportCommand(
            $dateFactory->reveal(),
            $timeCardRepository->reveal(),
            $templating->reveal()
        );

        $this->givenThisCommand($command);
        $this->whenItIsRun($parameters);
        $this->thenItShouldSuceed();
    }
}
