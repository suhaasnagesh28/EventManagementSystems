<?php
require_once 'Location.php';

class LocationTableGateway {

    private $connect;
    
    public function __construct($c) {
        $this->connect = $c;
    }
    
    // execute a query to get all locations
    public function getLocations() {
        $sql = "SELECT * FROM `locations`;";
        
        $statement = $this->connect->prepare($sql);
        $status = $statement->execute();
        
        if (!$status) {
            die("Could not retrieve location details");
        }
        
        return $statement;
    }
    
    // execute a query to get a location with the specified id
    public function getLocationsById($id) {
        $sqlQuery = "SELECT * FROM `locations` WHERE `locationID` = :id";
        
        $statement = $this->connect->prepare($sqlQuery);
        $params = array(
            "id" => $id
        );
        
        $status = $statement->execute($params);
        
        if (!$status) {
            die("Could not retrieve location ID");
        }
        
        return $statement;
    }
    
    public function insert($p) {
        $sql = "INSERT INTO `locations`(`Name`, `Address`, `ManagerFName`, `ManagerLName`, `ManagerEmail`, `ManagerNumber`, `MaxCapacity`) " .
                "VALUES (:Name, :Address, :ManagerFName, :ManagerLName, :ManagerEmail, :ManagerNumber, :MaxCapacity)";
        
        $statement = $this->connect->prepare($sql);
        $params = array(
            "Name"              => $p->getName(),
            "Address"           => $p->getAddress(),            
            "ManagerFName"      => $p->getMFName(),
            "ManagerLName"      => $p->getMLName(),
            "ManagerEmail"      => $p->getMEmail(),
            "ManagerNumber"     => $p->getMNumber(),
            "MaxCapacity"       => $p->getCap()
        );
        
        echo "<pre>";
        print_r($p);
        print_r($params);
        echo "</pre>";
        
        $status = $statement->execute($params);
        
        
        if (!$status) {
            die("Could not insert location");
        }
        
        $id = $this->connect->lastInsertId();
        
        return $id;
    }
    

    public function delete($id) {
        $sql = "DELETE FROM locations WHERE locationID = :id";
        
        $statement = $this->connect->prepare($sql);
        $params = array(
            "id" => $id
        );
        $status = $statement->execute($params);
        
        if (!$status) {
            die("Could not delete location");
        }
    }    

}