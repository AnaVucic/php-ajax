<?php

class User
{
    public $id;
    public $username;
    public $password;

    public function __construct($id = null, $username = null, $password = null)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
    }

    public static function logInUser($username, $password, mysqli $conn)
    {
        
        $query = "SELECT * FROM user WHERE username='$username' AND password='$password'";
        $result = $conn->query($query);

        if($result->num_rows == 1){
            return new User($result->fetch_assoc()["UserID"], $username, $password);
        }
        return null;
    }

}
