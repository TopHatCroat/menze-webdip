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
    private $activationToken;
    private $rememberToken;
    private $sessionToken;
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
            $sql = "INSERT INTO users(username, name, surname, email, password_digest, activation_token, session_token, remember_token, address, cities_id, profile_image, theme, roles_id, active, deleted, login_attempts, remembered_at, created_at, updated_at) " .
                "VALUES ('$this->username', '$this->name', '$this->surname', '$this->email', '$this->passwordDigest', '$this->activationToken', '$this->sessionToken', '$this->rememberToken', '$this->address', '$this->city', '$this->image', '$this->theme', '$this->role', '$this->active', '$this->deleted', '$this->loginAttepmts', '$this->rememberedAt', '$this->createdAt', '$this->updatedAt');";
        } else{
            $this->updatedAt = date('Y-m-d H:i:s');
            $sql = "UPDATE users SET username='$this->username',name='$this->name',surname='$this->surname',email='$this->email',password_digest='$this->passwordDigest',activation_token='$this->activationToken', session_token='$this->sessionToken', remember_token='$this->rememberToken',address='$this->address',cities_id='$this->city',profile_image='$this->image',theme='$this->theme',roles_id='$this->role',active='$this->active',deleted='$this->deleted',login_attempts='$this->loginAttepmts',remembered_at='$this->rememberedAt',created_at='$this->createdAt',updated_at='$this->updatedAt' WHERE id='$this->id'";
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
        echo $sql;
        $user = new User();
        $result = mysqli_fetch_array(Database::query($sql));
        if($result['id'] == null) return null;
        $user->build($result);
        return $user;
    }
    
    static public function findByRememberToken($cookie){
        $sql = "SELECT * FROM users WHERE remember_token='$cookie'";
        $user = new User();
        $result = mysqli_fetch_array(Database::query($sql));
        if($result['id'] == null) return null;
        $user->build($result);
        return $user;
    }

    static public function findBySessionToken($session){
        $sql = "SELECT * FROM users WHERE session_token='$session'";
        $user = new User();
        $result = mysqli_fetch_array(Database::query($sql));
        if($result['id'] == null) return null;
        $user->build($result);
        return $user;
    }
    
    static public function findByActivationToken($activation){
        $sql = "SELECT * FROM users WHERE activation_token='$activation'";
        $user = new User();
        $result = mysqli_fetch_array(Database::query($sql));
        if($result['id'] == null) return null;
        $user->build($result);
        return $user;        
    }

    static public function findByCredentials($username, $password){
        $password = hash("sha256", $password);
        $sql = "SELECT * FROM users WHERE username='$username' and password_digest='$password'";
        $user = new User();
        $result = mysqli_fetch_array(Database::query($sql));
        if($result['id'] == null) return null;
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
        $this->activationToken = $result['activation_token'];
        $this->sessionToken = $result['session_token'];
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
        $array["id"] = $this->id;
        $array["username"] = $this->username;
        $array["name"] = $this->name;
        $array["surname"] = $this->surname;
        $array["email"] = $this->email;
        $array["role"] = $this->role;
        $array["image"] = $this->image;
        $array["city"] = $this->city;
        $array["address"] = $this->address;
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
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
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
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param mixed $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
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
    public function getPasswordDigest()
    {
        return $this->passwordDigest;
    }

    /**
     * @param mixed $passwordDigest
     */
    public function setPasswordDigest($passwordDigest)
    {
        $this->passwordDigest = $passwordDigest;
    }

    /**
     * @return mixed
     */
    public function getActivationToken()
    {
        return $this->activationToken;
    }

    /**
     * @param mixed $activationToken
     */
    public function setActivationToken($activationToken)
    {
        $this->activationToken = $activationToken;
    }

    /**
     * @return mixed
     */
    public function getRememberToken()
    {
        return $this->rememberToken;
    }

    /**
     * @param mixed $rememberToken
     */
    public function setRememberToken($rememberToken)
    {
        $this->rememberToken = $rememberToken;
    }

    /**
     * @return mixed
     */
    public function getSessionToken()
    {
        return $this->sessionToken;
    }

    /**
     * @param mixed $sessionToken
     */
    public function setSessionToken($sessionToken)
    {
        $this->sessionToken = $sessionToken;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role)
    {
        $this->role = $role;
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
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * @param mixed $theme
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return mixed
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param mixed $deleted
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }

    /**
     * @return mixed
     */
    public function getLoginAttepmts()
    {
        return $this->loginAttepmts;
    }

    /**
     * @param mixed $loginAttepmts
     */
    public function setLoginAttepmts($loginAttepmts)
    {
        $this->loginAttepmts = $loginAttepmts;
    }

    /**
     * @return mixed
     */
    public function getRememberedAt()
    {
        return $this->rememberedAt;
    }

    /**
     * @param mixed $rememberedAt
     */
    public function setRememberedAt($rememberedAt)
    {
        $this->rememberedAt = $rememberedAt;
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