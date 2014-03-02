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

class PrintCheatSheetCommand extends Command
{
    /** @var TimeCardRepository */
    private $timeCardRepository;

    /** @var EngineInterface */
    private $templating;

    /** @var string */
    private $defaultProject;

    /**
     * @param TimeCardRepository $timeCardRepository
     * @param EngineInterface    $templating
     * @param string             $defaultProject
     */
    public function __construct(
        TimeCardRepository $timeCardRepository,
        EngineInterface $templating,
        $defaultProject
    )
    {
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
        $startHour = $this->timeCardRepository->findLastOne();

        $view = 'TempoSimpleSpaghettiBundle::cheat-sheet.md.twig';
        $parameters = array(
            'defaultProject' => $this->defaultProject,
            'startHour' => $startHour
        );

        $output->writeln($this->templating->render($view, $parameters));
    }
}
