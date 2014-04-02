<?php

namespace SeoMetrics\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use SeoMetrics\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use \SEOstats\Services\Social as SocialMedia;

class SocialMediaController extends BaseController implements ControllerProviderInterface
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
    		$google = SocialMedia::getGooglePlusShares();
    		$facebook = SocialMedia::getFacebookShares();
    		$twitter = SocialMedia::getTwitterShares();
    		$linkedin = SocialMedia::getLinkedInShares();
    		$pinterest = SocialMedia::getPinterestShares();

    		return $app['twig']->render('social-media.html.twig', array(
    			'google' => $google,
    			'facebook' => $facebook,
    			'twitter' => $twitter,
    			'linkedin' => $linkedin,
    			'pinterest' => $pinterest
    		));
    	})->bind('social_media');

    	return $controllers;
    }
}