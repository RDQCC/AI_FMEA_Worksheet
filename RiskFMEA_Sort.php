<?php
include "Showroom_DB.php";

$Project_ID = $_REQUEST['Project'];
$Document_No = $_REQUEST['Document'];
$Document_Revision = $_REQUEST['Revision'];
$Sort_No = $_REQUEST['Sort'];


//echo $Change_Number;


$query_GetRiskID = mysqli_query($con, "SELECT Risk_ID FROM Risk_FMEA WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\"");															

$RiskID_Num = mysqli_num_rows($query_GetRiskID);

for ($RiskID=1; $RiskID<$RiskID_Num+1; $RiskID++)
{
	$i = $RiskID -1;									//when save to database which starts from 0

	
$FMEA_Query=mysqli_query($con, "UPDATE Risk_FMEA SET
	
Project_ID	= '$Project_ID',
Document_No = '$Document_No',
Document_Revision = '$Document_Revision',	
Change_Number = '$Change_Number',

FMEA_Type = '$FMEAType[$i]',
P1_Pre = '$P1Pre[$i]',
P2_Pre = '$P2Pre[$i]',
S_Pre = '$SPre[$i]',
RiskRank_Pre = '$RiskRankPre[$i]',
Control_Type = '$ControlType[$i]',
P1_Post = '$P1Post[$i]',
P2_Post = '$P2Post[$i]',
S_Post = '$SPost[$i]',
RiskRank_Post = '$RiskRankPost[$i]'

WHERE Risk_ID ='$RiskID'");
}

?>