<?php
//no changes compared with _SR1.php
//session_start(); 


//if (!isset($_SESSION["User_ID"]) || $_SESSION["User_ID"]=="")
//	{
//		$ERR_MSG = "Time out, Please Re-Sign in";
//		echo "<script>window.location='index.php?ERR_MSG=$ERR_MSG'</script>";
//	} 

//$User_ID = strtoupper($_SESSION["User_ID"]); 
include "Showroom_DB.php";

?>
<link rel="stylesheet" type="text/css" href="CSS/RdPDM.css">
<link rel="stylesheet" type="text/css" href="CSS/ShowRoom.css">
<style type="text/css">
</style>

<script type="text/javascript">
	
</script>


<?php

$Part_Image = $_REQUEST['Part_Image'];

if (strtoupper(substr($Part_Image,-3))<>"PDF")
	{
		echo "<img src='/FMEA_Images/".$Part_Image."' width='98%'/>";  //width controls the image shows at iFRAME. without the width only part of image is shown
				
	}

if (strtoupper(substr($Part_Image,-3))=="PDF")
	{
		echo "<embed src='/FMEA_Images/".$Part_Image."' width='98%'/>";   //width='960' height='510'>
	}
	

mysql_close($con);  
					
?>

