<?php

$request_uri = basename(explode('?', $_SERVER['REQUEST_URI'], 2)[0], '.php');

switch ($request_uri) {
    case '':
        require '../resources/views/new_shows.php';
        break;
    case 'new-shows':
        require '../resources/views/new_shows.php';
        break;
    case 'popular-shows':
        require '../resources/views/popular_shows.php';
        break;
    case 'top-shows':
        require '../resources/views/top_shows.php';
        break;
    case 'tvshows':
        require '../resources/views/details.php';
        break;
    case 'cache-tvshows';
        require '../cronjobs/update.php';
        break;
    case '404':
        $page = '404';
        require '../resources/views/404.php';
        break;
    default:
        header('HTTP/1.0 404 Not Found');
        require '../resources/views/404.php';
        break;
}