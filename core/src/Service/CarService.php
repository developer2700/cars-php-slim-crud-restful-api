<?php

namespace App\Service;

use App\Exception\CarException;
use App\Repository\CarRepository;

/**
 * Cars Service.
 */
class CarService extends BaseService
{
    /**
     * @varCarRepository
     */
    protected $carRepository;

    /**
     * @param CarRepository $carRepository
     */
    public function __construct(CarRepository $carRepository)
    {
        $this->carRepository = $carRepository;
    }

    /**
     * @return CarRepository
     */
    protected function getCarRepository()
    {
        return $this->carRepository;
    }

    /**
     * Check if the car exists.
     *
     * @param int $carId
     * @return object
     */
    protected function checkAndGetCar($carId)
    {
        return $this->getCarRepository()->checkAndGetCar($carId);
    }

    /**
     * Get all cars.
     *
     * @return array
     */
    public function getCars($request)
    {
        return $this->getCarRepository()->getCars($request);
    }

    /**
     * Get one car by id.
     *
     * @param int $carId
     * @return object
     */
    public function getCar($carId)
    {
        return $this->checkAndGetCar($carId);
    }

    /**
     * Get cars  by name.
     *
     * @param int $carId
     * @return object
     */
    public function GetCarsByName($carName)
    {
        return $this->getCarRepository()->GetCarsByName($carName);
    }

    /**
     * Search cars by params.
     *
     * @param string $params
     * @return array
     */
    public function searchCars($request)
    {
        return $this->getCarRepository()->searchCars($request);
    }

    /**
     * Create a car.
     *
     * @param array $input
     * @return object
     * @throws CarException
     */
    public function createCar($input)
    {
        //throw new CarException('Tinput'.json_encode($input), 201);
       
        $data = json_decode(json_encode($input), true);
        
        if (empty($data['model_id'])) {
            throw new CarException('The field "Model_id" is required.', 210);
        }
         
         //$data['model_name'] = self::validateCarModelName($data['model_name']);
        
        return $this->getCarRepository()->createCar($data);
        
    }

    /**
     * Update a car.
     *
     * @param array $input
     * @param int $carId
     * @return object
     * @throws CarException
     */
    public function updateCar($input, $carId)
    {
        $car = $this->checkAndGetCar($carId);
        $data = json_decode(json_encode($input), true);
        if (!isset($data['model_id'])) {
            throw new CarException('Enter the model_id  to update the Car.', 400);
        }
        $data['id']=$carId;

        // if (isset($data['model_name'])) {
        //     $car->name = self::validateCarName($data->name);
        // }
       
        return $this->getCarRepository()->updateCar($data);
    }

    /**
     * synca cars.
     *
     * @return object
     * @throws CarException
     */
    public function syncCars($api)
    {
        return $this->getCarRepository()->syncCars($api);
    }

    /**
     * Delete a Car.
     *
     * @param int $carId
     * @return string
     */
    public function deleteCar($carId)
    {
        $this->checkAndGetCar($carId);

        return $this->getCarRepository()->deleteCar($carId);
    }
}
