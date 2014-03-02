<?php

/*
 * This file is part of the TempoSimple project.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TempoSimple\DataSource\DoctrineBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table("time_card")
 * @ORM\Entity(repositoryClass = "TempoSimple\DataSource\DoctrineBundle\Entity\TimeCardRepository")
 */
class TimeCard
{
    /**
     * @var integer
     *
     * @ORM\Column(name = "id", type = "integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy = "AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type = "string", name = "project_name")
     */
    private $projectName;

    /**
     * @var string
     *
     * @ORM\Column(type = "string", name = "task_title")
     */
    private $taskTitle;

    /**
     * @var string
     *
     * @ORM\Column(type = "string", name = "entry_date")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(type = "string", name = "start_hour")
     */
    private $startHour;

    /**
     * @var string
     *
     * @ORM\Column(type = "string", name = "end_hour")
     */
    private $endHour;

    /**
     * @var string
     *
     * @ORM\Column(type = "text", name = "description")
     */
    private $description;

    /**
     * @var DateTime
     *
     * @ORM\Column(type = "datetime", name = "created_at")
     */
    private $createdAt;

    /**
     * @param string $projectName
     * @param string $taskTitle
     * @param string $date
     * @param string $startHour
     * @param string $endHour
     * @param string $description
     */
    public function __construct(
        $projectName,
        $taskTitle,
        $date,
        $startHour,
        $endHour,
        $description = ''
    )
    {
        $this->projectName = $projectName;
        $this->taskTitle = $taskTitle;
        $this->description = $description;
        $this->date = $date;
        $this->startHour = $startHour;
        $this->endHour = $endHour;

        $this->createdAt = new DateTime();
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getProjectName()
    {
        return $this->projectName;
    }

    /**
     * @return string
     */
    public function getTaskTitle()
    {
        return $this->taskTitle;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getStartHour()
    {
        return $this->startHour;
    }

    /**
     * @return string
     */
    public function getEndHour()
    {
        return $this->endHour;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
