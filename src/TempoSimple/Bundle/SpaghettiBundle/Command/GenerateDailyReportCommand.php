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
use TempoSimple\DataSource\DoctrineBundle\Entity\TimeCardRepository;
use TempoSimple\Service\TimeBundle\Factory\DateFactory;
use TempoSimple\Service\TimeTrackingBundle\Timesheet\DailyTimesheet;

class GenerateDailyReportCommand extends Command
{
    /** @var DateFactory */
    private $dateFactory;

    /** @var DailyTimesheet   */
    private $dailyTimesheet;

    /** @var EngineInterface */
    private $templating;

    /**
     * @param DateFactory     $dateFactory
     * @param DailyTimesheet  $dailyTimesheet
     * @param EngineInterface $templating
     */
    public function __construct(
        DateFactory $dateFactory,
        DailyTimesheet $dailyTimesheet,
        EngineInterface $templating
    )
    {
        $this->dateFactory = $dateFactory;
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
        $day = $input->getOption('date');

        $tasks = $this->dailyTimesheet->find($day);

        $view = 'TempoSimpleSpaghettiBundle:Report:daily.md.twig';
        $parameters = array(
            'tasks' => $tasks,
            'date' => $day,
        );

        $output->writeln($this->templating->render($view, $parameters));
    }
}
