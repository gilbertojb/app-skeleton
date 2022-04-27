<?php

declare(strict_types=1);

use App\Application\Controller\AuthController;
use App\Application\Controller\EstadosController;
use App\Application\Controller\HomeController;

use App\Application\Middleware\AuthMiddleware;

use Psr\Container\ContainerInterface;

use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app, ContainerInterface $container) {
    $app->get('/', [HomeController::class, 'index'])->setName('home');

    $app->group('/auth', function (Group $group) {
        $group->get('/signin',  [AuthController::class, 'getSignIn'])->setName('auth.signin');
        $group->post('/signin', [AuthController::class, 'postSignIn']);
    });

    $app->group('/auth', function (Group $group) {
        $group->get('/signout', [AuthController::class, 'getSignOut'])->setName('auth.signout');
    })->add(new AuthMiddleware($container));
};
