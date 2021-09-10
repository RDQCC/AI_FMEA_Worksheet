<?php
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
	
function Select_Hazard()
{
 var Selected_HazardKeys = document.getElementById("Hazard_Type").value;	
 window.open("RiskFMEA_Harm.php?Hazard="+Selected_HazardKeys, "_self");
}
	
function Select_HS()
{
 var Selected_HSKeys = document.getElementById("HS_Type").value;	
 window.open("RiskFMEA_Harm.php?HS="+Selected_HSKeys, "_self");
}
	
function Select_Harm()
{
 var Selected_HarmKeys = document.getElementById("Harm_Type").value;	
 window.open("RiskFMEA_Harm.php?Harm="+Selected_HarmKeys, "_self");
}

function Change_SameTime_B(Collumn_Id)										//function: when enter failure mode, erase content of failure cause and keyword (after submit)
{	
	
	if (Collumn_Id == "Hazard")													
		{
			var Selected_Hazard = document.getElementById("Hazard_Keywords_B").value;
			var Selected_HS = "";
			var Selected_Harm = "";
		}
	
	else if (Collumn_Id == "HS")	
		{
			var Selected_HS = document.getElementById("HS_Keywords_B").value;
			var Selected_Hazard = "";
			var Selected_Harm = "";
		}
	
	else if (Collumn_Id == "Harm")	
		{
			var Selected_Harm = document.getElementById("Harm_Keywords_B").value;
			var Selected_Hazard = "";
			var Selected_HS = "";
		}
	
	window.open("RiskFMEA_Harm.php?HazardKeys="+Selected_Hazard+"&HSKeys="+Selected_HS+"&HarmKeys="+Selected_Harm, "_self");	
}
	
function Change_SameTime_A(Collumn_Id)										//function: when enter failure mode, erase content of failure cause and keyword (after submit)
{	
	
	if (Collumn_Id == "Hazard")													
		{
			var Selected_Hazard = document.getElementById("Hazard_Keywords_A").value;
			var Selected_HS = "";
			var Selected_Harm = "";
		}
	
	else if (Collumn_Id == "HS")	
		{
			var Selected_HS = document.getElementById("HS_Keywords_A").value;
			var Selected_Hazard = "";
			var Selected_Harm = "";
		}
	
	else if (Collumn_Id == "Harm")	
		{
			var Selected_Harm = document.getElementById("Harm_Keywords_A").value;
			var Selected_Hazard = "";
			var Selected_HS = "";
		}
	
	window.open("RiskFMEA_Harm.php?HazardKeys="+Selected_Hazard+"&HSKeys="+Selected_HS+"&HarmKeys="+Selected_Harm, "_self");	
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
	
$Hazard = $_REQUEST['Hazard'];			//these values are from Javascript for pull down windows
$HS = $_REQUEST['HS'];	
$Harm = $_REQUEST['Harm'];
	
$Hazard_Keywords = $_REQUEST['HazardKeys'];			//these values are from Javascript for inut keywords
$HS_Keywords = $_REQUEST['HSKeys'];	
$Harm_Keywords = $_REQUEST['HarmKeys'];
	

function Select_ButtonOption($Operation, $Operation_Title, $Operation_Ary_Desc, $Operation_Ary_Value) 
	{
	$Operation_ID = $_REQUEST[$Operation];						//make sure $Operation is equal to 'Hazard', 'HS', or 'Harm'
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

$Hazard_Keywords = $_POST['Hazard_Keywords_B'];
$Hazard_Keywords = addslashes($Hazard_Keywords);
$HS_Keywords = $_POST['HS_Keywords_B'];
$HS_Keywords = addslashes($HS_Keywords);
$Harm_Keywords = $_POST['Harm_Keywords_B'];
$Harm_Keywords = addslashes($Harm_Keywords);
	
$Hazard = $_POST['Hazard_Type'];
$Hazard = addslashes($Hazard);
$HS = $_POST['HS_Type'];
$HS = addslashes($HS);
$Harm = $_POST['Harm_Type'];
$Harm = addslashes($Harm);

?>	

<!-----------------------------------------------------------------------------------------------
//save these table of contents to database Regulatory_TOWProject and display on screen meantime
//--------------------------------------------------------------------------------------------->
	
<div class="Trace_Directory" style="text-align:left;">
<td>Home / Risk Management / RM Tools / Harm Descriptions</td>
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
    Search Harm Description through:</td> 
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
						
												
<tr><td class="NewUser_Table2_InputTitle"  colspan="2" style="text-indent:0.7em">Option 1: start from Hazard</td>
    <td class="NewUser_Table2_InputTitle" style="text-indent:0.7em; text-align:right">Hazard Keyword</td>
    <td><input type="text" name="Hazard_Keywords_A" ID="Hazard_Keywords_A" style="width:91%; <?php if($Hazard_Keywords<>'') echo'background-color:yellow'; ?>" value="<?php echo $Hazard_Keywords;?>" onChange="Change_SameTime_A('Hazard')"/></td>       
            
<?php 
$query_GetKeyName = mysqli_query($con, "SELECT DISTINCT (Hazard) FROM Risk_Mitigation ORDER BY Hazard ASC");														

$Key_Num = mysqli_num_rows($query_GetKeyName);
for ($i=0; $i<$Key_Num; $i++)
	{
	$Hazard_Row = mysqli_fetch_array($query_GetKeyName);
	$Hazard_Nos[$i] = $Hazard_Row['Hazard'];			//create a new array to store all project documents
	}
?>    																									
    <td class="NewUser_Table2_InputTitle" style="text-indent:0.7em; text-align:right">or Hazard</td>
    
    <td>
    <Select ID="Hazards_Type" name="Hazards_Type" class="Select_ButtonSpace" style="<?php if($Hazard <>'') echo'background-color:yellow';?>" OnChange="Select_Hazard()">    
<?php	
	
$Operation = 'Hazard';						
$Operation_Title = 'Select a Hazard';
$Operation_Ary_Desc =  $Hazard_Nos;	
$Operation_Ary_Value = $Hazard_Nos;					
Select_ButtonOption($Operation, $Operation_Title, $Operation_Ary_Desc, $Operation_Ary_Value);	
?>   										
	</select>    		       		
    </td>
</tr>
            	           	           	             	        	        	            	             	        	        	            	           	           	
<tr><td class="NewUser_Table2_InputTitle"  colspan="2" style="text-indent:0.7em">Option 2: start from Hazardous Situation</td>
    <td class="NewUser_Table2_InputTitle" style="text-indent:0.7em; text-align:right">HS Keyword</td>
    <td><input type="text" name="HS_Keywords_A" ID="HS_Keywords_A" style="width:91%; <?php if($HS_Keywords<>'') echo'background-color:yellow'; ?>" value="<?php echo $HS_Keywords;?>" onChange="Change_SameTime_A('HS')"/></td>                   
 
<?php 
$query_GetKeyName = mysqli_query($con, "SELECT DISTINCT (Hazardous_Situation) FROM Risk_Mitigation ORDER BY Hazardous_Situation ASC");														

$HS_Num = mysqli_num_rows($query_GetKeyName);
for ($i=0; $i<$HS_Num; $i++)
	{
	$HS_Row = mysqli_fetch_array($query_GetKeyName);
	$HS_Nos[$i] = $HS_Row['Hazardous_Situation'];			//create a new array to store all project documents
	}
?>    																									
    <td class="NewUser_Table2_InputTitle" style="text-indent:0.7em; text-align:right">or Keyword</td>
    
    <td>
    <Select ID="HS_Type" name="HS_Type" class="Select_ButtonSpace" style="<?php if($HS <>'') echo'background-color:yellow';?>" OnChange="Select_HS()">    
<?php	
	
$Operation = 'HS';						
$Operation_Title = 'Select a Hazardous Situation';
$Operation_Ary_Desc =  $HS_Nos;	
$Operation_Ary_Value = $HS_Nos;					
Select_ButtonOption($Operation, $Operation_Title, $Operation_Ary_Desc, $Operation_Ary_Value);	
?>   										
	</select>    		       		
    </td>
</tr>

<tr><td class="NewUser_Table2_InputTitle"  colspan="2" style="text-indent:0.7em">Option 3: start from Harm</td>
    <td class="NewUser_Table2_InputTitle" style="text-indent:0.7em; text-align:right">Harm Keyword</td>
    <td><input type="text" name="Harm_Keywords_A" ID="Harm_Keywords_A" style="width:91%; <?php if($Harm_Keywords<>'') echo'background-color:yellow'; ?>" value="<?php echo $Harm_Keywords;?>" onChange="Change_SameTime_A('Harm')"/></td>                   
 
<?php 
$query_GetKeyName = mysqli_query($con, "SELECT DISTINCT (Harm) FROM Risk_Mitigation ORDER BY Harm ASC");														

$Harm_Num = mysqli_num_rows($query_GetKeyName);
for ($i=0; $i<$Harm_Num; $i++)
	{
	$Harm_Row = mysqli_fetch_array($query_GetKeyName);
	$Harm_Nos[$i] = $Harm_Row['Harm'];			//create a new array to store all project documents
	}
?>    																									
    <td class="NewUser_Table2_InputTitle" style="text-indent:0.7em; text-align:right">or Harm</td>
    
    <td>
    <Select ID="Harm_Type" name="Harm_Type" class="Select_ButtonSpace" style="<?php if($Harm <>'') echo'background-color:yellow';?>" OnChange="Select_Harm()">    
<?php	
	
$Operation = 'Harm';						
$Operation_Title = 'Select a Harm';
$Operation_Ary_Desc =  $Harm_Nos;	
$Operation_Ary_Value = $Harm_Nos;					
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
        <td width="20%">&nbsp;</td>
        <td width="25%">&nbsp;</td>
        <td width="20%">&nbsp;</td>
        <td width="15%">&nbsp;</td>
        <td width="5%">&nbsp;</td>
        <td width="10%">&nbsp;</td>
	</tr>															
    <tr ID="UserList_Table2_Title" style="background-color:#EAF2FF;"> <!--background: url(Images/tr.gif) repeat-x;-->
		<td class="Regulatory_SubmissionTable_Title" style='color:#09F'>ID</td>
		<td class="Regulatory_SubmissionTable_Title" style="text-align: center;">Hazard</td>
		<td class="Regulatory_SubmissionTable_Title" style="text-align: center;">Hazardous Situation</td> 
		<td class="Regulatory_SubmissionTable_Title" style="text-align: center;">Harm</td>
		<td class="Regulatory_SubmissionTable_Title" style="text-align: center;">Harm Description</td>
		<td class="Regulatory_SubmissionTable_Title" style="text-align: center;">Severity</td>
		<td class="Regulatory_SubmissionTable_Title" style='border-right:none'>Note</td>		
	</tr>
		
		
<?php
		$Hazard_Array = [];
		$HS_Array = [];
		$Harm_Array = [];	
		$HarmDesc_Array = [];	
		$Severity_Array = [];
		$Note_Array =[];
	
		$Doc_Num = 0;
	
if (isset($Hazard_Keywords) && $Hazard_Keywords<>"") 
{
			
$query_GetHazard = mysqli_query($con, "SELECT DISTINCT (Hazard) FROM Risk_Mitigation WHERE Hazard LIKE \"%$Hazard_Keywords%\" ORDER BY Hazard ASC");
$Hazard_Num = mysqli_num_rows($query_GetHazard);
for ($i=0; $i<$Hazard_Num; $i++) 
  {
	$Hazard_Row = mysqli_fetch_array($query_GetHazard);
	$Hazard_Temp = $Hazard_Row['Hazard'];
	
	$query_GetHS = mysqli_query($con, "SELECT DISTINCT (Hazardous_Situation) FROM Risk_Mitigation WHERE Hazard=\"$Hazard_Temp\" ORDER BY Hazardous_Situation ASC");
	$HS_Num = mysqli_num_rows($query_GetHS);
	for ($j=0; $j<$HS_Num; $j++) 
	{
		$HS_Row = mysqli_fetch_array($query_GetHS);
		$HS_Temp = $HS_Row['Hazardous_Situation'];
	
		$query_GetHarm = mysqli_query($con, "SELECT DISTINCT (Harm) FROM Risk_Mitigation WHERE Hazard=\"$Hazard_Temp\" AND  Hazardous_Situation=\"$HS_Temp\" ORDER BY Harm ASC");
		$Harm_Num = mysqli_num_rows($query_GetHarm);		
		for ($k=0; $k<$Harm_Num; $k++) 
		{
			$Harm_Row = mysqli_fetch_array($query_GetHarm);
			$Harm_Temp = $Harm_Row['Harm'];	
		
			$query_GetSeverity = mysqli_query($con, "SELECT DISTINCT (Severity_Level) FROM Risk_Mitigation WHERE Hazard=\"$Hazard_Temp\" AND Hazardous_Situation=\"$HS_Temp\" AND Harm=\"$Harm_Temp\" ORDER BY Severity_Level DESC");
			$Severity_Num = mysqli_num_rows($query_GetSeverity);		
			for ($s=0; $s<$Severity_Num; $s++) 
			{
				$Severity_Row = mysqli_fetch_array($query_GetSeverity);
				$Severity_Temp = $Severity_Row['Severity_Level'];
				
				$query_GetDocument = mysqli_query($con, "SELECT * FROM Risk_Mitigation WHERE Hazard=\"$Hazard_Temp\" AND Hazardous_Situation=\"$HS_Temp\" AND Harm=\"$Harm_Temp\" AND Severity_Level=\"$Severity_Temp\"");
				
				$Document_Row = mysqli_fetch_array($query_GetDocument);
				$Hazard_Array[$Doc_Num] = $Document_Row['Hazard'];
				$HS_Array[$Doc_Num] = $Document_Row['Hazardous_Situation'];
				$Harm_Array[$Doc_Num] = $Document_Row['Harm'];
				$Severity_Array[$Doc_Num] = $Document_Row['Severity_Level'];				
				$Note_Array[$Doc_Num] = $Document_Row['Product_Category'];
				
				$Doc_Num=$Doc_Num+1;
			}
		}
	}
  }
}
	
else if (isset($Hazard) && $Hazard<>"") 
{
			
$query_GetHazard = mysqli_query($con, "SELECT DISTINCT (Hazard) FROM Risk_Mitigation WHERE Hazard=\"$Hazard\" ORDER BY Hazard ASC");
$Hazard_Num = mysqli_num_rows($query_GetHazard);
for ($i=0; $i<$Hazard_Num; $i++) 
  {
	$Hazard_Row = mysqli_fetch_array($query_GetHazard);
	$Hazard_Temp = $Hazard_Row['Hazard'];
	
	$query_GetHS = mysqli_query($con, "SELECT DISTINCT (Hazardous_Situation) FROM Risk_Mitigation WHERE Hazard=\"$Hazard_Temp\" ORDER BY Hazardous_Situation ASC");
	$HS_Num = mysqli_num_rows($query_GetHS);
	for ($j=0; $j<$HS_Num; $j++) 
	{
		$HS_Row = mysqli_fetch_array($query_GetHS);
		$HS_Temp = $HS_Row['Hazardous_Situation'];
	
		$query_GetHarm = mysqli_query($con, "SELECT DISTINCT (Harm) FROM Risk_Mitigation WHERE Hazard=\"$Hazard_Temp\" AND  Hazardous_Situation=\"$HS_Temp\" ORDER BY Harm ASC");
		$Harm_Num = mysqli_num_rows($query_GetHarm);		
		for ($k=0; $k<$Harm_Num; $k++) 
		{
			$Harm_Row = mysqli_fetch_array($query_GetHarm);
			$Harm_Temp = $Harm_Row['Harm'];	
		
			$query_GetSeverity = mysqli_query($con, "SELECT DISTINCT (Severity_Level) FROM Risk_Mitigation WHERE Hazard=\"$Hazard_Temp\" AND Hazardous_Situation=\"$HS_Temp\" AND Harm=\"$Harm_Temp\" ORDER BY Severity_Level DESC");
			$Severity_Num = mysqli_num_rows($query_GetSeverity);		
			for ($s=0; $s<$Severity_Num; $s++) 
			{
				$Severity_Row = mysqli_fetch_array($query_GetSeverity);
				$Severity_Temp = $Severity_Row['Severity_Level'];
				
				$query_GetDocument = mysqli_query($con, "SELECT * FROM Risk_Mitigation WHERE Hazard=\"$Hazard_Temp\" AND Hazardous_Situation=\"$HS_Temp\" AND Harm=\"$Harm_Temp\" AND Severity_Level=\"$Severity_Temp\"");
				
				$Document_Row = mysqli_fetch_array($query_GetDocument);
				$Hazard_Array[$Doc_Num] = $Document_Row['Hazard'];
				$HS_Array[$Doc_Num] = $Document_Row['Hazardous_Situation'];
				$Harm_Array[$Doc_Num] = $Document_Row['Harm'];
				$Severity_Array[$Doc_Num] = $Document_Row['Severity_Level'];				
				$Note_Array[$Doc_Num] = $Document_Row['Product_Category'];
				
				$Doc_Num=$Doc_Num+1;
			}
		}
	}
  }
}

else if (isset($HS_Keywords) && $HS_Keywords<>"") 
{
	$query_GetHS = mysqli_query($con, "SELECT DISTINCT (Hazardous_Situation) FROM Risk_Mitigation WHERE Hazardous_Situation LIKE \"%$HS_Keywords%\" ORDER BY Hazardous_Situation ASC");
	$HS_Num = mysqli_num_rows($query_GetHS);
	for ($j=0; $j<$HS_Num; $j++) 
	{
		$HS_Row = mysqli_fetch_array($query_GetHS);
		$HS_Temp = $HS_Row['Hazardous_Situation'];
	
		$query_GetHarm = mysqli_query($con, "SELECT DISTINCT (Harm) FROM Risk_Mitigation WHERE Hazardous_Situation=\"$HS_Temp\" ORDER BY Harm ASC");
		$Harm_Num = mysqli_num_rows($query_GetHarm);		
		for ($k=0; $k<$Harm_Num; $k++) 
		{
			$Harm_Row = mysqli_fetch_array($query_GetHarm);
			$Harm_Temp = $Harm_Row['Harm'];	
		
			$query_GetSeverity = mysqli_query($con, "SELECT DISTINCT (Severity_Level) FROM Risk_Mitigation WHERE Hazardous_Situation=\"$HS_Temp\" AND Harm=\"$Harm_Temp\" ORDER BY Severity_Level DESC");
			$Severity_Num = mysqli_num_rows($query_GetSeverity);		
			for ($s=0; $s<$Severity_Num; $s++) 
			{
				$Severity_Row = mysqli_fetch_array($query_GetSeverity);
				$Severity_Temp = $Severity_Row['Severity_Level'];
				
				$query_GetDocument = mysqli_query($con, "SELECT * FROM Risk_Mitigation WHERE Hazardous_Situation=\"$HS_Temp\" AND Harm=\"$Harm_Temp\" AND Severity_Level=\"$Severity_Temp\"");
				
				$Document_Row = mysqli_fetch_array($query_GetDocument);
				$HS_Array[$Doc_Num] = $Document_Row['Hazardous_Situation'];
				$Harm_Array[$Doc_Num] = $Document_Row['Harm'];
				$Severity_Array[$Doc_Num] = $Document_Row['Severity_Level'];				
				$Note_Array[$Doc_Num] = $Document_Row['Product_Category'];
				
				$Doc_Num=$Doc_Num+1;
			}
		}
	}
}
	
else if (isset($HS) && $HS<>"") 
{
	$query_GetHS = mysqli_query($con, "SELECT DISTINCT (Hazardous_Situation) FROM Risk_Mitigation WHERE Hazardous_Situation=\"$HS\" ORDER BY Hazardous_Situation ASC");
	$HS_Num = mysqli_num_rows($query_GetHS);
	for ($j=0; $j<$HS_Num; $j++) 
	{
		$HS_Row = mysqli_fetch_array($query_GetHS);
		$HS_Temp = $HS_Row['Hazardous_Situation'];
	
		$query_GetHarm = mysqli_query($con, "SELECT DISTINCT (Harm) FROM Risk_Mitigation WHERE Hazardous_Situation=\"$HS_Temp\" ORDER BY Harm ASC");
		$Harm_Num = mysqli_num_rows($query_GetHarm);		
		for ($k=0; $k<$Harm_Num; $k++) 
		{
			$Harm_Row = mysqli_fetch_array($query_GetHarm);
			$Harm_Temp = $Harm_Row['Harm'];	
		
			$query_GetSeverity = mysqli_query($con, "SELECT DISTINCT (Severity_Level) FROM Risk_Mitigation WHERE Hazardous_Situation=\"$HS_Temp\" AND Harm=\"$Harm_Temp\" ORDER BY Severity_Level DESC");
			$Severity_Num = mysqli_num_rows($query_GetSeverity);		
			for ($s=0; $s<$Severity_Num; $s++) 
			{
				$Severity_Row = mysqli_fetch_array($query_GetSeverity);
				$Severity_Temp = $Severity_Row['Severity_Level'];
				
				$query_GetDocument = mysqli_query($con, "SELECT * FROM Risk_Mitigation WHERE Hazardous_Situation=\"$HS_Temp\" AND Harm=\"$Harm_Temp\" AND Severity_Level=\"$Severity_Temp\"");
				
				$Document_Row = mysqli_fetch_array($query_GetDocument);
				$HS_Array[$Doc_Num] = $Document_Row['Hazardous_Situation'];
				$Harm_Array[$Doc_Num] = $Document_Row['Harm'];
				$Severity_Array[$Doc_Num] = $Document_Row['Severity_Level'];				
				$Note_Array[$Doc_Num] = $Document_Row['Product_Category'];
				
				$Doc_Num=$Doc_Num+1;
			}
		}
	}
}
	
else if (isset($Harm_Keywords) && $Harm_Keywords<>"") 
{
	
		$query_GetHarm = mysqli_query($con, "SELECT DISTINCT (Harm) FROM Risk_Mitigation WHERE Harm LIKE \"%$Harm_Keywords%\" ORDER BY Harm ASC");
		$Harm_Num = mysqli_num_rows($query_GetHarm);		
		for ($k=0; $k<$Harm_Num; $k++) 
		{
			$Harm_Row = mysqli_fetch_array($query_GetHarm);
			$Harm_Temp = $Harm_Row['Harm'];	
		
			$query_GetSeverity = mysqli_query($con, "SELECT DISTINCT (Severity_Level) FROM Risk_Mitigation WHERE Harm=\"$Harm_Temp\" ORDER BY Severity_Level DESC");
			$Severity_Num = mysqli_num_rows($query_GetSeverity);		
			for ($s=0; $s<$Severity_Num; $s++) 
			{
				$Severity_Row = mysqli_fetch_array($query_GetSeverity);
				$Severity_Temp = $Severity_Row['Severity_Level'];
				
				$query_GetDocument = mysqli_query($con, "SELECT * FROM Risk_Mitigation WHERE Harm=\"$Harm_Temp\" AND Severity_Level=\"$Severity_Temp\"");
				
				$Document_Row = mysqli_fetch_array($query_GetDocument);
				$Harm_Array[$Doc_Num] = $Document_Row['Harm'];
				$Severity_Array[$Doc_Num] = $Document_Row['Severity_Level'];				
				$Note_Array[$Doc_Num] = $Document_Row['Product_Category'];
				
				$Doc_Num=$Doc_Num+1;
			}
		}
}
	
else if (isset($Harm) && $Harm<>"") 
{
	
		$query_GetHarm = mysqli_query($con, "SELECT DISTINCT (Harm) FROM Risk_Mitigation WHERE Harm=\"$Harm\" ORDER BY Harm ASC");
		$Harm_Num = mysqli_num_rows($query_GetHarm);		
		for ($k=0; $k<$Harm_Num; $k++) 
		{
			$Harm_Row = mysqli_fetch_array($query_GetHarm);
			$Harm_Temp = $Harm_Row['Harm'];	
		
			$query_GetSeverity = mysqli_query($con, "SELECT DISTINCT (Severity_Level) FROM Risk_Mitigation WHERE Harm=\"$Harm_Temp\" ORDER BY Severity_Level DESC");
			$Severity_Num = mysqli_num_rows($query_GetSeverity);		
			for ($s=0; $s<$Severity_Num; $s++) 
			{
				$Severity_Row = mysqli_fetch_array($query_GetSeverity);
				$Severity_Temp = $Severity_Row['Severity_Level'];
				
				$query_GetDocument = mysqli_query($con, "SELECT * FROM Risk_Mitigation WHERE Harm=\"$Harm_Temp\" AND Severity_Level=\"$Severity_Temp\"");
				
				$Document_Row = mysqli_fetch_array($query_GetDocument);
				$Harm_Array[$Doc_Num] = $Document_Row['Harm'];
				$Severity_Array[$Doc_Num] = $Document_Row['Severity_Level'];				
				$Note_Array[$Doc_Num] = $Document_Row['Product_Category'];
				
				$Doc_Num=$Doc_Num+1;
			}
		}
}
	
// echo $Doc_Num;
	
for ($i=0; $i<$Doc_Num; $i++) 
{

	$Row[$i] = max(strlen($Hazard_Array[$i])/28+1, strlen($HS_Array[$i])/35+1, strlen($Harm_Array[$i])/28+1);
?>	

	<tr style='background-color:#FFFFFF;'>								
		  <td class='Regulatory_SubmissionTable_Section'><?php echo $i+1;?></td>
	  		
		  <td class='Regulatory_SubmissionTable_Section'>
		  <textarea rows="<?php echo $Row[$i];?>" ID="Hazard_<?php echo $Hazard_Array[$i];?>" class="Reg_CellInput" style="resize:none; width:93%; text-align:left;" readonly/><?php echo $Hazard_Array[$i];?></textarea>
		  </td>	 		   
		 		   
		  <td class='Regulatory_SubmissionTable_Section'>
		  <textarea rows="<?php echo $Row[$i];?>" ID="HS_<?php echo $HS_Array[$i];?>" class="Reg_CellInput" style="resize:none; width:93%; text-align:left;" readonly/><?php echo $HS_Array[$i];?></textarea>
		  </td>
		  
		  <td class='Regulatory_SubmissionTable_Section'>
		  <textarea rows="<?php echo $Row[$i];?>" ID="Harm_<?php echo $Harm_Array[$i];?>" class="Reg_CellInput" style="resize:none; width:93%; text-align:left;" readonly/><?php echo $Harm_Array[$i];?></textarea>
		  </td>		  
		  
 		  <td class='Regulatory_SubmissionTable_Section'>
		 <textarea rows="<?php echo $Row[$i];?>" ID="HarmDesc_<?php echo $HarmDesc_Array[$i];?>" class="Reg_CellInput" style="resize:none; width:93%; text-align:left;" readonly/><?php echo $HarmDesc_Array[$i];?></textarea></td>
		  
		  <td class='Regulatory_SubmissionTable_Section'>		  		  
		  <input type="text" ID="Severity_<?php echo $Severity_Array[$i];?>" value="<?php echo $Severity_Array[$i];?>" class="Reg_CellInput" style="width:90%; text-align:center;" readonly/></td>		  
		  
<?php		 
if ($User_ID != 'JERRYX')
{
$Note[$i]='';	
}

?>
		  <td class='Regulatory_SubmissionTable_Section'>
		  <textarea rows="<?php echo $Row[$i];?>" ID="Note_<?php echo $Note_Array[$i];?>" class="Reg_CellInput" style="resize:none; width:92%; text-align:left;" readonly/><?php echo $Note_Array[$i];?></textarea></td>	
	</tr>	
<?php	
}
?>
	
</table>

<table align='center' width='1024px' cellpadding='0' cellspacing='0' style='line-height:26px; border:solid #15B4FF 1px; border-top:none;'>
<tr style="line-height:10px; background-color:#EAF2FF;"><td colspan="2">&nbsp;</td></tr>


<tr style="background-color:#EAF2FF;">
<td align="left" class='UserList_Table2_FooterPage'>[ Total:<?php echo $Document_Num;?> Standards]</td>
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
<td>Home / Risk Management / RM Tools / Harm Description</td>
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
     Search Harm Description through:</td> 
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

<tr><td class="NewUser_Table2_InputTitle"  colspan="2" style="text-indent:0.7em">Option 1: start from Hazard</td>
    <td class="NewUser_Table2_InputTitle" style="text-indent:0.7em; text-align:right">Hazard Keyword</td>
    <td><input type="text" name="Hazard_Keywords_B" ID="Hazard_Keywords_B" style="width:91%; background-color:#FFF;?>" value="<?php echo $Hazard_Keywords;?>" onChange="Change_SameTime_B('Hazard')"/></td> 
            
<?php 
$query_GetKeyName = mysqli_query($con, "SELECT DISTINCT (Hazard) FROM Risk_Mitigation ORDER BY Hazard ASC");														

$Hazard_Num = mysqli_num_rows($query_GetKeyName);
for ($i=0; $i<$Hazard_Num; $i++)
	{
	$Hazard_Row = mysqli_fetch_array($query_GetKeyName);
	$Hazard_Nos[$i] = $Hazard_Row['Hazard'];			//create a new array to store all project documents
	}
?>    																									
    <td class="NewUser_Table2_InputTitle" style="text-indent:0.7em; text-align:right">or Hazard</td>
    
    <td>
    <Select ID="Hazard_Type" name="Hazard_Type" class="Select_ButtonSpace" style="<?php if($Hazard <>'') echo'background-color:yellow';?>" OnChange="Select_Hazard()">    
<?php	
	
$Operation = 'Hazard';						
$Operation_Title = 'Select a Hazard';
$Operation_Ary_Desc =  $Hazard_Nos;	
$Operation_Ary_Value = $Hazard_Nos;					
Select_ButtonOption($Operation, $Operation_Title, $Operation_Ary_Desc, $Operation_Ary_Value);	
?>   										
	</select>    		       		
    </td>
</tr>

<tr><td class="NewUser_Table2_InputTitle"  colspan="2" style="text-indent:0.7em">Option 2: start from Hazardous Situation</td>
    <td class="NewUser_Table2_InputTitle" style="text-indent:0.7em; text-align:right">HS Keyword</td>
    <td><input type="text" name="HS_Keywords_B" ID="HS_Keywords_B" style="width:91%; background-color:#FFF;" value="<?php echo $HS_Keywords;?>" onChange="Change_SameTime_B('HS')"/></td>                   
 
<?php 
$query_GetKeyName = mysqli_query($con, "SELECT DISTINCT (Hazardous_Situation) FROM Risk_Mitigation ORDER BY Hazardous_Situation ASC");														

$HS_Num = mysqli_num_rows($query_GetKeyName);
for ($i=0; $i<$HS_Num; $i++)
	{
	$HS_Row = mysqli_fetch_array($query_GetKeyName);
	$HS_Nos[$i] = $HS_Row['Hazardous_Situation'];			//create a new array to store all project documents
	}
?>    																									
    <td class="NewUser_Table2_InputTitle" style="text-indent:0.7em; text-align:right">or Keyword</td>
    
    <td>
    <Select ID="HS_Type" name="HS_Type" class="Select_ButtonSpace" style="<?php if($HS <>'') echo'background-color:yellow';?>" OnChange="Select_HS()">    
<?php	
	
$Operation = 'HS';						
$Operation_Title = 'Select a Hazardous Situation';
$Operation_Ary_Desc =  $HS_Nos;	
$Operation_Ary_Value = $HS_Nos;					
Select_ButtonOption($Operation, $Operation_Title, $Operation_Ary_Desc, $Operation_Ary_Value);	
?>   										
	</select>    		       		
    </td>
</tr>

<tr><td class="NewUser_Table2_InputTitle"  colspan="2" style="text-indent:0.7em">Option 3: start from Harm</td>
    <td class="NewUser_Table2_InputTitle" style="text-indent:0.7em; text-align:right">Harm Keyword</td>
    <td><input type="text" name="Harm_Keywords_B" ID="Harm_Keywords_B" style="width:91%; background-color:#FFF;?>" value="<?php echo $Harm_Keywords;?>" onChange="Change_SameTime_B('Harm')"/></td>                   
 
<?php 
$query_GetKeyName = mysqli_query($con, "SELECT DISTINCT (Harm) FROM Risk_Mitigation ORDER BY Harm ASC");														

$Harm_Num = mysqli_num_rows($query_GetKeyName);
for ($i=0; $i<$Harm_Num; $i++)
	{
	$Harm_Row = mysqli_fetch_array($query_GetKeyName);
	$Harm_Nos[$i] = $Harm_Row['Harm'];			//create a new array to store all project documents
	}
?>    																									
    <td class="NewUser_Table2_InputTitle" style="text-indent:0.7em; text-align:right">or Harm</td>
    
    <td>
    <Select ID="Harm_Type" name="Harm_Type" class="Select_ButtonSpace" style="<?php if($Harm <>'') echo'background-color:yellow';?>" OnChange="Select_Harm()">    
<?php	
	
$Operation = 'Harm';						
$Operation_Title = 'Select a Harm';
$Operation_Ary_Desc =  $Harm_Nos;	
$Operation_Ary_Value = $Harm_Nos;					
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
