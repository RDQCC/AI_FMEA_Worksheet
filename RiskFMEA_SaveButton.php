<?php
include "Showroom_DB.php";

$Project_ID = $_REQUEST['Project'];
$Document_No = $_REQUEST['Document'];
$Document_Revision = $_REQUEST['Revision'];
$Change_Number = $_REQUEST['ChangeNumber'];

$P_Pre = $_REQUEST['PPre'];
$S_Pre = $_REQUEST['SPre'];
$RiskRank_Pre = $_REQUEST['RiskRankPre'];
$Control_Type = $_REQUEST['ControlType'];
$P_Post = $_REQUEST['PPost'];
$S_Post = $_REQUEST['SPost'];
$RiskRank_Post = $_REQUEST['RiskRankPost'];

//echo $Change_Number;

//echo '<pre>';
//print_r($FMEA_Type);
//echo '</pre>';

$PPre = explode("," ,$P_Pre);
$SPre = explode("," ,$S_Pre);
$RiskRankPre = explode("," ,$RiskRank_Pre);
$ControlType = explode("," ,$Control_Type);
$PPost = explode("," ,$P_Post);
$SPost = explode("," ,$S_Post);
$RiskRankPost = explode("," ,$RiskRank_Post);

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

P_Pre = '$PPre[$i]',
S_Pre = '$SPre[$i]',
RiskRank_Pre = '$RiskRankPre[$i]',
Control_Type = '$ControlType[$i]',
P_Post = '$PPost[$i]',
S_Post = '$SPost[$i]',
RiskRank_Post = '$RiskRankPost[$i]'

WHERE Risk_ID ='$RiskID'");
}

?>