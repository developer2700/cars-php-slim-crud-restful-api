<?php

namespace App\Controller\Car;

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Delete Car Controller.
 */
class DeleteCar extends BaseCar
{
    /**
     * Delete a car.
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function __invoke($request, $response, $args)
    {
        $this->setParams($request, $response, $args);
        $carId = $this->args['id'];
        $car = $this->getCarService()->deleteCar($carId);

        return $this->jsonResponse('success', $car, 204);
    }
}
