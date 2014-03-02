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
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Templating\EngineInterface;
use TempoSimple\Bundle\SpaghettiBundle\Entity\TimeCardRepository;
use TempoSimple\Bundle\SpaghettiBundle\Entity\TimeCard;

class PunchTimeCardCommand extends Command
{
    /** @var TimeCardRepository */
    private $timeCardRepository;

    /** @var string */
    private $defaultProject;

    /**
     * @param TimeCardRepository $timeCardRepository
     * @param string             $defaultProject
     */
    public function __construct(
        TimeCardRepository $timeCardRepository,
        $defaultProject
    )
    {
        $this->timeCardRepository = $timeCardRepository;
        $this->defaultProject = $defaultProject;

        parent::__construct();
    }

    /** {@inheritdoc} */
    protected function configure()
    {
        try {
            $startHour = $this->timeCardRepository->findLastOne();
        } catch (\Exception $e) {
            $startHour = '09:00';
        }

        $this->setName('tempo-simple:punch:time-card');
        $this->setAliases(array('punch'));

        $this->addArgument('task', InputArgument::REQUIRED);
        $this->addArgument('end-hour', InputArgument::REQUIRED, 'Format: H:i (e.g. 18:15)');

        $this->addOption('project', '-p', InputOption::VALUE_REQUIRED,
            'What project are you working for?', $this->defaultProject
        );
        $this->addOption('description', '-D', InputOption::VALUE_REQUIRED,
            'What did you do?', ''
        );
        $this->addOption('date', '-d', InputOption::VALUE_REQUIRED,
            'Format: Y-m-d (e.g. 2014-01-23)', date('Y-m-d')
        );
        $this->addOption('start-hour', '-S', InputOption::VALUE_REQUIRED,
            'Format: H:i (e.g. 18:00)', $startHour
        );
    }

    /** {@inheritdoc} */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $timeCard = new TimeCard(
            $input->getOption('project'),
            $input->getArgument('task'),
            $input->getOption('date'),
            $input->getOption('start-hour'),
            $input->getArgument('end-hour'),
            $input->getOption('description')
        );

        $this->timeCardRepository->insert($timeCard);
    }
}
