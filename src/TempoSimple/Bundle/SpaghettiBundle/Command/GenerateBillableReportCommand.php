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

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use TempoSimple\Domain\TimeTracking\TimeCard;

class GenerateBillableReportCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('tempo-simple:generate:billable-report');
        $this->setAliases(array('billable'));

        $this->addOption('project', '-p', InputOption::VALUE_REQUIRED, 'The project',
            'Project 1'
        );
        $this->addOption('month', '-m', InputOption::VALUE_REQUIRED,
            'Format: Y-m (e.g. 2014-01)', date('Y-m')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $timeCardrepository = $this->getContainer()->get('tempo_simple_spaghetti.time_card_reporitory');
        $templating = $this->getContainer()->get('templating');

        $timeCards = $timeCardrepository->findBillable(
            $input->getOption('month'),
            $input->getOption('project')
        );

        $workingHours = array();
        foreach ($timeCards as $timeCard) {
            $task = $timeCard->getTaskTitle();
            if (!isset($workingHours[$task])) {
                $workingHours[$task] = 0.0;
            }

            $timeCard = new TimeCard(
                $timeCard->getStartHour(),
                $timeCard->getEndHour()
            );

            $workingHours[$task] += $timeCard->getWorkingHours();
        }

        $workingDays = array();
        foreach ($workingHours as $task => $workingHour) {
            $workingDays[$task] = $workingHour / 8.0;
        }
        $view = 'TempoSimpleSpaghettiBundle:Report:billable.md.twig';
        $parameters = array('workingDays' => $workingDays);

        $output->writeln($templating->render($view, $parameters));
    }
}
