<?php
session_start();
if (empty($_SESSION['login_user'])) {
	header("location:logout.php");
}
else{

include('header.php');
include('footer.php');
}

?>