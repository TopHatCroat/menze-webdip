<?php

/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 14.5.2016.
 * Time: 15:46
 */
class User {
    private $id;
    private $username;
    private $name;
    private $surname;
    private $email;
    private $passwordDigest;
    private $resetToken;
    private $rememberToken;
    private $role;
    private $image;
    private $city;
    private $address;
    private $theme;
    private $active;
    private $deleted;
    private $loginAttepmts;
    private $rememberedAt;
    private $createdAt;
    private $updatedAt;
//
//    /**
//     * User constructor.
//     * @param $id
//     * @param $username
//     * @param $name
//     * @param $surname
//     * @param $email
//     * @param $passwordDigest
//     * @param $resetToken
//     * @param $role
//     * @param $image
//     * @param $city
//     * @param $address
//     * @param $theme
//     * @param $active
//     * @param $deleted
//     * @param $loginAttepmts
//     * @param $rememberedAt
//     * @param $createdAt
//     * @param $updatedAt
//     */
//    public function __construct($id, $username, $name, $surname, $email, $passwordDigest, $resetToken, $role, $image, $city, $address, $theme, $active, $deleted, $loginAttepmts, $rememberedAt, $createdAt, $updatedAt){
//        $this->id = $id;
//        $this->username = $username;
//        $this->name = $name;
//        $this->surname = $surname;
//        $this->email = $email;
//        $this->passwordDigest = $passwordDigest;
//        $this->resetToken = $resetToken;
//        $this->role = $role;
//        $this->image = $image;
//        $this->city = $city;
//        $this->address = $address;
//        $this->theme = $theme;
//        $this->active = $active;
//        $this->deleted = $deleted;
//        $this->loginAttepmts = $loginAttepmts;
//        $this->rememberedAt = $rememberedAt;
//        $this->createdAt = $createdAt;
//        $this->updatedAt = $updatedAt;
//    }

    public function save(){
        $sql = "";
        if($this->id == null){
            $this->createdAt = date('Y-m-d H:i:s');
            $sql = "INSERT INTO users(username, name, surname, email, password_digest, reset_token, address, cities_id, profile_image, theme, roles_id, active, deleted, login_attemplts, remembered_at, created_at, updated_at) " .
                "VALUES ('$this->username', '$this->name', '$this->surname', '$this->email', '$this->passwordDigest', '$this->resetToken', '$this->address', '$this->city', '$this->image', '$this->theme', '$this->role', '$this->active', '$this->deleted', '$this->loginAttepmts', '$this->rememberedAt', '$this->createdAt', '$this->updatedAt');";
        } else{
            $this->updatedAt = date('Y-m-d H:i:s');
            $sql = "UPDATE users SET username='$this->username',name='$this->name',surname='$this->surname',email='$this->email',password_digest='$this->passwordDigest',reset_token='$this->address',address='$this->address',cities_id='$this->city',profile_image='$this->image',theme='$this->theme',roles_id='$this->role',active='$this->active',deleted='$this->deleted',login_attempts='$this->loginAttepmts',remembered_at='$this->rememberedAt',created_at='$this->createdAt',updated_at='$this->updatedAt' WHERE id='$this->id'";
        }
        $result = Database::query($sql);

        return $result;
    }

    /**
     * @param $id Users's id to find
     * @return User
     */
    static public function findById($id){
        $sql = "SELECT * FROM users WHERE id='$id'";
        $user = new User();
        $result = mysqli_fetch_array(Database::query($sql));
        $result = $result->fetch_assoc();
        $user->build($result);
        return $user;
    }
    
    static public function findByRememberToken($cookie){
        $sql = "SELECT * FROM users WHERE remember_token='$cookie'";
        $user = new User();
        $result = mysqli_fetch_array(Database::query($sql));
        $result = $result->fetch_assoc();
        $user->build($result);
        return $user;
    }

    /**
     * Retruns an array of all users
     * @return User array
     */
    static public function all(){
        $sql = "SELECT * FROM users";
        $result = Database::query($sql);
        $users = array();
        while ($row = $result->fetch_assoc()) {
            $user = new User();
            $user->build($row);
            array_push($users, $user);
        }
        return $users;
    }

    /**
     * Builds User data from key value array
     * @param $result array of User attributes
     */
    private function build($result){
        $this->id = $result['id'];
        $this->username = $result['username'];
        $this->name = $result['name'];
        $this->surname = $result['surname'];
        $this->email = $result['email'];
        $this->passwordDigest = $result['password_digest'];
        $this->resetToken = $result['reset_token'];
        $this->rememberToken = $result['remember_token'];
        $this->role = $result['roles_id'];
        $this->image = $result['profile_image'];
        $this->city = $result['cities_id'];
        $this->address = $result['address'];
        $this->theme = $result['theme'];
        $this->active = $result['active'];
        $this->deleted = $result['deleted'];
        $this->loginAttepmts = $result['login_attempts'];
        $this->rememberedAt = $result['remembered_at'];
        $this->createdAt = $result['created_at'];
        $this->updatedAt = $result['updated_at'];
    }

    public function toArray(){
        $array = array();
        $array["username"] = $this->username;
        $array["name"] = $this->name;
        $array["surname"] = $this->surname;
        $array["email"] = $this->email;
        $array["image"] = $this->image;
        $array["city"] = $this->city;
        $array["address"] = $this->address;
        return $array;
    }

}