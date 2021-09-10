<?php
include "Showroom_DB.php";
$Document_No = $_REQUEST['DocumentNo'];
$Document_Revision = $_REQUEST['DocumentRevision'];
$Change_Number = $_REQUEST['ChangeNumber'];

//$Project_ID = '10001';
//$Document_No = '10023';
//$Document_Revision = '1';
//$Change_Number = '2017023';

$query_GetRiskRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\"");															
$RiskID_Num = mysqli_num_rows($query_GetRiskRow);
$NewRiskID = $RiskID_Num + 1;

$FMEA_Query=mysqli_query($con, "INSERT INTO Risk_FMEA (Risk_ID, Change_Number, Document_No, Document_Revision) VALUES ('$NewRiskID', '$Change_Number', '$Document_No','$Document_Revision')");
//since inserting a new row in a table, there is no condition needed

echo $NewRiskID;

?>