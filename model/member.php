<?php

Class Member
{

    public $memberid;
    public $firstname;
    public $lastname;

    public function __construct($memberid = null, $firstname = null, $lastname = null)
    {
        $this->memberid = $memberid;
        $this->firstname = $firstname;
        $this->lastname = $lastname;      
    }

    public static function getAll(mysqli $conn)
    {
        $query = "SELECT * FROM member";

        if(!$result = $conn->query($query)) 
        {
            echo "Error occured while trying to get all MEMBER records";
            return null;
        } 
        elseif($result->num_rows == 0)
        {
            echo 'There are no records of MEMBER in database to show.';
            return null;
        } 
        else 
        {
            $members = array();
            while($row = $result->fetch_assoc())
            {
                $member = new Member($row["MemberID"], $row["Firstname"], $row["Lastname"]);
                array_push($members, $member);
            }
            return $members;
        }
    }

    public static function getById(mysqli $conn, $id)
    {
        $query = "SELECT * FROM member WHERE MemberID=$id";

        if($result = $conn->query($query))
        {
            $row = $result->fetch_assoc("MemberID");
            return new Member($row["MemberID"], $row["Firstname"], $row["Lastname"]);
        } 
        else 
        {
            echo "No MEMBER found by this id";
            return null;
        }
    }
}


?>