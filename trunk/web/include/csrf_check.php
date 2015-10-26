<?php
  @session_start();
  if( $_SERVER['REQUEST_METHOD']=='POST'  ){
	if (isset($_SESSION['csrf_keys'])
   		&& is_array($_SESSION['csrf_keys'])
		&& isset($_POST['csrf'])
   		&& in_array($_POST['csrf'],$_SESSION['csrf_keys'])
   	){
//		echo "<!-csrf check passed->";
  	}else{	
		echo "<!-csrf check failed->";
		exit(1);
  	}
  }
?>
