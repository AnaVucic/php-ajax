<?php
session_start();
unset($_SESSION['UserID']);
session_destroy();
session_write_close();
header('Location: index.php');
die;
