<!--Note: the page limit is control by variables of $Page_Limit (php) and Page_Limit(javascript)
located at 3 rows in "line 26, 163, 171" -->

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
	
function Select_a_FMEA1()
{
 	var Selected_FMEA1 = document.getElementById("FMEA1_ID").value;
 	window.open("RiskFMEA_Validation.php?FMEA1="+Selected_FMEA1, "_self"); 
} 

function Select_a_FMEA1Version()
{
 	var Selected_FMEA1 = document.getElementById("FMEA1_ID").value;
	var Selected_FMEA1Version = document.getElementById("FMEA1Version_ID").value;
	
 	window.open("RiskFMEA_Validation.php?FMEA1="+Selected_FMEA1+"&FMEA1Version="+Selected_FMEA1Version, "_self"); 
} 
	
function Select_a_FMEA2()
{
 	var Selected_FMEA1 = document.getElementById("FMEA1_ID").value;
	var Selected_FMEA1Version = document.getElementById("FMEA1Version_ID").value;
	var Selected_FMEA2 = document.getElementById("FMEA2_ID").value;
	
 	window.open("RiskFMEA_Validation.php?FMEA1="+Selected_FMEA1+"&FMEA1Version="+Selected_FMEA1Version+"&FMEA2="+Selected_FMEA2, "_self"); 
} 
	
function Select_a_FMEA2Version()
{
 	var Selected_FMEA1 = document.getElementById("FMEA1_ID").value;
	var Selected_FMEA1Version = document.getElementById("FMEA1Version_ID").value;
	var Selected_FMEA2 = document.getElementById("FMEA2_ID").value;
	var Selected_FMEA2Version = document.getElementById("FMEA2Version_ID").value;
	var Selected_Feature1 = document.getElementById("Feature1_ID").value;
	
 	window.open("RiskFMEA_Validation.php?FMEA1="+Selected_FMEA1+"&FMEA1Version="+Selected_FMEA1Version+"&FMEA2="+Selected_FMEA2+"&FMEA2Version="+Selected_FMEA2Version+"&Feature1="+Selected_Feature1, "_self"); 	
 
}
	
function Select_Feature1()
{
 	var Selected_FMEA1 = document.getElementById("FMEA1_ID").value;
	var Selected_FMEA1Version = document.getElementById("FMEA1Version_ID").value;
	var Selected_FMEA2 = document.getElementById("FMEA2_ID").value;
	var Selected_FMEA2Version = document.getElementById("FMEA2Version_ID").value;
	var Selected_Feature1 = document.getElementById("Feature1_ID").value;
	
 	window.open("RiskFMEA_Validation.php?FMEA1="+Selected_FMEA1+"&FMEA1Version="+Selected_FMEA1Version+"&FMEA2="+Selected_FMEA2+"&FMEA2Version="+Selected_FMEA2Version+"&Feature1="+Selected_Feature1, "_self"); 	
}
	
function Select_Feature2()
{
 	var Selected_FMEA1 = document.getElementById("FMEA1_ID").value;
	var Selected_FMEA1Version = document.getElementById("FMEA1Version_ID").value;
	var Selected_Feature1 = document.getElementById("Feature1_ID").value;
	//var Selected_FMEA2 = document.getElementById("FMEA2_ID").value;
	var Selected_Feature1 = document.getElementById("Feature1_ID").value;
	var Selected_Feature2 = document.getElementById("Feature2_ID").value;
	
 	window.open("RiskFMEA_Validation.php?FMEA1="+Selected_FMEA1+"&FMEA1Version="+Selected_FMEA1Version+"&Feature1="+Selected_Feature1+"&Feature2="+Selected_Feature2, "_self"); 	
}
	
function Select_Feature3()
{
 	var Selected_FMEA1 = document.getElementById("FMEA1_ID").value;
	var Selected_FMEA1Version = document.getElementById("FMEA1Version_ID").value;
	var Selected_Feature1 = document.getElementById("Feature1_ID").value;
	var Selected_Feature2 = document.getElementById("Feature2_ID").value;
	var Selected_Feature3 = document.getElementById("Feature3_ID").value;
	
 	window.open("RiskFMEA_Validation.php?FMEA1="+Selected_FMEA1+"&FMEA1Version="+Selected_FMEA1Version+"&Feature1="+Selected_Feature1+"&Feature2="+Selected_Feature2+"&Feature3="+Selected_Feature3, "_self"); 	
}
	
function Goto_Pages()	//input a page number, and click on the green arrow, program will turn to this page
{
	var Page_Limit = 15;
	var nPages= document.getElementById('Goto_Page').value;
	var nStart=(nPages-1)*Page_Limit;							//nStart is the row before the first row of the destination page
	//alert(nStart);
	var Selected_FMEA1 = document.getElementById("FMEA1_ID").value;
	var Selected_FMEA1Version = document.getElementById("FMEA1Version_ID").value;
	var Selected_FMEA2 = document.getElementById("FMEA2_ID").value;
	var Selected_FMEA2Version = document.getElementById("FMEA2Version_ID").value;
	var Selected_Feature1 = document.getElementById("Feature1_ID").value;
	var Selected_Feature2 = document.getElementById("Feature2_ID").value;
	var Selected_Feature3 = document.getElementById("Feature3_ID").value;
	
 	window.open("RiskFMEA_Validation.php?FMEA1="+Selected_FMEA1+"&FMEA1Version="+Selected_FMEA1Version+"&FMEA2="+Selected_FMEA2+"&FMEA2Version="+Selected_FMEA2Version+"&Feature1="+Selected_Feature1+"&Feature2="+Selected_Feature2+"&Feature3="+Selected_Feature3+"&Rec_Start="+nStart, "_self"); 
}
	
function Turn_Pages(TPage)						//click on one of four arrow icons, turn to first/last/next/previous page
{
	var Page_Limit = 15;
	var nStart = TPage;					//nStart is the row number (array) for the 1st row of the destination page
	//alert(nStart);
	var Selected_FMEA1 = document.getElementById("FMEA1_ID").value;
	var Selected_FMEA1Version = document.getElementById("FMEA1Version_ID").value;
	var Selected_FMEA2 = document.getElementById("FMEA2_ID").value;
	var Selected_FMEA2Version = document.getElementById("FMEA2Version_ID").value;
	var Selected_Feature1 = document.getElementById("Feature1_ID").value;
	var Selected_Feature2 = document.getElementById("Feature2_ID").value;
	var Selected_Feature3 = document.getElementById("Feature3_ID").value;

	window.open("RiskFMEA_Validation.php?FMEA1="+Selected_FMEA1+"&FMEA1Version="+Selected_FMEA1Version+"&FMEA2="+Selected_FMEA2+"&FMEA2Version="+Selected_FMEA2Version+"&Feature1="+Selected_Feature1+"&Feature2="+Selected_Feature2+"&Feature3="+Selected_Feature3+"&Rec_Start="+nStart, "_self"); 
}	
</script>

<?php
session_start(); 
if (!isset($_SESSION["User_ID"]) || $_SESSION["User_ID"]=="")
	{
		$ERR_MSG = "Authorization Failed !";
		echo "<script>window.location='index.php?ERR_MSG=$ERR_MSG'</script>";
	} 
$User_ID = strtoupper($_SESSION["User_ID"]); 

include "Showroom_DB.php";

$FMEA1 = $_REQUEST['FMEA1'];
$FMEA1Version = $_REQUEST['FMEA1Version'];
$FMEA2 = $_REQUEST['FMEA2'];
$FMEA2Version = $_REQUEST['FMEA2Version'];
$Feature1 = $_REQUEST['Feature1'];
$Feature2 = $_REQUEST['Feature2'];
$Feature3 = $_REQUEST['Feature3'];
$Rec_Start = $_REQUEST['Rec_Start'];	//the row number(array) for 1st row at he destination page
										//determine through javascript of reading page number

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
	
    																/*-------content rows--------------------------------*/
function getcolor()
    {
             	static $colorvalue;
             	if ($colorvalue=="#F5F5F5") $colorvalue="#FFFFFF";			//toggle features
             	else $colorvalue="#F5F5F5";
             	return($colorvalue);
     }

?>
<div class="Trace_Directory" style="text-align:left;">
<td>Home / Risk Management / FMEA Data Validation</td>
</div>

<div ID="UserList_Page">

<table ID="UserList_Table1" align="center" width='1024px'>				<!--table 1: titles of "myratrain user list + New user-->
<tr style="line-height:28px;">
	<td ID="UserList_Table1_Title1" style="text-align: center; font-size: 18px;">FMEA Data Validation</td>		
</tr>
</table>    

 
<table ID='UserList_Table2' align='center' width='1024px' cellpadding='0' cellspacing='0' style='line-height:26px; border:solid #15B4FF 1px'> 	<!-----------table 2: title for contents----------------------------------------------------------------------------------->
	<tr style="line-height:3px; background-color:#EAF2FF;">   			<!-------decoration line with division purpose----->
    	<td width="20%">&nbsp;</td>
        <td width="20%">&nbsp;</td>
        <td width="20%">&nbsp;</td>
        <td width="20%">&nbsp;</td>
        <td width="20%">&nbsp;</td>
	</tr>  							 															
	<!-------Title row--------------------------------->
<tr ID="UserList_Table2_Title" style="background-color:#EAF2FF;"> <!--background: url(Images/tr.gif) repeat-x;-->
<td class="UserList_Table2_TitleS">
<div>
<Select ID="FMEA1_ID" name="FMEA1_ID" class="Select_ButtonSpace" OnChange="Select_a_FMEA1()">

<?php	
$query_GetDocumentName = mysqli_query($con, "SELECT Document_No FROM DocumentReview_Approval WHERE Task_Abb LIKE '%FMEA'");

$Document_Num = mysqli_num_rows($query_GetDocumentName);
for ($i=0; $i<$Document_Num; $i++)
	{
	$Document_Row = mysqli_fetch_array($query_GetDocumentName);
	$Document_Nos[$i] = $Document_Row['Document_No'];		
	}															

$Operation = 'FMEA1';
$Operation_Title = 'Select a FMEA File';
$Operation_Ary_Desc = $Document_Nos;				//use for display
$Operation_Ary_Value = $Document_Nos;				//use for variables	
Select_ButtonOption($Operation, $Operation_Title, $Operation_Ary_Desc, $Operation_Ary_Value);	
		
?>   										
</select>	 			<!--function ending point---->						
</div>


<!-----set up a version button under the button "Select a FMEA File"-------------------->

<div>
<Select ID="FMEA1Version_ID" name="FMEA1Version_ID" class="Select_ButtonSpace" OnChange="Select_a_FMEA1Version()">

<?php	
$query_GetDocumentVersion = mysqli_query($con, "SELECT Document_Revision FROM DocumentReview_Approval WHERE Document_No=\"$FMEA1\"");

$Version_Num = mysqli_num_rows($query_GetDocumentVersion);
for ($i=0; $i<$Version_Num; $i++)
	{
	$Version_Row = mysqli_fetch_array($query_GetDocumentVersion);
	$Version_Nos[$i] = $Version_Row['Document_Revision'];		
	}															

$Operation = 'FMEA1Version';
$Operation_Title = 'Select a Version';
$Operation_Ary_Desc = $Version_Nos;				//use for display
$Operation_Ary_Value = $Version_Nos;				//use for variables	
Select_ButtonOption($Operation, $Operation_Title, $Operation_Ary_Desc, $Operation_Ary_Value);	
		
?>   										
</select>	 			<!--function ending point---->						
</div>
</td>	
	
<!--second group button: select other FMEA(option) and version-->
<td class="UserList_Table2_TitleS"> 
<div>
<Select ID="FMEA2_ID" name="FMEA2_ID" class="Select_ButtonSpace" OnChange="Select_a_FMEA2()">
<?php
$FMEA1 = $_REQUEST['FMEA1'];	//get name of selected Operation type from above javascript for internal (equiv $Operation_Type)
$query_GetDocumentName = mysqli_query($con, "SELECT Document_No FROM DocumentReview_Approval WHERE Task_Abb LIKE '%FMEA'");

$Document_Num = mysqli_num_rows($query_GetDocumentName);
$j=0;
for ($i=0; $i<$Document_Num; $i++)
	{
	$Document_Row = mysqli_fetch_array($query_GetDocumentName);
	$Document_Nos[$i] = $Document_Row['Document_No'];	
		if ($Document_Nos[$i] != $FMEA1) 		//remove the first selection from lists
		{		
			$Updated_FMEA[$j] = $Document_Nos[$i];
			$j = $j +1;
		}
	}	

$Operation = 'FMEA2';
$Operation_Title = 'Select other FMEA(option)';
$Operation_Ary_Desc = $Updated_FMEA;				//use for display
$Operation_Ary_Value = $Updated_FMEA;				//use for variables	
Select_ButtonOption($Operation, $Operation_Title, $Operation_Ary_Desc, $Operation_Ary_Value);
?>   										
</select>	 			<!--function ending point---->						
</div>

<!-----set up a version button under the button "Select a FMEA File(other)"-------------------->

<div>
<Select ID="FMEA2Version_ID" name="FMEA2Version_ID" class="Select_ButtonSpace" OnChange="Select_a_FMEA2Version()">

<?php	
$query_GetDocumentVersion = mysqli_query($con, "SELECT Document_Revision FROM DocumentReview_Approval WHERE Document_No=\"$FMEA2\"");

$Version_Num = mysqli_num_rows($query_GetDocumentVersion);
for ($i=0; $i<$Version_Num; $i++)
	{
	$Version_Row = mysqli_fetch_array($query_GetDocumentVersion);
	$Version_Nos[$i] = $Version_Row['Document_Revision'];		
	}															

$Operation = 'FMEA2Version';
$Operation_Title = 'Select a Version';
$Operation_Ary_Desc = $Version_Nos;				//use for display
$Operation_Ary_Value = $Version_Nos;				//use for variables	
Select_ButtonOption($Operation, $Operation_Title, $Operation_Ary_Desc, $Operation_Ary_Value);	
		
?>   										
</select>	 								
</div>
</td>
		
<td class="UserList_Table2_TitleS">
<div>
<Select ID="Feature1_ID" name="Feature1_ID" class="Select_ButtonSpace" OnChange="Select_Feature1()">
<?php	 
$Operation = 'Feature1';
$Operation_Title = 'Select the Feature #1';
$Operation_Ary_Desc = array('Failure Mode', 'Failure Cause', 'Hazard', 'Hazardous Situations', 'Harm', 'Pre_S', 'Pre_P', 'Pre_RR',  'Post_S', 'Post_P', 'Post_RR');	//use for display
$Operation_Ary_Value = array('Failure_Mode', 'Failure_Cause', 'Hazard', 'Hazard_Situation', 'Harm', 'S_Pre', 'P_Pre', 'RiskRank_Pre',  'S_Post', 'P_Post', 'RiskRank_Post');					//use for variables	
	
Select_ButtonOption($Operation, $Operation_Title, $Operation_Ary_Desc, $Operation_Ary_Value);	//use the function
?>   										
</select>	 			<!--function ending point---->						
</div>
</td>		

<?php		
$Feature1 = $_REQUEST['Feature1'];	
$Operation_Ary_Desc = array('Failure Mode', 'Failure Cause', 'Hazard', 'Hazardous Situations', 'Harm', 'Pre_S', 'Pre_P', 'Pre_RR',  'Post_S', 'Post_P', 'Post_RR');	//use for display
$Operation_Ary_Value = array('Failure_Mode', 'Failure_Cause', 'Hazard', 'Hazard_Situation', 'Harm', 'S_Pre', 'P_Pre', 'RiskRank_Pre',  'S_Post', 'P_Post', 'RiskRank_Post');	
	
$Feature1_Num = count($Operation_Ary_Value);	

$j=0;
for ($i=0; $i<$Feature1_Num; $i++)
	{	
		if ($Operation_Ary_Value[$i] != $Feature1) 	//remove used selection by Feature #1 from lists
		{		
			$Updated_Feature2_Value[$j] = $Operation_Ary_Value[$i];
			$Updated_Feature2_Desc[$j]  = $Operation_Ary_Desc[$i];
			$j = $j +1;
		}
	}					
?>						
										
<td class="UserList_Table2_TitleS">
<div>
<Select ID="Feature2_ID" name="Feature2_ID" class="Select_ButtonSpace" OnChange="Select_Feature2()">
<?php	 
$Operation = 'Feature2';
$Operation_Title = 'Select Feature #2(option)';
Select_ButtonOption($Operation, $Operation_Title, $Updated_Feature2_Desc, $Updated_Feature2_Value);	//use the function
?>   										
</select>	 			<!--function ending point---->						
</div>
</td>
		
<?php		
$Feature1 = $_REQUEST['Feature1'];	
$Feature2 = $_REQUEST['Feature2'];
$Operation_Ary_Desc = array('Failure Mode', 'Failure Cause', 'Hazard', 'Hazardous Situations', 'Harm', 'Pre_S', 'Pre_P', 'Pre_RR',  'Post_S', 'Post_P', 'Post_RR');	//use for display
$Operation_Ary_Value = array('Failure_Mode', 'Failure_Cause', 'Hazard', 'Hazard_Situation', 'Harm', 'S_Pre', 'P_Pre', 'RiskRank_Pre',  'S_Post', 'P_Post', 'RiskRank_Post');	
	
$Feature1_Num = count($Operation_Ary_Value);	

$j=0;
for ($i=0; $i<$Feature1_Num; $i++)
	{	
		if ($Operation_Ary_Value[$i] != $Feature1 && $Operation_Ary_Value[$i] != $Feature2)
			//remove used selection by Feature #1 & Feature #2 from lists
		{		
			$Updated_Feature3_Value[$j] = $Operation_Ary_Value[$i];
			$Updated_Feature3_Desc[$j]  = $Operation_Ary_Desc[$i];
			$j = $j +1;
		}
	}					
?>		
<td class="UserList_Table2_TitleS">
<div>
<Select ID="Feature3_ID" name="Feature3_ID" class="Select_ButtonSpace" OnChange="Select_Feature3()">
<?php	 
$Operation = 'Feature3';
$Operation_Title = 'Select Feature #3(option)';
Select_ButtonOption($Operation, $Operation_Title, $Updated_Feature3_Desc, $Updated_Feature3_Value);
?>   										
</select>	 			<!--function ending point---->						
</div>
</td>
</tr>

<?php 

if (empty($Rec_Start))
{
$Rec_Start = 0; 			//use to record the current page (through Javascript)
}
$FMEA1 = $_REQUEST['FMEA1'];
$FMEA1_Revision = $_REQUEST['FMEA1Version'];
$FMEA2 = $_REQUEST['FMEA2'];
$FMEA2_Revision = $_REQUEST['FMEA2Version'];
$Feature1 = $_REQUEST['Feature1'];
$Feature2 = $_REQUEST['Feature2'];
$Feature3 = $_REQUEST['Feature3'];
	
//----------------------case 1: No anyone Feature is selected----------------
if ($Feature1 =="" && $Feature2 == "" && $Feature3 == "")
{
$Num_Total = 1;
for($i=0; $i<15; $i++) 					//display a blank table
    {  
			$cTD0="."; 									
            $cTD1="."; 					
            $cTD2="."; 
            $cTD3=".";
            $cTD4=".";
            $bcolor=getcolor();
				
	echo "<tr bgcolor=$bcolor>";	
	echo "<td style='border-bottom:dotted #093 1px; border-right:dotted #093 1px;'>$cTD0</a></td>";	
	echo "<td style='border-bottom:dotted #093 1px; border-right:dotted #093 1px;'>$cTD1</a></td>";	
	//when clicked on the user_ID, it opens Add_User.php with "RdU_No" attached 
	
	echo "<td style='border-bottom:dotted #093 1px; border-right:dotted #093 1px;'>$cTD2</td>
		  <td style='border-bottom:dotted #093 1px; border-right:dotted #093 1px;'>$cTD3</td>
		  <td style='border-bottom:dotted #093 1px; border-right:none'>$cTD4</td>";								
	echo "</tr>";
	}
}
//-----case 2&3: file #1 & Feature #1 (two selected) are selected--(with file #2 condition)--------
	
else if ($FMEA1 !="" && $Feature1 !="" && $Feature2 == "" && $Feature3 == "")
{
if ($FMEA2 =="") 	//-----case 2: file #1 & Feature #1 are selected---
{
$query_ValidationFile1 = mysqli_query($con, "SELECT $Feature1, COUNT(*) FROM Risk_FMEA WHERE Document_No=\"$FMEA1\" AND Document_Revision=\"$FMEA1_Revision\" GROUP BY $Feature1");	
	
$Num_Total = mysqli_num_rows($query_ValidationFile1);	//for calculating rows
	
	
$query_ValidationFile1 = mysqli_query($con, "SELECT $Feature1, COUNT(*) FROM Risk_FMEA WHERE Document_No=\"$FMEA1\" AND Document_Revision=\"$FMEA1_Revision\" GROUP BY $Feature1 ORDER BY COUNT(*) DESC LIMIT 15 OFFSET $Rec_Start");	//
//count(*) means to make counts on each group
//group by: 
//order by: means ranking 
	
$Validation_Num1 = mysqli_num_rows($query_ValidationFile1);//number of feature group (hazard types)
for ($ValID=0; $ValID<$Validation_Num1; $ValID++)		//$ValID means the sequenctial of sorted features
{
$Validation_Row = mysqli_fetch_array($query_ValidationFile1);	
$Feature1_Val1[$ValID] = $Validation_Row[$Feature1]; 		//can use variable (awesome!)
$Feature1_Count1[$ValID] = $Validation_Row['COUNT(*)']; 
}
	
for($i=0; $i<15; $i++) //$Num_Page
    {  
			$cTD0=$Feature1_Count1[$i]; 									
            $cTD1="."; 					
            $cTD2=$Feature1_Val1[$i]; 
            $cTD3=".";
            $cTD4=".";
            $bcolor=getcolor();
				
	echo "<tr bgcolor=$bcolor>";	
	echo "<td style='border-bottom:dotted #093 1px; border-right:dotted #093 1px;'>$cTD0</a></td>";	
	echo "<td style='border-bottom:dotted #093 1px; border-right:dotted #093 1px;'>$cTD1</a></td>";	
	//when clicked on the user_ID, it opens Add_User.php with "RdU_No" attached 
	
	echo "<td style='border-bottom:dotted #093 1px; border-right:dotted #093 1px;'>$cTD2</td>
		  <td style='border-bottom:dotted #093 1px; border-right:dotted #093 1px;'>$cTD3</td>
		  <td style='border-bottom:dotted #093 1px; border-right:none'>$cTD4</td>";								
	echo "</tr>";
	}
}		
else //----------case 3: file #1, #2, and Feature #1 are selected (most challenge one)-----
	// since the part of displayed columns shall be created out of database, need new codes to display data per page
{
	
$query_ValidationFile1 = mysqli_query($con, "SELECT $Feature1, COUNT(*) FROM Risk_FMEA WHERE Document_No=\"$FMEA1\" AND Document_Revision=\"$FMEA1_Revision\" GROUP BY $Feature1 ORDER BY COUNT(*) DESC");	//
//count(*) means to make counts on each group
//group by: 
//order by: means ranking 
	
$Validation_Num1 = mysqli_num_rows($query_ValidationFile1);//number of feature group (hazard types)
for ($ValID=0; $ValID<$Validation_Num1; $ValID++)		//$ValID means the sequenctial of sorted features
{
$Validation_Row = mysqli_fetch_array($query_ValidationFile1);	
$Feature1_Val1[$ValID] = $Validation_Row[$Feature1]; 		//can use variable (awesome!)
$Feature1_Count1[$ValID] = $Validation_Row['COUNT(*)']; 	
}	
$query_ValidationFile2 = mysqli_query($con, "SELECT $Feature1, COUNT(*) FROM Risk_FMEA WHERE Document_No=\"$FMEA2\" AND Document_Revision=\"$FMEA2_Revision\" GROUP BY $Feature1 ORDER BY COUNT(*) DESC");	//
//count(*) means to make counts on each group
//group by: 
//order by: means ranking 
	
$Validation_Num2 = mysqli_num_rows($query_ValidationFile2);//number of feature group (hazard types)
for ($i=0; $i<$Validation_Num2; $i++)		//
{
$Validation_Row = mysqli_fetch_array($query_ValidationFile2);	
$Feature1_Val2[$i] = $Validation_Row[$Feature1]; 		
$Feature1_Count2[$i] = $Validation_Row['COUNT(*)']; 
}
									
for ($i=0; $i<$Validation_Num1; $i++)		//1st: fill file#2 column with the same length as file#1
{	
	$Feature1_Count2_Display[$i]=0;
	for ($j=0; $j<$Validation_Num2; $j++)
	{
		if ($Feature1_Val2[$j] == $Feature1_Val1[$i])	//$Feature1_Val2: featutre#1 from file2
														//$Feature1_Val1: featutre#1 from file1	
		{
		$Feature1_Count2_Display[$i] = $Feature1_Count2[$j]; //feature#1 is skipped (duplicated)
		continue;									//skip rest and back to for; cant use "return"
		}
	}
}	//close the for loop for searching on the feature#1 from file#1
	
							     //create two arrays for rest of feature1 and counts from file2	
$Intersect_Num = count(array_intersect($Feature1_Val1,$Feature1_Val2));
	
if ($Intersect_Num < $Validation_Num2)		//has extra feature1 from file2
{
$Feature1_Val2_Rest = array_values(array_diff($Feature1_Val2, array_intersect($Feature1_Val1,$Feature1_Val2)));
							//array_diff has key may not start from 0th, but array_values reset it
$Feature1_Val2_RestNumber = count($Feature1_Val2_Rest);	

for ($k=0; $k<$Feature1_Val2_RestNumber; $k++)
{
	for ($l=0; $l<$Validation_Num2; $l++)
	{
		if ($Feature1_Val2_Rest[$k] == $Feature1_Val2[$l])
		{
		$Feature1_Count2_Rest[$k] = $Feature1_Count2[$l];
		}
	}
}	
	
	$u=0;										//rank the array $Feature1_Val2_Rest
												//then search out associated "count data"
	$Feature1_Val2_RestRank[0] = $Feature1_Val2_Rest[0];			
	$Feature1_Count2_RestRank[0] = $Feature1_Count2_Rest[0];
	for ($V=0; $V<$Feature1_Val2_RestNumber-1; $V++)
	{
		for ($W=$V+1; $W<$Feature1_Val2_RestNumber; $W++)
		{
			if ($Feature1_Count2_Rest[$V] < $Feature1_Count2_Rest[$W])	//belows are larger
			{
			$Feature1_Val2_RestRank[$u] = $Feature1_Val2_Rest[$w];			//new arrays
			$Feature1_Count2_RestRank[$u] = $Feature1_Count2_Rest[$w];	
			}
		}
		$u=$u+1;
	}
													//create two arrays by merging
	$Feature1_Count2_Display = array_merge($Feature1_Count2_Display, $Feature1_Count2_Rest);
	$Feature1_Val2 = array_merge($Feature1_Val1 ,$Feature1_Val2_Rest);
}	//close for if in_array("untaken",$Feature1_Val2_Status)
	
$Rec_Start = $_REQUEST['Rec_Start'];	//the row number(array) for 1st row at he destination page
if (empty($Rec_Start))
{
$Rec_Start = 0; 			//use to record the current page (through Javascript)
}
$Num_Total = count($Feature1_Val2);		
for($i=$Rec_Start; $i<$Rec_Start+15; $i++) //$Num_Page
    {  
			$cTD0=$Feature1_Count1[$i]; 									
            $cTD1=$Feature1_Count2_Display[$i]; 					
            $cTD2=$Feature1_Val2[$i]; 
            $cTD3=".";
            $cTD4=".";
            $bcolor=getcolor();
				
	echo "<tr bgcolor=$bcolor>";	
	echo "<td style='border-bottom:dotted #093 1px; border-right:dotted #093 1px;'>$cTD0</a></td>";	
	echo "<td style='border-bottom:dotted #093 1px; border-right:dotted #093 1px;'>$cTD1</a></td>";	
	//when clicked on the user_ID, it opens Add_User.php with "RdU_No" attached 
	
	echo "<td style='border-bottom:dotted #093 1px; border-right:dotted #093 1px;'>$cTD2</td>
		  <td style='border-bottom:dotted #093 1px; border-right:dotted #093 1px;'>$cTD3</td>
		  <td style='border-bottom:dotted #093 1px; border-right:none'>$cTD4</td>";								
	echo "</tr>";
	}						
 }		//close if/else the second file determiniation
}      //close the case 2

//-----Case 4: File#1, feature#1, feature#2 are selected ----
	
else if ($Feature1 !="" && $Feature2 != "" && $Feature3 == "")
{
$query_ValidationRow = mysqli_query($con, "SELECT $Feature1, $Feature2, COUNT(*) FROM Risk_FMEA WHERE Document_No=\"$FMEA1\" AND Document_Revision=\"$FMEA1_Revision\" GROUP BY $Feature1, $Feature2");
$Num_Total = mysqli_num_rows($query_ValidationRow);		
	
$query_ValidationRow = mysqli_query($con, "SELECT $Feature1, $Feature2, COUNT(*) FROM Risk_FMEA WHERE Document_No=\"$FMEA1\" AND Document_Revision=\"$FMEA1_Revision\" GROUP BY $Feature1, $Feature2 ORDER BY COUNT(*) DESC LIMIT 15 OFFSET $Rec_Start");	
//count(*) means to make counts on each group
//group by: 
//order by: means ranking 
	
$Validation_Num = mysqli_num_rows($query_ValidationRow);	//
for ($ValID=0; $ValID<$Validation_Num; $ValID++)			//get ranked data without group
{
$Validation_Row = mysqli_fetch_array($query_ValidationRow);	
$Feature1_Val[$ValID] = $Validation_Row[$Feature1]; 		//can use variable (awesome!)
$Feature2_Val[$ValID] = $Validation_Row[$Feature2];	
$Feature1_Count[$ValID] = $Validation_Row['COUNT(*)']; 
}
	

$Feature1_Reranked[0] = $Feature1_Val[0];	//rerank and store in a new array (all members from the same group are next eachother)
$Feature2_Reranked[0] = $Feature2_Val[0];
$Feature1_Recount[0] = $Feature1_Count[0];
$k=0;														//$k is for $Feature1_Reranked[$k]
for ($i=0; $i<$Validation_Num; $i++)
{
	if ($Feature1_Val_Status[$i] != 'taken' && $i != 0)		//taken from the first loop i, if does not taken from previous, take to new array.
	{
	$k=$k+1;
	$Feature1_Reranked[$k] = $Feature1_Val[$i];
	$Feature2_Reranked[$k] = $Feature2_Val[$i];
	$Feature1_Recount[$k] = $Feature1_Count[$i];
	}
	elseif ($Feature1_Val_Status[$i] == 'taken')
	{
	continue;		//"continue" is used to skip rest of codes and back to next iteration
	}
	for ($j=$i+1; $j<$Validation_Num; $j++)
	{
		if ($Feature1_Val[$i] == $Feature1_Val[$j])			//take from the second loop j-->end, if have the same feature (eg. Hazard); if yes, take to new array. 
		{
			$k=$k+1;
			$Feature1_Reranked[$k] = $Feature1_Val[$j];
			$Feature2_Reranked[$k] = $Feature2_Val[$j];
			$Feature1_Recount[$k] = $Feature1_Count[$j];
			$Feature1_Val_Status[$j] = 'taken';		//taken mark for $Feature 1 at old array (norank) for avoiding feed to new array repeatedly
			$Feature1_Reranked_Status[$k] = 'taken';//taken mark for $Feature 1 at new array (rerank) for controling background color merge
		}
	}

}
	
for($i=0; $i<15; $i++) //$Num_Page
    {  
			$cTD0=$Feature1_Recount[$i]; 	//								
            $cTD1="."; 					
            $cTD2=$Feature1_Reranked[$i]; 	//
            $cTD3=$Feature2_Reranked[$i]; 	//
            $cTD4=".";
		
		if ($Feature1_Reranked_Status[$i] != 'taken')
		{
        $bcolor=getcolor();
		}
				
	echo "<tr bgcolor=$bcolor>";	
	echo "<td style='border-bottom:dotted #093 1px; border-right:dotted #093 1px;'>$cTD0</a></td>";	
	echo "<td style='border-bottom:dotted #093 1px; border-right:dotted #093 1px;'>$cTD1</a></td>";	
	//when clicked on the user_ID, it opens Add_User.php with "RdU_No" attached 
	
	echo "<td style='border-bottom:dotted #093 1px; border-right:dotted #093 1px;'>$cTD2</td>
		  <td style='border-bottom:dotted #093 1px; border-right:dotted #093 1px;'>$cTD3</td>
		  <td style='border-bottom:dotted #093 1px; border-right:none'>$cTD4</td>";								
	echo "</tr>";
	}
}
	
//----------Case 5: File#1, feature 1, 2, 3 are selected----------------
	
else if ($Feature1 !="" && $Feature2 != "" && $Feature3 != "")
{
$query_ValidationRow = mysqli_query($con, "SELECT COUNT(*), $Feature1, $Feature2, $Feature3 FROM Risk_FMEA WHERE Document_No=\"$FMEA1\" AND Document_Revision=\"$FMEA1_Revision\" GROUP BY $Feature1, $Feature2, $Feature3");		
$Num_Total = mysqli_num_rows($query_ValidationRow);	
	
$query_ValidationRow = mysqli_query($con, "SELECT COUNT(*), $Feature1, $Feature2, $Feature3 FROM Risk_FMEA WHERE Document_No=\"$FMEA1\" AND Document_Revision=\"$FMEA1_Revision\" GROUP BY $Feature1, $Feature2, $Feature3 ORDER BY COUNT(*) DESC LIMIT 15 OFFSET $Rec_Start");	
//count(*) means to make counts on each group
//group by: 
//order by: means ranking 
	
$Validation_Num = mysqli_num_rows($query_ValidationRow);	//
for ($ValID=0; $ValID<$Validation_Num; $ValID++)			//get ranked data without group
{
$Validation_Row = mysqli_fetch_array($query_ValidationRow);	
$Feature1_Val[$ValID] = $Validation_Row[$Feature1]; 		//can use variable (awesome!)
$Feature2_Val[$ValID] = $Validation_Row[$Feature2];	
$Feature3_Val[$ValID] = $Validation_Row[$Feature3];
$Feature_Count[$ValID] = $Validation_Row['COUNT(*)']; 
}
	
//rerank just slightly adjust on the feature 3 when have the same feature 1 and 2. it is based on basic ranking from Mysql outputs
$Feature1_Reranked[0] = $Feature1_Val[0];	//rerank and store in a new array (all members from the same group are next eachother)
$Feature2_Reranked[0] = $Feature2_Val[0];
$Feature3_Reranked[0] = $Feature3_Val[0];
$Feature_Recount[0] = $Feature_Count[0];
$k=0;														//$k is for $Feature1_Reranked[$k]
for ($i=0; $i<$Validation_Num; $i++)
{
	if ($Feature2_Val_Status[$i] != 'taken' && $i != 0)		//taken from the first loop i, if does not taken from previous, take to new array.
	{
	$k=$k+1;
	$Feature1_Reranked[$k] = $Feature1_Val[$i];
	$Feature2_Reranked[$k] = $Feature2_Val[$i];
	$Feature3_Reranked[$k] = $Feature3_Val[$i];
	$Feature_Recount[$k] = $Feature_Count[$i];
	}
	elseif ($Feature2_Val_Status[$i] == 'taken')	//variable has been taken, will skip to run the following codes to find next variable with same the feature
	{
	continue;		//"continue" is used to skip rest of codes and back to next iteration
	}
	
	for ($j=$i+1; $j<$Validation_Num; $j++)
	{
		if (($Feature1_Val[$i] == $Feature1_Val[$j]) && ($Feature2_Val[$i] == $Feature2_Val[$j]))			
//take from the second loop j-->end, if have the same feature (eg. Hazard); if yes, take to new array. 
		{
			$k=$k+1;
			$Feature1_Reranked[$k] = $Feature1_Val[$j];
			$Feature2_Reranked[$k] = $Feature2_Val[$j];
			$Feature3_Reranked[$k] = $Feature3_Val[$j];
			$Feature_Recount[$k] = $Feature_Count[$j];
			$Feature2_Val_Status[$j] = 'taken';		//taken mark for $Feature 1 at old array (norank) for avoiding feed to new array repeatedly
			$Feature2_Reranked_Status[$k] = 'taken';//taken mark for $Feature 1 at new array (rerank) for controling background color merge
		}
	}
}
			
for($i=0; $i<15; $i++) //$Num_Page
    {  
			
			$cTD0=$Feature_Recount[$i]; 									
            $cTD1="."; 					
            $cTD2=$Feature1_Reranked[$i]; 
            $cTD3=$Feature2_Reranked[$i];
            $cTD4=$Feature3_Reranked[$i];
		
		if ($Feature2_Reranked_Status[$i] != 'taken')
		{
        $bcolor=getcolor();
		}
				
	echo "<tr bgcolor=$bcolor>";	
	echo "<td style='border-bottom:dotted #093 1px; border-right:dotted #093 1px;'>$cTD0</a></td>";	
	echo "<td style='border-bottom:dotted #093 1px; border-right:dotted #093 1px;'>$cTD1</a></td>";	
	//when clicked on the user_ID, it opens Add_User.php with "RdU_No" attached 
	
	echo "<td style='border-bottom:dotted #093 1px; border-right:dotted #093 1px;'>$cTD2</td>
		  <td style='border-bottom:dotted #093 1px; border-right:dotted #093 1px;'>$cTD3</td>
		  <td style='border-bottom:dotted #093 1px; border-right:none'>$cTD4</td>";								
	echo "</tr>";
	}
	
}
?>


<!------------------------------------------below is about the table bottom row---------------------------------------------->
<tr style="line-height:24px;">
	<td colspan="6" style="background-color:#EAF2FF; border-top:solid #15B4FF 1px;">
    <?php
		echo "<div style='height:3px; width:100%; line-height:0; font-size:0; margin:2px 0px 0px 0px; padding:0; clear:both;'>&nbsp;</div>";
		
		$xPage="RiskFMEA_Validation.php";
		$Page_Limit=15;
/*		
		$Project_ID = $_REQUEST['Project'];
		$Document_No = $_REQUEST['Document'];
		$Document_Revision = $_REQUEST['Revision'];
		$query_GetRiskRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\"");
		$Num_Total = mysqli_num_rows($query_GetRiskRow);
		
*/		
		
		$TotalPage=ceil($Num_Total/$Page_Limit);
		$CurrentPage=ceil($Rec_Start/$Page_Limit)+1;
		
echo "<div class='UserList_Table2_FooterPage'>[ Total: ".$Num_Total." &nbsp;]</div>";	
echo "<div class='UserList_Table2_FooterPage'>[ Current Page: ".$CurrentPage." of ".$TotalPage." &nbsp;]</div>";
echo "<div class='UserList_Table2_FooterWith'>";
			
$LastPage=($TotalPage-1)*$Page_Limit;	//the row number(array) for the 1st row of last page
if ($CurrentPage<$TotalPage)			//determine if "turn to last page" sign is able to be activiated(bright)
	{ 
?>
	<div class='UserList_Table2_FooterIcon'><a href='javascript:void(0)' onclick='Turn_Pages(<?php echo $LastPage;?>)'><img src='Images/ar_right_abs.gif' class='UserList_Table2_IconSize'/></a></div>  				<!--display the bright ">|" and able to turn to the end page-->
<?php
	}  
else
	{
	echo "<div class='UserList_Table2_FooterIcon'><a href='javascript:void(0)' style=''><img src='Images/ar_right_abs_dis.gif' class='UserList_Table2_IconSize'/></a></div>";  			    	//display the dark ">|" and disable to turn to the end page 
	}
			
$NextPage=$CurrentPage*$Page_Limit;  
if ($NextPage<$Num_Total) 								//determine if "turn to next page" sign is able to be activated (bright)
	{ 
?>

	<div class='UserList_Table2_FooterIcon' style='margin-right:8px'><a href='javascript:void(0)' onclick='Turn_Pages(<?php echo $NextPage;?>)'><img src='Images/ar_right.gif' class='UserList_Table2_IconSize'/></a></div>					<!-- display the bright ">" and able to turn to the next page -->
							
<?php
	}  
else
	{

	echo "<div class='UserList_Table2_FooterIcon' style='margin-right:8px'><a href='javascript:void(0)' style=''><img src='Images/ar_right_dis.gif' class='UserList_Table2_IconSize'/></a></div>";  //display the dark ">" and disable to turn to the next page 
	}
				
echo "<div class='UserList_Table2_FooterGoto'>Go to &nbsp;";	//display word "go to"
?>

																	<!-- display a table for enter/display the page number -->
<input type='text' id='Goto_Page' name='Goto_Page' style='width:40px; padding:1px 4px; text-align:center;' maxlength='4' value="<?php echo $CurrentPage;?>" onkeyup="this.value=this.value.replace(/\D/g,'')"/> &nbsp;<a href='javascript:void(0)' onclick='Goto_Pages()'><img src='Images/ar_go.png' width='14' height='14'  title="Go" style='vertical-align: text-bottom;' /></a>

<?php
echo "</div>";
			
$prve=($CurrentPage-2)*$Page_Limit;  
if ($prve>=0) 											//determine if "turn to previous page" sign is able to be activated (bright)
	{  
?>
	<div class='UserList_Table2_FooterIcon' style='margin-right:2em;'><a href='javascript:void(0)' onclick='Turn_Pages(<?php echo $prve;?>)'><img src='Images/ar_left.gif' class='UserList_Table2_IconSize'/></a></div> 
													 <!--display the bright "<" and able to turn to the previous page-->
<?php
	} 
else
	{
	echo "<div class='UserList_Table2_FooterIcon' style='margin-right:2em'><a href='javascript:void(0)' style=''><img src='Images/ar_left_dis.gif' class='UserList_Table2_IconSize'/></a></div>";  //display the dark "<" and disable to turn to the previous page
	}   
				  
if ($CurrentPage>1)                                 //determine if "turn to the first page" sign is able to be activiated(bright)
	{
?>
	<div class='UserList_Table2_FooterIcon' style='margin-right:8px'><a href='javascript:void(0)' onclick='Turn_Pages(0)'><img src='Images/ar_left_abs.gif' class='UserList_Table2_IconSize'/></a></div>
													<!--display the bright "|<" and able to turn to the first page-->
<?php
	}
else
	{
	echo "<div class='UserList_Table2_FooterIcon' style='margin-right:8px'><a href='javascript:void(0)' style=''><img src='Images/ar_left_abs_dis.gif' class='UserList_Table2_IconSize'/></a></div>";  //display the dark "|<" and disable to turn to the first page
	}   
	echo "</div>";
	echo "<div class='UserList_Table2_Bottom'>&nbsp;</div>";

?>        
</td>
</tr>
</table>
    
</div>
<?php

mysqli_close($con);
?>
