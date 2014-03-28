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
use TempoSimple\Service\TimeTrackingBundle\Timesheet\BillableTimesheet;

class GenerateBillableReportCommand extends Command
{
    /** @var DateFactory */
    private $dateFactory;

    /** @var ConsoleQueryFactory */
    private $consoleQueryFactory;

    /** @var BillableTimesheet */
    private $billableTimesheet;

    /** @var string */
    private $defaultProject;

    /**
     * @param DateFactory         $dateFactory
     * @param ConsoleQueryFactory $consoleQueryFactory
     * @param BillableTimesheet   $billableTimesheet
     * @param string              $defaultProject
     */
    public function __construct(
        DateFactory $dateFactory,
        ConsoleQueryFactory $consoleQueryFactory,
        BillableTimesheet $billableTimesheet,
        $defaultProject
    )
    {
        $this->dateFactory = $dateFactory;
        $this->consoleQueryFactory = $consoleQueryFactory;
        $this->billableTimesheet = $billableTimesheet;
        $this->defaultProject = $defaultProject;

        parent::__construct();
    }

    /** {@inheritdoc} */
    protected function configure()
    {
        $today = $this->dateFactory->today();

        $this->setName('tempo-simple:generate:billable-report');
        $this->setAliases(array('billable'));

        $this->addOption('project', '-p', InputOption::VALUE_REQUIRED, 'The project',
            $this->defaultProject
        );
        $this->addOption('month', '-m', InputOption::VALUE_REQUIRED,
            'Format: Y-m (e.g. 2014-01)', $today->getMonth()
        );
    }

    /** {@inheritdoc} */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $billableQuery = $this->consoleQueryFactory->makeBillable($input);

        $byTitleTaskCollection = $this->billableTimesheet->match($billableQuery);

        $table = new Table($output);
        $table->setHeaders($byTitleTaskCollection->getHeaders());
        $table->setRows($byTitleTaskCollection->getRows());
        $table->render();
    }
}
