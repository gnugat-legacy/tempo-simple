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
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class CommandTestCase extends WebTestCase
{
    const EXIT_SUCCESS = 0;

    protected $commandTester;

    /**
     * Sets the CommandTester
     *
     * @param $commandName
     */
    protected function givenThisCommand($commandName)
    {
        $kernel = $this->createKernel();
        $kernel->boot();

        $command = $kernel->getContainer()->get($commandName);

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
