<?php

class Restaurant {
    private $id;
    private $name;
    private $email;
    private $address;
    private $city;
    private $image;
    private $createdAt;
    private $updatedAt;

    public function save(){
        $sql = "";
        if($this->id == null){
            $this->createdAt = date('Y-m-d H:i:s');
            $sql = "INSERT INTO restaurants(name, email, address, cities_id, image, created_at, updated_at) " .
                "VALUES ('$this->name', '$this->email', '$this->address', '$this->city', '$this->image', '$this->createdAt', '$this->updatedAt')";
        } else{
            $this->updatedAt = date('Y-m-d H:i:s');
            $sql = "UPDATE resstaurants SET name='$this->name', email='$this->email', address='$this->address', cities_id='$this->city', image='$this->image', created_at='$this->createdAt',updated_at='$this->updatedAt' WHERE id='$this->id'";
        }
        $result = Database::query($sql);

        return $result;
    }
    
    static public function findById($id){
        $sql = "SELECT * FROM restaurants WHERE id='$id'";
        $restaurant = new Restaurant();
        $result = mysqli_fetch_array(Database::query($sql));
        $restaurant->build($result);
        return $restaurant;
    }

    static public function all(){
        $sql = "SELECT * FROM restaurants";
        $user = Session::getLoggedInUser();
        $result = Database::queryWithLog($sql, $user->getId());
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
        $this->image = $result['image'];
        $this->address = $result['address'];
        $this->createdAt = $result['created_at'];
        $this->updatedAt = $result['updated_at'];
    }

    public function toArray(){
        $array = array();
        $array["id"] = $this->id;
        $array["name"] = $this->name;
        $array["email"] = $this->email;
        $array["city"] = $this->city;
        $array["address"] = $this->address;
        $array["picture"] = $this->image;
        $array["updatedAt"] = $this->updatedAt;
        $array["createdAt"] = $this->createdAt;
        return $array;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }


    
}