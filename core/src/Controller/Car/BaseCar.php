<?php

namespace App\Controller\Car;

use App\Controller\BaseController;
use App\Service\CarService;
use Slim\Container;
use Slim\Http\UploadedFile;
use Intervention\Image\ImageManagerStatic as Image;


/**
 * Base Car Controller.
 */
abstract class BaseCar extends BaseController
{
    /**
     * @var $CarService
     */
    protected $carService;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->carService = $container->get('car_service');
    }

    /**
     * @return CarService
     */
    protected function getCarService()
    {
        return $this->carService;
    }

/**
 * Moves the uploaded file to the upload directory and assigns it a unique name
 * to avoid overwriting an existing uploaded file.
 *
 * @param string $directory directory to which the file is moved
 * @param UploadedFile $uploaded file uploaded file to move
 * @return string filename of moved file
 */
function moveUploadedFile($directory, UploadedFile $uploadedFile)
{
    try{
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $basename = bin2hex(random_bytes(8));  
        $filename = sprintf('%s.%0.8s', $basename, $extension);

        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

        return $filename;
    }
        catch(\Exception $e){
            throw new \Exception($e, 201);
    }
}
}
