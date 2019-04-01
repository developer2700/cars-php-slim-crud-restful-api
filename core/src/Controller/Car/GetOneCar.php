<?php

namespace App\Controller\Car;

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Get One Car Controller.
 */
class GetOneCar extends BaseCar
{
    /**
     * Get one car by id.
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function __invoke($request, $response, $args)
    {
        $this->setParams($request, $response, $args);
        $car = $this->getCarService()->getCar($this->args['id']);

        return $this->jsonResponse('success', $car, 200);
    }
}
