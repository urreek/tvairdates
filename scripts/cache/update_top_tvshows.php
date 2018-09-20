<?php

require_once __DIR__.'/../../vendor/autoload.php';

$configs = require __DIR__.'/../../config.php';

$token  = new \Tmdb\ApiToken('b616193ba38eec32e0603fae57f97cbe');
$client = new \Tmdb\Client($token);
$tvRepository = new \Tmdb\Repository\TvRepository($client);

$tvshows = $tvshows = $tvRepository->getTopRated();

$shows = array();
$tempShows = array();

for($i = 1; $i <= $tvshows->getTotalPages(); $i++){
    $tvshows = $tvRepository->getTopRated(['page' => $i]);
	
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

apcu_store('top-tvshows', $shows);