<?php
    require_once('rb.php');
    require_once('orm.php');
    
    $dbo = new ORM("mysql", "", "localhost", "test", "root", "password", false);
    
    $users = $dbo->Load('users', 12);
    
    $dbo->Delete($users);
        
    echo $users->username.' has been removed.';
?> 
