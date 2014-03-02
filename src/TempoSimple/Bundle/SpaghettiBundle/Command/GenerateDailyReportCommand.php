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

class GenerateDailyReportCommand extends Command
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
        $this->setName('tempo-simple:generate:daily-report');
        $this->setAliases(array('daily'));

        $this->addOption('date', '-d', InputOption::VALUE_REQUIRED,
            'Format: Y-m-d (e.g. 2014-01-23)', date('Y-m-d')
        );
    }

    /** {@inheritdoc} */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $date = $input->getOption('date');

        $timeCards = $this->timeCardRepository->findForDate($date);
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

        $output->writeln($this->templating->render($view, $parameters));
    }
}
