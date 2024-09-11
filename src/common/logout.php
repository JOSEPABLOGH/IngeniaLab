<?php
session_start();
session_destroy();
header("Location: /TC2005B_602_01/IngeniaLab/index.php");
exit();
