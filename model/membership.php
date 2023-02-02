<?php

class Membership
{
    public $membershipid;
    public $membershipname;
    public $description;
    public $duration;
    public $fee;


    public function __construct( $membershipid = null,  $membershipname = null, $description = null, $duration = null, $fee = null)
    {
        $this->membershipid = $membershipid;
        $this->membershipname = $membershipname;
        $this->description = $description;
        $this->duration = $duration; 
        $this->fee = $fee; 
    }

    public static function getAll(mysqli $conn)
    {
        $query = "SELECT * FROM membership";

        if(!$result = $conn->query($query)) 
        {
            echo "Error occured while trying to get all MEMBERSHIP records";
            return null;
        } 
        elseif($result->num_rows == 0)
        {
            echo 'There are no records of MEMBERSHIP in database to show.';
            return null;
        } 
        else 
        {
            $memberships = array();
            while($row = $result->fetch_assoc())
            {
                $membership = new Membership($row["MembershipID"], $row["MembershipName"], $row["Description"], $row["Duration"], $row["Fee"]);
                array_push($memberships, $membership);
            }
            return $memberships;
        
        }
    }

    public static function getOne(mysqli $conn, $id)
    {
        $query = "SELECT * FROM membership WHERE MembershipID=$id";

        if($result = $conn->query($query))
        {
            $row = $result->fetch_array(1);
            return new Membership($row["MembershipID"], $row["MembershipName"], $row["Description"], $row["Duration"], $row["Fee"]);
        } 
        else 
        {
            echo "No MEMBER found by this id";
            return null;
        }
    }





}

?>