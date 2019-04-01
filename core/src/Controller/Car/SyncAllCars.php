<?php

namespace App\Controller\Car;

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Sync All Cars Controller.
 */
class SyncAllCars extends BaseCar
{
    /**
     * Sync All Cars from external api .
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function __invoke($request, $response, $args)
    {
        $this->setParams($request, $response, $args);
        $api=getenv('api_carquery');
        $cars = $this->getCarService()->syncCars($api);

        return $this->jsonResponse('success', $cars, 200);
    }
}
