<?php
/**
 * Created by PhpStorm.
 * User: guerosf
 * Date: 02.08.17
 * Time: 12:57
 */

use model\Url;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

require_once __DIR__ . '/bootstrap.php';


$app = new \Slim\App();

/** @var \Slim\Container $container */
$container = $app->getContainer();

$settings = $container->get('settings');
$settings->replace([
    'displayErrorDetails' => true,
]);

$container['entityManager'] = function ($container) use ($entityManager) {
    return $entityManager;
};

$container['view'] = function (\Psr\Container\ContainerInterface $container) {
    $view = new \Slim\Views\Twig(__DIR__ . '/src/templates');

    $router = $container->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new \Slim\Views\TwigExtension($router, $uri));

    return $view;
};

$container[\src\Controllers\AuthenticationController::class] = function (\Psr\Container\ContainerInterface $container) {
    return new \src\Controllers\AuthenticationController($container->get('view'));
};

$app->add(function(Request $request, Response $response, $next) {

    $auth = new \src\components\Authentication($this->entityManager, $this->get('request'));

    $userIsLogin = $auth->wasLogin() || $auth->login();
    $currentPathIsLogin = $request->getUri()->getPath() === $this->get('router')->pathFor('login');
    var_dump($userIsLogin);

//    $auth->logout();

    if (!$userIsLogin && !$currentPathIsLogin) {
//    if (true) {
        var_dump('in redirect');
//        session_destroy();


        $uri = $request->getUri()->withPath($this->get('router')->pathFor('login'));
        $response = $response->withRedirect($uri, 200);


//        return $this->get('view')->render($response, 'login.html.twig', ['error' => 'saffa']);

        return $response;

//        return $this->get('router')->redirect('','/login', 200);

//        return $this->get('twig')->render('login.html.twig', ['error' => '']);
    }

    if ($userIsLogin && $currentPathIsLogin) {
        $response = $response->withRedirect('/', 200);
    } else {
        $request = $request->withAttribute('error', 'sfsafa');
    }

    return $next($request, $response);
});

$app->map(['GET', 'POST'],'/login', \src\Controllers\AuthenticationController::class . ':login')->setName('login');

$app->get('/', function(Request $request, Response $response, $args) {
    $response->getBody()->write('after auth');

    return $response;
});

$app->run();
exit;

$auth = new \src\components\Authentication($entityManager, $request);
$loader = new Twig_Loader_Filesystem(__DIR__ . '/src/templates');
$twig = new Twig_Environment($loader);

//session_start();
if (!$auth->wasLogin() && !$auth->login()) {

//    session_destroy();

    echo $twig->render('login.html.twig');
    exit;
}

if (isset($request->getQueryParams()['logOut'])) {
    $auth->logout();
    session_destroy();
    header('Location: ' . Url::homeUrl());
    exit;
}

\model\AutoPayment::run();

$url = new Url($entityManager, $request);

$url->manager();
