<?php
    require_once('rb.php');
    require_once('orm.php');
    
    $dbo = new ORM("mysql", "", "localhost", "test", "root", "password", false);
    
    $users = $dbo->Load('users', 18);
        
    echo $users->username.' has a note that reads: '.$users->notebdy;
?> 
