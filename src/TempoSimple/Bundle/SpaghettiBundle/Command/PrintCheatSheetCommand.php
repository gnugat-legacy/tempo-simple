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

    /**
     * @param EngineInterface $templating
     */
    public function __construct(
        EngineInterface $templating
    )
    {
        $this->templating = $templating;

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

        $output->writeln($this->templating->render($view));
    }
}
