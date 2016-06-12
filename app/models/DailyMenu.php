<?php

class DailyMenu {
    private $id;
    private $restaurant;
    private $menu;
    private $type;
    private $amount;
    private $sold;
    private $createdAt;
    private $updatedAt;

    public function save(){
        $sql = "";
        if($this->id == null){
            $this->createdAt = date('Y-m-d H:i:s');
            $sql = "INSERT INTO daily_menus(restaurants_id, menus_id, type, amount, sold, created_at, updated_at) " .
                "VALUES ('$this->restaurant', '$this->menu', '$this->type', '$this->amount', '$this->sold', '$this->createdAt', '$this->updatedAt')";
        } else{
            $this->updatedAt = date('Y-m-d H:i:s');
            $sql = "UPDATE daily_menus SET restaurants_id='$this->restaurant', menus_id='$this->menu', type='$this->type', amount='$this->amount', '$this->sold', created_at='$this->createdAt',updated_at='$this->updatedAt' WHERE id='$this->id'";
        }
        $result = Database::query($sql);

        return $result;
    }

    static public function findById($id){
        $sql = "SELECT * FROM daily_menus WHERE id='$id'";
        $dailyMenu = new DailyMenu();
        $result = mysqli_fetch_array(Database::query($sql));
        $dailyMenu->build($result);
        return $dailyMenu;
    }

    static public function all(){
        $sql = "SELECT * FROM daily_menus";
        $result = Database::query($sql);
        $dailyMenus = array();
        while ($row = $result->fetch_assoc()) {
            $dailyMenu = new DailyMenu();
            $dailyMenu->build($row);
            array_push($dailyMenus, $dailyMenu);
        }
        return $dailyMenus;
    }

    static public function findByRestaurant($id){
        $sql = "SELECT * FROM daily_menus WHERE restaurants_id='$id'";
        $result = Database::query($sql);
        $dailyMenus = array();
        while ($row = $result->fetch_assoc()) {
            $dailyMenu = new DailyMenu();
            $dailyMenu->build($row);
            array_push($dailyMenus, $dailyMenu);
        }
        return $dailyMenus;
    }

    /**
     * Builds User data from key value array
     * @param $result array of User attributes
     */
    private function build($result){
        $this->id = $result['id'];
        $this->restaurant = $result['restaurants_id'];
        $this->menu = $result['menus_id'];
        $this->type = $result['type'];
        $this->amount = $result['amount'];
        $this->sold = $result['sold'];
        $this->createdAt = $result['created_at'];
        $this->updatedAt = $result['updated_at'];
    }

    public function toArray(){
        $array = array();
        $array["id"] = $this->id;
        $array["restaurant"] = $this->restaurant;
        $array["menu"] = $this->menu;
        $array["type"] = $this->type;
        $array["amount"] = $this->amount;
        $array["sold"] = $this->sold;
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
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * @param mixed $menu
     */
    public function setMenu($menu)
    {
        $this->menu = $menu;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getSold()
    {
        return $this->sold;
    }

    /**
     * @param mixed $sold
     */
    public function setSold($sold)
    {
        $this->sold = $sold;
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