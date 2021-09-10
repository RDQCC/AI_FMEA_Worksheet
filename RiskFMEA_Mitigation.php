<?php
//----------Menu: under risk management/RM Tools /Mitigation solutions---------------------------------------
//---------function: enter "failure mode", or "potential cause", or "Key word" , search realted risk info----

session_start(); 
if (!isset($_SESSION["User_ID"]) || $_SESSION["User_ID"]=="")
	{
		$ERR_MSG = "Authorization Failed !";
		echo "<script>window.location='index.php?ERR_MSG=$ERR_MSG'</script>";
	} 

$User_ID = strtoupper($_SESSION["User_ID"]); 

?>
<!doctype html>
<html> 
<head>

<link href="CSS/ShowRoom.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">

function getXMLObject() //XML OBJECT
	{
		var xmlHttp = false;
		try 
			{
				xmlHttp = new ActiveXObject("Msxml2.XMLHTTP") // For Old Microsoft Browsers
			}
		catch (e) 
			{
				try 
					{
						xmlHttp = new ActiveXObject("Microsoft.XMLHTTP") // For Microsoft IE 6.0+
					}
				catch (e2) 
					{
						xmlHttp = false // No Browser accepts the XMLHTTP Object then false
					}
			}
		if (!xmlHttp && typeof XMLHttpRequest != 'undefined') 
			{
				xmlHttp = new XMLHttpRequest(); //For Mozilla, Opera Browsers
			}
		return xmlHttp; // Mandatory Statement returning the ajax object created
	}

	var xmlhttp = new getXMLObject();

	
function Set_Respond_Value() {
	if(xmlhttp.readyState == 4)
	{
	var response = xmlhttp.responseText;
		//alert (response);
	//document.getElementById("ABC").value='response';
	}
}
	
	
//------------------belows are for creating table of contents per a historial project		
	
function Select_Keys()
{
 var Selected_Keys = document.getElementById("Keys_Type").value;	
 window.open("RiskFMEA_Mitigation.php?Keys="+Selected_Keys, "_self");
}

function Change_SameTime_B(Collumn_Id)										//function: when enter failure mode, erase content of failure cause and keyword (before submit)
{	
	
	if (Collumn_Id == "Failure_Mode")													
		{
			var Selected_FailureMode = document.getElementById("FailureMode_Keywords_B").value;
			var Selected_PotentialCause = "";
		}
	
	else if (Collumn_Id == "Potential_Cause")	
		{
			var Selected_PotentialCause = document.getElementById("PotentialCause_Keywords_B").value;
			var Selected_FailureMode = "";
		}
	window.open("RiskFMEA_Mitigation.php?FailureModeKeys="+Selected_FailureMode+"&PotentialCauseKeys="+Selected_PotentialCause, "_self");	
}
	
function Change_SameTime_A(Collumn_Id)										//function: when enter failure mode, erase content of failure cause and keyword (after submit)
{	
	
	if (Collumn_Id == "Failure_Mode")													
		{
			var Selected_FailureMode = document.getElementById("FailureMode_Keywords_A").value;
			var Selected_PotentialCause = "";
		}
	
	else if (Collumn_Id == "Potential_Cause")	
		{
			var Selected_PotentialCause = document.getElementById("PotentialCause_Keywords_A").value;
			var Selected_FailureMode = "";
		}
	window.open("RiskFMEA_Mitigation.php?FailureModeKeys="+Selected_FailureMode+"&PotentialCauseKeys="+Selected_PotentialCause, "_self");	
}
	
function Standard_Exit()
	{
	parent.Home_WelcomePage()  //once the function is activiated, the window will direct to parent (Home.php) and run Javascript function which re-layouts left and right area
	}	
	
function Standard_Export()
{
	var Selected_Project = document.getElementById("ProjectID_TOW").value;	
 	var Selected_Document = document.getElementById("DocumentNo_TOW").value;
 	var Selected_Revision = document.getElementById("DocumentRevision_TOW").value;
	
	window.open("Regulatory_TOWtoExcel.php?Project="+Selected_Project+"&Document="+Selected_Document+"&Revision="+Selected_Revision, "_self"); 
}	
	
</script> 
</head>


<body>

<!------------------------------------------table 1: feedback title------------------------------------------------->
<?php
include "Showroom_DB.php";
	
$FailureMode_Keywords = $_REQUEST['FailureModeKeys'];			//these values are from Javascript
$PotentialCause_Keywords = $_REQUEST['PotentialCauseKeys'];	
$Keys = $_REQUEST['Keys'];


function Select_ButtonOption($Operation, $Operation_Title, $Operation_Ary_Desc, $Operation_Ary_Value) 
	{
	$Operation_ID = $_REQUEST[$Operation];	//get name of selected Operation type from above javascript for internal (equiv $Operation_Type)
	$Operation_Ary_ValueComing = array($Operation_ID);			//variable within array shall have no quoation (waste 3 hours)		
	$Operation_Ary_L = count($Operation_Ary_Value);
	//---------------------------
	for ($cj=0; $cj<$Operation_Ary_L; $cj++)							//This loop is used to obtain the description of selected $Operation_ID
		{
		if ($Operation_Ary_Value[$cj] == $Operation_ID)
			{
			$Operation_ID_Desc = $Operation_Ary_Desc[$cj];				//$Operation_ID_Desc shall be displayed at button
			}
		}
	$Operation_Ary_ValueDesc = array($Operation_ID_Desc);	
	
	$Operation_Ary_DifValue = array_diff($Operation_Ary_Value, $Operation_Ary_ValueComing);	//the difference is used to display rest of options
	$Operation_Ary_DifDesc = array_diff($Operation_Ary_Desc, $Operation_Ary_ValueDesc);		//in pull down table after one option is selected
	$Operation_Ary_L = count($Operation_Ary_DifValue);		
	//--------------------------						
	if (isset($Operation_ID) && $Operation_ID<>'') 					//if click on an option ($Operation_ID is set(isset) and not(<>) blank
		{																	
		echo "<option value='$Operation_ID'>$Operation_ID_Desc</option>";		//hold the selected option as table default (display)				
		for ($ci=0; $ci<=$Operation_Ary_L; $ci++)
			{
			if (isset($Operation_Ary_DifValue[$ci])) 						//skip the blank row for "title: please select one"
				{		
				echo "<option value='$Operation_Ary_DifValue[$ci]'>$Operation_Ary_DifDesc[$ci]</option>";//display rest options only (no blank) 			
				}
			}
		}
	else	
		{
	?>
    	<option value=""><?php echo $Operation_Title?></option>
    <?php
		$Operation_Ary_M = count($Operation_Ary_Value);	
		for ($cj=0; $cj<$Operation_Ary_M; $cj++)
			{
	?>									
   <option value="<?php echo $Operation_Ary_Value[$cj] ?>" ID="<?php echo $Operation_Ary_Value[$cj] ?>"><?php echo $Operation_Ary_Desc[$cj] ?></option>;
    <?php
			}
		} //end of 'else'
	}	//end of the function
	
	
//	---------------------------------level 1: if has a "submit"------------------------------

if (isset($_POST['SubmissionInitiation_Submit']) && $_POST['SubmissionInitiation_Submit'] == 'Submit')
{
//save product features (regulation conditions) to database Regulatory_ProjectFeatures

$FailureMode_Keywords	= $_POST['FailureMode_Keywords_B'];
$FailureMode_Keywords = addslashes($FailureMode_Keywords);
$PotentialCause_Keywords	= $_POST['PotentialCause_Keywords_B'];
$PotentialCause_Keywords = addslashes($PotentialCause_Keywords);		
$Keys = $_POST['Keys_Type'];
$Keys = addslashes($Keys);

?>	

<!-----------------------------------------------------------------------------------------------
//save these table of contents to database Regulatory_TOWProject and display on screen meantime
//--------------------------------------------------------------------------------------------->
	
<div class="Trace_Directory" style="text-align:left;">
<td>Home / Risk Management / RM Tools / Mitigation Solutions</td>
</div>

<!--<div ID="AddUser_WebPage"> -->
<form name="Feedback_Form" action="" method="post" onkeydown="if(event.keyCode==13 || event.keyCode==116) return false;" onsubmit="Check_RdU()"> 

<!--table 2nd level: for showing project info by selecting-------------------->

<table align="center" width='1024px'>
<tr style="background-color:transparent; line-height:20px;">
    	<td width="100%">&nbsp;</td>
</tr>
							
<tr style="line-height:24px;">
	<td style="text-align:left; font:14px; font-family: Tahoma, Geneva, sans-serif; color:cadetblue;"><img src="Images/feedback.png" width="24" height="24" align="absmiddle" /> 
    Search Mitigation Solutions through:</td> 
</tr>
</table>                 
           
 <!---table 4 contents---------------------->
<table ID='NewUser_Table2' align='center'>
<tr class="NewUser_Table2_DecorationLine">
    	<td width="12%">&nbsp;</td>
        <td width="21%">&nbsp;</td>
        <td width="12%">&nbsp;</td>
        <td width="21%">&nbsp;</td>
        <td width="12%">&nbsp;</td>
        <td width="21%">&nbsp;</td>
</tr>

<tr class="FMEA_FirstBlank"><td colspan="6">&nbsp;</td></tr>
						
												
<tr><td class="NewUser_Table2_InputTitle"  colspan="6" style="text-indent:0.7em">Enter or Select a Keyword below:</td></tr>
<tr>
    <td class="NewUser_Table2_InputTitle" style="text-indent:0.7em; text-align:right">Failure Mode</td>
    <td><input type="text" name="FailureMode_Keywords_A" ID="FailureMode_Keywords_A" style="width:91%; <?php if($FailureMode_Keywords<>'') echo'background-color:yellow'; ?>" value="<?php echo $FailureMode_Keywords;?>" onChange="Change_SameTime_A('Failure_Mode')"/></td>       
    
    <td class="NewUser_Table2_InputTitle" style="text-indent:0.7em; text-align:right">or Potential Cause</td>
    <td><input type="text" name="PotentialCause_Keywords_A" ID="PotentialCause_Keywords_A" style="width:91%; <?php if($PotentialCause_Keywords<>'') echo'background-color:yellow'; ?>" value="<?php echo $PotentialCause_Keywords;?>" onChange="Change_SameTime_A('Potential_Cause')"/></td>             
 
<?php 
$query_GetKeyName = mysqli_query($con, "SELECT DISTINCT (Keyword) FROM Risk_Mitigation ORDER BY Keyword ASC");														

$Key_Num = mysqli_num_rows($query_GetKeyName);
for ($i=0; $i<$Key_Num; $i++)
	{
	$Key_Row = mysqli_fetch_array($query_GetKeyName);
	$Key_Nos[$i] = $Key_Row['Keyword'];			//create a new array to store all project documents
	}
?>    																									
    <td class="NewUser_Table2_InputTitle" style="text-indent:0.7em; text-align:right">or Keyword</td>
    
    <td>
    <Select ID="Keys_Type" name="Keys_Type" class="Select_ButtonSpace" style="<?php if($Keys <>'') echo'background-color:yellow';?>" OnChange="Select_Keys()">    
<?php	
	
$Operation = 'Keys';						
$Operation_Title = 'Select a Keyword';
$Operation_Ary_Desc =  $Key_Nos;	
$Operation_Ary_Value = $Key_Nos;					
Select_ButtonOption($Operation, $Operation_Title, $Operation_Ary_Desc, $Operation_Ary_Value);	
?>   										
	</select>    		       		
    </td>
</tr>
            	           	           	             	        	        	            	             	        	        	            	           	           	

<!-------Submit the form------------------>

<tr class="NewUser_Table2_Bottom" style="line-height:12px;" >	
        <td colspan="6">&nbsp;</td></tr>
<tr class="NewUser_Table2_Bottom" style='border:solid #EAF2FF 1px;'>
        <td colspan="6" align="center" >
 <input type="submit" name="SubmissionInitiation_Submit" value="Submit" class="RdPDM_Button_Small" style="height:28px;"/>
        </td></tr>
<tr class="NewUser_Table2_Bottom" style="line-height:3px;" >
        <td colspan="6">&nbsp;</td></tr>
</table>
</form>

   
<table ID='Regulatory_SubmissionTable' align='center' width='1024px' cellpadding='0' cellspacing='0' style='line-height:26px; border:solid #15B4FF 1px; border-bottom: none;'> 	<!-----------table 2: title for contents----------------------------------------------------------------------------------->
	<tr style="line-height:3px; background-color:#EAF2FF;">   			<!-------decoration line with division purpose----->
    	<td width="5%">&nbsp;</td>
        <td width="22%">&nbsp;</td>
        <td width="22%">&nbsp;</td>
        <td width="7%">&nbsp;</td>
        <td width="5%">&nbsp;</td>
        <td width="30%">&nbsp;</td>
        <td width="9%">&nbsp;</td>
	</tr>															
    <tr ID="UserList_Table2_Title" style="background-color:#EAF2FF;"> <!--background: url(Images/tr.gif) repeat-x;-->
		<td class="Regulatory_SubmissionTable_Title" style='color:#09F'>ID</td>
		<td class="Regulatory_SubmissionTable_Title" style="text-align: center;">Failure Mode</td>
		<td class="Regulatory_SubmissionTable_Title" style="text-align: center;">Potential Cause</td> 
		<td class="Regulatory_SubmissionTable_Title" style="text-align: center;">FMEA</td>
		<td class="Regulatory_SubmissionTable_Title" style="text-align: center;">Category</td>
		<td class="Regulatory_SubmissionTable_Title" style="text-align: center;">Mitigation</td>
		<td class="Regulatory_SubmissionTable_Title" style='border-right:none'>Note</td>		
	</tr>
		
		
<?php
	
if (isset($FailureMode_Keywords) && $FailureMode_Keywords<>"") 
{
		$Failure_Mode = [];
		$Potential_Cause = [];
		$FMEA = [];	
		$Category = [];	
		$Mitigation = [];
		$Note =[];
			
$query_GetTableofStandard = mysqli_query($con, "SELECT * FROM Risk_Mitigation WHERE (Failure_Mode LIKE \"%$FailureMode_Keywords%\") AND (Mitigation_Design <>'') ORDER BY FIELD(FMEA_Type,'SRA','UFMEA','DFMEA','DFMEA(M)','DFMEA(E)','SEFMEA','SWFMEA','PFMEA')");
		$Document_Num_D = mysqli_num_rows($query_GetTableofStandard);
		for ($i=0; $i<$Document_Num_D; $i++) 
		{
		$Document_Row = mysqli_fetch_array($query_GetTableofStandard);
		$Failure_Mode_D[$i] = $Document_Row['Failure_Mode'];
		$Potential_Cause_D[$i] = $Document_Row['Potential_Cause'];
		$FMEA_D[$i] = $Document_Row['FMEA_Type'];	
		$Category_D[$i] = 'Design';	
		$Mitigation_D[$i] = $Document_Row['Mitigation_Design'];
		$Note_D[$i] = $Document_Row['Product_Category'];
		}
	
		if ($Document_Num_D>0)
		{
		$Failure_Mode = array_merge($Failure_Mode,$Failure_Mode_D);
		$Potential_Cause = array_merge($Potential_Cause,$Potential_Cause_D);
		$FMEA = array_merge($FMEA,$FMEA_D);	
		$Category = array_merge($Category,$Category_D);	
		$Mitigation = array_merge($Mitigation,$Mitigation_D);
		$Note = array_merge($Note,$Note_D);
		}
	
$query_GetTableofStandard = mysqli_query($con, "SELECT * FROM Risk_Mitigation WHERE (Failure_Mode LIKE \"%$FailureMode_Keywords%\") AND (Mitigation_Process <>'') ORDER BY FIELD(FMEA_Type,'SRA','UFMEA','DFMEA','DFMEA(M)','DFMEA(E)','SEFMEA','SWFMEA','PFMEA')");
		$Document_Num_P = mysqli_num_rows($query_GetTableofStandard);
		for ($i=0; $i<$Document_Num_P; $i++) 
		{
		$Document_Row = mysqli_fetch_array($query_GetTableofStandard);
		$Failure_Mode_P[$i] = $Document_Row['Failure_Mode'];
		$Potential_Cause_P[$i] = $Document_Row['Potential_Cause'];
		$FMEA_P[$i] = $Document_Row['FMEA_Type'];	
		$Category_P[$i] = 'Process';	
		$Mitigation_P[$i] = $Document_Row['Mitigation_Process'];
		$Note_P[$i] = $Document_Row['Product_Category'];
		}	
	
		if ($Document_Num_P>0)
		{
		$Failure_Mode = array_merge($Failure_Mode,$Failure_Mode_P);
		$Potential_Cause = array_merge($Potential_Cause,$Potential_Cause_P);
		$FMEA = array_merge($FMEA,$FMEA_P);	
		$Category = array_merge($Category,$Category_P);	
		$Mitigation = array_merge($Mitigation,$Mitigation_P);
		$Note = array_merge($Note,$Note_P);
		}
	
$query_GetTableofStandard = mysqli_query($con, "SELECT * FROM Risk_Mitigation WHERE (Failure_Mode LIKE \"%$FailureMode_Keywords%\") AND (Mitigation_Info <>'') ORDER BY FIELD(FMEA_Type,'SRA','UFMEA','DFMEA','DFMEA(M)','DFMEA(E)','SEFMEA','SWFMEA','PFMEA')");
		$Document_Num_I = mysqli_num_rows($query_GetTableofStandard);
		for ($i=0; $i<$Document_Num_I; $i++) 
		{
		$Document_Row = mysqli_fetch_array($query_GetTableofStandard);
		$Failure_Mode_I[$i] = $Document_Row['Failure_Mode'];
		$Potential_Cause_I[$i] = $Document_Row['Potential_Cause'];
		$FMEA_I[$i] = $Document_Row['FMEA_Type'];	
		$Category_I[$i] = 'Info';	
		$Mitigation_I[$i] = $Document_Row['Mitigation_Info'];
		$Note_I[$i] = $Document_Row['Product_Category'];
		}
	
		if ($Document_Num_I>0)
		{
		$Failure_Mode = array_merge($Failure_Mode,$Failure_Mode_I);
		$Potential_Cause = array_merge($Potential_Cause,$Potential_Cause_I);
		$FMEA = array_merge($FMEA,$FMEA_I);	
		$Category = array_merge($Category,$Category_I);	
		$Mitigation = array_merge($Mitigation,$Mitigation_I);
		$Note = array_merge($Note,$Note_I);	
		}
	
		$Document_Num = $Document_Num_D+$Document_Num_P+$Document_Num_I;
}
			
else if (isset($PotentialCause_Keywords) && $PotentialCause_Keywords<>"") 
{
		$Failure_Mode = [];
		$Potential_Cause = [];
		$FMEA = [];	
		$Category = [];	
		$Mitigation = [];
		$Note =[];
	
$query_GetTableofStandard = mysqli_query($con, "SELECT * FROM Risk_Mitigation WHERE (Potential_Cause LIKE \"%$PotentialCause_Keywords%\") AND (Mitigation_Design <>'') ORDER BY FIELD(FMEA_Type,'SRA','UFMEA','DFMEA','DFMEA(M)','DFMEA(E)','SEFMEA','SWFMEA','PFMEA')");
		$Document_Num_D = mysqli_num_rows($query_GetTableofStandard);
		for ($i=0; $i<$Document_Num_D; $i++) 
		{
		$Document_Row = mysqli_fetch_array($query_GetTableofStandard);
		$Failure_Mode_D[$i] = $Document_Row['Failure_Mode'];
		$Potential_Cause_D[$i] = $Document_Row['Potential_Cause'];
		$FMEA_D[$i] = $Document_Row['FMEA_Type'];	
		$Category_D[$i] = 'Design';	
		$Mitigation_D[$i] = $Document_Row['Mitigation_Design'];
		$Note_D[$i] = $Document_Row['Product_Category'];
		}
	
		if ($Document_Num_D>0)
		{
		$Failure_Mode = array_merge($Failure_Mode,$Failure_Mode_D);
		$Potential_Cause = array_merge($Potential_Cause,$Potential_Cause_D);
		$FMEA = array_merge($FMEA,$FMEA_D);	
		$Category = array_merge($Category,$Category_D);	
		$Mitigation = array_merge($Mitigation,$Mitigation_D);
		$Note = array_merge($Note,$Note_D);
		}
	
$query_GetTableofStandard = mysqli_query($con, "SELECT * FROM Risk_Mitigation WHERE (Potential_Cause LIKE \"%$PotentialCause_Keywords%\") AND (Mitigation_Process <>'') ORDER BY FIELD(FMEA_Type,'SRA','UFMEA','DFMEA','DFMEA(M)','DFMEA(E)','SEFMEA','SWFMEA','PFMEA')");
		$Document_Num_P = mysqli_num_rows($query_GetTableofStandard);
		for ($i=0; $i<$Document_Num_P; $i++) 
		{
		$Document_Row = mysqli_fetch_array($query_GetTableofStandard);
		$Failure_Mode_P[$i] = $Document_Row['Failure_Mode'];
		$Potential_Cause_P[$i] = $Document_Row['Potential_Cause'];
		$FMEA_P[$i] = $Document_Row['FMEA_Type'];	
		$Category_P[$i] = 'Process';	
		$Mitigation_P[$i] = $Document_Row['Mitigation_Process'];
		$Note_P[$i] = $Document_Row['Product_Category'];
		}
	
		if ($Document_Num_P>0)
		{
		$Failure_Mode = array_merge($Failure_Mode,$Failure_Mode_P);
		$Potential_Cause = array_merge($Potential_Cause,$Potential_Cause_P);
		$FMEA = array_merge($FMEA,$FMEA_P);	
		$Category = array_merge($Category,$Category_P);	
		$Mitigation = array_merge($Mitigation,$Mitigation_P);
		$Note = array_merge($Note,$Note_P);
		}	
	
$query_GetTableofStandard = mysqli_query($con, "SELECT * FROM Risk_Mitigation WHERE (Potential_Cause LIKE \"%$PotentialCause_Keywords%\") AND (Mitigation_Info <>'') ORDER BY FIELD(FMEA_Type,'SRA','UFMEA','DFMEA','DFMEA(M)','DFMEA(E)','SEFMEA','SWFMEA','PFMEA')");
		$Document_Num_I = mysqli_num_rows($query_GetTableofStandard);
		for ($i=0; $i<$Document_Num_I; $i++) 
		{
		$Document_Row = mysqli_fetch_array($query_GetTableofStandard);
		$Failure_Mode_I[$i] = $Document_Row['Failure_Mode'];
		$Potential_Cause_I[$i] = $Document_Row['Potential_Cause'];
		$FMEA_I[$i] = $Document_Row['FMEA_Type'];	
		$Category_I[$i] = 'Info';	
		$Mitigation_I[$i] = $Document_Row['Mitigation_Info'];
		$Note_I[$i] = $Document_Row['Product_Category'];
		}
	
		if ($Document_Num_I>0)
		{
		$Failure_Mode = array_merge($Failure_Mode,$Failure_Mode_I);
		$Potential_Cause = array_merge($Potential_Cause,$Potential_Cause_I);
		$FMEA = array_merge($FMEA,$FMEA_I);	
		$Category = array_merge($Category,$Category_I);	
		$Mitigation = array_merge($Mitigation,$Mitigation_I);
		$Note = array_merge($Note,$Note_I);	
		}
	
		$Document_Num = $Document_Num_D+$Document_Num_P+$Document_Num_I;
}
	
else if (isset($Keys) && $Keys<>"") 
{
		$Failure_Mode = [];
		$Potential_Cause = [];
		$FMEA = [];	
		$Category = [];	
		$Mitigation = [];
		$Note =[];	
	
$query_GetTableofStandard = mysqli_query($con, "SELECT * FROM Risk_Mitigation WHERE Keyword=\"$Keys\" AND Mitigation_Design <>'' ORDER BY FIELD(FMEA_Type,'SRA','UFMEA','DFMEA','DFMEA(M)','DFMEA(E)','SEFMEA','SWFMEA','PFMEA')");
		$Document_Num_D = mysqli_num_rows($query_GetTableofStandard);
		for ($i=0; $i<$Document_Num_D; $i++) 
		{
		$Document_Row = mysqli_fetch_array($query_GetTableofStandard);
		$Failure_Mode_D[$i] = $Document_Row['Failure_Mode'];
		$Potential_Cause_D[$i] = $Document_Row['Potential_Cause'];
		$FMEA_D[$i] = $Document_Row['FMEA_Type'];	
		$Category_D[$i] = 'Design';	
		$Mitigation_D[$i] = $Document_Row['Mitigation_Design'];
		$Note_D[$i] = $Document_Row['Product_Category'];
		}
	
		if ($Document_Num_D>0)
		{
		$Failure_Mode = array_merge($Failure_Mode,$Failure_Mode_D);
		$Potential_Cause = array_merge($Potential_Cause,$Potential_Cause_D);
		$FMEA = array_merge($FMEA,$FMEA_D);	
		$Category = array_merge($Category,$Category_D);	
		$Mitigation = array_merge($Mitigation,$Mitigation_D);
		$Note = array_merge($Note,$Note_D);
		}	
		
$query_GetTableofStandard = mysqli_query($con, "SELECT * FROM Risk_Mitigation WHERE Keyword=\"$Keys\" AND Mitigation_Process <>'' ORDER BY FIELD(FMEA_Type,'SRA','UFMEA','DFMEA','DFMEA(M)','DFMEA(E)','SEFMEA','SWFMEA','PFMEA')");
		$Document_Num_P = mysqli_num_rows($query_GetTableofStandard);
		for ($i=0; $i<$Document_Num_P; $i++) 
		{
		$Document_Row = mysqli_fetch_array($query_GetTableofStandard);
		$Failure_Mode_P[$i] = $Document_Row['Failure_Mode'];
		$Potential_Cause_P[$i] = $Document_Row['Potential_Cause'];
		$FMEA_P[$i] = $Document_Row['FMEA_Type'];	
		$Category_P[$i] = 'Process';	
		$Mitigation_P[$i] = $Document_Row['Mitigation_Process'];
		$Note_P[$i] = $Document_Row['Product_Category'];
		}
	
		if ($Document_Num_P>0)
		{
		$Failure_Mode = array_merge($Failure_Mode,$Failure_Mode_P);
		$Potential_Cause = array_merge($Potential_Cause,$Potential_Cause_P);
		$FMEA = array_merge($FMEA,$FMEA_P);	
		$Category = array_merge($Category,$Category_P);	
		$Mitigation = array_merge($Mitigation,$Mitigation_P);
		$Note = array_merge($Note,$Note_P);
		}	

$query_GetTableofStandard = mysqli_query($con, "SELECT * FROM Risk_Mitigation WHERE Keyword=\"$Keys\" AND Mitigation_Info <>'' ORDER BY FIELD(FMEA_Type,'SRA','UFMEA','DFMEA','DFMEA(M)','DFMEA(E)','SEFMEA','SWFMEA','PFMEA')");
		$Document_Num_I = mysqli_num_rows($query_GetTableofStandard);
		for ($i=0; $i<$Document_Num_I; $i++) 
		{
		$Document_Row = mysqli_fetch_array($query_GetTableofStandard);
		$Failure_Mode_I[$i] = $Document_Row['Failure_Mode'];
		$Potential_Cause_I[$i] = $Document_Row['Potential_Cause'];
		$FMEA_I[$i] = $Document_Row['FMEA_Type'];	
		$Category_I[$i] = 'Info';	
		$Mitigation_I[$i] = $Document_Row['Mitigation_Info'];
		$Note_I[$i] = $Document_Row['Product_Category'];
		}
	
		if ($Document_Num_I>0)
		{
		$Failure_Mode = array_merge($Failure_Mode,$Failure_Mode_I);
		$Potential_Cause = array_merge($Potential_Cause,$Potential_Cause_I);
		$FMEA = array_merge($FMEA,$FMEA_I);	
		$Category = array_merge($Category,$Category_I);	
		$Mitigation = array_merge($Mitigation,$Mitigation_I);
		$Note = array_merge($Note,$Note_I);	
		}
	
		$Document_Num = $Document_Num_D+$Document_Num_P+$Document_Num_I;
}	
	
for ($i=0; $i<$Document_Num; $i++) 
{

	$Row[$i] = max(strlen($Failure_Mode[$i])/31+1, strlen($Potential_Cause[$i])/31+1, strlen($Mitigation[$i])/45+1);
?>	

	<tr style='background-color:#FFFFFF;'>								
		  <td class='Regulatory_SubmissionTable_Section'><?php echo $i+1;?></td>
	  		
		  <td class='Regulatory_SubmissionTable_Section'>
		  <textarea rows="<?php echo $Row[$i];?>" ID="Mode_<?php echo $Failure_Mode[$i];?>" class="Reg_CellInput" style="resize:none; width:93%; text-align:left;" readonly/><?php echo $Failure_Mode[$i];?></textarea>
		  </td>	 		   
		 		   
		  <td class='Regulatory_SubmissionTable_Section'>
		  <textarea rows="<?php echo $Row[$i];?>" ID="Cause_<?php echo $Potential_Cause[$i];?>" class="Reg_CellInput" style="resize:none; width:93%; text-align:left;" readonly/><?php echo $Potential_Cause[$i];?></textarea>
		  </td>
		  
		  <td class='Regulatory_SubmissionTable_Section'>
		  <input type="text" ID="FMEA_<?php echo $FMEA[$i];?>" value="<?php echo $FMEA[$i];?>" class="Reg_CellInput" style="width:90%; text-align:center;" readonly/></td>
		  
		  <td class='Regulatory_SubmissionTable_Section'>		  		  
		  <input type="text" ID="Category_<?php echo $Category[$i];?>" value="<?php echo $Category[$i];?>" class="Reg_CellInput" style="width:90%; text-align:center;" readonly/></td>		  
		  
		  <td class='Regulatory_SubmissionTable_Section'>
		 <textarea rows="<?php echo $Row[$i];?>" ID="Mitigation_<?php echo $Mitigation[$i];?>" class="Reg_CellInput" style="resize:none; width:93%; text-align:left;" readonly/><?php echo $Mitigation[$i];?></textarea></td> 
<?php		 
if ($User_ID != 'JERRYX')
{
$Note[$i]='';	
}

?>
		  <td class='Regulatory_SubmissionTable_Section'>
		  <textarea rows="<?php echo $Row[$i];?>" ID="Note_<?php echo $Note[$i];?>" class="Reg_CellInput" style="resize:none; width:92%; text-align:left;" readonly/><?php echo $Note[$i];?></textarea></td>	
	</tr>	
<?php	
}
?>
	
</table>

<table align='center' width='1024px' cellpadding='0' cellspacing='0' style='line-height:26px; border:solid #15B4FF 1px; border-top:none;'>
<tr style="line-height:10px; background-color:#EAF2FF;"><td colspan="2">&nbsp;</td></tr>


<tr style="background-color:#EAF2FF;">
<td align="left" class='UserList_Table2_FooterPage'>[ Total:<?php echo $Document_Num;?> Failure Modes]</td>
<td align="right"> 
<input type="button" value="Save" name="Form_Saved" id="Form_SaveButton" class="RdPDM_Button" onClick="Regulatory_Save()">
<input type="button" value="Export" name="Form_Export" id="Form_ExportButton" class="RdPDM_Button" onClick="Standard_Export()">
<input type="button" value="Exit" name="Form_Exit" id="Form_ExitButton" class="RdPDM_Button" style="margin-right:5px;" onClick="Standard_Exit()">
</td></tr>

<tr style="line-height:10px; background-color:#EAF2FF;"><td colspan="2">&nbsp;</td></tr>
</table> 

</div>
<?php
}

//--------------------------------------------------------------------------------------------------
//-----------------------------level 2 no "submit" clicked and no "action" selected-------------
//--------------------------------------------------------------------------------------------------
	
else
{
			
?>
<div class="Trace_Directory" style="text-align:left;">
<td>Home / Risk Management / RM Tools / Mitigation Solutions</td>
</div>

<!--<div ID="AddUser_WebPage"> -->
<form name="Feedback_Form" action="" method="post" onkeydown="if(event.keyCode==13 || event.keyCode==116) return false;" onsubmit="Check_RdU()"> 

<!--table 2nd level: for showing project info by selecting-------------------->

<table align="center" width='1024px'>
<tr style="background-color:transparent; line-height:20px;">
    	<td width="100%">&nbsp;</td>
</tr>
							
<tr style="line-height:24px;">
	<td style="text-align:left; font:14px; font-family: Tahoma, Geneva, sans-serif; color:cadetblue;"><img src="Images/feedback.png" width="24" height="24" align="absmiddle" /> <!--absmiddle makes to middle in vertical--->
     Search Mitigation Solutions through:</td> 
</tr>
</table>                 
           
 <!---table 4 contents---------------------->
<table ID='NewUser_Table2' align='center'>
<tr class="NewUser_Table2_DecorationLine">
    	<td width="12%">&nbsp;</td>
        <td width="21%">&nbsp;</td>
        <td width="12%">&nbsp;</td>
        <td width="21%">&nbsp;</td>
        <td width="12%">&nbsp;</td>
        <td width="21%">&nbsp;</td>
</tr>

<tr class="FMEA_FirstBlank"><td colspan="6">&nbsp;</td></tr>
	
						
<!--Option 2: create a table of standard ---> 												
<tr><td class="NewUser_Table2_InputTitle"  colspan="6" style="text-indent:0.7em">Enter or Select a Keyword below:</td></tr>
<tr>
    <td class="NewUser_Table2_InputTitle" style="text-indent:0.7em; text-align:right">Failure Mode</td>
    <td><input type="text" name="FailureMode_Keywords_B" ID="FailureMode_Keywords_B" style="width:91%; background-color:#FFF;" value="<?php echo $FailureMode_Keywords;?>" onChange="Change_SameTime_B('Failure_Mode')"/></td>  

    
    <td class="NewUser_Table2_InputTitle" style="text-indent:0.7em; text-align:right">or Potential Cause</td>
    <td><input type="text" name="PotentialCause_Keywords_B" ID="PotentialCause_Keywords_B" style="width:91%; background-color:#FFF;" value="<?php echo $PotentialCause_Keywords;?>" onChange="Change_SameTime_B('Potential_Cause')"/></td>
 
<?php 
$query_GetKeyName = mysqli_query($con, "SELECT DISTINCT (Keyword) FROM Risk_Mitigation ORDER BY Keyword ASC");														

$Key_Num = mysqli_num_rows($query_GetKeyName);
for ($i=0; $i<$Key_Num; $i++)
	{
	$Key_Row = mysqli_fetch_array($query_GetKeyName);
	$Key_Nos[$i] = $Key_Row['Keyword'];			//create a new array to store all project documents
	}
?>    																									
    <td class="NewUser_Table2_InputTitle" style="text-indent:0.7em; text-align:right">or Keyword</td>
    
    <td>
    <Select ID="Keys_Type" name="Keys_Type" class="Select_ButtonSpace"  OnChange="Select_Keys()"> 
<?php	
	
$Operation = 'Keys';						
$Operation_Title = 'Select a Keyword';
$Operation_Ary_Desc =  $Key_Nos;	
$Operation_Ary_Value = $Key_Nos;					
Select_ButtonOption($Operation, $Operation_Title, $Operation_Ary_Desc, $Operation_Ary_Value);	
?>   										
	</select>    		       		
    </td>
</tr> 						


<!-------Submit the form------------------>

<tr class="NewUser_Table2_Bottom" style="line-height:12px;" >	
        <td colspan="6">&nbsp;</td></tr>
<tr class="NewUser_Table2_Bottom" style='border:solid #EAF2FF 1px;'>
        <td colspan="6" align="center" >
 <input type="submit" name="SubmissionInitiation_Submit" value="Submit" class="RdPDM_Button_Small" style="height:28px;"/>
        </td></tr>
<tr class="NewUser_Table2_Bottom" style="line-height:3px;" >
        <td colspan="6">&nbsp;</td></tr>
</table>
</form>

<?php								// close for the else condition
}								// close for the second level else condition
mysqli_close($con);  
?>
</body>
</html>
