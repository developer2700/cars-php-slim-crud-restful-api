<?php

namespace App\Controller\Car;

use Slim\Http\Request;
use Slim\Http\Response;
use Intervention\Image\ImageManagerStatic as Image;


/**
 * Update Car Controller.
 */
class UpdateCar extends BaseCar
{
    /**
     * Update a Car.
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

        
        $directory=getenv('APP_PATH').DIRECTORY_SEPARATOR."uploads";
        
        $uploadedFiles = $request->getUploadedFiles();
        $uploadedFile = $uploadedFiles['image'];
        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
           
            $filename = $this->moveUploadedFile($directory, $uploadedFile);
            $fullfilename= $directory.DIRECTORY_SEPARATOR.$filename;
           
            $fullThumbFilename= $directory.DIRECTORY_SEPARATOR."thumb-".$filename;
            $thumb = Image::make($fullfilename)->resize(100, 100)->save($fullThumbFilename);
            $input['image']=$filename;
          
            //return json_encode($fullfilename);
        }


        $car = $this->getCarService()->updateCar($input, $this->args['id']);

        return $this->jsonResponse('success', $car, 200);
    }








}
