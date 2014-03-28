<?php

/*
 * This file is part of the TempoSimple project.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TempoSimple\Application\WebBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FrontController extends Controller
{
    /**
     * @Method({"GET"})
     * @Route("/activity")
     * @Template
     *
     * @param Request $request
     *
     * @return array
     */
    public function activityAction(Request $request)
    {
        $webQueryFactory = $this->get('tempo_simple_web.web_query_factory');
        $activityTimesheet = $this->get('tempo_simple_time_tracking.activity_timesheet');

        $activityQuery = $webQueryFactory->makeActivity($request);
        $byDayTaskCollection = $activityTimesheet->find($activityQuery->getMonth());

        return array(
            'byDayTaskCollection' => $byDayTaskCollection,
        );
    }
}
