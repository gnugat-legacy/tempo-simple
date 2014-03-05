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
use TempoSimple\DomainModel\TimeTracking\Project;
use TempoSimple\DomainModel\TimeTracking\Task;
use TempoSimple\DomainModel\TimeTracking\TimeCard;
use TempoSimple\Service\TimeBundle\Factory\DateFactory;

class GenerateBillableReportCommand extends Command
{
    /** @var DateFactory */
    private $dateFactory;

    /** @var TimeCardRepository */
    private $timeCardRepository;

    /** @var EngineInterface */
    private $templating;

    /** @var string */
    private $defaultProject;

    /**
     * @param DateFactory        $dateFactory
     * @param TimeCardRepository $timeCardRepository
     * @param EngineInterface    $templating
     * @param string             $defaultProject
     */
    public function __construct(
        DateFactory $dateFactory,
        TimeCardRepository $timeCardRepository,
        EngineInterface $templating,
        $defaultProject
    )
    {
        $this->dateFactory = $dateFactory;
        $this->timeCardRepository = $timeCardRepository;
        $this->templating = $templating;
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
        $month = $input->getOption('month');
        $projectName = $input->getOption('project');

        $project = new Project($projectName);

        $timeCards = $this->timeCardRepository->findForMonthAndProject($month, $projectName);
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
