<?php
    require_once('rb.php');
    require_once('orm.php');
    
    $dbo = new ORM("mysql", "", "localhost", "test", "root", "password", false);
    
    $users = $dbo->Load('users', 18);
    
    $users->notebdy = 'Test User access 0wnd!';
    $id = $dbo->Save($users);
    
    echo $id;
?> 
