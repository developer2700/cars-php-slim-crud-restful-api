<?php

namespace App\Controller;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * FrontController Controller.
 */
class FrontController extends BaseController
{
    

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Get search page.
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function getSearch($request, $response, $args)
    {
        $file = '../public_html/search_cars.html';
        if (file_exists($file)) {
            return $response->write(file_get_contents($file));
        } else {
            throw new \Slim\Exception\NotFoundException($request, $response);
        }
    }


    /**
     * Get index.
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function getIndex($request, $response, $args)
    {
        $file = '../public_html/index.html';
        if (file_exists($file)) {
            return $response->write(file_get_contents($file));
        } else {
            throw new \Slim\Exception\NotFoundException($request, $response);
        }
    }

    /**
     * Get  AdminCarList.
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function getAdminCarList($request, $response, $args)
    {
        $file = '../public_html/adminfiles/list_cars.html';
        if (file_exists($file)) {
            return $response->write(file_get_contents($file));
        } else {
            throw new \Slim\Exception\NotFoundException($request, $response);
        }
    }

    /**
     * Get  AdminCarEdit.
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function getAdminCarEdit($request, $response, $args)
    {
        $file = '../public_html/adminfiles/edit_car.html';
        if (file_exists($file)) {
            return $response->write(file_get_contents($file));
        } else {
            throw new \Slim\Exception\NotFoundException($request, $response);
        }
    }



       /**
     * Get  AdminCarCreate.
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function getAdminCarCreate($request, $response, $args)
    {
        $file = '../public_html/adminfiles/edit_car.html';
        if (file_exists($file)) {
            return $response->write(file_get_contents($file));
        } else {
            throw new \Slim\Exception\NotFoundException($request, $response);
        }
    }

     
}
