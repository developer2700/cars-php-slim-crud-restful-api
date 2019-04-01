<?php

namespace App\Controller;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Default Controller.
 */
class DefaultController extends BaseController
{
    const API_VERSION = '1.0';

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Get Help.
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function getHelp($request, $response, $args)
    {
        $this->setParams($request, $response, $args);
        $url = getenv('APP_DOMAIN');
        $endpoints = [
            'cars' => $url . '/api/v1/cars',
            'status' => $url . '/status',
            'this help' => $url . '/help',
            'sync with carQuery api' =>  $url . '/api/v1/cars/sync',
            'search' =>  $url . '/api/v1/cars/search/',
        ];
        $message = [
            'endpoints' => $endpoints,
            'version' => self::API_VERSION,
            'timestamp' => time(),
        ];

        return $this->jsonResponse('success', $message, 200);
    }

    /**
     * Get API Status.
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function getStatus($request, $response, $args)
    {
        $this->setParams($request, $response, $args);
        $carService = $this->container->get('car_service');
        $db = [
            'cars' => ($carService->getCars($request)['count']) ." records",
        ];
        $status = [
            'db' => $db,
            'version' => self::API_VERSION,
            'timestamp' => time(),
        ];

        return $this->jsonResponse('success', $status, 200);
    }
}
