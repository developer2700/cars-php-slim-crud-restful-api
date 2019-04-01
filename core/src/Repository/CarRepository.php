<?php

namespace App\Repository;

use App\Exception\CarException;

/**
 * Cars Repository.
 */
class CarRepository extends BaseRepository
{
   /**
     * @array fillable $columns
     */
    protected $fillable;
   

    /**
     * @param \PDO $database
     */
    public function __construct(\PDO $database)
    {
        $this->database = $database;

        $this->fillable =['model_id','model_make_id', 'model_name',
        'model_trim','model_year','model_body',
        'model_engine_position','model_engine_type','model_engine_compression','model_engine_fuel',
        'make_country','model_weight_kg','model_transmission_type','image','price'
        ];

    }

    /**
     * Check if the car exists.
     *
     * @param int|string $CarId
     * @return object
     * @throws CarException
     */
    public function checkAndGetCar($carId)
    {
        $query = 'SELECT * FROM cars WHERE id=:id';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $carId);
        $statement->execute();
        $car = $statement->fetchObject();
        if (empty($car)) {
            throw new CarException('Car not found.', 404);
        }

        return $car;
    }


    /**
     * Check if the car exists by model_id is DB.
     *
     * @param int|string $model_id
     * @return object
     * @throws CarException
     */
    public function checkCarExistsByModelId ($modelId)
    {
        $query = 'SELECT * FROM cars WHERE model_id=:modelId';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('modelId', $modelId);
        $statement->execute();
        $car = $statement->fetchObject();
        return $car;
    }


      /**
     *sync cars from api.
     *
     * @return object
     * @throws CarException
     */
    public function syncCars($api)
    {
        try {

            $api_result=file_get_contents($api);
            $data = json_decode($api_result, true);
            $rowUpdatedCount=0;
            $rowInsertCount=0;

            foreach ($data['Trims'] as $row) {
                $row['price']=rand(4000,12000) *10;    
                if( empty($this->checkCarExistsByModelId($row['model_id'])) ) { 
                    // new recored
                    $columnNames =implode(',',array_keys($row));
                    $columnsParams =implode(',',array_map(function ($arr) { return ':'.$arr; }, array_keys($row)));
                    $query = "INSERT INTO cars ($columnNames) VALUES ($columnsParams) ";

                    $statement = $this->getDb()->prepare($query);
                    $statement->execute($row);
                    $rowInsertCount += $statement->rowCount();
                    continue;
                }

                // removing fillables columns to prevent  from updating rows (they must not be affected when the database is updated with from the API.)
                //$row= ['model_id'=>174847,'model_engine_bore_mm'=>444];
                $allowed=array_diff(array_keys($row), $this->fillable);
                $modelId=$row['model_id'];
    
                $filtered = array_filter(
                    $row,
                    function ($key) use ($allowed) {
                        return in_array($key, $allowed);
                    },
                    ARRAY_FILTER_USE_KEY
                );
            
                $columnParams =implode(',',array_map(function ($arr) { return "$arr=:$arr"; }, $allowed));
                $query = "UPDATE cars SET $columnParams  WHERE model_id=$modelId";
                $statement = $this->getDb()->prepare($query);
                $statement->execute($filtered);
                $rowUpdatedCount += $statement->rowCount();

            }
          

            
            
           
            return "$rowUpdatedCount rows updated And $rowInsertCount rows inserted .";
        }

        catch(\Exception $e){
            throw new CarException($e, 201);
        }
        

       

    }

    /**
     * Get all cars.
     *
     * @return array
     */
    public function getCars($req)
    {
        $page      = ($req->getParam('page', 0) > 0) ? $req->getParam('page') : 1;
        $limit      = ($req->getParam('limit', 0) > 0) ? $req->getParam('limit') : 2; // Number of rows on one page
        $skip      = ($page - 1) * $limit;
        $count = $this->getDb()->query('SELECT count(*) from cars')->fetchColumn(); 

        $query = "SELECT * FROM cars ORDER BY id desc limit $skip,$limit";
        $statement = $this->getDb()->prepare($query);
        $statement->execute();
        $items=$statement->fetchAll();
        
        return  [
                'items'         => $items,
                'needed'        => $count > $limit,
                'count'         => $count,
                'page'          => $page,
                'lastpage'      => (ceil($count / $limit) == 0 ? 1 : ceil($count / $limit)),
                'limit'         => $limit,
        ];

    }



      /**
     * Search cars by Name 
     *_
     * @param request $name
     * @return array
     * @throws Exception
     */
    public function GetCarsByName($name)
    {
        try{
                $sql = " SELECT DISTINCT model_name FROM cars  WHERE LOWER(model_name) like  LOWER(concat(:model_name, '%'))";
                $statement = $this->getDb()->prepare($sql);
                $statement->bindParam(":model_name",$name );
                $statement->execute();
                $cars = $statement->fetchAll();

                return $cars;

            }catch(\Exception $e){
                throw new \Exception($e,201);
            }

    }



    /**
     * Search cars by params (?model_name=BMW & min_price=11&...)
     *_
     * @param request $request
     * @return array
     * @throws CarException
     */
    public function searchCars($req)
    {
         
        try{
              
                $where = [];
                $params=$req->getParams();

                $paginArr=['page','limit'];
                $allowed=array_diff(array_keys($params), $paginArr);
    
                $filtered = array_filter(
                    $params,
                    function ($key) use ($allowed) {
                        return in_array($key, $allowed);
                    },
                    ARRAY_FILTER_USE_KEY
                );

               
                $filtered=array_filter($filtered);

                foreach($filtered as $key=>$param){
                
                    if ($key=='model_name') {
                        $where[] = " LOWER(model_name) like LOWER(concat(:model_name, '%'))  ";
                    }
                    elseif ($key=='min_price') {
                        $where[] = " price >= :min_price  ";
                    }
                    elseif ($key=='max_price') {
                        $where[] = " price <= :max_price ";
                    }
                    elseif ($key=='make_country') {
                        $where[] = " LOWER(make_country) like LOWER(concat(:make_country, '%'))  ";
                    }
                }

                $wheres = "";
                if(count($where) > 0){
                    $wheres= ' WHERE ' . implode(' AND ', $where);
                }
              

                 
                $statement = $this->getDb()->prepare(" SELECT count(*) FROM cars  $wheres ");
                $statement->execute($filtered);
                $count = $statement->fetchColumn();

              
                $page      = ($req->getParam('page', 0) > 0) ? $req->getParam('page') : 1;
                $limit      = ($req->getParam('limit', 0) > 0) ? $req->getParam('limit') : 5;  
                $skip      = ($page - 1) * $limit;
                
                $sql = " SELECT * FROM cars  $wheres  ORDER BY id DESC limit $skip,$limit ";
                $statement = $this->getDb()->prepare($sql);
                $statement->execute($filtered);
                $cars = $statement->fetchAll();

               
                return  [
                   
                    'needed'        => $count > $limit,
                    'count'         => $count,
                    'page'          => $page,
                    'lastpage'      => (ceil($count / $limit) == 0 ? 1 : ceil($count / $limit)),
                    'limit'         => $limit,
                    'items'         => $cars,
            ];

            }catch(\Exception $e){
                throw new \Exception($e,201);
            }

    }



    /**
     * Create a car.
     *
     * @param object $car
     * @return object
     */
    public function createCar($car)
    {
        try{
            $columnNames =implode(',',$this->fillable);
            $columnParams =implode(',',array_map(function ($arr) { return ':'.$arr; }, $this->fillable));
    
            $query = "INSERT INTO cars ($columnNames) VALUES ($columnParams) ";
            $statement = $this->getDb()->prepare($query);
            $randomPrice=rand(4000,12000) *10;      
            $car['price'] =isset($car['price']) && $car['price'] ? $car['price'] : $randomPrice;
            
           
            $null=null;
            foreach ($this->fillable as $column) {
                if(isset($car["$column"]) && $car["$column"] )
                        $statement->bindParam(":$column",$car["$column"] );
                else
                        $statement->bindParam(":$column",$null );
            }
            $statement->execute();
        }
        catch(\Exception $e){
            throw new CarException($e, 201);
        }
       
        
       
        return $this->checkAndGetCar($this->database->lastInsertId());
    }

    /**
     * Update a car.
     *
     * @param object $car
     * @return object
     */
    public function updateCar($car)
    {
        try{
            //model_id=:model_id,model_make_id=:model_make_id ,...
            $columnParams =implode(',',array_map(function ($arr) { return "$arr=:$arr"; }, $this->fillable));
    
            $query = "UPDATE cars SET $columnParams  WHERE id=:id";
            $statement = $this->getDb()->prepare($query);
            $statement->bindParam('id', $car['id']);

            $randomPrice=rand(4000,12000) *10;     
            $car['price'] =(isset($car['price']) && $car['price']) ? $car['price'] : $randomPrice;
           
            
            $null=null;
            foreach ($this->fillable as $column) {
                if(isset($car["$column"]) && $car["$column"] )
                        $statement->bindParam(":$column",$car["$column"] );
                else
                        $statement->bindParam(":$column",$null );
            }
            $statement->execute();
            return $this->checkAndGetCar($car['id']);
        }
        catch(\Exception $e){
            throw new CarException($e, 201);
        }
       
    }

    /**
     * Delete a car.
     *
     * @param int $carId
     * @return string
     */
    public function deleteCar($carId)
    {
        $query = 'DELETE FROM cars WHERE id=:id';
        $statement = $this->getDb()->prepare($query);
        $statement->bindParam('id', $carId);
        $statement->execute();

        return 'The car was deleted.';
    }

 
}
