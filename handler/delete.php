<?php
require "../db_connection.php";
require "../model/member.php";
require "../model/membership.php";
require "../model/member_membership.php"; 

if (isset($_POST['deleteKey1']) && isset($_POST['deleteKey2'])) {

    $x = new Member($_POST['deleteKey1']);
    $y = new Membership($_POST['deleteKey2']);
    $ToDelete = new MemberMembership($x, $y, new DateTime());
    $status = $ToDelete->deleteById($conn);

    if ($status) {
        echo "Success";
    } else {
        echo "Failed";
    }
}