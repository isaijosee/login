<?php
$db_host="b7lofr9uqlk0z6vh6den-mysql.services.clever-cloud.com"; //localhost server 
$db_user="u5pnv6f2wskqv3nt";	//database username
$db_password="6ks15jig2tHVUrzDv1cm";	//database password   
$db_name="b7lofr9uqlk0z6vh6den";	//database name

try
{
	$db=new PDO("mysql:host={$db_host};dbname={$db_name}",$db_user,$db_password);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOEXCEPTION $e)
{
	$e->getMessage();
}

?>



