<?php

// composer autolad
require 'vendor/autoload.php';

$mainConfig = @require 'config.inc.php';
if (!$mainConfig || empty($mainConfig)) {
    die('Technical error'); // should throw an Exception and decide afterwards if to log it and/or what response should be given to the client
}

$dbConfig = $mainConfig['db']['default'];


//--------
// this should be in an external file, required on demand
Propel::init('src/models/build/conf/hwtest_iplesca-conf.php');
// add config.inc.php credentials
$propelConfig = Propel::getConfiguration();
$propelConfig['datasources'][$dbConfig['name']]['connection'] = array(
    'dsn'      => 'mysql:host=' . $dbConfig['host'] . ';dbname=' . $dbConfig['name'],
    'user'     => $dbConfig['username'],
    'password' => $dbConfig['password']
);
Propel::setConfiguration($propelConfig);
//--------

$app = new Silex\Application();
//$app['debug'] = true;
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

// general shared service to generate a proper page object
$app['createPage'] = $app->protect(function ($page = 'main') use ($app) {
    // minimum safety
    $definedPages = array('main', 'users');
    
    if (in_array(strtolower($page), $definedPages)) {
        // give it a proper a class name 
        // NOTE: the class will be autoloaded by composer, if there is one defined :P
        $page .= 'Page';
    } else {
        $page = 'Show404Page';
    }
    
    // Prepare the Twig template engine. This is not required in ajax mode
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__ . '/src/views',
    ));

    // fire the page controller and inject the template engine
    $pageController = new $page($app, $app['twig']);
    
    // the page controller will know what to do
    return $pageController;
});

// Routing for all pages
$app->get('/', function () use ($app) {
    return $app['createPage']('Main')->render();
})->bind('homepage');

$app->get('/users', function ($id = 0) use ($app) {
    return $app->redirect('/'); // no user, no page
});

$app->get('/users/{id}', function ($id) use ($app) {
    $userPage = $app['createPage']('Users');
    
    $userPage->info($id);
    
    return $userPage->render();
})->assert('id', '\d+')   // accept only digits
  ->bind('userspage');

// AJAX routing, if any
$app->get('/ajax/{controller}/{action}', function () use ($app) {
    // TODO, if time
});

// ... and finally deal with errors
$app->error(function () use ($app) {
    return $app['createPage']('Error')->render();
});

$app->run();

