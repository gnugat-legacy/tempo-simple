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
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Templating\EngineInterface;
use TempoSimple\Service\TimeBundle\Factory\DateFactory;
use TempoSimple\Bundle\SpaghettiBundle\Factory\ConsoleQueryFactory;
use TempoSimple\Service\TimeTrackingBundle\Timesheet\DailyTimesheet;

class GenerateDailyReportCommand extends Command
{
    /** @var DateFactory */
    private $dateFactory;

    /** @var ConsoleQueryFactory */
    private $consoleQueryFactory;

    /** @var DailyTimesheet   */
    private $dailyTimesheet;

    /** @var EngineInterface */
    private $templating;

    /**
     * @param DateFactory         $dateFactory
     * @param ConsoleQueryFactory $consoleQueryFactory
     * @param DailyTimesheet      $dailyTimesheet
     * @param EngineInterface     $templating
     */
    public function __construct(
        DateFactory $dateFactory,
        ConsoleQueryFactory $consoleQueryFactory,
        DailyTimesheet $dailyTimesheet,
        EngineInterface $templating
    )
    {
        $this->dateFactory = $dateFactory;
        $this->consoleQueryFactory = $consoleQueryFactory;
        $this->dailyTimesheet = $dailyTimesheet;
        $this->templating = $templating;

        parent::__construct();
    }

    /** {@inheritdoc} */
    protected function configure()
    {
        $today = $this->dateFactory->today();

        $this->setName('tempo-simple:generate:daily-report');
        $this->setAliases(array('daily'));

        $this->addOption('date', '-d', InputOption::VALUE_REQUIRED,
            'Format: Y-m-d (e.g. 2014-01-23)', $today->getDay()
        );
    }

    /** {@inheritdoc} */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $dailyQuery = $this->consoleQueryFactory->makeDaily($input);
        $day = $dailyQuery->getDay();

        $tasks = $this->dailyTimesheet->match($dailyQuery);

        $view = 'TempoSimpleSpaghettiBundle:Report:daily.md.twig';
        $parameters = array(
            'tasks' => $tasks,
            'date' => $day,
        );

        $output->writeln($this->templating->render($view, $parameters));
    }
}
