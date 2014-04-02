<?php

namespace SeoMetrics\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use SeoMetrics\Controller\BaseController;

class SeoMetricsController extends BaseController implements ControllerProviderInterface
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
    		$pageRanks = $this->getPageRanks();
    		return $app['twig']->render('index.html.twig', array(
    			'alexa' => $pageRanks['alexa'],
    			'google' => $pageRanks['google']
    		));
    	})->bind('index');

		return $controllers;
    }

    private function getPageRanks()
    {
    	try{
			$alexa = \SEOstats\Services\Alexa::getGlobalRank();
			$google = \SEOstats\Services\Google::getPageRank();
		}catch (SEOstatsException $e) {
		  	die($e->getMessage());
		}

		return array(
			'alexa' => $alexa,
			'google' => $google
		);	
    }
}