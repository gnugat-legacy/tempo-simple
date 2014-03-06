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
use TempoSimple\DataSource\DoctrineBundle\Entity\TimeCardRepository;
use TempoSimple\DataSource\DoctrineBundle\Entity\TimeCard;
use TempoSimple\Service\TimeBundle\Factory\DateFactory;
use TempoSimple\Service\TimeBundle\Factory\TimeOfDayFactory;

class PunchTimeCardCommand extends Command
{
    /** @var DateFactory */
    private $dateFactory;

    /** @var TimeOfDayFactory */
    private $timeOfDayFactory;

    /** @var TimeCardRepository */
    private $timeCardRepository;

    /** @var string */
    private $defaultProject;

    /**
     * @param DateFactory        $dateFactory
     * @param TimeOfDayFactory   $timeOfDayFactory
     * @param TimeCardRepository $timeCardRepository
     * @param string             $defaultProject
     */
    public function __construct(
        DateFactory $dateFactory,
        TimeOfDayFactory $timeOfDayFactory,
        TimeCardRepository $timeCardRepository,
        $defaultProject
    )
    {
        $this->dateFactory = $dateFactory;
        $this->timeOfDayFactory = $timeOfDayFactory;
        $this->timeCardRepository = $timeCardRepository;
        $this->defaultProject = $defaultProject;

        parent::__construct();
    }

    /** {@inheritdoc} */
    protected function configure()
    {
        $today = $this->dateFactory->today()->getDay();
        try {
            $startHour = $this->timeCardRepository->findLastOneForDay($today);
        } catch (\Exception $e) {
            $startHour = '09:00';
        }

        $this->setName('tempo-simple:punch:time-card');
        $this->setAliases(array('punch'));

        $this->addArgument('task', InputArgument::REQUIRED);

        $this->addOption('project', '-p', InputOption::VALUE_REQUIRED,
            'What project are you working for?', $this->defaultProject
        );
        $this->addOption('description', '-D', InputOption::VALUE_REQUIRED,
            'What did you do?', ''
        );
        $this->addOption('date', '-d', InputOption::VALUE_REQUIRED,
            'Format: Y-m-d (e.g. 2014-01-23)', $today
        );
        $this->addOption('start-hour', '-S', InputOption::VALUE_REQUIRED,
            'Format: H:i (e.g. 18:00)', $startHour
        );
        $this->addOption('end-hour', '-E', InputOption::VALUE_REQUIRED,
            'Format: H:i (e.g. 18:15)', $this->timeOfDayFactory->now()->getHour()
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
            $input->getOption('end-hour'),
            $input->getOption('description')
        );

        $this->timeCardRepository->insert($timeCard);
    }
}
