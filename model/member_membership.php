<?php



class MemberMembership
{
    public $member;
    public $membership;
    public DateTime $startDate;
    public $status;

    public function __construct($member = null, $membership = null, DateTime $startDate = null, $status = false)
    {
        $this->member = $member;
        $this->membership = $membership;
        $this->startDate = $startDate;
        $this->status = $status; 
    }

    public static function getAll(mysqli $conn)
    {
        $query = "SELECT MemberID, Firstname, Lastname, status, start_date, MembershipID, MembershipName, Description, Duration, Fee 
        FROM member_membership t1 
        JOIN member t2 ON t1.member_id=t2.MemberID 
        JOIN membership t3 ON t1.membership_id = t3.MembershipID ORDER BY start_date DESC";

        if(!$result = $conn->query($query)) 
        {
            echo "Error occured while trying to get all MEMBER_MEMBERSHIP records";
            return null;
        } 
        elseif($result->num_rows == 0)
        {
            echo 'There are no records of MEMBER_MEMBERSHIP in database to show.';
            return null;
        } 
        else 
        {
            $data = array();
            while($row = $result->fetch_assoc())
            {
                $date = new DateTime($row["start_date"]);
                $active = $row["status"];
                $membership = new Membership($row["MembershipID"], $row["MembershipName"], $row["Description"], $row["Duration"], $row["Fee"]);
                $member = new Member($row["MemberID"], $row["Firstname"], $row["Lastname"]);
                $record = new MemberMembership($member, $membership, $date, $active);

                array_push($data, $record);
            }
            return $data;
        
        }
    }

    public static function add($data, mysqli $conn)
    {
        $memberID = $data->member->memberid;
        $membershipID = $data->membership->membershipid;
        $date = $data->startDate->format("Y-m-d");
        $status = true;
        $query = "INSERT INTO member_membership(member_id,membership_id,start_date,status) 
        VALUES($memberID, $membershipID, '$date', 1)";

        return $conn->query($query);
    }

    public static function getById($memberid, $membershipid, mysqli $conn)
    {
        $query = "SELECT MemberID, Firstname, Lastname, status, start_date, MembershipID, MembershipName, Description, Duration, Fee 
        FROM member_membership t1 
        JOIN member t2 ON t1.member_id=t2.MemberID 
        JOIN membership t3 ON t1.membership_id = t3.MembershipID 
        WHERE MemberID=$memberid AND MembershipID=$membershipid";

        $result = $conn->query($query);
        $result = $result->fetch_array(1);
        if ($result) {
            $date = new DateTime($result["start_date"]);
            $active = $result["status"];
            $membership = new Membership($result["MembershipID"], $result["MembershipName"], $result["Description"], $result["Duration"], $result["Fee"]);
            $member = new Member($result["MemberID"], $result["Firstname"], $result["Lastname"]);
            $record = new MemberMembership($member, $membership, $date, $active);
            return $record;
        } else {
            return null;
        }
    }

    public static function update($memberid, $membershipid, $newdate, mysqli $conn) {
        $newdate = strtotime($newdate);
        $newdate = date("Y-m-d", $newdate);
        $query = "UPDATE member_membership SET 
        start_date = '$newdate'
        WHERE member_id=$memberid AND membership_id=$membershipid";
        return $conn->query($query);
    }

    public function deleteById(mysqli $conn) {
        $memberidtodel = $this->member->memberid;
        $membershipidtodel = $this->membership->membershipid;
        $query = "DELETE FROM member_membership WHERE member_id=$memberidtodel AND membership_id=$membershipidtodel";
        return $conn->query($query);
    }
}