<?php
require_once('abstractDAO.php');
require_once('./model/entity.php');

class entityDAO extends abstractDAO {
        
    function __construct() {
        try{
            parent::__construct();
        } catch(mysqli_sql_exception $e){
            throw $e;
        }
    }  
    
    /* use the query() method of a mysqli object. Returns an array of
    <code>Pet</code> objects. If no pet exists rfeturns false */
    public function getEntities(){
        //The query method returns a mysqli_result object
        $result = $this->mysqli->query('SELECT * FROM petcollection');
        $pets = Array();
        
        if($result->num_rows >= 1){
            while($row = $result->fetch_assoc()){
                //Create a new pet object, and add it to the array.
                $pet = new Entity($row['id'], $row['name'], $row['birthdate'], $row['image']);
                $pets[] = $pet;
            }
            $result->free();//free the conenection
            return $pets;//return the record
        }
        $result->free(); //free the connection
        return false;
    }   

    /* Prepared statements with a select query*/
    public function getEntity($entityId){
        $query = 'SELECT * FROM petcollection WHERE id = ?'; 
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param('i', $entityId);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows == 1){
            $temp = $result->fetch_assoc();
            $entity = new Entity($temp['id'],$temp['name'], $temp['birthdate'], $temp['image']);
            $result->free();
            return $entity;
        }
        $result->free();
        return false;
    }


    
    public function addEntity($pet){
        
        //if(!is_numeric($pet->getEntityId())){
         //   return 'Id must be a number'
        //}

        if(!$this->mysqli->connect_errno){
            //The query uses the question mark (?) as a
            //placeholder for the parameters to be used
            //in the query.
			$query = 'INSERT INTO petcollection (name, birthdate, image) VALUES (?,?,?)';
			//The prepare method of the mysqli object returns
            //a mysqli_stmt object. It takes a parameterized 
            //query as a parameter.
            $stmt = $this->mysqli->prepare($query);
            
            if($stmt){
                    $name = $pet->getName();
			        $birthdate = $pet->getBirthdate();
			        $image = $pet->getImage();
                  
			        $stmt->bind_param('sss', 
				        $name,
				        $birthdate,
				        $image
			        );    
                    //Execute the statement
                    $stmt->execute();         
                    
                    if($stmt->error){
                        return $stmt->error;
                    } else {
                        return $pet->getName() . ' added successfully!';
                    } 
			}
             else {
                $error = $this->mysqli->errno . ' ' . $this->mysqli->error;
                echo $error; 
                return $error;
            }
       
        }else {
            return 'Could not connect to Database.';
        }
    }

    public function updateEntity($pet){
        
        if(!$this->mysqli->connect_errno){
            //The query uses the question mark (?) as a
            //placeholder for the parameters to be used
            //in the query.
            $query = "UPDATE petcollection SET name=?, birthdate=?, image=? WHERE id=?";
            //The prepare method of the mysqli object returns
            //a mysqli_stmt object. It takes a parameterized 
            //query as a parameter.
            $stmt = $this->mysqli->prepare($query);
            if($stmt){
                    $id = $pet->getId();
                    $name = $pet->getName();
			        $birthdate = $pet->getBirthdate();
			        $image = $pet->getImage();
                  
			        $stmt->bind_param('sssi', 
				        $name,
				        $birthdate,
				        $image,
                        $id
			        );    
                    //Execute the statement
                    $stmt->execute();         
                    
                    if($stmt->error){
                        return $stmt->error;
                    } else {
                        return $pet->getName() . ' updated successfully!';
                    } 
			}
             else {
                $error = $this->mysqli->errno . ' ' . $this->mysqli->error;
                echo $error; 
                return $error;
            }
       
        }else {
            return 'Could not connect to Database.';
        }
    }   

    public function deleteEntity($petId){
        if(!$this->mysqli->connect_errno){
            $query = 'DELETE FROM petcollection WHERE id = ?';
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param('i', $petId);
            $stmt->execute();
            if($stmt->error){
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
}
?>

