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
use TempoSimple\DomainModel\TimeTracking\Project;
use TempoSimple\Service\TimeBundle\Factory\DateFactory;
use TempoSimple\Service\TimeTrackingBundle\Timesheet\ActivityTimesheet;

class GenerateActivityReportCommand extends Command
{
    /** @var DateFactory */
    private $dateFactory;

    /** @var ActivityTimesheet */
    private $activityTimesheet;

    /** @var EngineInterface */
    private $templating;

    /**
     * @param DateFactory       $dateFactory
     * @param ActivityTimesheet $activityTimesheet
     * @param EngineInterface   $templating
     */
    public function __construct(
        DateFactory $dateFactory,
        ActivityTimesheet $activityTimesheet,
        EngineInterface $templating
    )
    {
        $this->dateFactory = $dateFactory;
        $this->activityTimesheet = $activityTimesheet;
        $this->templating = $templating;

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
        $month = $input->getOption('month');

        $days = $this->activityTimesheet->find($month);

        $view = 'TempoSimpleSpaghettiBundle:Report:activity.md.twig';
        $parameters = array('days' => $days);

        $output->writeln($this->templating->render($view, $parameters));
    }
}
