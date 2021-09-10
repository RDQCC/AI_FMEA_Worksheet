
<?php 
session_start(); 
if (!isset($_SESSION["User_ID"]) || $_SESSION["User_ID"]=="")
	{
		$ERR_MSG = "Authorization Failed !";
		echo "<script>window.location='index.php?ERR_MSG=$ERR_MSG'</script>";
	} 
$User_ID = strtoupper($_SESSION["User_ID"]); 

include "Showroom_DB.php";
include "Table_HarmtoHS.php";
include "Table_HarmtoSeverity.php";
include "Table_HarmDefinition.php";

include "Table_HStoHSDefinition.php";
include "Table_HStoHazard.php";
//include "Table_HStoNCICode.php";


?>

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
	
	
function Select_a_HarmType()
{
	var Selected_Harm = document.getElementById("Harm_ID").value;
	window.open("RiskFMEA_PadSandBox.php?Harm="+Selected_Harm, "_self"); 
}

function Select_a_SeverityType()
{	
	var Selected_Harm = document.getElementById("Harm_ID").value;
	var Selected_Severity = document.getElementById("Severity_ID").value;
	
	window.open("RiskFMEA_PadSandBox.php?Harm="+Selected_Harm+"&Severity="+Selected_Severity, "_self"); 
}
	
function Select_a_HSType()
{
	var Selected_Harm = document.getElementById("Harm_ID").value;
	var Selected_Severity = document.getElementById("Severity_ID").value;
	
	var Selected_HS = document.getElementById("HS_ID").value;	
	window.open("RiskFMEA_PadSandBox.php?HS="+Selected_HS+"&Harm="+Selected_Harm+"&Severity="+Selected_Severity, "_self"); 
}
	
function Select_a_Hazard()
{
	var Selected_Harm = document.getElementById("Harm_ID").value;
	var Selected_Severity = document.getElementById("Severity_ID").value;	
	var Selected_HS = document.getElementById("HS_ID").value;
	
 	var Selected_Hazard = document.getElementById("Hazard_ID").value;
 	window.open("RiskFMEA_PadSandBox.php?Hazard="+Selected_Hazard+"&HS="+Selected_HS+"&Harm="+Selected_Harm+"&Severity="+Selected_Severity, "_self"); 
}	
	
</script>

<?php
/*
$Hazard_ID = $_REQUEST['Hazard'];
$HS_ID = $_REQUEST['HS'];
$Harm_ID = $_REQUEST['Harm'];
$Severity_ID = $_REQUEST['Severity'];*/

	
//--------------below function taking variable $Display value from database first-- 
//----------------then has the same function as Select_ButtonOption 
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


function Select_ButtonOptionPrefill($Display, $Operation_ID, $Operation, $Operation_Title, $Operation_Ary)
{
	
	//--------------level 1: if has an option is submit --------------
if (isset($Operation_ID) && $Operation_ID<>'')
{
$NewAry = array($Operation_ID);	//create a new array with only one variable (variable within array shall have no quoation (waste 3 hours)	
	
	$Operation_Ary_Dif = array_diff($Operation_Ary, $NewAry);	//the difference is used to display rest of options
	$Operation_Ary_L = count($Operation_Ary_Dif);		
	//--------------------------																						
		echo "<option value='$Operation_ID'>$Operation_ID</option>";		//hold the selected option as table default (display)				
		for ($ci=0; $ci<=$Operation_Ary_L; $ci++)
			{
			if (isset($Operation_Ary_Dif[$ci])) 			//skip the blank row for "title: please select one"
				{		
				echo "<option value='$Operation_Ary_Dif[$ci]'>$Operation_Ary_Dif[$ci]</option>";//display rest options only (no blank) 			
				}
			}		
}	
else
{
	//------------- level 2: no option is submit, then if need to prefill or show title
	if (isset($Display) && $Display<>'') 	//if have prefilled data
	{	
	$NewAry = array($Display);	//create a new array with only one variable (variable within array shall have no quoation (waste 3 hours)	
	
	$Operation_Ary_Dif = array_diff($Operation_Ary, $NewAry);	//the difference is used to display rest of options
	$Operation_Ary_L = count($Operation_Ary_Dif);		
	//--------------------------																						
		echo "<option value='$Display'>$Display</option>";		//hold the selected option as table default (display)				
		for ($ci=0; $ci<=$Operation_Ary_L; $ci++)
			{
			if (isset($Operation_Ary_Dif[$ci])) 			//skip the blank row for "title: please select one"
				{		
				echo "<option value='$Operation_Ary_Dif[$ci]'>$Operation_Ary_Dif[$ci]</option>";//display rest options only (no blank) 			
				}
			}
	}
	//-----------------------------------------------------------
	else 													//else no prefilled data
	{	
	$Operation_ID = $_REQUEST[$Operation];	//get name of selected Operation type from above javascript for internal (equiv $Operation_Type)
	$NewAry = array($Operation_ID);	//variable within array shall have no quoation (waste 3 hours)
														//create a new array with only one variable
	
	$Operation_Ary_Dif = array_diff($Operation_Ary, $NewAry);	//the difference is used to display rest of options
	$Operation_Ary_L = count($Operation_Ary_Dif);		
	//--------------------------						
	if (isset($Operation_ID) && $Operation_ID<>'') 	//if select an option (rather than title, since it has no value/desc) ($Operation_ID is set(isset) and not(<>) blank
		{																	
		echo "<option value='$Operation_ID'>$Operation_ID</option>";		//hold the selected option as table default (display)				
		for ($ci=0; $ci<=$Operation_Ary_L; $ci++)
			{
			if (isset($Operation_Ary_Dif[$ci])) 			//skip the blank row for "title: please select one"
				{		
				echo "<option value='$Operation_Ary_Dif[$ci]' ID='$Operation_Ary_Dif[$ci]'>$Operation_Ary_Dif[$ci]</option>";//display rest options only (no blank) 			
				}
			}
		}
	else				//if have no section (display the title, no value)
		{
	?>
    	<option value=""><?php echo $Operation_Title?></option>    
    <?php
		$Operation_Ary_M = count($Operation_Ary);		//no title is counted, when pull down window, no title is an option
		for ($cj=0; $cj<$Operation_Ary_M; $cj++)
			{
	?>									
   <option value="<?php echo $Operation_Ary[$cj] ?>" ID="<?php echo $Operation_Ary[$cj] ?>"><?php echo $Operation_Ary[$cj] ?></option>;
    <?php
			}
		} //end of 'else'
	}						//close else for no prefilled data (close level 2)
}							// close level 1 else
	
}	//end of the function	
	

?>

<div class="Trace_Directory">
<td>Home / Risk Management / Hazard Sandbox / Padmaviti Sandbox</td>
</div>

<div ID="UserList_Page">
<table ID="UserList_Table1" align="center" width='1024px'>				
<tr style="line-height:28px;">
	<td ID="UserList_Table1_Title1" style="text-align: center; font-size: 18px;">Padmaviti SandBox</td>		
</tr>
<tr style="line-height:28px;"><td>&nbsp;</td></tr>	<!--blank row-->
</table>
</div>

<div> 
<!-------------------------------------------------------------------------------------------> 
<!----------------------table 3: hazard (most right)-----------------------------------------> 
<!-------------------------------------------------------------------------------------------> 

<table class='SandBox_SecondTableTitle' align='center' width='300px' cellpadding='0' cellspacing='0' style='float:right; line-height:26px; border:solid #15B4FF 1px; margin-right: 60px;'> 	
<tr style="line-height:25px; background-color:#EAF2FF;">   			<!-------decoration line with division purpose----->
<td style="text-align: center;">Harm table</td>
</tr>  							 															

<tr ID="UserList_Table2_Title">
<td style="color: red; font-size: 14px; border-top:solid #15B4FF 1px; text-indent: 8px;">Select from table</td></tr>
	
<tr>
<td style="text-align: center;">
<div>
<Select ID="Harm_ID" name="Harm_ID" class="Select_ButtonSpace" OnChange="Select_a_HarmType()">
<?php
		
$Operation = 'Harm';	//keep the same as :$request
$Operation_Title = 'Select a harm';
$Operation_Ary_Desc = array('Additional Surgical Procedure', 'Arrhythmia', 'Cardiac Perforation', 'Burn, Thermal', 'Cerebrovascular Accident', 'Discomfort', 'Embolism', 'Heart Failure', 'Hematoma', 'Hypersensitivity', 'Hypertension', 'Hypotension', 'Infection', 'Injury', 'Ischemic Heart Disease', 'No consequences or impact to patient', 'Pocket Erosion', 'Prolonged Surgery', 'Pneumothorax', 'Respiratory Failure', 'Scar Tissue', 'Seroma', 'Syncope');	//use for display
$Operation_Ary_Value = array('Additional Surgical Procedure', 'Arrhythmia', 'Cardiac Perforation', 'Burn, Thermal', 'Cerebrovascular Accident', 'Discomfort', 'Embolism', 'Heart Failure', 'Hematoma', 'Hypersensitivity', 'Hypertension', 'Hypotension', 'Infection', 'Injury', 'Ischemic Heart Disease', 'No consequences or impact to patient', 'Pocket Erosion', 'Prolonged Surgery', 'Pneumothorax', 'Respiratory Failure', 'Scar Tissue', 'Seroma', 'Syncope');					//use for variables	
Select_ButtonOption($Operation, $Operation_Title, $Operation_Ary_Desc, $Operation_Ary_Value);
			
?>   										
</select>	 
</div></td></tr>	 			

<tr ID="UserList_Table2_Title">
	<td style="color: red; font-size: 14px; text-indent: 8px;">Severity of the harm</td></tr> 

<tr>
<td style="text-align: center;"><div>
<?php					
$Harm_ID = $_REQUEST['Harm']; //$harm can not get from database due to it is not save to database this moment yet
$Operation_Ary = Table_HarmtoSeverity($Harm_ID); 	
?>

<Select ID="Severity_ID" name="Severity_ID" class="Select_ButtonSpace" OnChange="Select_a_SeverityType()">
<?php	
$Operation = 'Severity';		//keep the same as :$request
$Operation_Title = 'Select a severity level';
$Severity_ID = $_REQUEST['Severity'];
$Operation_ID = $Severity_ID;

Select_ButtonOptionPrefill($Display, $Operation_ID, $Operation, $Operation_Title, $Operation_Ary)	
?>   										
</select>	 			<!--function ending point---->						
</div>
</td>
</tr>


<tr ID="UserList_Table2_Title">
<td style="color: red; font-size: 14px; text-indent: 8px; padding-top:3px; line-height:24px;">Harm Definition</td></tr>

<?php
$Harm_Intervention = Table_HarmDefinition($Harm_ID, $Severity_ID);
?>

<tr>   
    <td style="text-align: center;"><textarea rows="9" ID="Intervention_ID" name="Intervention_ID" style="width:95%; background-color:#FFF; margin-top:1px; margin-bottom:5px"><?php echo $Harm_Intervention;?></textarea></td>
</tr>	

<tr ID="UserList_Table2_Title" bgcolor="#EAF2FF" style="line-height:20px;">
	<td style="border-top:solid #15B4FF 1px;text-indent: 5px;">*Work Instruction: Master Harms List</td></tr>
<tr ID="UserList_Table2_Title" bgcolor="#EAF2FF" style="line-height:20px;"><td>&nbsp;</td></tr>	
		

</table>
      
<!-----------------------------------------------------------------------------------------------> 
<!-----------------------table 2: hazardous situations (middle)----------------------------------> 
<!-----------------------------------------------------------------------------------------------> 

<table class='SandBox_SecondTableTitle' align='center' width='300px' cellpadding='0' cellspacing='0' style='float:right; line-height:26px; border:solid #15B4FF 1px; margin-right: 30px;'> 
	
<tr style="line-height:25px; background-color:#EAF2FF;">   			<!-------decoration line with division purpose----->
<td style="text-align: center;">Hazardous situation table</td>
</tr>
  							 															
<tr ID="UserList_Table2_Title">
<td style="color: red; font-size: 14px; border-top:solid #15B4FF 1px; text-indent: 8px;">Select from table</td></tr>
	
<tr>
<td style="text-align: center;">
<div>
<Select ID="HS_ID" name="HS_ID" class="Select_ButtonSpace" OnChange="Select_a_HSType()">
<?php
$Display ='';		
$Operation = 'HS';
$HS_ID = $_REQUEST['HS'];
$Harm_ID = $_REQUEST['Harm'];
$Operation_ID = $HS_ID;	
$Operation_Title = 'Select a hazardous Situation';
$Operation_Ary = Table_HarmtoHS($Harm_ID);

Select_ButtonOptionPrefill($Display, $Operation_ID, $Operation, $Operation_Title, $Operation_Ary)
?>   										
	</select></div></td></tr>	 			

	<tr><td>&nbsp;</td></tr>	<!--two blank rows-->
	<tr><td>&nbsp;</td></tr>
<?php
//if (isset($HS_ID) && $HS_ID<>'') 	//if have a selection from "potential hazard situations", update $HS_Definitoin; otherwise, maintain the value of variable as database
//{	
$HS_Definition = Table_HStoHSDefinition($HS_ID);	
//}
?>
<tr ID="UserList_Table2_Title">
<td style="color: red; font-size: 14px; text-indent: 8px; line-height:24px;"><div style="margin-top: -1px;">Hazardous Situation Definition</div></td></tr>

<tr>   
    <td style="text-align: center;"><textarea rows="9" name="HS_Definition" style="width:95%; background-color:#FFF; margin-bottom:5px"><?php echo $HS_Definition;?></textarea></td>
</tr>	

<tr ID="UserList_Table2_Title" bgcolor="#EAF2FF" style="line-height:20px;">
	<td style="border-top:solid #15B4FF 1px;text-indent: 5px;">*Work Instruction: Hazardous situations Definition List</td></tr>
<tr ID="UserList_Table2_Title" bgcolor="#EAF2FF" style="line-height:20px;"><td>&nbsp;</td></tr>
	
</table>

<!-----------------------------------------------------------------------------------------------> 
<!-----------table 1: hazard (most left)-----3 tables total are 1024px---------------------------> 
<!-----------------------------------------------------------------------------------------------> 

<table class='SandBox_SecondTableTitle' align='center' width='420px' cellpadding='0' cellspacing='0' style='float:right; line-height:26px; border:solid #15B4FF 1px; margin-right: 30px;'> 
<tr style="line-height:25px"; bgcolor="#EAF2FF";>   <!--light blue color as true-->		
	<td style="text-align: center;">Hazard table</td>
</tr> 

	
<tr ID="UserList_Table2_Title">
	<td style="color: red; font-size: 14px; border-top:solid #15B4FF 1px; text-indent: 8px;">Select from FDA Lists</td></tr>
	
	
<!-----------------Start to select from FDA lists: FDA Hazard (3)--------------->		
		
<tr>
<td style="text-align: center;">
<div>
<Select ID="Hazard_ID" name="Hazard_ID" class="Select_ButtonSpace" OnChange="Select_a_Hazard()">
<?php
		
$Operation = 'Hazard';
$HS_ID = $_REQUEST['HS'];	
$Operation_Title = 'Select a hazard';
//$Operation_Ary_Value = Table_HStoNCICode($HS_ID);
$Operation_Ary_Desc = Table_HStoHazard($HS_ID);
$Operation_Ary_Value = Table_HStoHazard($HS_ID);
	
Select_ButtonOption($Operation, $Operation_Title, $Operation_Ary_Desc, $Operation_Ary_Value);
?>   										
	</select></div></td></tr>	
		
			<!-------------Auto fill the Problem category (1)---->	
<?php 
$Hazard_ID = $_REQUEST['Hazard'];	//
	
$query_GetHazardName = mysqli_query($con, "SELECT * FROM Risk_FDACodes WHERE Hazard=\"$Hazard_ID\"");															

	$Hazard_Row = mysqli_fetch_array($query_GetHazardName);
	$Category_ID = $Hazard_Row['Problem_Category'];
	$SubCategory_ID = $Hazard_Row['Sub_Category'];
	$Hazard_Desc = $Hazard_Row['Hazard_Desc'];
	$FDA_Code = $Hazard_Row['FDA_Code'];
	$NCI_Code = $Hazard_Row['NCI_Code'];
		
?>
<tr ID="UserList_Table2_Title" style="margin-top:5px;">
<!--<div style="margin-top:5px;">	-->					

<td style="text-align: center;"><input type="text" name="Category_ID" value='<?php echo $Category_ID;?>' style="width:95%; margin-top:5px; background-color:#FFF;" /></td>
<!--</div>	--> 			
</tr>

			<!------auto fill the sub-category (2)----------->			
												
<tr ID="UserList_Table2_Title">
<!--<div style="margin-top:5px;">	-->					

<td style="text-align: center;"><input type="text" name="SubCategory_ID" value='<?php echo $SubCategory_ID;?>' style="width:95%; margin-top:5px; background-color:#FFF;" /></td>
<!--</div>	--> 			
</tr>
	
<!-------------------Auto fill Hazard description, FDA Codes, and NCI codes--->

<tr ID="UserList_Table2_Title">
	<td style="color: red; font-size: 14px; text-indent: 8px;">Hazard Description</td></tr>
<tr>   
    <td style="text-align: center;"><textarea rows="4" name="Hazard_Desc" style="width:95%; background-color:#FFF;"><?php echo $Hazard_Desc;?></textarea></td>
</tr>	

<tr ID="UserList_Table2_Title">
	<td style="color: red; font-size: 14px; text-indent: 8px;">Hazard Codes</td></tr>
									
<tr ID="UserList_Table2_Title">	
<td style="text-align: center;"><input type="text" name="FDA_Code" value='<?php echo $FDA_Code;?>' style="width:95%; margin-bottom:5px; background-color:#FFF;" /></td></tr>

<tr ID="UserList_Table2_Title">	
<td style="text-align: center;"><input type="text" ID="NCI_Code" name="NCI_Code" value="<?php echo $NCI_Code;?>" style="width:95%; background-color:#FFF; margin-bottom:8px" /></td></tr>	

<tr ID="UserList_Table2_Title" bgcolor="#EAF2FF" style="line-height:20px;">
	<td style="border-top:solid #15B4FF 1px;text-indent: 5px;">*FDA Device Problem Code Hierarchy</td></tr>
	
<tr ID="UserList_Table2_Title" bgcolor="#EAF2FF" style="line-height:20px;">
	<td style="text-indent: 5px;">*WWW.FDA.GOV</td>
</tr>

</table>

<!------------------------------------------below is about the table bottom row---------------------------------------------->
<table style='clear:both'>		<!--push above three tables side by side-->
<tr style="line-height:24px;" bgcolor="#EAF2FF">

</tr>
</table>
    
</div>

<?php
mysqli_close($con);
?>
