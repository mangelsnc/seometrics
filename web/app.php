<?php

require_once __DIR__.'/../vendor/autoload.php';

use SeoMetrics\Controller\SeoMetricsController;
use SeoMetrics\Controller\AlexaController;
use SeoMetrics\Controller\GoogleController;
use SeoMetrics\Controller\MozscapeController;
use SeoMetrics\Controller\OpenSiteExplorerController;
use SeoMetrics\Controller\SistrixController;
use SeoMetrics\Controller\SocialMediaController;

const DOMAIN = "http://www.prosolutions.es";

$app = new Silex\Application();
$app['debug'] = true;
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'dbs.options' => array (
        'driver'    => 'pdo_mysql',
        'host'      => 'localhost',
        'dbname'    => 'seometrics',
        'user'      => '',
        'password'  => '',
        'charset'   => 'utf8',
	)
));
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app['domain'] = DOMAIN;

$app->mount('/', new SeoMetricsController(DOMAIN));
$app->mount('/alexa', new AlexaController(DOMAIN));
$app->mount('/google', new GoogleController(DOMAIN));
$app->mount('/mozscape', new MozscapeController(DOMAIN));
$app->mount('/ose', new OpenSiteExplorerController(DOMAIN));
$app->mount('/sistrix', new SistrixController(DOMAIN));
$app->mount('/social-media', new SocialMediaController(DOMAIN));

$app->run();
