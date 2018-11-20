<?php
set_include_path($_SERVER['DOCUMENT_ROOT'].'/../resources/includes/');
require_once __DIR__.'/../../vendor/autoload.php';
$token  = new \Tmdb\ApiToken('b616193ba38eec32e0603fae57f97cbe');
$client = new \Tmdb\Client($token);
$tvRepository = new \Tmdb\Repository\TvRepository($client);

if(!isset($_GET['id'])){
    header('Location:/404');
}

$tvshow = $tvRepository->load($_GET['id']); //apcu_fetch($_GET['id']);
$title = $tvshow->getName();
$firstAirDate = $tvshow->getFirstAirDate();
$lastAirDate = $tvshow->getLastAirDate();
$nextAirDate = $tvshow->getNextEpisodeToAir() ? $tvshow->getNextEpisodeToAir() : null;
$networks = $tvshow->getNetworks();
$genres = $tvshow->getGenres();
$rating = $tvshow->getVoteAverage();
$overview = $tvshow->getOverview();
$numberOfEpisodes = $tvshow->getNumberOfEpisodes();
$numberOfSeasons = $tvshow->getNumberOfSeasons();
$status = $tvshow->getStatus();

$isNew = '';

if($nextAirDate){
    $nextAirDate = '<span class="badge badge-success">'.$nextAirDate->format('Y-m-d').'</span>';
}
else{
    if($status == 'Canceled')
        $nextAirDate  = '<span class="badge badge-danger">Canceled</span>';
    elseif($status == 'Ended')
        $nextAirDate  = '<span class="badge badge-warning">Ended</span>';
    elseif($status == 'In Production')
        $nextAirDate  = '<span class="badge badge-primary">In Production</span>';
    elseif($status == 'Returning Series')
        $nextAirDate = '<span class="badge badge-success">Returning</span>';
}

$today = new DateTime();
$difference = $firstAirDate->diff($today);

if($difference->y == 0 && $difference->m < 6){
    $isNew = 'New';
}

//Popularity stars
$popularity = $tvshow->getPopularity();
$numberOfStars = 0;
$stars = '';

switch ($popularity) {
    case $popularity >= 40:
        $numberOfStars = 5;
        break;
    case $popularity >= 20:
        $numberOfStars = 4;
        break;
    case $popularity >= 10:
        $numberOfStars = 3;
        break;
    case $popularity >= 5:
        $numberOfStars = 2;
        break;
    case $popularity >= 0:
        $numberOfStars = 1;
        break;
}

for($i = 0; $i < $numberOfStars; $i++){
    $stars .= '<i class="fas fa-star" style="font-size: 1.3rem; color: #ff0"></i>';
}

include("header.php");
include("navigation.php");
?>
    <div class="row no-gutters" style="background-color: #e9ecef">
        <div class="col-12 col-md-4">
            <img class="img-fluid details-img" src="http://image.tmdb.org/t/p/w500/<?php echo $tvshow->getPosterPath() ?>">
        </div>
        <div class="col-12 col-md-8">
            <div id="details-content" class="jumbotron">
                <h1><b><?php echo $title ?> <small class="text-muted">(<?php echo $firstAirDate->format('Y') ?>)</small></b>  <span class="badge badge-dark"><?php echo $isNew ?></span></h1>
                <p class="text-muted" id="genres">
                    <small>
                        <?php 
                            $i = 0; 
                            foreach($genres as $genre){
                                if($i < $genres->count()-1){
                                    echo $genre->getName().' | ';
                                }
                                else{
                                    echo $genre->getName();
                                }
                                $i++;
                            }
                        ?>
                    </small>
                </p>
                <p class="lead details-overview"><?php echo $overview ?></p>
                <hr class="my-4">
                <h6><b>Popularity:</b> <?php echo $stars ?></h6>
                <h6><b>Rating:</b> <?php echo $rating ?> </h6>
                <h6><b>Next Episode:</b> <?php echo $nextAirDate ?></h6>
                <h6><b>Previous Episode:</b> <span class="badge badge-primary"><?php echo $lastAirDate->format('Y-m-d') ?></span></h6>
                <hr class="my-4">
                <h6><b>Episodes:</b> <?php echo $numberOfEpisodes ?></h6>
                <h6><b>Seasons:</b> <?php echo $numberOfSeasons ?></h6>
                <h6>
                    <b>Networks:</b> 
                        <?php 
                            $i = 0; 
                            foreach($networks as $network){
                                if($i < $networks->count()-1){
                                    echo $network->getName().' | ';
                                }
                                else{
                                    echo $network->getName();
                                }
                                $i++;
                            }
                        ?>
                </h6>
                <hr class="my-4">
                <div class="details-video-wrapper">
                    <?php
                    $trailerUrl = '';
                    foreach($tvshow->getVideos() as $key => $video){
                        $video->setUrlFormat('https://www.youtube.com/embed/%s');
                        $trailerUrl = $video->getUrl();
                        echo '<div class="details-video embed-responsive embed-responsive-16by9">
                                <iframe class="embed-responsive-item" src='.$trailerUrl.' width="300"></iframe>
                                </div>';
                    }

                    ?>
                </div>
            </div>
        </div>
    </div>
<?php

include("footer.php");