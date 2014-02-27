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
use TempoSimple\Bundle\SpaghettiBundle\Command\PunchTimeCardCommand;

class PunchTimeCardCommandTest extends CommandTestCase
{
    public function testExecute()
    {
        $parameters = array(
            'task' => 'task',
            'start-hour' => '07:45',
            'end-hour' => '08:00',
        );

        $timeCardRepositoryClass = 'TempoSimple\Bundle\SpaghettiBundle\Entity\TimeCardRepository';
        $timeCardRepository = $this->prophet->prophesize($timeCardRepositoryClass);

        $command = new PunchTimeCardCommand(
            $timeCardRepository->reveal()
        );

        $this->givenThisCommand($command);
        $this->whenItIsRun($parameters);
        $this->thenItShouldSuceed();
    }
}
