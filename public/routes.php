<?php

// all requests are redirected to this file.
// use your .htaccess file to set this up.

error_reporting(-1);
require_once(__dir__ . '/../vendor/autoload.php');
require(__dir__ . '/../resources/config.php');


$klein = new Klein\Klein;

// First, let's setup the layout our site will use. By passing
// an anonymous function in Klein will respond to all methods/URI's.
$klein->respond(function ($request, $response, $service) {
    $service->layout('../resources/layouts/default.php');
});

// Home page view
$klein->respond('/', function ($request, $response, $service) {
    // add some data to the view.
    $service->pageTitle = 'RESTAURANT BEOORDELEN';

    // This is the function that renders the view inside the layout.
    $service->render(VIEWS.'/home.php');
});

// Home page view
$klein->respond('/login', function ($request, $response, $service) {
    // add some data to the view.
    $service->pageTitle = 'LOGIN';

    // This is the function that renders the view inside the layout.
    $service->render(VIEWS.'/login.php');
});

// Home page view
$klein->respond('/uitloggen', function ($request, $response, $service) {
    // add some data to the view.
    $service->pageTitle = 'UITLOGGEN';

    // This is the function that renders the view inside the layout.
    $service->render(VIEWS.'/uitloggen.php');
});

// LOGO API
$klein->respond('GET', '/logo/[:naam]', function ($request, $response, $service) {
    $naam = $request->naam;
    $path = FOTO . "/" . $naam;

    $filename = basename($path);
    $file_extension = strtolower(substr(strrchr($filename,"."),1));

    switch( $file_extension ) {
        case "gif": $ctype="image/gif"; break;
        case "png": $ctype="image/png"; break;
        case "jpeg":
        case "jpg": $ctype="image/jpeg"; break;
        default:
    }

    header('Content-Type:'.$ctype);
    header('Content-Length: ' . filesize($path));
    readfile($path);
});
$klein->respond('GET', '/logo/[:naam]', function ($request, $response, $service) {
    $naam = $request->naam;
    $path = FOTO . "/" . $naam;

    $filename = basename($path);
    $file_extension = strtolower(substr(strrchr($filename,"."),1));

    switch( $file_extension ) {
        case "gif": $ctype="image/gif"; break;
        case "png": $ctype="image/png"; break;
        case "jpeg":
        case "jpg": $ctype="image/jpeg"; break;
        default:
    }

    header('Content-Type:'.$ctype);
    header('Content-Length: ' . filesize($path));
    readfile($path);
});

$klein->respond('GET', '/user/[:naam]', function ($request, $response, $service) {
    $naam = $request->naam;
    $path = USERFOTO . "/" . $naam;

    $filename = basename($path);
    $file_extension = strtolower(substr(strrchr($filename,"."),1));

    switch( $file_extension ) {
        case "gif": $ctype="image/gif"; break;
        case "png": $ctype="image/png"; break;
        case "jpeg":
        case "jpg": $ctype="image/jpeg"; break;
        default:
    }

    header('Content-Type:'.$ctype);
    header('Content-Length: ' . filesize($path));
    readfile($path);
});

// RESTAURANT API
$klein->respond('/restaurant/[:naam]', function ($request, $response, $service) {
    $service->naam = $request->naam;
    $service->pageTitel = $request->naam;

    $service->render(VIEWS.'/restaurant.php');
});


// HTTP ERRORS
$klein->onHttpError(function ($code, $router) {
    switch ($code) {
        case 404:
            $router->response()->body(
                '404 - Ik kan niet vinden waar u naar zoekt.'
            );
            break;
        case 405:
            $router->response()->body(
                '405 - U heeft geen toestemming hier te komen.'
            );
            break;
        default:
            $router->response()->body(
                'Oh nee, er is iets ergs gebeurt! Errorcode:'. $code
            );
    }
});

$klein->dispatch();
