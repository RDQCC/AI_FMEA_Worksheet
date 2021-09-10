<?php
session_start(); 
if (!isset($_SESSION["User_ID"]) || $_SESSION["User_ID"]=="")
	{
		$ERR_MSG = "Authorization Failed !";
		echo "<script>window.location='index.php?ERR_MSG=$ERR_MSG'</script>";
	} 
$User_ID = strtoupper($_SESSION["User_ID"]); 

include "Showroom_DB.php";

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


</script> 

<!------------------------------------------table 1: feedback title------------------------------------------------->
<?php
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


if (isset($_POST['Feedback_Submit']))		
	{
	$Project_ID = $_POST['Project_ID'];
	echo "<script>window.location='RiskFMEA_IFU.php?Project=$Project_ID'</script>";
	}

else
{
			
?>

<div>                    
<form name="Feedback_Form" action="" method="post" onkeydown="if(event.keyCode==13 || event.keyCode==116) return false;" onsubmit="Check_RdU()">            
 <!------------------------------------------table 2: Name, position, and feedback inputs------------------------------------------------>
<table ID='FMEA_RMPFrontpage2' align='center'>
<tr class="NewUser_Table2_DecorationLine">
    	<td width="40%">&nbsp;</td>
    	<td width="60%">&nbsp;</td>
</tr>
    
<tr>								<!--------Name and position inputs---------->										
<td class="NewUser_Table2_InputTitle" style="text-indent:0.7em; font-size:14px; ">Create IFU/UM Output</td>
       	
<td>
<?php  	
													//each Project_ID takes only one row in table Project_Info
$query_GetProjectName = mysqli_query($con, "SELECT Project_ID FROM Project_Info");															

$Project_Num = mysqli_num_rows($query_GetProjectName);
for ($i=0; $i<$Project_Num; $i++)
	{
	$Project_Row = mysqli_fetch_array($query_GetProjectName);
	$Project_Lists[$i] = $Project_Row['Project_ID'];			//create a new array to store all project names
	}
?>

<div>
						<!--function starting point--->
	<Select ID="Project_ID" name="Project_ID" style="width:92%;">
<?php	 
$Operation = 'Project';
$Operation_Title = 'Select a Project';
$Operation_Ary_Desc = $Project_Lists;				//use for display
$Operation_Ary_Value = $Project_Lists;				//use for variables	
Select_ButtonOption($Operation, $Operation_Title, $Operation_Ary_Desc, $Operation_Ary_Value);	//use the function
?>   										
	</select>	 			<!--function ending point---->
</div>				
</td>	
       	                    
</tr>
       										

<tr class="NewUser_Table2_Bottom" style="line-height:12px;" >	<!-------Submit the form------------------>
        <td colspan="2">&nbsp;</td>
</tr>

<tr class="NewUser_Table2_Bottom" style='border:solid #EAF2FF 1px;'>
        <td colspan="2" align="center" >
 <input type="submit" id="Feedback_Submit" name="Feedback_Submit" value="Submit" class="RdPDM_Button_Small" style="height:28px;"/>
        </td>
</tr>

<tr class="NewUser_Table2_Bottom" style="line-height:3px;" >
        <td colspan="2">&nbsp;</td>
</tr>
</table>
</form>
 
</div>
<?php
}
mysqli_close($con);  
?>
