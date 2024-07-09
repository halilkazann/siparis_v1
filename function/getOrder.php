<?php
session_start();
echo $_SESSION['webSite']."<br>";
echo $_SESSION['token'];
echo "<pre>";
print_r($_SESSION);

