<?php
class role{
    private $id;
    private $name;
    private $description;

    public function save(){
        $sql = "";
        if($this->id == null){
            $sql = "INSERT INTO roles(name, description) " .
                "VALUES ('$this->name', '$this->description')";
        } else {
            $sql = "UPDATE roles SET name='$this->name', description='$this->description' WHERE id='$this->id'";
        }
        $result = Database::query($sql);
        return $result;
    }

    static public function all(){
        $sql = "SELECT * FROM roles";
        $result = Database::query($sql);
        $roles = array();
        while ($row = $result->fetch_assoc()) {
            $role = new role();
            $role->build($row);
            array_push($roles, $role);
        }
        return $roles;
    }

    static public function findById($id){
        $sql = "SELECT * FROM roles WHERE id='$id'";
        $role = new role();
        $result = mysqli_fetch_array(Database::query($sql));
        $result = $result->fetch_assoc();
        $role->build($result);
        return $role;
    }

    private function build($result){
        $this->id = $result['id'];
        $this->name = $result['name'];
        $this->description = $result['description'];
    }

    public function toArray(){
        $array = array();
        $array["id"] = $this->id;
        $array["name"] = $this->name;
        $array["description"] = $this->description;
        return $array;
    }
}

?>