<?php
	$fconn = mysqli_connect("192.168.88.194", "jda", "", "deped_ams");

	
	if($fconn -> connect_error){
		die("Connection Error:".$fconn -> connect_error);
	}
	
?>