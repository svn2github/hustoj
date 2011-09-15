<?php
if (!isset($_SESSION['postkey'])||$_SESSION['postkey']!=$_POST['postkey'])
	exit(1);
?>
