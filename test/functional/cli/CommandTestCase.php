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

use TempoSimple\Bundle\SpaghettiBundle\Command\TimeCardAddCommand;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Console\Command\Command;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommandTestCase extends WebTestCase
{
    const EXIT_SUCCESS = 0;

    protected $command;
    protected $commandTester;

    /**
     * Sets the CommandTester
     *
     * @param Command $command
     */
    protected function givenThisCommand(Command $command)
    {
        $kernel = $this->createKernel();
        $kernel->boot();

        $application = new Application($kernel);
        $application->add($command);

        $command = $application->find($command->getName());
        $this->commandTester = new CommandTester($command);
    }

    /**
     * Executes the command
     *
     * @param array $parameters
     */
    protected function whenItIsRun(array $parameters = array())
    {
        $this->commandTester->execute($parameters);
    }

    protected function thenItShouldSuceed()
    {
        $this->assertSame(self::EXIT_SUCCESS, $this->commandTester->getStatusCode());
    }
}
