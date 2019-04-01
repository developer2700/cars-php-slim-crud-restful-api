<?php
$app->get('/help', 'App\Controller\DefaultController:getHelp');
$app->get('/status', 'App\Controller\DefaultController:getStatus');

$app->group('/api/v1', function () use ($app) {
    $app->group('/cars', function () use ($app) {
        $app->get('/sync', 'App\Controller\Car\SyncAllCars');
        $app->get('', 'App\Controller\Car\GetAllCars');
        $app->get('/[{id}]', 'App\Controller\Car\GetOneCar');
        $app->get('/search/byname/[{name}]', 'App\Controller\Car\GetCarsByName');
        $app->get('/search/[{query}]', 'App\Controller\Car\SearchCars');
        $app->post('/search/[{query}]', 'App\Controller\Car\SearchCars');
        $app->post('', 'App\Controller\Car\CreateCar');
        $app->post('/edit/[{id}]', 'App\Controller\Car\UpdateCar');
        $app->delete('/[{id}]', 'App\Controller\Car\DeleteCar');
    });
});



$app->get('/search', 'App\Controller\FrontController:getSearch');
$app->get('/', 'App\Controller\FrontController:getIndex');
$app->get('/admin/list', 'App\Controller\FrontController:getAdminCarList');
$app->get('/admin/edit/[{id}]', 'App\Controller\FrontController:getAdminCarEdit');
$app->get('/admin/create/', 'App\Controller\FrontController:getAdminCarCreate');
 

 

 
 
 


