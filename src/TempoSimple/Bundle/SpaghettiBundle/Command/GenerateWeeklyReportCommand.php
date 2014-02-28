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
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Templating\EngineInterface;
use TempoSimple\Bundle\SpaghettiBundle\Entity\TimeCardRepository;

class GenerateWeeklyReportCommand extends Command
{
    /** @var TimeCardRepository */
    private $timeCardRepository;

    /** @var EngineInterface */
    private $templating;

    /**
     * @param TimeCardRepository $timeCardRepository
     * @param EngineInterface    $templating
     */
    public function __construct(
        TimeCardRepository $timeCardRepository,
        EngineInterface $templating
    )
    {
        $this->timeCardRepository = $timeCardRepository;
        $this->templating = $templating;

        parent::__construct();
    }

    /** {@inheritdoc} */
    protected function configure()
    {
        $this->setName('tempo-simple:generate:weekly-report');
        $this->setAliases(array('weekly'));
    }

    /** {@inheritdoc} */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $timeCards = $this->timeCardRepository->findForLastWeek();
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

        $output->writeln($this->templating->render($view, $parameters));
    }
}
