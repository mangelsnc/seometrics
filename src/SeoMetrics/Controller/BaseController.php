<?php

namespace SeoMetrics\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class BaseController
{   
	private $url;
	private $seostats;

	public function __construct($domain)
	{
		$this->url = $domain;
		$this->seostats = new \SEOstats\SEOstats;
		$this->seostats->setUrl($this->url);
	}
}