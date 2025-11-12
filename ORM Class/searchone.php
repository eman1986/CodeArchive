<?php
    require_once('rb.php');
    require_once('orm.php');
    
    $dbo = new ORM("mysql", "", "localhost", "test", "root", "password", false);
    
    $result = $dbo->Get('users', "username=? and notebdy=?", array('me1', 'me12'));
        
    //see if we find any results.
    if ($result == null) {
    	echo 'No Results';
    } else {
	  echo $result;
    }
?> 
