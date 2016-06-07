<?php

class Menu {
    private $id;
    private $restaurant;
    private $title;
    private $description;
    private $image;
    private $createdAt;
    private $updatedAt;

    public function save(){
        $sql = "";
        if($this->id == null){
            $this->createdAt = date('Y-m-d H:i:s');
            $sql = "INSERT INTO menus(restaurant_id, title, description, image, created_at, updated_at) " .
                "VALUES ('$this->restaurant', '$this->title', '$this->description', '$this->image', '$this->createdAt', '$this->updatedAt')";
        } else{
            $this->updatedAt = date('Y-m-d H:i:s');
            $sql = "UPDATE menus SET restaurants_id='$this->restaurant', title='$this->title', description='$this->description', image='$this->image', created_at='$this->createdAt',updated_at='$this->updatedAt' WHERE id='$this->id'";
        }
        $result = Database::query($sql);

        return $result;
    }

    static public function findById($id){
        $sql = "SELECT * FROM menus WHERE id='$id'";
        $menu = new Menu();
        $result = mysqli_fetch_array(Database::query($sql));
        $menu->build($result);
        return $menu;
    }

    static public function all(){
        $sql = "SELECT * FROM menus";
        $result = Database::query($sql);
        $menus = array();
        while ($row = $result->fetch_assoc()) {
            $menu = new Menu();
            $menu->build($row);
            array_push($menus, $menu);
        }
        return $menus;
    }

    /**
     * Builds User data from key value array
     * @param $result array of User attributes
     */
    private function build($result){
        $this->id = $result['id'];
        $this->restaurant = $result['restaurant_id'];
        $this->title = $result['title'];
        $this->description = $result['description'];
        $this->image = $result['image'];
        $this->createdAt = $result['created_at'];
        $this->updatedAt = $result['updated_at'];
    }

    public function toArray(){
        $array = array();
        $array["id"] = $this->id;
        $array["restaurant"] = $this->restaurant;
        $array["title"] = $this->title;
        $array["description"] = $this->description;
        $array["image"] = $this->image;
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
    public function getRestaurant()
    {
        return $this->restaurant;
    }

    /**
     * @param mixed $restaurant
     */
    public function setRestaurant($restaurant)
    {
        $this->restaurant = $restaurant;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
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