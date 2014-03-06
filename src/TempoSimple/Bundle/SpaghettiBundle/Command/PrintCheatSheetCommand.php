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
use TempoSimple\DataSource\DoctrineBundle\Entity\TimeCardRepository;
use TempoSimple\Service\TimeBundle\Factory\DateFactory;
use TempoSimple\Service\TimeBundle\Factory\TimeOfDayFactory;

class PrintCheatSheetCommand extends Command
{
    /** @var DateFactory */
    private $dateFactory;

    /** @var TimeOfDayFactory */
    private $timeOfDayFactory;

    /** @var TimeCardRepository */
    private $timeCardRepository;

    /** @var EngineInterface */
    private $templating;

    /** @var string */
    private $defaultProject;

    /**
     * @param DateFactory        $dateFactory
     * @param TimeOfDayFactory   $timeOfDayFactory
     * @param TimeCardRepository $timeCardRepository
     * @param EngineInterface    $templating
     * @param string             $defaultProject
     */
    public function __construct(
        DateFactory $dateFactory,
        TimeOfDayFactory $timeOfDayFactory,
        TimeCardRepository $timeCardRepository,
        EngineInterface $templating,
        $defaultProject
    )
    {
        $this->dateFactory = $dateFactory;
        $this->timeOfDayFactory = $timeOfDayFactory;
        $this->timeCardRepository = $timeCardRepository;
        $this->templating = $templating;
        $this->defaultProject = $defaultProject;

        parent::__construct();
    }

    /** {@inheritdoc} */
    protected function configure()
    {
        $this->setName('tempo-simple:print:cheat-sheet');
        $this->setAliases(array('cheat'));
    }

    /** {@inheritdoc} */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $today = $this->dateFactory->today();
        $startHour = $this->timeCardRepository->findLastOneForDay($today->getDay());
        $now = $this->timeOfDayFactory->now();
        $endHour = $now->getHour();

        $view = 'TempoSimpleSpaghettiBundle::cheat-sheet.md.twig';
        $parameters = array(
            'defaultProject' => $this->defaultProject,
            'startHour' => $startHour,
            'endHour' => $endHour,
            'today' => $today,
        );

        $output->writeln($this->templating->render($view, $parameters));
    }
}
