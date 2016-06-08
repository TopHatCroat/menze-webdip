<?php

class Reservation {
    private $id;
    private $reservedAt;
    private $accepted;
    private $acceptedMessage;
    private $completed;
    private $completedMessage;
    private $createdAt;
    private $updatedAt;
    private $restaurant;
    private $user;

    public function save(){
        $sql = "";
        if($this->id == null){
            $this->createdAt = date('Y-m-d H:i:s');
            $sql = "INSERT INTO reservations(reserved_at, accepted, accepted_message, completed, completed_message, restaurants_id, users_id, created_at, updated_at) " .
                "VALUES ('$this->reservedAt', '$this->accepted', '$this->acceptedMessage', '$this->completed', '$this->completedMessage', '$this->restaurant', '$this->user', '$this->createdAt', '$this->updatedAt')";
        } else{
            $this->updatedAt = date('Y-m-d H:i:s');
            $sql = "UPDATE reservations SET reserved_at='$this->reservedAt', accepted='$this->accepted', accepted_message='$this->acceptedMessage', completed='$this->completed', completed_message='$this->completedMessage', restaurants_id='$this->restaurant', users_id='$this->user', created_at='$this->createdAt',updated_at='$this->updatedAt' WHERE id='$this->id'";
        }
        $result = Database::query($sql);
        var_dump($result);
        return $result;
    }

    static public function findById($id){
        $sql = "SELECT * FROM reservations WHERE id='$id'";
        $restaurant = new Reservation();
        $result = mysqli_fetch_array(Database::query($sql));
        $restaurant->build($result);
        return $restaurant;
    }

    static public function findByRestaurant($id){
        $sql = "SELECT * FROM reservations WHERE restaurants_id='$id'";
        $restaurant = new Reservation();
        $result = mysqli_fetch_array(Database::query($sql));
        $restaurant->build($result);
        return $restaurant;
    }

    static public function findByUser($id){
        $sql = "SELECT * FROM reservations WHERE users_id='$id'";
        $restaurant = new Reservation();
        $result = mysqli_fetch_array(Database::query($sql));
        $restaurant->build($result);
        return $restaurant;
    }

    static public function all(){
        $sql = "SELECT * FROM reservations";
        $result = Database::query($sql);
        $reservations = array();
        while ($row = $result->fetch_assoc()) {
            $reservation = new Reservation();
            $reservation->build($row);
            array_push($reservations, $reservation);
        }
        return $reservations;
    }

    /**
     * Builds User data from key value array
     * @param $result array of User attributes
     */
    private function build($result){
        $this->id = $result['id'];
        $this->reservedAt = $result['reserved_at'];
        $this->accepted = $result['accepted'];
        $this->acceptedMessage = $result['accepted_message'];
        $this->completed = $result['completed'];
        $this->completedMessage = $result['completed_message'];
        $this->restaurant = $result['restaurants_id'];
        $this->user = $result['users_id'];
        $this->createdAt = $result['created_at'];
        $this->updatedAt = $result['updated_at'];
    }

    public function toArray(){
        $array = array();
        $array["id"] = $this->id;
        $array["reservedAt"] = $this->reservedAt;
        $array["accepted"] = $this->accepted;
        $array["acceptedMessage"] = $this->acceptedMessage;
        $array["completed"] = $this->completed;
        $array["completedMessage"] = $this->completedMessage;
        $array["restaurant"] = $this->restaurant;
        $array["user"] = $this->user;
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
    public function getReservedAt()
    {
        return $this->reservedAt;
    }

    /**
     * @param mixed $reservedAt
     */
    public function setReservedAt($reservedAt)
    {
        $this->reservedAt = gmdate("Y-m-d H:i:s ", $reservedAt);;
    }

    /**
     * @return mixed
     */
    public function getAccepted()
    {
        return $this->accepted;
    }

    /**
     * @param mixed $accepted
     */
    public function setAccepted($accepted)
    {
        $this->accepted = $accepted;
    }

    /**
     * @return mixed
     */
    public function getAcceptedMessage()
    {
        return $this->acceptedMessage;
    }

    /**
     * @param mixed $acceptedMessage
     */
    public function setAcceptedMessage($acceptedMessage)
    {
        $this->acceptedMessage = $acceptedMessage;
    }

    /**
     * @return mixed
     */
    public function getCompleted()
    {
        return $this->completed;
    }

    /**
     * @param mixed $completed
     */
    public function setCompleted($completed)
    {
        $this->completed = $completed;
    }

    /**
     * @return mixed
     */
    public function getCompletedMessage()
    {
        return $this->completedMessage;
    }

    /**
     * @param mixed $completedMessage
     */
    public function setCompletedMessage($completedMessage)
    {
        $this->completedMessage = $completedMessage;
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

    
}