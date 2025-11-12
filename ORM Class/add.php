<?php

    require_once('rb.php');
    require_once('orm.php');
    
    $dbo = new ORM("mysql", "", "localhost", "test", "root", "password", false);
    
    $user = $dbo->Create('users');
    
    $user->username = 'Ed';
    $user->notebdy = 'New user test!!!!!';

    $id = $dbo->Save($user);
    
    echo $id;
?> 
