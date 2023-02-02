<?php
require "../db_connection.php";
require "../model/member.php";
require "../model/membership.php";
require "../model/member_membership.php"; 

if(isset($_POST['date']) && isset($_POST['member']) && isset($_POST['membership'])) 
{
    $member = Member::getOne($conn, $_POST['member']);
    $membership = Membership::getOne($conn, $_POST['membership']);
    $date = new DateTime($_POST['date']);

    $new_membership = new MemberMembership($member, $membership, $date, true);
    $status = MemberMembership::add($new_membership, $conn);
    if ($status) {
        echo "Success";
    } else {
        echo "Failed";
    }

}
