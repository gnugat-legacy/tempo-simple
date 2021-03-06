<?php

/*
 * This file is part of the TempoSimple project.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TempoSimple\Bundle\SpaghettiBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use TempoSimple\Bundle\SpaghettiBundle\Factory\ConsoleQueryFactory;
use TempoSimple\Service\TimeBundle\Factory\DateFactory;
use TempoSimple\Service\TimeTrackingBundle\Timesheet\ActivityTimesheet;

class GenerateActivityReportCommand extends Command
{
    /** @var DateFactory */
    private $dateFactory;

    /** @var ConsoleQueryFactory */
    private $consoleQueryFactory;

    /** @var ActivityTimesheet */
    private $activityTimesheet;

    /**
     * @param DateFactory         $dateFactory
     * @param ConsoleQueryFactory $consoleQueryFactory
     * @param ActivityTimesheet   $activityTimesheet
     */
    public function __construct(
        DateFactory $dateFactory,
        ConsoleQueryFactory $consoleQueryFactory,
        ActivityTimesheet $activityTimesheet
    )
    {
        $this->dateFactory = $dateFactory;
        $this->consoleQueryFactory = $consoleQueryFactory;
        $this->activityTimesheet = $activityTimesheet;

        parent::__construct();
    }

    /** {@inheritdoc} */
    protected function configure()
    {
        $today = $this->dateFactory->today();

        $this->setName('tempo-simple:generate:activity-report');
        $this->setAliases(array('activity'));

        $this->addOption('month', '-m', InputOption::VALUE_REQUIRED,
            'Format: Y-m (e.g. 2014-01)', $today->getMonth()
        );
    }

    /** {@inheritdoc} */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $activityQuery = $this->consoleQueryFactory->makeActivity($input);

        $byDayTaskCollection = $this->activityTimesheet->match($activityQuery);

        $table = new Table($output);
        $table->setHeaders($byDayTaskCollection->getHeaders());
        $table->setRows($byDayTaskCollection->getRows());
        $table->render();
    }
}
