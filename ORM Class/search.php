<?php
    require_once('rb.php');
    require_once('orm.php');
    
    $dbo = new ORM("mysql", "", "localhost", "test", "root", "password", false);
    
    $search = $dbo->Search('users', "username=? and notebdy=?", array('me1', 'me12'));
            
    //see if we find any results.
    if ($search == null) {
    	echo 'No Results';
    } else {
		foreach($search as $users) {
		  echo $users->username.'-'.$users->notebdy.'<br />';
		}
    }
?> 
