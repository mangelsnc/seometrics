<?php

namespace SeoMetrics\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use SeoMetrics\Controller\BaseController;

class AlexaController extends BaseController implements ControllerProviderInterface
{   
	private $url;
	private $seostats;

	public function __construct($domain)
	{
		parent::__construct($domain);
	}

	public function connect(Application $app)
    {
    	$controllers = $app['controllers_factory'];

    	$controllers->get('/', function() use ($app){
    		$dailyTrafficTrendGraph = $this->getAlexaDailyTrafficTrendGraph();
    		$dailyPageViewsPercentGraph = $this->getAlexaDailyPageviewsPercentGraph();
    		$dailyPageViewsPerUserGraph = $this->getAlexaDailyPageviewsPerUserGraph();
    		$timeOnSiteGraph = $this->getAlexaTimeOnSiteGraph();
    		$bounceRatePercentGraph = $this->getAlexaBounceRatePercentGraph();
    		$searchVisitsGraph = $this->getAlexaSearchVisitsGraph();
    		$rankings = $this->getRankings();

    		return $app['twig']->render('alexa.html.twig', array(
    			'dailyTrafficTrendGraph' => $dailyTrafficTrendGraph,
    			'dailyPageViewsPercentGraph' => $dailyPageViewsPercentGraph,
    			'dailyPageViewsPerUserGraph' => $dailyPageViewsPerUserGraph,
    			'timeOnSiteGraph' => $timeOnSiteGraph,
    			'bounceRatePercentGraph' => $bounceRatePercentGraph,
    			'searchVisitsGraph' => $searchVisitsGraph,
    			'rankings' => $rankings
    		));
    	})->bind('alexa');

		return $controllers;
	}

	private function getAlexaDailyTrafficTrendGraph()
    {
    	return \SEOstats\Services\Alexa::getTrafficGraph(1, false, "auto", "auto");
    }

    private function getAlexaDailyPageViewsPercentGraph()
    {
    	return \SEOstats\Services\Alexa::getTrafficGraph(2, false, "auto", "auto");
    }

    private function getAlexaDailyPageViewsPerUserGraph()
    {
    	return \SEOstats\Services\Alexa::getTrafficGraph(3, false, "auto", "auto");
    }

    private function getAlexaTimeOnSiteGraph()
    {
    	return \SEOstats\Services\Alexa::getTrafficGraph(4, false, "auto", "auto");
    }

    private function getAlexaBounceRatePercentGraph()
    {
    	return \SEOstats\Services\Alexa::getTrafficGraph(5, false, "auto", "auto");
    }

    private function getAlexaSearchVisitsGraph()
    {
    	return \SEOstats\Services\Alexa::getTrafficGraph(6, false, "auto", "auto");
    }

    private function getRankings()
    {
    	return array(
    		'global' => \SEOstats\Services\Alexa::getGlobalRank(),
    		'monthly' => \SEOstats\Services\Alexa::getMonthlyRank(),
    		'weekly' => \SEOstats\Services\Alexa::getWeeklyRank(),
    		'daily' => \SEOstats\Services\Alexa::getDailyRank(),
    		'country' => \SEOstats\Services\Alexa::getCountryRank(),
    		'backlinks' => \SEOstats\Services\Alexa::getBacklinkCount(),
    		'pageloadtime' => \SEOstats\Services\Alexa::getPageLoadTime()
    	);
    }
}