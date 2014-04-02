<?php

namespace SeoMetrics\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use SeoMetrics\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class GoogleController extends BaseController implements ControllerProviderInterface
{
	private $url;
	private $seostats;

	public function __construct($url)
	{
		parent::__construct($url);
	}

	public function connect(Application $app)
    {
    	$controllers = $app['controllers_factory'];

    	$controllers->get('/', function() use ($app) {
    		$pageRank = \SEOstats\Services\Google::getPageRank();
    		$pageSpeedScore = \SEOstats\Services\Google::getPagespeedScore();
    		$pageSpeedAnalysis = \SEOstats\Services\Google::getPagespeedAnalysis();
    		$siteIndexTotal = \SEOstats\Services\Google::getSiteindexTotal();
    		$backLinks = \SEOstats\Services\Google::getBacklinksTotal();

    		return $app['twig']->render('google.html.twig', array(
    			'pageRank' => $pageRank,
    			'pageSpeed' => array(
    				'score' => $pageSpeedScore,
    				'analysis' => $pageSpeedAnalysis),
    			'siteIndexTotal' => $siteIndexTotal,
    			'backLinks' => $backLinks
    		));    		
    	})->bind('google');

    	$controllers->get('/serp-search', function(Request $request) use ($app){
    		$keyword = $request->query->get('keyword');
    		$aux = \SEOstats\Services\Google::getSerps($keyword, 10, $this->url);
    		
    		$serps = array();
    		foreach($aux as $serp){
    			$serp['headline'] = utf8_encode($serp['headline']);
    			$serps[]=$serp;
    		}

    		return new JsonResponse($serps);
    	})->bind('serp_search');

    	return $controllers;
    }
}