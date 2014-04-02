<?php

namespace SeoMetrics\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use SeoMetrics\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class OpenSiteExplorerController extends BaseController implements ControllerProviderInterface
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
    	
    	$controllers->get('/', function() use ($app){
    		$ose = \SEOstats\Services\OpenSiteExplorer::getPageMetrics();

    		return $app['twig']->render('ose.html.twig', array(
    			'ose' => $ose
    		));
    	})->bind('ose');
    	
    	return $controllers;
    }
}
