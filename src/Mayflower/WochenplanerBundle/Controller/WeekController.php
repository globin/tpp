<?php

namespace Mayflower\WochenplanerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WeekController extends Controller
{
    /**
     * shows week overview
     *
     * @param $year int The year to be shown, default null shows current
     * @param $week int The week to be shown, default null shows current
     */
    public function indexAction($year, $week)
    {
        $today = new \DateTime('today');
        $year = $year ? $year : $today->format('Y');
        $week = $week ? $week : $today->format('W');
        $persons = $this->getDoctrine()
            ->getRepository('MayflowerWochenplanerBundle:Person')
            ->findAll();
        $selectedDate = new \DateTime($year."W".sprintf('%02d', $week));
        $tasks = $this->getDoctrine()
            ->getRepository('MayflowerWochenplanerBundle:Task')
            ->findByWeek($selectedDate);
        return $this->render(
            'MayflowerWochenplanerBundle:Week:index.html.twig',
            array(
                'selectedDate' => $selectedDate,
                'year' => $year,
                'week' => $week,
                'persons' => $persons
            )
        );

    }

}
