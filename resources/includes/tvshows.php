<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/../vendor/autoload.php';
include_once('pagination.php');

function getShows($tvshows, $currentPage){
  $configs = require __DIR__.'/../../config.php';
  $showPerPage = $configs['GRID_ROWS'] * $configs['GRID_COLUMNS'];
  $total_pages = ceil(count($tvshows) / $showPerPage);
  $file = basename($_SERVER["SCRIPT_FILENAME"], '.php'); 
  $tvshows = array_slice($tvshows, ($currentPage - 1) * $showPerPage, $showPerPage);
  $content = '';
  $column = '';
  
  for ($i = 0; $i < count($tvshows); $i++) {
    $tvshow = $tvshows[$i];
    $id = $tvshow->getId();
    $title = $tvshow->getName();
    $overview = $tvshow->getOverview();
    $posterPath = $tvshow->getPosterPath();
    $rating = $tvshow->getVoteAverage() != 0 ? $tvshow->getVoteAverage() : '0.0';
    
    $column .= <<<HTML
    <div class="col-6 col-sm-2 image-wrapper">
      <div class="image-overlay-wrapper">
        <a href="tvshows?id={$id}">
          <img src="https://image.tmdb.org/t/p/w300/{$posterPath}">
          <div class="image-overlay-content">
            <h1>{$rating}<i class="far fa-star fa-sm"></i></h1>
            <h2>{$title}</h2>
            <p class="tvshow-overview">{$overview}</p>      
          </div>
        </a>
      </div>
    </div>
HTML;

}
$content .= '<div class="row no-gutters">'.$column.'</div>';

return $content . pagination($currentPage, $total_pages);
}
?>
