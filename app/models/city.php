<?php
class City{
    private $id;
    private $name;
    private $zipcode;

    public function save(){
        $sql = "";
        if($this->id == null){
            $sql = "INSERT INTO cities(name, zipcode) " .
                "VALUES ('$this->name', '$this->zipcode')";
        } else {
            $sql = "UPDATE cities SET name='$this->name', zipcode='$this->zipcode' WHERE id='$this->id'";
        }
        $result = Database::query($sql);
        return $result;
    }

    static public function all(){
        $sql = "SELECT * FROM cities";
        $result = Database::query($sql);
        $cities = array();
        while ($row = $result->fetch_assoc()) {
            $city = new City();
            $city->build($row);
            array_push($cities, $city);
        }
        return $cities;
    }

    static public function findById($id){
        $sql = "SELECT * FROM cities WHERE id='$id'";
        $city = new City();
        $result = mysqli_fetch_array(Database::query($sql));
        $result = $result->fetch_assoc();
        $city->build($result);
        return $city;
    }

    private function build($result){
        $this->id = $result['id'];
        $this->name = $result['name'];
        $this->zipcode = $result['zipcode'];
    }

    public function toArray(){
        $array = array();
        $array["id"] = $this->id;
        $array["name"] = $this->name;
        $array["zipcode"] = $this->zipcode;
        return $array;
    }
}

?>