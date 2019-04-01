<?php

use App\Service\CarService;
use App\Repository\CarRepository;
use App\Handler\ApiError;

$container = $app->getContainer();

/**
 * @return ApiError
 */
$container['errorHandler'] = function() {
    return new ApiError;
};

/**
 * @param ContainerInterface $container
 * @return CarService
 */
$container['car_service'] = function($container) {
    return new CarService($container->get('car_repository'));
};

/**
 * @param ContainerInterface $container
 * @return CarRepository
 */
$container['car_repository'] = function($container) {
    return new CarRepository($container->get('db'));
};

  