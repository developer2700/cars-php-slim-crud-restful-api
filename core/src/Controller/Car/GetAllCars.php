<?php

namespace App\Controller\Car;

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Get All Cars Controller.
 */
class GetAllCars extends BaseCar
{
    /**
     * Get all cars.
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function __invoke($request, $response, $args)
    {
        $this->setParams($request, $response, $args);
        $cars = $this->getCarService()->getCars($request);

        return $this->jsonResponse('success', $cars, 200);
    }
}
