<?php
set_include_path($_SERVER['DOCUMENT_ROOT'].'/../resources/views/components/');

if (empty($_GET['page'])) {
	header('Location:popular-shows?page=1');
}
require_once __DIR__.'/components/tvshows.php';

$cacheKey = 'popular-tvshows';

if(!apcu_exists($cacheKey)){
    require_once __DIR__.'/../../scripts/cache/update_popular_tvshows.php';
}

$result = apcu_fetch($cacheKey);
$content = getShows($result, $_GET['page']);

include("header.php");
include("navigation.php");
echo '<main>'.$content.'</main>';
include("footer.php");