<?php
    $server = $_GET['update_server'];
    $cmd = "curl http://$server/update.html";
    $output = shell_exec($cmd);
    echo $output;
?>