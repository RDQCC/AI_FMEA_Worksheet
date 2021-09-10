<?PHP

$con = mysqli_connect("rdpdmshowroom.c390vilt1vzv.us-west-1.rds.amazonaws.com","showroom","801Sprudence", "DDP2");
if (!$con)
	{
		Print '<p>Failed to connect to the database!</p>';
		$Msg_Title="Web Database Temporary Unavailable! ";
		$Msg_Content="Error Message: ".mysqli_error()."; <br />Please Send above Error Message to System Administrator";
	}
else
	{
		/*mysql_query("SET NAMES 'UTF8'");
		mysql_query("SET CHARACTER SET UTF8");
		mysql_query("SET CHARACTER_SET_RESULTS='UTF8'");
		mysql_select_db("DDP2", $con);*/
	}
?>

