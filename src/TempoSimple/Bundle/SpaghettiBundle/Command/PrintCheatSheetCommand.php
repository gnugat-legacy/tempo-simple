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

class PrintCheatSheetCommand extends Command
{
    /** @var EngineInterface */
    private $templating;

    /** @var string */
    private $defaultProject;

    /**
     * @param EngineInterface $templating
     * @param string          $defaultProject
     */
    public function __construct(
        EngineInterface $templating,
        $defaultProject
    )
    {
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
        $view = 'TempoSimpleSpaghettiBundle::cheat-sheet.md.twig';
        $parameters = array(
            'defaultProject' => $this->defaultProject,
        );

        $output->writeln($this->templating->render($view, $parameters));
    }
}
