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
use TempoSimple\Bundle\SpaghettiBundle\Entity\TimeCardRepository;
use TempoSimple\Domain\TimeTracking\Project;
use TempoSimple\Domain\TimeTracking\Task;
use TempoSimple\Domain\TimeTracking\TimeCard;

class GenerateBillableReportCommand extends Command
{
    /** @var TimeCardRepository */
    private $timeCardrepository;

    /** @var EngineInterface */
    private $templating;

    /** @var string */
    private $defaultProject;

    /**
     * @param TimeCardRepository $timeCardrepository
     * @param EngineInterface    $templating
     * @param string             $defaultProject
     */
    public function __construct(
        TimeCardRepository $timeCardrepository,
        EngineInterface $templating,
        $defaultProject
    )
    {
        $this->timeCardrepository = $timeCardrepository;
        $this->templating = $templating;
        $this->defaultProject = $defaultProject;

        parent::__construct();
    }

    /** {@inheritdoc} */
    protected function configure()
    {
        $this->setName('tempo-simple:generate:billable-report');
        $this->setAliases(array('billable'));

        $this->addOption('project', '-p', InputOption::VALUE_REQUIRED, 'The project',
            $this->defaultProject
        );
        $this->addOption('month', '-m', InputOption::VALUE_REQUIRED,
            'Format: Y-m (e.g. 2014-01)', date('Y-m')
        );
    }

    /** {@inheritdoc} */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $month = $input->getOption('month');
        $projectName = $input->getOption('project');

        $project = new Project($projectName);

        $timeCards = $this->timeCardrepository->findBillable($month, $projectName);
        foreach ($timeCards as $timeCard) {
            $taskTitle = $timeCard->getTaskTitle();
            $startHour = $timeCard->getStartHour();
            $endHour = $timeCard->getEndHour();

            $timeCard = new TimeCard($startHour, $endHour);

            if (!$project->hasTask($taskTitle)) {
                $task = new Task($taskTitle);
                $project->addTask($task);
            }
            $task = $project->getTask($taskTitle);
            $task->addTimeCard($timeCard);
        }

        $view = 'TempoSimpleSpaghettiBundle:Report:billable.md.twig';
        $parameters = array('tasks' => $project->getTasks());

        $output->writeln($this->templating->render($view, $parameters));
    }
}
