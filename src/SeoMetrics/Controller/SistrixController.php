<?php

namespace SeoMetrics\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use SeoMetrics\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class SistrixController extends BaseController implements ControllerProviderInterface
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

    	$controllers->get('/', function() use($app){
    		$visibilityIndex = \SEOstats\Services\Sistrix::getVisibilityIndex();

    		return $app['twig']->render('sistrix.html.twig', array(
    			'visibilityIndex' => $visibilityIndex
    		));

    	})->bind('sistrix');

		return $controllers;
    }
}