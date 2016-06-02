<?php

/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 2.6.2016.
 * Time: 22:25
 */
class Restaurant
{
    private $id;
    private $name;
    private $email;
    private $address;
    private $city;
    private $createdAt;
    private $updatedAt;

    public function save(){
        $sql = "";
        if($this->id == null){
            $this->createdAt = date('Y-m-d H:i:s');
            $sql = "INSERT INTO restaurants(name, email, address, cities_id, created_at, updated_at) " .
                "VALUES ('$this->name', '$this->email', '$this->address', '$this->city, '$this->createdAt', '$this->updatedAt');";
        } else{
            $this->updatedAt = date('Y-m-d H:i:s');
            $sql = "UPDATE resstaurants SET name='$this->name', email='$this->email', address='$this->address', cities_id='$this->city', created_at='$this->createdAt',updated_at='$this->updatedAt' WHERE id='$this->id'";
        }
        $result = Database::query($sql);
        return $result;
    }
    
    static public function findById($id){
        $sql = "SELECT * FROM restaurants WHERE id='$id'";
        $restaurant = new Restaurant();
        $result = mysqli_fetch_array(Database::query($sql));
        $result = $result->fetch_assoc();
        $restaurant->build($result);
        return $restaurant;
    }

    static public function all(){
        $sql = "SELECT * FROM restaurants";
        $result = Database::query($sql);
        $restaurants = array();
        while ($row = $result->fetch_assoc()) {
            $restaurant = new Restaurant();
            $restaurant->build($row);
            array_push($restaurants, $restaurant);
        }
        return $restaurants;
    }

    /**
     * Builds User data from key value array
     * @param $result array of User attributes
     */
    private function build($result){
        $this->id = $result['id'];
        $this->name = $result['name'];
        $this->email = $result['email'];
        $this->city = $result['cities_id'];
        $this->address = $result['address'];
        $this->createdAt = $result['created_at'];
        $this->updatedAt = $result['updated_at'];
    }

    public function toArray(){
        $array = array();
        $array["name"] = $this->name;
        $array["email"] = $this->email;
        $array["city"] = $this->city;
        $array["address"] = $this->address;
        $array["updatedAt"] = $this->updatedAt;
        $array["createdAt"] = $this->createdAt;
        return $array;
    }
    
}