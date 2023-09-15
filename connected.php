<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); //on dev only
$con=mysqli_connect("localhost","","","statican_music");
mysqli_set_charset($con, 'utf8');


?> 