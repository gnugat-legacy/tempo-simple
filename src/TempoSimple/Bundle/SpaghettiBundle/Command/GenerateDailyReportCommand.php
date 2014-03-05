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

class GenerateDailyReportCommand extends Command
{
    /** @var DateFactory */
    private $dateFactory;

    /** @var TimeCardRepository */
    private $timeCardRepository;

    /** @var EngineInterface */
    private $templating;

    /**
     * @param DateFactory        $dateFactory
     * @param TimeCardRepository $timeCardRepository
     * @param EngineInterface    $templating
     */
    public function __construct(
        DateFactory $dateFactory,
        TimeCardRepository $timeCardRepository,
        EngineInterface $templating
    )
    {
        $this->dateFactory = $dateFactory;
        $this->timeCardRepository = $timeCardRepository;
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

        $timeCards = $this->timeCardRepository->findForDay($day);
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
            'date' => $day,
        );

        $output->writeln($this->templating->render($view, $parameters));
    }
}
