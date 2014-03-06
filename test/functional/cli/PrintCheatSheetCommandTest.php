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
use TempoSimple\Bundle\SpaghettiBundle\Command\PrintCheatSheetCommand;

class PrintCheatSheetCommandTest extends CommandTestCase
{
    const MONTH = '1989-01';
    const DAY = '1989-01-25';
    const HOUR = '12:05';

    public function testExecute()
    {
        $parameters = array();

        $defaultProject = 'Project 1';

        $dateClass = 'TempoSimple\DomainModel\Time\Date';
        $date = $this->prophet->prophesize($dateClass);
        $date->getMonth()->willReturn(self::MONTH);
        $date->getDay()->willReturn(self::DAY);

        $dateFactoryClass = 'TempoSimple\Service\TimeBundle\Factory\DateFactory';
        $dateFactory = $this->prophet->prophesize($dateFactoryClass);
        $dateFactory->today()->willReturn($date->reveal());

        $timeOfDayClass = 'TempoSimple\DomainModel\Time\TimeOfDay';
        $timeOfDay = $this->prophet->prophesize($timeOfDayClass);
        $timeOfDay->getHour()->willReturn(self::HOUR);

        $timeOfDayFactoryClass = 'TempoSimple\Service\TimeBundle\Factory\TimeOfDayFactory';
        $timeOfDayFactory = $this->prophet->prophesize($timeOfDayFactoryClass);
        $timeOfDayFactory->now()->willReturn($timeOfDay->reveal());

        $timeCardRepositoryClass = 'TempoSimple\DataSource\DoctrineBundle\Entity\TimeCardRepository';
        $timeCardRepository = $this->prophet->prophesize($timeCardRepositoryClass);

        $templatingClass = 'Symfony\Component\Templating\EngineInterface';
        $templating = $this->prophet->prophesize($templatingClass);

        $command = new PrintCheatSheetCommand(
            $dateFactory->reveal(),
            $timeOfDayFactory->reveal(),
            $timeCardRepository->reveal(),
            $templating->reveal(),
            $defaultProject
        );

        $this->givenThisCommand($command);
        $this->whenItIsRun($parameters);
        $this->thenItShouldSuceed();
    }
}
