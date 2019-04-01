<?php

namespace App\Controller\Car;

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Search Cars Controller.
 */
class SearchCars extends BaseCar
{
    /**
     * Search cars by query.
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function __invoke($request, $response, $args)
    {
        
        $this->setParams($request, $response, $args);
        $input = $this->getInput();

      
        $cars = $this->getCarService()->searchCars($request);
        
        return $this->jsonResponse('success', $cars, 200);
    }
}
