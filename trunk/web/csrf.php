<?php
  @session_start();
  $token = md5(uniqid(rand(), true));
  if(!isset($_SESSION['csrf_keys'])){
	$_SESSION['csrf_keys']=array();
  }
  array_push($_SESSION['csrf_keys'],$token);
  while(count($_SESSION['csrf_keys'])>10) 
	array_shift($_SESSION['csrf_keys']);
  
?><input type="hidden" name="csrf" value="<?php echo $token?>" class="<?php echo in_array($token,$_SESSION['csrf_keys'])?>">
