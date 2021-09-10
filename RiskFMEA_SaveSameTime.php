 <?php
include "Showroom_DB.php";
/*
Project='+Selected_Project+'&Document='+Selected_Document+'&Revision='+Selected_Revision+'&ChangeNumber='+Selected_ChangeNumber+"&RiskID="+Risk_ID+"&CollumnId="+Collumn_Id+"&CellSave="+Selected_CellSave+"&RiskRankPre="+RiskRankPre_Changed);*/

$Document_No = $_REQUEST['Document'];
$Document_Revision = $_REQUEST['Revision'];
$Change_Number = $_REQUEST['ChangeNumber'];

$Risk_ID = $_REQUEST['RiskID'];
$Collumn_Id = $_REQUEST['CollumnId'];			//this value is detected (colums)
$Cell_Value = $_REQUEST['CellSave'];			//this value is updated (P, S)
$RiskRank = $_REQUEST['RiskRank'];				//this value is calculated by


//echo '<pre>';
//print_r($FMEA_Type);
//echo '</pre>';

if ($Collumn_Id == 'PPre')
{
	$FMEA_Query=mysqli_query($con, "UPDATE Risk_FMEA SET	
	P_Pre = '$Cell_Value',
	RiskRank_Pre = '$RiskRank'
WHERE Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Risk_ID ='$Risk_ID'");
}	

else if ($Collumn_Id == 'SPre')
{
	$FMEA_Query=mysqli_query($con, "UPDATE Risk_FMEA SET	
	S_Pre = '$Cell_Value',
	RiskRank_Pre = '$RiskRank'
WHERE Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Risk_ID ='$Risk_ID'");
}

else if ($Collumn_Id == 'ControlType')
{
	$FMEA_Query=mysqli_query($con, "UPDATE Risk_FMEA SET	
	Control_Type = '$Cell_Value'
WHERE Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Risk_ID ='$Risk_ID'");
}

else if ($Collumn_Id == 'PPost')
{
	$FMEA_Query=mysqli_query($con, "UPDATE Risk_FMEA SET	
	P_Post = '$Cell_Value',
	RiskRank_Post = '$RiskRank'
WHERE Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Risk_ID ='$Risk_ID'");
}

else if ($Collumn_Id == 'SPost')
{
	$FMEA_Query=mysqli_query($con, "UPDATE Risk_FMEA SET	
	S_Post = '$Cell_Value',
	RiskRank_Post = '$RiskRank'
WHERE Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Risk_ID ='$Risk_ID'");
}

else if ($Collumn_Id == 'Problem_Category')
{
	$FMEA_Query=mysqli_query($con, "UPDATE Risk_FMEA SET	
	Problem_Category = '$Cell_Value'
WHERE Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Risk_ID ='$Risk_ID'");
}

else if ($Collumn_Id == 'Sub_Category')
{
	$FMEA_Query=mysqli_query($con, "UPDATE Risk_FMEA SET	
	Sub_Category = '$Cell_Value'
WHERE Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Risk_ID ='$Risk_ID'");
}

else if ($Collumn_Id == 'Hazard')
{
	$FMEA_Query=mysqli_query($con, "UPDATE Risk_FMEA SET	
	Hazard = '$Cell_Value'
WHERE Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Risk_ID ='$Risk_ID'");
}

else if ($Collumn_Id == 'Harm')
{
	$FMEA_Query=mysqli_query($con, "UPDATE Risk_FMEA SET
	
		Harm = '$Cell_Value'
	
WHERE Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Risk_ID ='$Risk_ID'");
}

else if ($Collumn_Id == 'Severity')
{
	$FMEA_Query=mysqli_query($con, "UPDATE Risk_FMEA SET
	
		Harm_Severity = '$Cell_Value'
	
WHERE Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Risk_ID ='$Risk_ID'");
}

?>










