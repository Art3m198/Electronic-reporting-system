<?php 
date_default_timezone_set("Europe/Moscow");
require 'libs/rb.php';
R::setup( 'mysql:host=localhost;dbname=report','report', '12345' ); 

if ( !R::testconnection() )
{
		exit ('Connection To The Database Failed');
}

session_start();