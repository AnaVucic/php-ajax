<?php
require "../db_connection.php";
require "../model/member.php";
require "../model/membership.php";
require "../model/member_membership.php"; 

if (isset($_POST['key1']) && isset($_POST['key2'])) {
    
    $member_membership = MemberMembership::getById($_POST['key1'], $_POST['key2'], $conn);
    
    echo json_encode($member_membership);
}
