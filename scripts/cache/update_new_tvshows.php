<?php

require_once __DIR__.'/../../vendor/autoload.php';

$configs = require __DIR__.'/../../config.php';

$token  = new \Tmdb\ApiToken('b616193ba38eec32e0603fae57f97cbe');
$client = new \Tmdb\Client($token);
$tvDiscoverrepository = new \Tmdb\Repository\DiscoverRepository($client);
$query = new \Tmdb\Model\Query\Discover\DiscoverTvQuery();

$startDate = new DateTime();
$startDate = $startDate->modify('-6 month');
$query->page(1)->language('en')->sortBy('popularity.desc')->firstAirDateGte($startDate)->firstAirDateLte(new DateTime());
$tvshows = $tvDiscoverrepository->discoverTv($query);

$shows = array();
$tempShows = array();

for($i = 1; $i <= $tvshows->getTotalPages(); $i++){
    $startDate = new DateTime();
	$startDate = $startDate->modify('-3 month');
	$endDate = new DateTime();
	$endDate = $endDate->modify('+3 month');
    $query->page($i)->language('en')->sortBy('popularity.desc')->firstAirDateGte($startDate)->firstAirDateLte($endDate);
    $tvshows = $tvDiscoverrepository->discoverTv($query);
	
	foreach($tvshows as $tvshow){
		if($tvshow->getPosterPath() != null){
			$shows[] = $tvshow;
			if(count($shows) == ($configs['GRID_ROWS'] * $configs['GRID_COLUMNS'] * $configs['MAX_PAGES'])){
				break;
			}
		}
	}

	usleep(125000);

	if(count($shows) == ($configs['GRID_ROWS'] * $configs['GRID_COLUMNS'] * $configs['MAX_PAGES'])){
		break;
	}
}

apcu_store('new-tvshows', $shows);