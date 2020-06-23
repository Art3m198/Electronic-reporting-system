<?php 
date_default_timezone_set("Europe/Moscow");
require 'libs/rb.php';
R::setup( 'mysql:host=localhost:8889;dbname=name','name', 'password' ); 

if ( !R::testconnection() )
{
		exit ('Connection To The Database Failed');
}

session_start();