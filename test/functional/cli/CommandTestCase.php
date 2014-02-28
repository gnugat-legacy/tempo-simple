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

use Prophecy\Prophet;
use Prophecy\Exception\Prediction\PredictionException;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

class CommandTestCase extends WebTestCase
{
    const EXIT_SUCCESS = 0;

    protected $prophet;
    protected $commandTester;

    protected function setUp()
    {
        $this->prophet = new Prophet();
    }

    protected function tearDown()
    {
        $this->prophet->checkPredictions();
        $this->prophet = null;
    }

    protected function onNotSuccessfulTest(\Exception $e)
    {
        if ($e instanceof PredictionException) {
            $e = new \PHPUnit_Framework_AssertionFailedError($e->getMessage(), $e->getCode(), $e);
        }

        return parent::onNotSuccessfulTest($e);
    }

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
