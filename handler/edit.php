<?php
require "../db_connection.php";
require "../model/member.php";
require "../model/membership.php";
require "../model/member_membership.php"; 

if(isset($_POST['editDate']) && isset($_POST['memberIDEdit']) && isset($_POST['membershipIDEdit'])) 
{
    $status = MemberMembership::update($_POST['memberIDEdit'], $_POST['membershipIDEdit'], $_POST['editDate'], $conn);
    if ($status) {
        echo "Success";
    } else {
        echo "Failed";
    }

}