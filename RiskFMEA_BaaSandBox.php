
<?php 
session_start(); 
if (!isset($_SESSION["User_ID"]) || $_SESSION["User_ID"]=="")
	{
		$ERR_MSG = "Authorization Failed !";
		echo "<script>window.location='index.php?ERR_MSG=$ERR_MSG'</script>";
	} 
$User_ID = strtoupper($_SESSION["User_ID"]); 

include "Showroom_DB.php";
include "Table_HazardtoHS.php";
include "Table_HStoHarm.php";
include "Table_HStoHSDefinition.php";
include "Table_HarmDefinition.php";
include "Table_HarmtoSeverity.php";
include "Table_SeveritytoNumber.php";

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
	

function Select_a_Category()
{
	var Selected_Category = document.getElementById("Category_ID").value;
 	window.open("RiskFMEA_BaaSandBox.php?Category="+Selected_Category, "_self"); 	
}

function Select_a_SubCategory()
{
	var Selected_Category = document.getElementById("Category_ID").value;
 	var Selected_SubCategory = document.getElementById("SubCategory_ID").value;
	
 	window.open("RiskFMEA_BaaSandBox.php?Category="+Selected_Category+"&SubCategory="+Selected_SubCategory, "_self"); 
} 
	
function Select_a_Hazard()
{
	var Selected_Category = document.getElementById("Category_ID").value;
 	var Selected_SubCategory = document.getElementById("SubCategory_ID").value;
 	var Selected_Hazard = document.getElementById("Hazard_ID").value;

 	window.open("RiskFMEA_BaaSandBox.php?Category="+Selected_Category+"&SubCategory="+Selected_SubCategory+"&Hazard="+Selected_Hazard, "_self"); 
}
	
function Select_a_HSType()
{
	var Selected_Category = document.getElementById("Category_ID").value;
 	var Selected_SubCategory = document.getElementById("SubCategory_ID").value;
 	var Selected_Hazard = document.getElementById("Hazard_ID").value;
	var Selected_NCI = document.getElementById("NCI_Code").value;
	
	var Selected_HS = document.getElementById("HS_ID").value;	
	window.open("RiskFMEA_BaaSandBox.php?HS="+Selected_HS+"&Category="+Selected_Category+"&SubCategory="+Selected_SubCategory+"&Hazard="+Selected_Hazard+"&NCI="+Selected_NCI, "_self"); 
}
	
function Select_a_HarmType()
{
	var Selected_Category = document.getElementById("Category_ID").value;
 	var Selected_SubCategory = document.getElementById("SubCategory_ID").value;
 	var Selected_Hazard = document.getElementById("Hazard_ID").value;
	var Selected_NCI = document.getElementById("NCI_Code").value;
	
	var Selected_HS = document.getElementById("HS_ID").value;
	var Selected_Harm = document.getElementById("Harm_ID").value;
	window.open("RiskFMEA_BaaSandBox.php?HS="+Selected_HS+"&Category="+Selected_Category+"&SubCategory="+Selected_SubCategory+"&Hazard="+Selected_Hazard+"&NCI="+Selected_NCI+"&Harm="+Selected_Harm, "_self"); 
}

function Select_a_SeverityType()
{
	var Selected_Category = document.getElementById("Category_ID").value;
 	var Selected_SubCategory = document.getElementById("SubCategory_ID").value;
 	var Selected_Hazard = document.getElementById("Hazard_ID").value;
	var Selected_NCI = document.getElementById("NCI_Code").value;
	
	var Selected_HS = document.getElementById("HS_ID").value;
	var Selected_Harm = document.getElementById("Harm_ID").value;
	var Selected_Severity = document.getElementById("Severity_ID").value;
	window.open("RiskFMEA_BaaSandBox.php?HS="+Selected_HS+"&Category="+Selected_Category+"&SubCategory="+Selected_SubCategory+"&Hazard="+Selected_Hazard+"&NCI="+Selected_NCI+"&Harm="+Selected_Harm+"&Severity="+Selected_Severity, "_self"); 
}	
	
</script>

<?php

$Category_ID = $_REQUEST['Category'];
$SubCategory_ID = $_REQUEST['SubCategory'];
$Hazard_ID = $_REQUEST['Hazard'];
$HS_ID = $_REQUEST['HS'];
$NCI_Code = $_REQUEST['NCI'];
$Harm_ID = $_REQUEST['Harm'];
$Severity_ID = $_REQUEST['Severity'];

	
//--------------below function taking variable $Display value from database first-- 
//----------------then has the same function as Select_ButtonOption 
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
<td>Home / Risk Management / Hazard Sandbox / Baahubali Sandbox</td>
</div>

<div ID="UserList_Page">
<table ID="UserList_Table1" align="center" width='1024px'>				
<tr style="line-height:28px;">
	<td ID="UserList_Table1_Title1" style="text-align: center; font-size: 18px;">Baahubali SandBox</td>		
</tr>
<tr style="line-height:28px;"><td>&nbsp;</td></tr>	<!--blank row-->
</table>
</div>

<div>    
<!-----------------------------------------------------------------------------------------------> 
<!-----------table 1: hazard (most left)-----3 tables total are 1024px---------------------------> 
<!-----------------------------------------------------------------------------------------------> 

<table class='SandBox_SecondTableTitle' align='center' width='420px' cellpadding='0' cellspacing='0' style='float:left; line-height:26px; border:solid #15B4FF 1px;'> 
<tr style="line-height:25px"; bgcolor="#EAF2FF";>   <!--light blue color as true-->		
	<td style="text-align: center;">Hazard table</td>
</tr> 

	
<tr ID="UserList_Table2_Title">
	<td style="color: red; font-size: 14px; border-top:solid #15B4FF 1px; text-indent: 8px;">Select from FDA Lists</td></tr>
		
			<!-------------Start to select from FDA lists: Problem category (1)---->	
<?php 
												
$query_GetCategoryName = mysqli_query($con, "SELECT DISTINCT Problem_Category FROM Risk_FDACodes");															

$HazardCategory_Num = mysqli_num_rows($query_GetCategoryName);
for ($i=0; $i<$HazardCategory_Num; $i++)
	{
	$Category_Row = mysqli_fetch_array($query_GetCategoryName);
	$Category_Lists[$i] = $Category_Row['Problem_Category'];			//create a new array to store all category names
	}	
		
?>
<tr ID="UserList_Table2_Title">
<td style="text-align: center;">
<div>						
		<Select ID="Category_ID" name="Category_ID" class="Select_ButtonSpace" OnChange="Select_a_Category()">
<?php
$Display = '';					//extract from database which shall be pre-filled at table	
$Category_ID = $_REQUEST['Category'];			//submit from above onchange where associated 		
$Operation = 'Category';
$Operation_Title = 'Select a Problem Category';
$Operation_ID = $Category_ID;
$Operation_Ary = $Category_Lists;				//use for display
Select_ButtonOptionPrefill($Display, $Operation_ID, $Operation, $Operation_Title, $Operation_Ary);	//the funtion uses to show the pull down windows	 
?>
		</select>
</div>	 			
</td>
</tr>

			<!------Start to select from FDA lists: sub-category (2)----------->		
		
<?php 
												
$query_GetCategoryName = mysqli_query($con, "SELECT DISTINCT Sub_Category FROM Risk_FDACodes WHERE Problem_Category=\"$Category_ID\"");															

$HazardCategory_Num = mysqli_num_rows($query_GetCategoryName);
for ($i=0; $i<$HazardCategory_Num; $i++)
	{
	$SubCategory_Row = mysqli_fetch_array($query_GetCategoryName);
	$SubCategory_Lists[$i] = $SubCategory_Row['Sub_Category'];			//create a new array to store all category names
	}	
?>
<tr ID="UserList_Table2_Title">
<td style="text-align: center;">
<div style="margin-top:5px;">						
		<Select ID="SubCategory_ID" name="SubCategory_ID" class="Select_ButtonSpace" OnChange="Select_a_SubCategory()">	
<?php
		
$Display = '';		//extract from database which shall be pre-filled at table
$SubCategory_ID = $_REQUEST['SubCategory'];			//submit from above onchange where associated ID="SubCategory_ID"	
$Operation = 'SubCategory';
$Operation_Title = 'Select a Sub-Category';
$Operation_ID = $SubCategory_ID;
$Operation_Ary = $SubCategory_Lists;				//use for display	 

Select_ButtonOptionPrefill($Display, $Operation_ID, $Operation, $Operation_Title, $Operation_Ary);	//the funtion uses to show the pull down windows
?>
		</select>
</div>	 			
</td>
</tr>	
		
		<!-----------------Start to select from FDA lists: FDA Hazard (3)--------------->		
		
<?php 	
//echo $Category_ID;
$query_GetHazardName = mysqli_query($con, "SELECT Hazard FROM Risk_FDACodes WHERE Problem_Category=\"$Category_ID\" AND Sub_Category=\"$SubCategory_ID\" ORDER BY Hazard ASC");															

$Hazard_Num = mysqli_num_rows($query_GetHazardName);
for ($i=0; $i<$Hazard_Num; $i++)
	{
	$Hazard_Row = mysqli_fetch_array($query_GetHazardName);
	$Hazard_Lists[$i] = $Hazard_Row['Hazard'];			//create a new array to store all category names
	}
$Display = '';							//extract from database which shall be pre-filled at table
$Operation = 'Hazard';
$Operation_Title = 'Select a FDA Hazard';
$Hazard_ID = $_REQUEST['Hazard'];			//submit from above onchange where associated ID="Hazard_ID"
$Operation_ID = $Hazard_ID;		
$Operation_Ary = $Hazard_Lists;				//use for display		
?>
<tr ID="UserList_Table2_Title">
<td style="text-align: center;">
<div style="margin-top:5px;">						
		<Select ID="Hazard_ID" name="Hazard_ID" class="Select_ButtonSpace" OnChange="Select_a_Hazard('<?php echo $Hazard_ID;?>')">		
<?php		
Select_ButtonOptionPrefill($Display, $Operation_ID, $Operation, $Operation_Title, $Operation_Ary);	//the funtion uses to show the pull down windows
?>
		</select>
</div>	 			
</td>
</tr>	

<!-------------------Auto fill Hazard description, FDA Codes, and NCI codes--->
<?php
			
$query_GetHazardName = mysqli_query($con, "SELECT * FROM Risk_FDACodes WHERE Problem_Category=\"$Category_ID\" AND Sub_Category=\"$SubCategory_ID\" AND Hazard=\"$Hazard_ID\"");

	$HazardInfo_Row = mysqli_fetch_array($query_GetHazardName);
	$Hazard_Desc = $HazardInfo_Row['Hazard_Desc'];	
	$NCI_Code = $HazardInfo_Row['NCI_Code'];
	$FDA_Code = $HazardInfo_Row['FDA_Code'];

?>

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

<!-----------------------------------------------------------------------------------------------> 
<!-----------------------table 2: hazardous situations (middle)----------------------------------> 
<!-----------------------------------------------------------------------------------------------> 

<table class='SandBox_SecondTableTitle' align='center' width='300px' cellpadding='0' cellspacing='0' style='float:left; line-height:26px; border:solid #15B4FF 1px; margin-left: 30px;'> 
	
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
		
$Operation = 'HS';
$HS_ID = $_REQUEST['HS'];
$Operation_ID = $HS_ID;	
$Operation_Title = 'Select a hazardous Situation';
$Operation_Ary = Table_HazardtoHS($NCI_Code);

Select_ButtonOptionPrefill($Display, $Operation_ID, $Operation, $Operation_Title, $Operation_Ary)
?>   										
	</select></div></td></tr>	 			

	<tr><td>&nbsp;</td></tr>	<!--two blank rows-->
	<tr><td>&nbsp;</td></tr>
<?php
if (isset($HS_ID) && $HS_ID<>'') 	//if have a selection from "potential hazard situations", update $HS_Definitoin; otherwise, maintain the value of variable as database
{	
$HS_Definition = Table_HStoHSDefinition($HS_ID);	
}
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

<!-------------------------------------------------------------------------------------------> 
<!----------------------table 3: hazard (most right)-----------------------------------------> 
<!-------------------------------------------------------------------------------------------> 

<table class='SandBox_SecondTableTitle' align='center' width='300px' cellpadding='0' cellspacing='0' style='float:left; line-height:26px; border:solid #15B4FF 1px; margin-left: 30px;'> 	
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
$HS_ID = $_REQUEST['HS'];		
$Harm_ID = $_REQUEST['Harm'];
$Operation_ID = $Harm_ID;	
$Operation_Ary = Table_HStoHarm($HS_ID);
		
$Operation = 'Harm';	//keep the same as :$request
$Operation_Title = 'Select a harm';

Select_ButtonOptionPrefill($Display, $Operation_ID, $Operation, $Operation_Title, $Operation_Ary)	
		
?>   										
</select>	 
</div></td></tr>	 			

<tr ID="UserList_Table2_Title">
	<td style="color: red; font-size: 14px; text-indent: 8px;">Severity of the harm</td></tr> 

<tr>
<td style="text-align: center;"><div>
<?php					
$Harm_ID = $_REQUEST['Harm']; //$Harm_ID; //$harm can not get from database due to it is not save to database this moment yet
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
<!------------------------------------------below is about the table bottom row---------------------------------------------->
<table style='clear:both'>		<!--push above three tables side by side-->
<tr style="line-height:24px;" bgcolor="#EAF2FF">

</tr>
</table>
    
</div>
<?php

mysqli_close($con);
?>
