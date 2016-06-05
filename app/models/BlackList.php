<?php

/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 2.6.2016.
 * Time: 23:14
 */
class BlackList
{
    private $id;
    private $description;
    private $releaseAt;
    private $createdAt;
    private $updatedAt;
    private $restaurant;
    private $user;

    public function save(){
        $sql = "";
        if($this->id == null){
            $this->createdAt = date('Y-m-d H:i:s');
            $sql = "INSERT INTO blacklist(description, release_at, restaurant_id, users_id, created_at, updated_at) " .
                "VALUES ('$this->description', '$this->releaseAt', '$this->restaurant', '$this->user', '$this->createdAt', '$this->updatedAt');";
        } else{
            $this->updatedAt = date('Y-m-d H:i:s');
            $sql = "UPDATE blacklist SET description='$this->description', release_at='$this->releaseAt', restaurants_id='$this->restaurant', users_id='$this->r', created_at='$this->createdAt',updated_at='$this->updatedAt' WHERE id='$this->id'";
        }
        $result = Database::query($sql);
        return $result;
    }

    static public function findById($id){
        $sql = "SELECT * FROM blacklist WHERE id='$id'";
        $blacklist = new BlackList();
        $result = mysqli_fetch_array(Database::query($sql));
        $result = $result->fetch_assoc();
        $blacklist->build($result);
        return $blacklist;
    }

    static public function all(){
        $sql = "SELECT * FROM blacklist";
        $result = Database::query($sql);
        $blacklist = array();
        while ($row = $result->fetch_assoc()) {
            $blackItem = new BlackList();
            $blackItem->build($row);
            array_push($blacklist, $blackItem);
        }
        return $blacklist;
    }

    /**
     * Builds User data from key value array
     * @param $result array of User attributes
     */
    private function build($result){
        $this->id = $result['id'];
        $this->description = $result['description'];
        $this->restaurant = $result['restaurants_id'];
        $this->user = $result['users_id'];
        $this->releaseAt = $result['release_at'];
        $this->createdAt = $result['created_at'];
        $this->updatedAt = $result['updated_at'];
    }

    public function toArray(){
        $array = array();
        $array["description"] = $this->description;
        $array["releaseAt"] = $this->releaseAt;
        $array["restaurant"] = $this->restaurant;
        $array["user"] = $this->user;
        $array["updatedAt"] = $this->updatedAt;
        $array["createdAt"] = $this->createdAt;
        return $array;
    }
}