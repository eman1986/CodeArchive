<?php
    require_once('rb.php');
    require_once('orm.php');
    
    $dbo = new ORM("mysql", "", "localhost", "test", "root", "password", false);

    $count = $dbo->NumResults('users');
    
    echo $count;
?>
