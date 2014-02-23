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
use Symfony\Component\Console\Output\OutputInterface;

class GenerateWeeklyReportCommand extends ContainerAwareCommand
{
    /** {@inheritdoc} */
    protected function configure()
    {
        $this->setName('tempo-simple:generate:weekly-report');
        $this->setAliases(array('weekly'));
    }

    /** {@inheritdoc} */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $timeCardrepository = $this->getContainer()->get('tempo_simple_spaghetti.time_card_reporitory');
        $templating = $this->getContainer()->get('templating');

        $timeCards = $timeCardrepository->findForLastWeek();
        $projects = array();
        foreach ($timeCards as $timeCard) {
            $project = $timeCard->getProjectName();
            if (!isset($projects[$project])) {
                $projects[$project] = array();
            }

            $task = $timeCard->getTaskTitle();
            if (!isset($projects[$project][$task])) {
                $projects[$project][$task] = array();
            }

            $description = $timeCard->getDescription();
            if (!in_array($description, $projects[$project][$task])) {
                $projects[$project][$task][] = $description;
            }
        }
        $view = 'TempoSimpleSpaghettiBundle:Report:weekly.md.twig';
        $parameters = array('projects' => $projects);

        $output->writeln($templating->render($view, $parameters));
    }
}
