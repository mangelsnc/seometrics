<?php

namespace SeoMetrics\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use SeoMetrics\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class MozscapeController extends BaseController implements ControllerProviderInterface
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
    		$mozRank = \SEOstats\Services\Mozscape::getMozRank();
    		$mozRankRaw = \SEOstats\Services\Mozscape::getMozRankRaw();
    		$linkCount = \SEOstats\Services\Mozscape::getLinkCount();
    		$equityLinkCount = \SEOstats\Services\Mozscape::getEquityLinkCount();
    		$pageAuthority = \SEOstats\Services\Mozscape::getPageAuthority();
    		$domainAuthority = \SEOstats\Services\Mozscape::getDomainAuthority();

    		return $app['twig']->render('mozscape.html.twig', array(
    			'mozRank' => $mozRank,
    			'mozRankRaw' => $mozRankRaw,
    			'linkCount' => $linkCount,
    			'equityLinkCount' => $equityLinkCount,
    			'pageAuthority' => $pageAuthority,
    			'domainAuthority' => $domainAuthority
    		));
    	})->bind('mozscape');

    	return $controllers;
    }
}