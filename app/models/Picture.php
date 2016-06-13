<?php

class Picture {
    private $id;
    private $path;
    private $title;
    private $tags;
    private $user;
    private $dailyMenu;
    private $createdAt;
    private $updatedAt;

    public function save(){
        $sql = "";
        if($this->id == null){
            $this->createdAt = date('Y-m-d H:i:s');
            $sql = "INSERT INTO pictures(path, title, tags, users_id, daily_menus_id, created_at, updated_at) " .
                "VALUES ('$this->path', '$this->title', '$this->tags', '$this->user', '$this->dailyMenu', '$this->createdAt', '$this->updatedAt')";
        } else{
            $this->updatedAt = date('Y-m-d H:i:s');
            $sql = "UPDATE pictures SET path='$this->path', title='$this->title', tags='$this->tags', users_id='$this->user', daily_menus_id='$this->dailyMenu', created_at='$this->createdAt',updated_at='$this->updatedAt' WHERE id='$this->id'";
        }
        $result = Database::query($sql);
        return $result;
    }

    static public function findById($id){
        $sql = "SELECT * FROM pictures WHERE id='$id'";
        $picture = new Picture();
        $result = mysqli_fetch_array(Database::query($sql));
        $picture->build($result);
        return $picture;
    }

    static public function findByUser($id, $skip){
        if($skip == null) $sql = "SELECT * FROM pictures WHERE users_id='$id' LIMIT 6";
        else {
            $limit = intval($skip) + 6;
            $sql = "SELECT * FROM pictures WHERE users_id='$id' LIMIT $skip, $limit";
        }
        $result = Database::query($sql);
        $pictures = array();
        while ($row = $result->fetch_assoc()) {
            $picture = new Picture();
            $picture->build($row);
            array_push($pictures, $picture);
        }
        return $pictures;
    }

    static public function findByRestaurant($restaurantId){
        $sql = "SELECT * FROM pictures WHERE restaurants_id = '$restaurantId'";
        $result = Database::query($sql);
        $pictures = array();
        while ($row = $result->fetch_assoc()) {
            $picture = new Picture();
            $picture->build($row);
            array_push($pictures, $picture);
        }
        return $pictures;
    }

    static public function all(){
        $sql = "SELECT * FROM pictures";
        $result = Database::query($sql);
        $pictures = array();
        while ($row = $result->fetch_assoc()) {
            $picture = new Picture();
            $picture->build($row);
            array_push($pictures, $picture);
        }
        return $pictures;
    }

    /**
     * Builds User data from key value array
     * @param $result array of User attributes
     */
    private function build($result){
        $this->id = $result['id'];
        $this->path = $result['path'];
        $this->title = $result['title'];
        $this->tags = $result['tags'];
        $this->user = $result['users_id'];
        $this->dailyMenu = $result['daily_menus_id'];
        $this->createdAt = $result['created_at'];
        $this->updatedAt = $result['updated_at'];
    }

    public function toArray(){
        $array = array();
        $array["id"] = $this->id;
        $array["path"] = $this->path;
        $array["title"] = $this->title;
        $array["tags"] = $this->tags;
        $array["user"] = $this->user;
        $array["dailyMenu"] = $this->dailyMenu;
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
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
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
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param mixed $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getDailyMenu()
    {
        return $this->dailyMenu;
    }

    /**
     * @param mixed $dailyMenu
     */
    public function setDailyMenu($dailyMenu)
    {
        $this->dailyMenu = $dailyMenu;
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