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

class GenerateDailyReportCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('tempo-simple:generate:daily-report');
        $this->setAliases(array('daily'));

        $this->addOption('date', '-d', InputOption::VALUE_REQUIRED,
            'Format: Y-m-d (e.g. 2014-01-23)', date('Y-m-d')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $timeCardrepository = $this->getContainer()->get('tempo_simple_spaghetti.time_card_reporitory');
        $templating = $this->getContainer()->get('templating');

        $date = $input->getOption('date');

        $timeCards = $timeCardrepository->findForDate($date);
        $tasks = array();
        foreach ($timeCards as $timeCard) {
            $task = $timeCard->getTaskTitle();
            if (!isset($tasks[$task])) {
                $tasks[$task] = array();
            }

            $description = $timeCard->getDescription();
            if (!in_array($description, $tasks[$task])) {
                $tasks[$task][] = $description;
            }
        }
        $view = 'TempoSimpleSpaghettiBundle:Report:daily.md.twig';
        $parameters = array(
            'tasks' => $tasks,
            'date' => $date,
        );

        $output->writeln($templating->render($view, $parameters));
    }
}
