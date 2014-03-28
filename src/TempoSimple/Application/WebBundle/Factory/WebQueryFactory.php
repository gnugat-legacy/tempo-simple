<?php

/*
 * This file is part of the TempoSimple project.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TempoSimple\Application\WebBundle\Factory;

use Symfony\Component\HttpFoundation\Request;
use TempoSimple\Service\TimeBundle\Factory\DateFactory;
use TempoSimple\Service\TimeTrackingBundle\Query\ActivityQuery;

class WebQueryFactory
{
    /** @var DateFactory */
    private $dateFactory;

    /** @param DateFactory $dateFactory */
    public function __construct(DateFactory $dateFactory)
    {
        $this->dateFactory = $dateFactory;
    }

    /**
     * @param Request $request
     *
     * @return ActivityQuery
     */
    public function makeActivity(Request $request)
    {
        $today = $this->dateFactory->today();
        $month = $request->request->get('month', $today->getMonth());

        return new ActivityQuery($month);
    }
}
