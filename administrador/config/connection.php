<?php
$con  = mysqli_connect('localhost','root','','bd_bha_sci');
$con->set_charset("utf8");
if(mysqli_connect_errno())
{
    echo 'Database Connection Error';
}
