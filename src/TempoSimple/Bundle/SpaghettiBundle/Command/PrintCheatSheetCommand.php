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

class PrintCheatSheetCommand extends ContainerAwareCommand
{
    /** {@inheritdoc} */
    protected function configure()
    {
        $this->setName('tempo-simple:print:cheat-sheet');
        $this->setAliases(array('cheat'));
    }

    /** {@inheritdoc} */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $templating = $this->getContainer()->get('templating');

        $view = 'TempoSimpleSpaghettiBundle::cheat-sheet.md.twig';

        $output->writeln($templating->render($view));
    }
}
