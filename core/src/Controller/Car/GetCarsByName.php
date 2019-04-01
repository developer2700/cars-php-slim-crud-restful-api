<?php

namespace App\Controller\Car;

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Get all Cars by name Controller.
 */
class GetCarsByName extends BaseCar
{
    /**
     * Get  car by name.
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function __invoke($request, $response, $args)
    {
        $this->setParams($request, $response, $args);
        $car = $this->getCarService()->GetCarsByName($this->args['name']);

        return $this->jsonResponse('success', $car, 200);
    }
}
