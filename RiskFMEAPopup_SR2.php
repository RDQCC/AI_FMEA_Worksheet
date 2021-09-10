<?php 

include "Showroom_DB.php";
include "Table_HazardtoHS.php";
include "Table_HStoHarm.php";
include "Table_HStoHSDefinition.php";
include "Table_HarmDefinition.php";
include "Table_HarmtoSeverity.php";
include "Table_SeveritytoNumber.php";

?>	
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="CSS/ShowRoom.css">
<!--<link rel="stylesheet" type="text/css" href="CSS/RdPDM.css">-->

<style type="text/css">
	
</style>

<script type="text/javascript">

function Hidden_SubmitButton(button)
	{
	button.style.visibility = "hidden";			
	}
	
	
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
	
	
function CheckImg(obj, CNX)
	{   
		var AllowExt = ".jpg|.gif|.png|.pdf|";		//.bmp|.doc|.docx|
		var FileExt = obj.value.substr(obj.value.lastIndexOf(".")).toLowerCase();
		if (AllowExt != 0 && AllowExt.indexOf(FileExt + "|") == -1) 
			{ 
				alert("Uploaded document should be a picture or PDF file !");
				document.getElementById(CNX).value='';
				document.all.CNX.outerHTML   =   document.all.CNX.outerHTML;
				return false;
			}
			
		var str=obj.value.split("\\")[obj.value.split("\\").length-1];
		var re=/[\u0391-\uFFE5]+/g;
		if (str.match(re)!=null) 
			{ 
//				alert("上传文件名中不能包含汉字 !!!");
				document.getElementById(CNX).value='';
				document.all.CNX.outerHTML   =   document.all.CNX.outerHTML;
				return false;
			}
		
		var myReg = "[@/'\"#$%&^*]+"; 
		var SP_Name = document.getElementById(CNX).value;
        var reg = new RegExp(myReg);
		if(reg.test(SP_Name))
			{
				alert("Spectra File Name Should NOT Contain '[@/'\"#$%&^*]+' !!!");
				document.getElementById(CNX).value='';
				document.all.CNX.outerHTML   =   document.all.CNX.outerHTML;
				return false;
			}			
	}
	

function FMEAImage_PopUp(PartImage) //activiate displays of two windows (hidden before), point to new php, send out the variable 
{			
	document.getElementById('FMEAImage_POP_DW').style.display='block'; 
	document.getElementById('FMEAImage_POP_BG').style.display='block';
	document.getElementById("FMEAImage_POPUPFrame").src= "RiskFMEAPopupImage_SR2.php?Part_Image="+PartImage;															
}
	
function FMEAImage_POP_Close()
{
	document.getElementById('FMEAImage_POP_DW').style.display='none'; 
	document.getElementById('FMEAImage_POP_BG').style.display='none';
	document.getElementById("Rd_Task_POPUP").src= "";
}	
	
function Select_a_Category()
{
	var Selected_Category = document.getElementById("Category_ID").value;
	
	var Selected_ProjectID = document.getElementById("Pop_ProjectID").value;
	var Selected_DocNo = document.getElementById("Pop_DocNo").value;
	var Selected_DocRev = document.getElementById("Pop_DocRev").value;
	var Selected_ClickedCross = document.getElementById("Pop_Cross").value;
	var Selected_RiskID = document.getElementById("Pop_RiskID").value;
	
 	window.open("RiskFMEAPopup_SR2.php?Category="+Selected_Category+"&ProjectID="+Selected_ProjectID+"&Project="+Selected_ProjectID+"&Document="+Selected_DocNo+"&Revision="+Selected_DocRev+"&Cross="+Selected_ClickedCross+"&Risk_ID="+Selected_RiskID, "_self"); 	
}

function Select_a_SubCategory()
{
	var Selected_Category = document.getElementById("Category_ID").value;
 	var Selected_SubCategory = document.getElementById("SubCategory_ID").value;
	
	var Selected_ProjectID = document.getElementById("Pop_ProjectID").value;
	var Selected_DocNo = document.getElementById("Pop_DocNo").value;
	var Selected_DocRev = document.getElementById("Pop_DocRev").value;
	var Selected_ClickedCross = document.getElementById("Pop_Cross").value;
	var Selected_RiskID = document.getElementById("Pop_RiskID").value;
	
 	window.open("RiskFMEAPopup_SR2.php?Category="+Selected_Category+"&SubCategory="+Selected_SubCategory+"&Project="+Selected_ProjectID+"&Document="+Selected_DocNo+"&Revision="+Selected_DocRev+"&Cross="+Selected_ClickedCross+"&Risk_ID="+Selected_RiskID, "_self"); 
} 
	
function Select_a_Hazard()
{
	var Selected_Category = document.getElementById("Category_ID").value;
 	var Selected_SubCategory = document.getElementById("SubCategory_ID").value;
 	var Selected_Hazard = document.getElementById("Hazard_ID").value;
	
	var Selected_ProjectID = document.getElementById("Pop_ProjectID").value;
	var Selected_DocNo = document.getElementById("Pop_DocNo").value;
	var Selected_DocRev = document.getElementById("Pop_DocRev").value;
	var Selected_ClickedCross = document.getElementById("Pop_Cross").value;
	var Selected_RiskID = document.getElementById("Pop_RiskID").value;

 	window.open("RiskFMEAPopup_SR2.php?Category="+Selected_Category+"&SubCategory="+Selected_SubCategory+"&Hazard="+Selected_Hazard+"&Project="+Selected_ProjectID+"&Document="+Selected_DocNo+"&Revision="+Selected_DocRev+"&Cross="+Selected_ClickedCross+"&Risk_ID="+Selected_RiskID, "_self"); 
}
	
function Select_a_HSType()
{
	var Selected_ProjectID = document.getElementById("Pop_ProjectID").value;
	var Selected_DocNo = document.getElementById("Pop_DocNo").value;
	var Selected_DocRev = document.getElementById("Pop_DocRev").value;
	var Selected_ClickedCross = document.getElementById("Pop_Cross").value;
	var Selected_RiskID = document.getElementById("Pop_RiskID").value;
	
	//var Selected_Hazard = document.getElementById("Hazard_ID").value; //it has no define since it was located at previous popup screen
	var Selected_HS = document.getElementById("HS_ID").value;
	
	window.open("RiskFMEAPopup_SR2.php?HS="+Selected_HS+"&Project="+Selected_ProjectID+"&Document="+Selected_DocNo+"&Revision="+Selected_DocRev+"&Cross="+Selected_ClickedCross+"&Risk_ID="+Selected_RiskID, "_self"); 
}
		
function Select_a_HarmType()
{
	var Selected_ProjectID = document.getElementById("Pop_ProjectID").value;
	var Selected_DocNo = document.getElementById("Pop_DocNo").value;
	var Selected_DocRev = document.getElementById("Pop_DocRev").value;
	var Selected_ClickedCross = document.getElementById("Pop_Cross").value;
	var Selected_RiskID = document.getElementById("Pop_RiskID").value;
	
	var Selected_Harm = document.getElementById("Harm_ID").value;
	
	window.open("RiskFMEAPopup_SR2.php?Harm="+Selected_Harm+"&Project="+Selected_ProjectID+"&Document="+Selected_DocNo+"&Revision="+Selected_DocRev+"&Cross="+Selected_ClickedCross+"&Risk_ID="+Selected_RiskID, "_self"); 
}	

function Select_a_SeverityType()
{
	var Selected_ProjectID = document.getElementById("Pop_ProjectID").value;
	var Selected_DocNo = document.getElementById("Pop_DocNo").value;
	var Selected_DocRev = document.getElementById("Pop_DocRev").value;
	var Selected_ClickedCross = document.getElementById("Pop_Cross").value;
	var Selected_RiskID = document.getElementById("Pop_RiskID").value;
	
	var Selected_Harm = document.getElementById("Harm_ID").value;
	var Selected_Severity = document.getElementById("Severity_ID").value;
	
	window.open("RiskFMEAPopup_SR2.php?Harm="+Selected_Harm+"&Severity="+Selected_Severity+"&Project="+Selected_ProjectID+"&Document="+Selected_DocNo+"&Revision="+Selected_DocRev+"&Cross="+Selected_ClickedCross+"&Risk_ID="+Selected_RiskID, "_self"); 
}
</script>

<!-----------------------------------------Program starts---------------------------------------------------------> 
<!---------------------------------------------------------------------------------------------------------------->
<?php

function Select_ButtonOption($Operation, $Operation_Title, $Operation_Ary_Desc, $Operation_Ary_Value) 
	{
	$Operation_ID = $_REQUEST[$Operation];	//get name of selected Operation type from above javascript for internal (equiv $Operation_Type)
	$Operation_Ary_ValueComing = array($Operation_ID);	//variable within array shall have no quoation (waste 3 hours)
														//create a new array with only one variable
	$Operation_Ary_L = count($Operation_Ary_Value);
	//---------------------------
	for ($cj=0; $cj<$Operation_Ary_L; $cj++)							//This loop is used to obtain the description of selected $Operation_ID and its value
		{
		if ($Operation_Ary_Value[$cj] == $Operation_ID)
			{
			$Operation_ID_Desc = $Operation_Ary_Desc[$cj];				//new variable for displayed option 
			$Operation_ID_Value = $Operation_ID;						//new variable for value for displayed option														
			}
		}
	$Operation_Ary_ValueDesc = array($Operation_ID_Desc);				//new array with only one variable															
	
	$Operation_Ary_DifValue = array_diff($Operation_Ary_Value, $Operation_Ary_ValueComing);	//the difference is used to display rest of options
	$Operation_Ary_DifDesc = array_diff($Operation_Ary_Desc, $Operation_Ary_ValueDesc);		//in pull down table after one option is selected
	$Operation_Ary_L = count($Operation_Ary_DifValue);		
	//--------------------------						
	if (isset($Operation_ID) && $Operation_ID<>'') 	//if select an option (rather than title, since it has no value/desc) ($Operation_ID is set(isset) and not(<>) blank
		{																	
		echo "<option value='$Operation_ID_Value'>$Operation_ID_Desc</option>";		//hold the selected option as table default (display)				
		for ($ci=0; $ci<=$Operation_Ary_L; $ci++)
			{
			if (isset($Operation_Ary_DifValue[$ci])) 			//skip the blank row for "title: please select one"
				{		
				echo "<option value='$Operation_Ary_DifValue[$ci]'>$Operation_Ary_DifDesc[$ci]</option>";//display rest options only (no blank) 			
				}
			}
		}
	else				//if have no section (display the title, no value)
		{
	?>
    	<option value=""><?php echo $Operation_Title?></option>    
    <?php
		$Operation_Ary_M = count($Operation_Ary_Value);		//no title is counted, when pull down window, no title is an option
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
	


$Project_ID =$_REQUEST['Project'];					//$_REQUEST gets values from Javascript
$Document_No = $_REQUEST['Document'];
$Document_Revision = $_REQUEST['Revision'];
$Risk_ID = $_REQUEST['Risk_ID'];
$Clicked_Cross = $_REQUEST['Cross'];
$Task_Abb = $_REQUEST['TaskAbb'];
$Category_ID = $_REQUEST['Category'];
$SubCategory_ID = $_REQUEST['SubCategory'];
$Hazard_ID = $_REQUEST['Hazard'];
$HS_ID = $_REQUEST['HS'];
$Harm_ID = $_REQUEST['Harm'];


?>
<input type="hidden" id="Pop_ProjectID" name="Pop_ProjectID" value="<?php echo $Project_ID;?>" />
<input type="hidden" id="Pop_DocNo" name="Pop_DocNo" value="<?php echo $Document_No;?>" />
<input type="hidden" id="Pop_DocRev" name="Pop_DocRev" value="<?php echo $Document_Revision;?>" />

<input type="hidden" id="Pop_Cross" name="Pop_Cross" value="<?php echo $Clicked_Cross;?>" />
<input type="hidden" id="Pop_RiskID" name="Pop_RiskID" value="<?php echo $Risk_ID;?>" />

<!-------------------------------------When Clicked on "Description" button (1)------------------------------> 
<!---------------------------------------------------------------------------------------------------------------->
<?php
if ($Clicked_Cross == 'Description')
{
   if (isset($_POST['FMEAData_Submit']) && $_POST['FMEAData_Submit'] == 'Save')	//if clicked on button "save", save all screen data to database
   {				
		
	   	if ($_POST['Desc_Image'] == "")												//if button "choose file" not selected
		{
		$Description = $_POST['Description'];
		$Description = addslashes($Description);	
		$Level = $_POST['Level'];
		$Level = addslashes($Level);
		$Requirement = $_POST['Requirement'];
		$Requirement = addslashes($Requirement);	
		$Specification = $_POST['Specification'];
		$Specification = addslashes($Specification);
		$Operation = $_POST['Operation'];
		$Operation = addslashes($Operation);
			

		$FMEA_Query=mysqli_query($con, "UPDATE Risk_FMEA SET
	
		Description = '$Description',	
		Level = '$Level',
		Requirement = '$Requirement',
		Operation = '$Operation',
		Specification = '$Specification'

		WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Risk_ID ='$Risk_ID'");	
		}
	   
	  
	   
	   if ($_FILES['Desc_Image'] != "")	//if button "choose file" is clicked, then ...can not use $_POST['Part_Image'] here, why can not "else"
	   {

		$Desc_ImageName      = $_FILES['Desc_Image']['name'];
		$Desc_ImageName_Type = $_FILES['Desc_ImageName']['type'];
		$Desc_ImageName_Size = $_FILES['Desc_ImageName']['size'];
		$Desc_ImageName_Temp = $_FILES['Desc_Image']['tmp_name'];			//temperary name always changed
		
		
		$folder = 'FMEA_Images/';
		$path = $folder.$Desc_ImageName;
			if ($_FILES['Desc_ImageName']['error'] > 0)
			{
				$Msg_Title = "Upload_Failed";
				echo "<script>window.location='Info_SR2.php?Msg_Title=$Msg_Title'</script>";
			}
			else if (($_FILES['Desc_ImageName']['size']/1024)>3072)
			{
				$Msg_Title = "Upload_Size3";
				echo "<script>window.location='Info_SR2.php?Msg_Title=$Msg_Title'</script>";	
			}
			else
			{
				if (move_uploaded_file($Desc_ImageName_Temp,$path))
				{
					
		$Description = $_POST['Description'];
		$Description = addslashes($Description);	
		$Level = $_POST['Level'];
		$Level = addslashes($Level);	
		$Operation = $_POST['Operation'];
		$Operation = addslashes($Operation);
		$Requirement = $_POST['Requirement'];
		$Requirement = addslashes($Requirement);	
		$Specification = $_POST['Specification'];
		$Specification = addslashes($Specification);
					
		$Desc_Image = $Desc_ImageName;
				
		$FMEA_Query=mysqli_query($con, "UPDATE Risk_FMEA SET
	
		Description = '$Description',
		Level = '$Level',
		Requirement = '$Requirement',
		Specification = '$Specification',
		Operation = '$Operation',
		Desc_Image = '$Desc_Image'

		WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Risk_ID ='$Risk_ID'");
		//SINCE Risk_FMEA table is for all FMEA docs
				}
				else 
				{
				//echo ('uploaded failed');
				//echo $_FILES['Part_Image']['error'];			//if activiate, it will show error when upload text only 
				}
			}
		}
	   
	
	}
	else													//if button "save" not clicked, taken data from database and display on screen
	{
				
		$query_GetPartRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Risk_ID=\"$Risk_ID\"");
		$Desc_Row = mysqli_fetch_array($query_GetPartRow);
		$Description = $Desc_Row['Description'];
		$Level = $Desc_Row['Level'];
		$Operation = $Desc_Row['Operation'];
		$Requirement = $Desc_Row['Requirement'];
		$Specification = $Desc_Row['Specification'];
		$Desc_Image = $Desc_Row['Desc_Image'];	
		
		
		//--------------------------Display description for DFMEA (Mechanical, Electrical) (1)
		if ($Task_Abb == "MDFMEA" || $Task_Abb == "EDFMEA")	
		{
?>
<div class="FMEAPopUp_Div" style="width:800px; height:400px;">


<!--------------------display head section (icon, title)------------------------->	
<div>	
<div class='FMEA_PopUp_Head'>
<img src="Images/11394.gif" class='FMEA_PopUp_Head_Image'/>
<span class='FMEA_PopUp_Head_Title'>Part Description</span>					
</div>

<div ID="PopUp_Window_Owner">
<span class='PopUp_Window_Owner_Title'>Risk ID: <?php echo $Risk_ID;?></span>           
</div>
</div>

<!--------------------display data section (issue, contents)------------------------->
<form name="RdP_NewForm" action="" method="post" enctype="multipart/form-data">
<table class="FMEAPopUp_Table1" style="width:750px" align='center'>
<tr class="NewUser_Table2_DecorationLine">
    	<td width="20%">&nbsp;</td>
    	<td width="50%">&nbsp;</td>
    	<td width="30%">&nbsp;</td>    	
</tr>	
	
		
<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">Part Description</td>    
    	<td colspan="2"><textarea rows="3" name="Description" style="width:97%; background-color:#FFF;" /><?php echo $Description;?></textarea></td>
</tr>
				
<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">Block</td>    
    	<td colspan="2"><input type="text" name="Level" value='<?php echo $Level;?>' style="width:97%; background-color:#FFF;" /></td>
</tr>	

<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">Design Requirement</td>    
    	<td colspan="2"><textarea rows="3" name="Requirement" style="width:97%; background-color:#FFF;" /><?php echo $Requirement;?></textarea></td>
</tr>

<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">Design Specification</td>    
    	<td colspan="2"><textarea rows="3" name="Specification" style="width:97%; background-color:#FFF;" /><?php echo $Specification;?></textarea></td>
</tr>


<tr> 	
  		<td class="FMEA_UploadImageTitle">Image:<img src="Images/open.gif" align="absmiddle" width="20" height="20"/></td> 
        <td style='font-size:12px; font-weight:500; color:#066; text-indent:1em;'>
        <input type="file" id="Desc_Image" name="Desc_Image" value="" style="width:96%; background-color:#FFF; margin-left:-5px;" onchange="CheckImg(this,'Desc_Image')"/> 
        </td>
        <td style='text-align:left;'><a href="javascript:void(0)" onclick="FMEAImage_PopUp('<?php echo $Desc_Image;?>')"><?php echo $Desc_Image;?></a></td> 	
</tr>				
</table>

<!-------Save button --------->	
<table align="center">
<tr><td>				
<input type="submit" name="FMEAData_Submit" value="Save" class="Save_Button" style="height:28px; margin-top:10px;" onClick="Hidden_SubmitButton(this)"/>
</td></tr>
</table> 

</form>
</div>	
<?php
		}       //close for DFMEA description display


	
		//--------------------------Display description for PFMEA series (manufacturing, packaging, sterilization)(2)
		else if ($Task_Abb == "PFMEA" || $Task_Abb == "PKFMEA" || $Task_Abb == "STFMEA")	
		{
?>
<div class="FMEAPopUp_Div" style="width:800px; height:400px;">


<!--------------------display head section (icon, title)------------------------->	
<div>	
<div class='FMEA_PopUp_Head'>
<img src="Images/11394.gif" class='FMEA_PopUp_Head_Image'/>
<span class='FMEA_PopUp_Head_Title'>Process Description</span>					<!--<?php echo $Clicked_Cross;?>-->
</div>

<div ID="PopUp_Window_Owner">
<span class='PopUp_Window_Owner_Title'>Risk ID: <?php echo $Risk_ID;?></span>           
</div>
</div>

<!--------------------display data section (issue, contents)------------------------->
<form name="RdP_NewForm" action="" method="post" enctype="multipart/form-data">
<table class="FMEAPopUp_Table1" style="width:750px" align='center'>
<tr class="NewUser_Table2_DecorationLine">
    	<td width="25%">&nbsp;</td>
    	<td width="50%">&nbsp;</td>
    	<td width="25%">&nbsp;</td>    	
</tr>	
	
		
<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">Process Description</td>    
    	<td colspan="2"><textarea rows="3" name="Description" style="width:97%; background-color:#FFF;" /><?php echo $Description;?></textarea></td>
</tr>
				
<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">Level</td>    
    	<td colspan="2"><input type="text" name="Level" value='<?php echo $Level;?>' style="width:97%; background-color:#FFF;" /></td>
</tr>
<!--
<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">Operation</td>    
    	<td colspan="2"><input type="text" name="Operation" value='<?php echo $Operation;?>' style="width:97%; background-color:#FFF;" /></td>
</tr>	
-->
<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">Process Requirement</td>    
    	<td colspan="2"><textarea rows="3" name="Requirement" style="width:97%; background-color:#FFF;" /><?php echo $Requirement;?></textarea></td>
</tr>

<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">Process Specification</td>    
    	<td colspan="2"><textarea rows="3" name="Specification" style="width:97%; background-color:#FFF;" /><?php echo $Specification;?></textarea></td>
</tr>


<tr> 	
  		<td class="FMEA_UploadImageTitle">Image:<img src="Images/open.gif" align="absmiddle" width="20" height="20"/></td> 
        <td style='font-size:12px; font-weight:500; color:#066; text-indent:1em;'>
        <input type="file" id="Desc_Image" name="Desc_Image" value="" style="width:96%; background-color:#FFF; margin-left:-5px;" onchange="CheckImg(this,'Desc_Image')"/> 
        </td>
        <td style='text-align:left;'><a href="javascript:void(0)" onclick="FMEAImage_PopUp('<?php echo $Desc_Image;?>')"><?php echo $Desc_Image;?></a></td> 	
</tr>				
</table>

<!-------Save button --------->	
<table align="center">
<tr><td>				
<input type="submit" name="FMEAData_Submit" value="Save" class="Save_Button" style="height:28px; margin-top:10px;" onClick="Hidden_SubmitButton(this)"/>
</td></tr>
</table> 

</form>
</div>	
<?php
		}       //close for PFMEA description display
		
			
//--------------------------Display description for Software FMEA (3)
		else if ($Task_Abb == "SWFMEA")	
		{
?>
<div class="FMEAPopUp_Div" style="width:800px; height:400px;">


<!--------------------display head section (icon, title)------------------------->	
<div>	
<div class='FMEA_PopUp_Head'>
<img src="Images/11394.gif" class='FMEA_PopUp_Head_Image'/>
<span class='FMEA_PopUp_Head_Title'>Software Description</span>					<!--<?php echo $Clicked_Cross;?>-->
</div>

<div ID="PopUp_Window_Owner">
<span class='PopUp_Window_Owner_Title'>Risk ID: <?php echo $Risk_ID;?></span>           
</div>
</div>

<!--------------------display data section (issue, contents)------------------------->
<form name="RdP_NewForm" action="" method="post" enctype="multipart/form-data">
<table class="FMEAPopUp_Table1" style="width:750px" align='center'>
<tr class="NewUser_Table2_DecorationLine">
    	<td width="25%">&nbsp;</td>
    	<td width="50%">&nbsp;</td>
    	<td width="25%">&nbsp;</td>    	
</tr>	
	
		
<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">Software Description</td>    
    	<td colspan="2"><textarea rows="3" name="Description" style="width:97%; background-color:#FFF;" /><?php echo $Description;?></textarea></td>
</tr>
				
<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">Module</td>    
    	<td colspan="2"><input type="text" name="Level" value='<?php echo $Level;?>' style="width:97%; background-color:#FFF;" /></td>
</tr>
<!--
<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">Operation</td>    
    	<td colspan="2"><input type="text" name="Operation" value='<?php echo $Operation;?>' style="width:97%; background-color:#FFF;" /></td>
</tr>	
-->
<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">Software Requirement</td>    
    	<td colspan="2"><textarea rows="3" name="Requirement" style="width:97%; background-color:#FFF;" /><?php echo $Requirement;?></textarea></td>
</tr>

<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">Software Specification</td>    
    	<td colspan="2"><textarea rows="3" name="Specification" style="width:97%; background-color:#FFF;" /><?php echo $Specification;?></textarea></td>
</tr>


<tr> 	
  		<td class="FMEA_UploadImageTitle">Image:<img src="Images/open.gif" align="absmiddle" width="20" height="20"/></td> 
        <td style='font-size:12px; font-weight:500; color:#066; text-indent:1em;'>
        <input type="file" id="Desc_Image" name="Desc_Image" value="" style="width:96%; background-color:#FFF; margin-left:-5px;" onchange="CheckImg(this,'Desc_Image')"/> 
        </td>
        <td style='text-align:left;'><a href="javascript:void(0)" onclick="FMEAImage_PopUp('<?php echo $Desc_Image;?>')"><?php echo $Desc_Image;?></a></td> 	
</tr>				
</table>

<!-------Save button --------->	
<table align="center">
<tr><td>				
<input type="submit" name="FMEAData_Submit" value="Save" class="Save_Button" style="height:28px; margin-top:10px;" onClick="Hidden_SubmitButton(this)"/>
</td></tr>
</table> 

</form>
</div>	
<?php
		}       //close for Software FMEA description display				
					
							
//--------------------------Display description for System FMEA (4)
		else if ($Task_Abb == "SFMEA")	
		{
?>
<div class="FMEAPopUp_Div" style="width:800px; height:400px;">


<!--------------------display head section (icon, title)------------------------->	
<div>	
<div class='FMEA_PopUp_Head'>
<img src="Images/11394.gif" class='FMEA_PopUp_Head_Image'/>
<span class='FMEA_PopUp_Head_Title'>System Description</span>					<!--<?php echo $Clicked_Cross;?>-->
</div>

<div ID="PopUp_Window_Owner">
<span class='PopUp_Window_Owner_Title'>Risk ID: <?php echo $Risk_ID;?></span>           
</div>
</div>

<!--------------------display data section (issue, contents)------------------------->
<form name="RdP_NewForm" action="" method="post" enctype="multipart/form-data">
<table class="FMEAPopUp_Table1" style="width:750px" align='center'>
<tr class="NewUser_Table2_DecorationLine">
    	<td width="20%">&nbsp;</td>
    	<td width="50%">&nbsp;</td>
    	<td width="30%">&nbsp;</td>    	
</tr>	
	
		
<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">System Description</td>    
    	<td colspan="2"><textarea rows="3" name="Description" style="width:97%; background-color:#FFF;" /><?php echo $Description;?></textarea></td>
</tr>
				
<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">Level</td>    
    	<td colspan="2"><input type="text" name="Level" value='<?php echo $Level;?>' style="width:97%; background-color:#FFF;" /></td>
</tr>
<!--
<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">Operation</td>    
    	<td colspan="2"><input type="text" name="Operation" value='<?php echo $Operation;?>' style="width:97%; background-color:#FFF;" /></td>
</tr>	
-->
<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">System Requirement</td>    
    	<td colspan="2"><textarea rows="3" name="Requirement" style="width:97%; background-color:#FFF;" /><?php echo $Requirement;?></textarea></td>
</tr>

<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">System Specification</td>    
    	<td colspan="2"><textarea rows="3" name="Specification" style="width:97%; background-color:#FFF;" /><?php echo $Specification;?></textarea></td>
</tr>


<tr> 	
  		<td class="FMEA_UploadImageTitle">Image:<img src="Images/open.gif" align="absmiddle" width="20" height="20"/></td> 
        <td style='font-size:12px; font-weight:500; color:#066; text-indent:1em;'>
        <input type="file" id="Desc_Image" name="Desc_Image" value="" style="width:96%; background-color:#FFF; margin-left:-5px;" onchange="CheckImg(this,'Desc_Image')"/> 
        </td>
        <td style='text-align:left;'><a href="javascript:void(0)" onclick="FMEAImage_PopUp('<?php echo $Desc_Image;?>')"><?php echo $Desc_Image;?></a></td> 	
</tr>				
</table>

<!-------Save button --------->	
<table align="center">
<tr><td>				
<input type="submit" name="FMEAData_Submit" value="Save" class="Save_Button" style="height:28px; margin-top:10px;" onClick="Hidden_SubmitButton(this)"/>
</td></tr>
</table> 

</form>
</div>	
<?php
		}       //close for System FMEA description display				
			
				
//--------------------------Display description for Use FMEA (5)
		else if ($Task_Abb == "UFMEA")	
		{
?>
<div class="FMEAPopUp_Div" style="width:800px; height:400px;">


<!--------------------display head section (icon, title)------------------------->	
<div>	
<div class='FMEA_PopUp_Head'>
<img src="Images/11394.gif" class='FMEA_PopUp_Head_Image'/>
<span class='FMEA_PopUp_Head_Title'>Use Description</span>					<!--<?php echo $Clicked_Cross;?>-->
</div>

<div ID="PopUp_Window_Owner">
<span class='PopUp_Window_Owner_Title'>Risk ID: <?php echo $Risk_ID;?></span>           
</div>
</div>

<!--------------------display data section (issue, contents)------------------------->
<form name="RdP_NewForm" action="" method="post" enctype="multipart/form-data">
<table class="FMEAPopUp_Table1" style="width:750px" align='center'>
<tr class="NewUser_Table2_DecorationLine">
    	<td width="25%">&nbsp;</td>
    	<td width="50%">&nbsp;</td>
    	<td width="25%">&nbsp;</td>    	
</tr>	
	
		
<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">Usability Description</td>    
    	<td colspan="2"><textarea rows="3" name="Description" style="width:97%; background-color:#FFF;" /><?php echo $Description;?></textarea></td>
</tr>
				
<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">Task</td>    
    	<td colspan="2"><input type="text" name="Level" value='<?php echo $Level;?>' style="width:97%; background-color:#FFF;" /></td>
</tr>
<!--
<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">Operation</td>    
    	<td colspan="2"><input type="text" name="Operation" value='<?php echo $Operation;?>' style="width:97%; background-color:#FFF;" /></td>
</tr>	
-->
<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">Usability Requirement</td>    
    	<td colspan="2"><textarea rows="3" name="Requirement" style="width:97%; background-color:#FFF;" /><?php echo $Requirement;?></textarea></td>
</tr>

<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">Usability Specification</td>    
    	<td colspan="2"><textarea rows="3" name="Specification" style="width:97%; background-color:#FFF;" /><?php echo $Specification;?></textarea></td>
</tr>


<tr> 	
  		<td class="FMEA_UploadImageTitle">Image:<img src="Images/open.gif" align="absmiddle" width="20" height="20"/></td> 
        <td style='font-size:12px; font-weight:500; color:#066; text-indent:1em;'>
        <input type="file" id="Desc_Image" name="Desc_Image" value="" style="width:96%; background-color:#FFF; margin-left:-5px;" onchange="CheckImg(this,'Desc_Image')"/> 
        </td>
        <td style='text-align:left;'><a href="javascript:void(0)" onclick="FMEAImage_PopUp('<?php echo $Desc_Image;?>')"><?php echo $Desc_Image;?></a></td> 	
</tr>				
</table>

<!-------Save button --------->	
<table align="center">
<tr><td>				
<input type="submit" name="FMEAData_Submit" value="Save" class="Save_Button" style="height:28px; margin-top:10px;" onClick="Hidden_SubmitButton(this)"/>
</td></tr>				<!--margin-top: 2px;--->
</table> 

</form>
</div>	
<?php
		}       //close for Use FMEA description display						
							

	}		//close for else of "if clicked on "save" button
}		//close for "if clicked on Mitigationaction button"
?>

<!-------------------------------------When Clicked on "Model affected" button (2)------------------------------> 
<!---------------------------------------------------------------------------------------------------------------->
<?php
if ($Clicked_Cross == 'Model')
{


if (isset($_POST['FMEAData_Submit']))	
	{		
		
		$Model = $_POST['Model'];
		$Model = addslashes($Model);

$FMEA_Query=mysqli_query($con, "UPDATE Risk_FMEA SET
	
Model = '$Model'

WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Risk_ID ='$Risk_ID'");
	}
else
	{
		
$query_GetRequrementRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Risk_ID=\"$Risk_ID\"");
$Requirement_Row = mysqli_fetch_array($query_GetRequrementRow);
$Model = $Requirement_Row['Model'];			
	
		
?>
<div class="FMEAPopUp_Div" style="width:800px; height:400px;">


<!--display head section (icon, title)------>
<div>		
<div class='FMEA_PopUp_Head'>
<img src="Images/11394.gif" class='FMEA_PopUp_Head_Image'/>
<span class='FMEA_PopUp_Head_Title'>Model Affected</span>
</div>

<div ID="PopUp_Window_Owner">
<span class='PopUp_Window_Owner_Title'>Risk ID: <?php echo $Risk_ID;?></span>           
</div>
</div>
<!---display data section (issue, contents)-->
<form name="RdP_NewForm" action="" method="post">
<table class="FMEAPopUp_Table1" style="width:750px" align='center'>    
<tr class="NewUser_Table2_DecorationLine">
    	<td width="20%">&nbsp;</td>
    	<td width="80%">&nbsp;</td>   	
</tr>	
	
		
<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">Model affected</td>    
    	<td><textarea rows="3" name="Model" style="width:97%; margin-bottom:10px; background-color:#FFF;"><?php echo $Model;?></textarea></td>
</tr>									
</table>

<!-------Save button --------->	
<table align="center">
<tr><td>				
<input type="submit" id="FMEAData_Submit" name="FMEAData_Submit" value="Save" class="Save_Button" style="height:28px; margin-top:10px;" onClick="Hidden_SubmitButton(this)"/>
</td></tr>
</table> 

</form>
</div>	
	
<?php
	}		//close for "if clicked on "save" button
}		//close for "if clicked on Model affected button"
?>

<!-------------------------------------When Clicked on "Document" button (3)------------------------------> 
<!---------------------------------------------------------------------------------------------------------------->
<?php
if ($Clicked_Cross == 'Desc_Document')
{


if (isset($_POST['FMEAData_Submit']))	
	{		
		
		$Desc_Document = $_POST['Desc_Document'];
		$Desc_Document = addslashes($Desc_Document);

$FMEA_Query=mysqli_query($con, "UPDATE Risk_FMEA SET
	
Desc_Document = '$Desc_Document'

WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Risk_ID ='$Risk_ID'");
	}
else
	{
		
$query_GetRequrementRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Risk_ID=\"$Risk_ID\"");
$Requirement_Row = mysqli_fetch_array($query_GetRequrementRow);
$Desc_Document = $Requirement_Row['Desc_Document'];			
	
		
?>
<div class="FMEAPopUp_Div" style="width:800px; height:400px;">


<!--display head section (icon, title)------>
<div>		
<div class='FMEA_PopUp_Head'>
<img src="Images/11394.gif" class='FMEA_PopUp_Head_Image'/>
<span class='FMEA_PopUp_Head_Title'>Associated Documents</span>
</div>

<div ID="PopUp_Window_Owner">
<span class='PopUp_Window_Owner_Title'>Risk ID: <?php echo $Risk_ID;?></span>           
</div>
</div>
<!---display data section (issue, contents)-->
<form name="RdP_NewForm" action="" method="post">
<table class="FMEAPopUp_Table1" style="width:750px" align='center'>    
<tr class="NewUser_Table2_DecorationLine">
    	<td width="20%">&nbsp;</td>
    	<td width="80%">&nbsp;</td>   	
</tr>	
	
		
<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">Documents</td>    
    	<td><textarea rows="2" name="Desc_Document" style="width:97%; margin-bottom:10px; background-color:#FFF;"><?php echo $Desc_Document;?></textarea></td>
</tr>									
</table>

<!-------Save button --------->	
<table align="center">
<tr><td>				
<input type="submit" id="FMEAData_Submit" name="FMEAData_Submit" value="Save" class="Save_Button" style="height:28px; margin-top:10px;" onClick="Hidden_SubmitButton(this)"/>
</td></tr>
</table> 

</form>
</div>	
	
<?php
	}		//close for "if clicked on "save" button
}		//close for "if clicked on Document button"
?>
<!-------------------------------When Clicked on "Potential Failure Mode" button (4)------------------------------> 
<!---------------------------------------------------------------------------------------------------------------->
<?php
if ($Clicked_Cross == 'FailureMode')
{

   if (isset($_POST['FMEAData_Submit']) && $_POST['FMEAData_Submit'] == 'Save')	
   {	
		
      if ($_POST['FailureMode_Image'] == "")												//if button "choose file" not selected
	  {

	  $FailureMode = $_POST['FailureMode'];
	  $FailureMode = addslashes($FailureMode);
	  $FMEA_Query=mysqli_query($con, "UPDATE Risk_FMEA SET
	
	  Failure_Mode = '$FailureMode'
	
	WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Risk_ID ='$Risk_ID'");
	  }
	   	  
	   
	 if ($_FILES['FailureMode_Image'] != "")		//if button "choose file" is clicked, then ...can not use $_POST['Part_Image'] here, why can not "else"
  	 {
	
		$FailureMode_ImageName      = $_FILES['FailureMode_Image']['name'];
		$FailureMode_ImageName_Type = $_FILES['FailureMode_ImageName']['type'];
		$FailureMode_ImageName_Size = $_FILES['FailureMode_ImageName']['size'];
		$FailureMode_ImageName_Temp = $_FILES['FailureMode_Image']['tmp_name'];			//temperary name always changed
		
		
		$folder = 'FMEA_Images/';
		$path = $folder.$FailureMode_ImageName;
		if ($_FILES['FailureMode_ImageName']['error'] > 0)
		{
			$Msg_Title = "Upload_Failed";
			echo "<script>window.location='Info_SR1.php?Msg_Title=$Msg_Title'</script>";
		}
		else if (($_FILES['FailureMode_ImageName']['size']/1024)>3072)
		{
			$Msg_Title = "Upload_Size3";
			echo "<script>window.location='Info_SR1.php?Msg_Title=$Msg_Title'</script>";	
		}
		else
		{
			if (move_uploaded_file($FailureMode_ImageName_Temp,$path))
			{		
			$FailureMode = $_POST['FailureMode'];
			$FailureMode = addslashes($FailureMode);
			$FailureMode_Image = $FailureMode_ImageName;		
		
			$FMEA_Query=mysqli_query($con, "UPDATE Risk_FMEA SET
	
			Failure_Mode = '$FailureMode',
			FailureMode_Image = '$FailureMode_Image'

		WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Risk_ID ='$Risk_ID'");
			}
			else 
			{
			//echo ('uploaded failed');
			//echo $_FILES['FailureMode_Image']['error'];
			}
		}			
	 }
   }
	
   else				//else for not clicked on button "save"
   {
		
$query_GetFMRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Risk_ID=\"$Risk_ID\"");
$FM_Row = mysqli_fetch_array($query_GetFMRow);
$FailureMode = $FM_Row['Failure_Mode'];			
$FailureMode_Image = $FM_Row['FailureMode_Image'];
		
?>
<div class="FMEAPopUp_Div" style="width:800px; height:400px;">


<!--display head section (icon, title)------>
<div>		
<div class='FMEA_PopUp_Head'>
<img src="Images/11394.gif" class='FMEA_PopUp_Head_Image'/>
<span class='FMEA_PopUp_Head_Title'>Potential Failure Modes</span>
</div>

<div ID="PopUp_Window_Owner">
<span class='PopUp_Window_Owner_Title'>Risk ID: <?php echo $Risk_ID;?></span>           
</div>
</div>

<!---display data section (issue, contents)-->
<form name="RdP_NewForm" action="" method="post" enctype="multipart/form-data">
<table class="FMEAPopUp_Table1" style="width:750px" align='center'>
<tr class="NewUser_Table2_DecorationLine">
    	<td width="25%">&nbsp;</td>
    	<td width="50%">&nbsp;</td>
    	<td width="25%">&nbsp;</td>   	
</tr>	
	
		
<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">Failure Mode</td>    
    	<td colspan="2"><textarea rows="3" name="FailureMode" style="width:97%; background-color:#FFF;"><?php echo $FailureMode;?></textarea></td>
</tr>				

<tr> 	
  		<td class="FMEA_UploadImageTitle">Image:<img src="Images/open.gif" align="absmiddle" width="20" height="20"/></td> 
        <td style='font-size:12px; font-weight:500; color:#066; text-indent:1em;'>
        <input type="file" id="FailureMode_Image" name="FailureMode_Image" Value="" style="width:96%; background-color:#FFF; margin-bottom:10px; margin-left:-5px;" onchange="CheckImg(this,'FailureMode_Image')"/> 
        </td>
        <td style='text-align:left;'><a href="javascript:void(0)" onclick="FMEAImage_PopUp('<?php echo $FailureMode_Image;?>')"><?php echo $FailureMode_Image;?></a></td>               		       					
</tr>	
							
</table>

<!-------Save button --------->	
<table align="center">
<tr><td>				
<input type="submit" id="FMEAData_Submit" name="FMEAData_Submit" value="Save" class="Save_Button" style="height:28px; margin-top:10px;" onClick="Hidden_SubmitButton(this)"/>
</td></tr>
</table> 

</form>
</div>	
	
<?php
	}		//close for "if clicked on "save" button
}		//close for "if clicked on failure mode button"
?>


<!-------------------------------When Clicked on "Failure causes" button (5)------------------------------> 
<!---------------------------------------------------------------------------------------------------------------->
<?php
if ($Clicked_Cross == 'FMCause')
{


if (isset($_POST['FMEAData_Submit']))	
	{		
		
		$FM_Cause = $_POST['FM_Cause'];
        $FM_Cause = addslashes($FM_Cause);
		
		$FMEA_Query=mysqli_query($con, "UPDATE Risk_FMEA SET
	
		Failure_Cause = '$FM_Cause'

	WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Risk_ID ='$Risk_ID'");
	}
else																			//pull variable values and display on screen
	{
		
$query_GetFMCauseRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Risk_ID=\"$Risk_ID\"");
$FMCause_Row = mysqli_fetch_array($query_GetFMCauseRow);
$FM_Cause = $FMCause_Row['Failure_Cause'];			

		
?>
<div class="FMEAPopUp_Div" style="width:800px; height:400px;">


<!--display head section (icon, title)------>	
<div>	
<div class='FMEA_PopUp_Head'>
<img src="Images/11394.gif" class='FMEA_PopUp_Head_Image'/>
<span class='FMEA_PopUp_Head_Title'>Potential Causes of the Failure Mode</span>
</div>

<div ID="PopUp_Window_Owner">
<span class='PopUp_Window_Owner_Title'>Risk ID: <?php echo $Risk_ID;?></span>           
</div>
</div>

<!---display data section (issue, contents)-->
<form name="RdP_NewForm" action="" method="post">
<table class="FMEAPopUp_Table1" style="width:750px" align='center'>
<tr class="NewUser_Table2_DecorationLine">
    	<td width="25%">&nbsp;</td>
    	<td width="75%">&nbsp;</td>   	
</tr>	
			
<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">Causes of Failure Mode</td>    
    	<td><textarea rows="3" name="FM_Cause" style="width:97%; margin-bottom:10px; background-color:#FFF;"><?php echo $FM_Cause;?></textarea></td>
</tr>											
</table>

<!-------Save button --------->	
<table align="center">
<tr><td>				
<input type="submit" id="FMEAData_Submit" name="FMEAData_Submit" value="Save" class="Save_Button" style="height:28px; margin-top:10px;" onClick="Hidden_SubmitButton(this)"/>
</td></tr>
</table> 

</form>
</div>	
	
<?php
	}		//close for "if clicked on "save" button
}		//close for "if clicked on Failure cause button"
?>

<!-------------------------------When Clicked on "Hazard" button (6)------------------------------> 
<!----------------------------------------------Problem_Category, sub_category, Hazard which values are assigned by Javascript $_REQUEST------------------>
<!----------------------------------------------Hazard desc, FDA_Code, NCI_Code which values are assigned by HTML $_POST---------------------------------->
<?php
if ($Clicked_Cross == 'Hazard')
{


if (isset($_POST['FMEAData_Submit']))		//if clicked on "save", deposit to database
	{		
		$Category_ID = $_POST['Category_ID'];
		$SubCategory_ID = $_POST['SubCategory_ID'];
		$Hazard_ID = $_POST['Hazard_ID'];
		$Hazard_Desc = $_POST['Hazard_Desc'];
		$Hazard_Desc = addslashes($Hazard_Desc);
		$FDA_Code = $_POST['FDA_Code'];
		$NCI_Code = $_POST['NCI_Code'];
		
		
		$FMEA_Query=mysqli_query($con, "UPDATE Risk_FMEA SET
	
		
		Problem_Category = '$Category_ID',
		Sub_Category ='$SubCategory_ID',
		Hazard = '$Hazard_ID',
		Hazard_Desc = '$Hazard_Desc',
		FDA_Code = '$FDA_Code',
		NCI_Code = '$NCI_Code'
		
		WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Risk_ID ='$Risk_ID'");

	}	
else 			//if does not clicked on "Save" button
	{

	$query_GetHazardRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Risk_ID=\"$Risk_ID\"");
		
	$HazardInfo_Row = mysqli_fetch_array($query_GetHazardRow);
	$Problem_Category = $HazardInfo_Row['Problem_Category'];
	$Sub_Category = $HazardInfo_Row['Sub_Category'];
	$Hazard = $HazardInfo_Row['Hazard'];
	$Hazard_Desc = $HazardInfo_Row['Hazard_Desc'];
	$FDA_Code = $HazardInfo_Row['FDA_Code'];
	$NCI_Code = $HazardInfo_Row['NCI_Code'];	
?>
<div class="FMEAPopUp_Div" style="width:800px; height:400px;">


<!--display head section (icon, title)------>	
<div>	
<div class='FMEA_PopUp_Head'>
<img src="Images/11394.gif" class='FMEA_PopUp_Head_Image'/>
<span class='FMEA_PopUp_Head_Title'>Potential Hazards</span>
</div>

<div ID="PopUp_Window_Owner">
<span class='PopUp_Window_Owner_Title'>Risk ID: <?php echo $Risk_ID;?></span>           
</div>
</div>

<!---display data section (issue, contents)-->
<form name="RdP_NewForm" action="" method="post">
<table class="FMEAPopUp_Table1" style="width:750px" align='center'>
<tr class="NewUser_Table2_DecorationLine">
    	<td width="20%">&nbsp;</td>
    	<td width="25%">&nbsp;</td>
    	<td width="25%">&nbsp;</td>
    	<td width="30%">&nbsp;</td>   	
</tr>
	
<!---selection button "hazard from history"----->			
<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">Select from Database</td>       	
<td>
<div>
<!--function starting point--->
<Select ID="Operation_Type" name="Operation_Type" class="Select_ButtonSpace" OnChange="Select_a_OperationType()">
<?php	 
$Operation = 'Operation';
$Operation_Title = 'Select a hazard';
$Operation_Ary_Desc = array('Battery depletion', 'Electrical shorting', 'Item containmated');	//use for display
$Operation_Ary_Value = array('Operational', 'Facilities', 'Human');					//use for variables	
Select_ButtonOption($Operation, $Operation_Title, $Operation_Ary_Desc, $Operation_Ary_Value);	//use the function
?>   										
</select>	 								
</div>
</td>
</tr>
<!-------------------close the first selection button for FDA category--->

<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">Select from FDA Lists</td>   
		 
		
<!-----------------Start to select from FDA lists: Problem category (1)--------------------->
 									<!--program is similar to Selections of FMEA mainscreen; "DISTINCT' uses to search unique category collections --->
<?php 
												
$query_GetCategoryName = mysqli_query($con, "SELECT DISTINCT Problem_Category FROM Risk_FDACodes");															

$HazardCategory_Num = mysqli_num_rows($query_GetCategoryName);
for ($i=0; $i<$HazardCategory_Num; $i++)
	{
	$Category_Row = mysqli_fetch_array($query_GetCategoryName);
	$Category_Lists[$i] = $Category_Row['Problem_Category'];			//create a new array to store all category names
	}	
		
?>
<td>
<div>						
		<Select ID="Category_ID" name="Category_ID" class="Select_ButtonSpace" OnChange="Select_a_Category()">
<?php
$Display = $Problem_Category;					//extract from database which shall be pre-filled at table	
$Category_ID = $_REQUEST['Category'];			//submit from above onchange where associated 		
$Operation = 'Category';
$Operation_Title = 'Problem Category';
$Operation_ID = $Category_ID;
$Operation_Ary = $Category_Lists;				//use for display
Select_ButtonOptionPrefill($Display, $Operation_ID, $Operation, $Operation_Title, $Operation_Ary);	//the funtion uses to show the pull down windows	 
?>
		</select>
</div>	 			
</td>
		
		<!-----------------Start to select from FDA lists: sub-category (2)--------------------->		
		
<?php 
												
$query_GetCategoryName = mysqli_query($con, "SELECT DISTINCT Sub_Category FROM Risk_FDACodes WHERE Problem_Category=\"$Category_ID\"");															

$HazardCategory_Num = mysqli_num_rows($query_GetCategoryName);
for ($i=0; $i<$HazardCategory_Num; $i++)
	{
	$SubCategory_Row = mysqli_fetch_array($query_GetCategoryName);
	$SubCategory_Lists[$i] = $SubCategory_Row['Sub_Category'];			//create a new array to store all category names
	}	
?>
<td>
<div>						
		<Select ID="SubCategory_ID" name="SubCategory_ID" class="Select_ButtonSpace" OnChange="Select_a_SubCategory()">	
<?php
		
$Display = $Sub_Category;							//extract from database which shall be pre-filled at table
$SubCategory_ID = $_REQUEST['SubCategory'];			//submit from above onchange where associated ID="SubCategory_ID"	
$Operation = 'SubCategory';
$Operation_Title = 'Sub-Category';
$Operation_ID = $SubCategory_ID;
$Operation_Ary = $SubCategory_Lists;				//use for display	 

Select_ButtonOptionPrefill($Display, $Operation_ID, $Operation, $Operation_Title, $Operation_Ary);	//the funtion uses to show the pull down windows
?>
		</select>
</div>	 			
</td>	
		
		<!-----------------Start to select from FDA lists: FDA Hazard (3)--------------------->		
		
<?php 	
//echo $Category_ID;
$query_GetHazardName = mysqli_query($con, "SELECT Hazard FROM Risk_FDACodes WHERE Problem_Category=\"$Category_ID\" AND Sub_Category=\"$SubCategory_ID\" ORDER BY Hazard ASC");															

$Hazard_Num = mysqli_num_rows($query_GetHazardName);
for ($i=0; $i<$Hazard_Num; $i++)
	{
	$Hazard_Row = mysqli_fetch_array($query_GetHazardName);
	$Hazard_Lists[$i] = $Hazard_Row['Hazard'];			//create a new array to store all category names
	}
$Display = $Hazard;							//extract from database which shall be pre-filled at table
$Operation = 'Hazard';
$Operation_Title = 'FDA Hazard Lists';
$Hazard_ID = $_REQUEST['Hazard'];			//submit from above onchange where associated ID="Hazard_ID"
$Operation_ID = $Hazard_ID;		
$Operation_Ary = $Hazard_Lists;				//use for display		
?>
<td>
<div>						
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
	if (!isset($_REQUEST['Category']) && $_REQUEST['Category'] =="") 	
	{
	$query_GetHazardRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Risk_ID=\"$Risk_ID\"");
		
	$HazardInfo_Row = mysqli_fetch_array($query_GetHazardRow);
	$Hazard_Desc = $HazardInfo_Row['Hazard_Desc'];
	$FDA_Code = $HazardInfo_Row['FDA_Code'];
	$NCI_Code = $HazardInfo_Row['NCI_Code'];
	}
	else
	{
			
$query_GetHazardName = mysqli_query($con, "SELECT * FROM Risk_FDACodes WHERE Problem_Category=\"$Category_ID\" AND Sub_Category=\"$SubCategory_ID\" AND Hazard=\"$Hazard_ID\"");															

	$HazardInfo_Row = mysqli_fetch_array($query_GetHazardName);
	$Hazard_Desc = $HazardInfo_Row['Hazard_Desc'];	
	$NCI_Code = $HazardInfo_Row['NCI_Code'];
	$FDA_Code = $HazardInfo_Row['FDA_Code'];
	}
?>

<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">Hazard Description</td>    
    	<td colspan="3"><textarea rows="2" name="Hazard_Desc" style="width:98%; background-color:#FFF;"><?php echo $Hazard_Desc;?></textarea></td>
</tr>		
<tr class="FMEA_PopUp_Row">	
<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em; margin-bottom: 10px;">Hazard Codes</td> 
<td><input type="text" name="FDA_Code" value='<?php echo $FDA_Code;?>' style="width:95%; margin-bottom:10px; background-color:#FFF;" /></td>
<td><input type="text" name="NCI_Code" value="<?php echo $NCI_Code;?>" style="width:95%; margin-bottom:10px; background-color:#FFF;" /></td>
															
</table>
<!-------Save button --------->	
<table align="center">
<tr><td>				
<input type="submit" id="FMEAData_Submit" name="FMEAData_Submit" value="Save" class="Save_Button" style="height:28px; margin-top:10px;" onClick="Hidden_SubmitButton(this)"/>
</td></tr>
</table> 

</form>
</div>	
	
<?php
		//}		//close for "if /else select on any 3 selection buttons"
		
	}		//close for "if clicked on "save" button
}		//close for "if clicked on Hazard button"
?>

<!-------------------------------When Clicked on "Hazard situation" button (7)------------------------------> 
<!---------------------------------------------------------------------------------------------------------------->
<?php
if ($Clicked_Cross == 'HazardSituation')
{

if (isset($_POST['FMEAData_Submit']))	
	{		
	
		$Hazard_Situation = $_POST['HS_ID'];
		$Hazard_Situation = addslashes($Hazard_Situation);
		$HS_Definition = $_POST['HS_Definition'];
		$HS_Definition = addslashes($HS_Definition);
		
		$FMEA_Query=mysqli_query($con, "UPDATE Risk_FMEA SET
	
		Hazard_Situation = '$Hazard_Situation',
		HS_Definition = '$HS_Definition'

	WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Risk_ID ='$Risk_ID'");
	}
else
	{
$query_GetHazardRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Risk_ID=\"$Risk_ID\"");
$Hazard_Row = mysqli_fetch_array($query_GetHazardRow);
$Hazard = $Hazard_Row['Hazard'];
$NCI_Code = $Hazard_Row['NCI_Code'];
$HS_Database = $Hazard_Row['Hazard_Situation'];
$Display = $HS_Database; 
$HS_Definition = $Hazard_Row['HS_Definition'];
	
?>
<div class="FMEAPopUp_Div" style="width:800px; height:400px;">


<!--display head section (icon, title)------>	
<div>	
<div class='FMEA_PopUp_Head'>
<img src="Images/11394.gif" class='FMEA_PopUp_Head_Image'/>
<span class='FMEA_PopUp_Head_Title'>Potential Hazard Situations</span>
</div>

<div ID="PopUp_Window_Owner">
<span class='PopUp_Window_Owner_Title'>Risk ID: <?php echo $Risk_ID;?></span>           
</div>
</div>

<!---display data section (issue, contents)-->
<form name="RdP_NewForm" action="" method="post">
<table class="FMEAPopUp_Table1" style="width:750px" align='center'>
<tr class="NewUser_Table2_DecorationLine">
    	<td width="30%">&nbsp;</td>
    	<td width="70%">&nbsp;</td>   	
</tr>	
	
<!---selection button "hazard situation"----->			
<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">Potential Hazard situations</td>       	
<td>
<div>
<!--function starting point--->
<Select ID="HS_ID" name="HS_ID" class="Select_ButtonSpace" OnChange="Select_a_HSType()">
<?php
		
$Operation = 'HS';
$HS_ID = $_REQUEST['HS'];
$Operation_ID = $HS_ID;	
$Operation_Title = 'Select a hazard Situation';
$Operation_Ary = Table_HazardtoHS($NCI_Code);

Select_ButtonOptionPrefill($Display, $Operation_ID, $Operation, $Operation_Title, $Operation_Ary)
?>   										
</select>	 			<!--function ending point---->						
</div>
</td>
</tr>
<?php
if (isset($HS_ID) && $HS_ID<>'') 	//if have a selection from "potential hazard situations", update $HS_Definitoin; otherwise, maintain the value of variable as database
{	
$HS_Definition = Table_HStoHSDefinition($HS_ID);	
}
?>
<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">Hazard Situation Definition</td>    
    	<td><textarea rows="6" name="HS_Definition" style="width:95%; background-color:#FFF; margin-bottom:10px;"><?php echo $HS_Definition;?></textarea></td>
</tr>

<!-------------------close the hazard situation selection button--------->
</table>

<!-------Save button --------->	
<table align="center">
<tr><td>				
<input type="submit" id="FMEAData_Submit" name="FMEAData_Submit" value="Save" class="Save_Button" style="height:28px; margin-top:10px;" onClick="Hidden_SubmitButton(this)"/>
</td></tr>
</table> 

</form>
</div>	
	
<?php
	}		//close for "if clicked on "save" button
}		//close for "if clicked on Hazard situation"
?>

<!-------------------------------When Clicked on "Harms of Failure Mode" button (6)------------------------------> 
<!---------------------------------------------------------------------------------------------------------------->
<?php
if ($Clicked_Cross == 'FMHarm')
{

if (isset($_POST['FMEAData_Submit']))	
	{		
		
		$Harm = $_POST['Harm_ID'];
		$Harm = addslashes($Harm);
		$Harm_Severity = $_POST['Severity_ID'];
		$Harm_Severity = addslashes($Harm_Severity);
		$Harm_Intervention = $_POST['Intervention_ID'];
		$Harm_Intervention = addslashes($Harm_Intervention);
		
		$FMEA_Query=mysqli_query($con, "UPDATE Risk_FMEA SET
	
		Harm = '$Harm',
		Harm_Severity = '$Harm_Severity',
		Harm_Intervention = '$Harm_Intervention'
		

		WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Risk_ID=\"$Risk_ID\"");
	}
else
	{
//--------------------for harm selection-------------			
								
?>
<div class="FMEAPopUp_Div" style="width:800px; height:400px;">


<!--display head section (icon, title)------>	
<div>	
<div class='FMEA_PopUp_Head'>
<img src="Images/11394.gif" class='FMEA_PopUp_Head_Image'/>
<span class='FMEA_PopUp_Head_Title'>Potential Harm to Patients</span>
</div>

<div ID="PopUp_Window_Owner">
<span class='PopUp_Window_Owner_Title'>Risk ID: <?php echo $Risk_ID;?></span>           
</div>
</div>

<!---display data section (issue, contents)-->
<form name="RdP_NewForm" action="" method="post">
<table class="FMEAPopUp_Table1" style="width:750px" align='center'>
<tr class="NewUser_Table2_DecorationLine">
    	<td width="25%">&nbsp;</td>
    	<td width="75%">&nbsp;</td>   	
</tr>	
<!---selection button "harm"----->			
<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">Potential Harm to Patients</td>       	
<td>
<div>
<!--function starting point--->
<Select ID="Harm_ID" name="Harm_ID" class="Select_ButtonSpace" OnChange="Select_a_HarmType()">
<?php
$query_GetHarmRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Risk_ID=\"$Risk_ID\"");
$Harm_Row = mysqli_fetch_array($query_GetHarmRow);
$HS = $Harm_Row['Hazard_Situation'];
$Harm_Database = $Harm_Row['Harm'];
$Display = $Harm_Database; 
		
$Harm_ID = $_REQUEST['Harm'];
$Operation_ID = $Harm_ID;	
$Operation_Ary = Table_HStoHarm($HS);
		
$Operation = 'Harm';	//keep the same as :$request
$Operation_Title = 'Select a harm';

Select_ButtonOptionPrefill($Display, $Operation_ID, $Operation, $Operation_Title, $Operation_Ary)	
		
?>   										
</select>	 			<!--function ending point---->						
</div>
</td>
</tr>

<!---close the "harm" selection---->
	
<!---selection button "severity of harm" and "Harm definition"---->			
<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">Severity of the harm</td>       	
<td>
<div>

<?php		
$query_GetSeverityRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Risk_ID=\"$Risk_ID\"");
$Severity_Row = mysqli_fetch_array($query_GetSeverityRow);
$Severity_Database = $Severity_Row['Harm_Severity'];
$Display = $Severity_Database; 
$Harm_Intervention = $Severity_Row['Harm_Intervention'];
				
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
<!---close the "severity of harm" selection---->

<?php
if (isset($Severity_ID) && $Severity_ID<>'') 	//if have a selection from "severity of the harm", update $Harm_Intervention; otherwise, maintain the value of variable as database
{
$Harm_ID = $_REQUEST['Harm'];
$Severity_ID = $_REQUEST['Severity'];	
$Harm_Intervention = Table_HarmDefinition($Harm_ID, $Severity_ID);
$S_Pre = Table_SeveritytoNumber($Severity_ID);
$S_Post = Table_SeveritytoNumber($Severity_ID);
	
		$FMEA_Query=mysqli_query($con, "UPDATE Risk_FMEA SET
	
		S_Pre = '$S_Pre',
		S_Post = '$S_Post'
		
		WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Risk_ID=\"$Risk_ID\"");	
	
}
?>

<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">Harm Definition</td>    
    	<td><textarea rows="5" name="Intervention_ID" style="width:95%; background-color:#FFF; margin-bottom:10px;"><?php echo $Harm_Intervention;?></textarea></td>
</tr>
</table>

<!-------------------close the hazard situation selection button--------->	
											
<!-------Save button --------->	
<table align="center">
<tr><td>				
<input type="submit" id="FMEAData_Submit" name="FMEAData_Submit" value="Save" class="Save_Button" style="height:28px; margin-top:10px;" onClick="Hidden_SubmitButton(this)"/>
</td></tr>
</table> 

</form>
</div>	
	
<?php
	}		//close for "if clicked on "save" button
}		//close for "if clicked on Mitigationaction button"
?>
<!-------------------------------When Clicked on "Current controls" button (7)------------------------------> 
<!---------------------------------------------------------------------------------------------------------------->
<?php
if ($Clicked_Cross == 'CurrentControl')
{


if (isset($_POST['FMEAData_Submit']))	
	{		
		
		$CurrentControl_Design = $_POST['CurrentControl_Design'];
		$CurrentControl_Design = addslashes($CurrentControl_Design);
	    $CurrentControl_Process = $_POST['CurrentControl_Process'];
		$CurrentControl_Process = addslashes($CurrentControl_Process);
		$CurrentControl_Info = $_POST['CurrentControl_Info'];
		$CurrentControl_Info = addslashes($CurrentControl_Info);		

$FMEA_Query=mysqli_query($con, "UPDATE Risk_FMEA SET
	
CurrentControl_Design	= '$CurrentControl_Design',
CurrentControl_Process = '$CurrentControl_Process',
CurrentControl_Info = '$CurrentControl_Info'

WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Risk_ID=\"$Risk_ID\"");
	}
else
	{
		
$query_GetCurrentControlRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Risk_ID=\"$Risk_ID\"");		
$CurrentControl_Row = mysqli_fetch_array($query_GetCurrentControlRow);
		
$CurrentControl_Design = $CurrentControl_Row['CurrentControl_Design'];
$CurrentControl_Process = $CurrentControl_Row['CurrentControl_Process'];
$CurrentControl_Info = $CurrentControl_Row['CurrentControl_Info'];
		
?>
<div class="FMEAPopUp_Div" style="width:800px; height:400px;">


<!--------------------display head section (icon, title)------------------------->
<div>		
<div class='FMEA_PopUp_Head'>
<img src="Images/11394.gif" class='FMEA_PopUp_Head_Image'/>
<span class='FMEA_PopUp_Head_Title'>Current Controls(reference to any applicable documents)</span>
</div>

<div ID="PopUp_Window_Owner">
<span class='PopUp_Window_Owner_Title'>Risk ID: <?php echo $Risk_ID;?></span>           
</div>
</div>

<!--------------------display data section (issue, contents)------------------------->
<form name="RdP_NewForm" action="" method="post">
<table class="FMEAPopUp_Table1" style="width:750px" align='center'>
<tr class="NewUser_Table2_DecorationLine">
    	<td width="20%">&nbsp;</td>
    	<td width="80%">&nbsp;</td>   	
</tr>	
	
		
<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">Controls by Design</td>    
    	<td><textarea rows="3" name="CurrentControl_Design" style="width:97%; background-color:#FFF;"><?php echo $CurrentControl_Design;?></textarea></td>
</tr>				
<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">Controls by Process</td>    
    	<td><textarea rows="3" name="CurrentControl_Process" style="width:97%; background-color:#FFF;"><?php echo $CurrentControl_Process;?></textarea></td>
</tr>	
<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">Controls by Info</td>    
    	<td><textarea rows="3" name="CurrentControl_Info" style="width:97%; background-color:#FFF; margin-bottom:10px;"><?php echo $CurrentControl_Info;?></textarea></td>
</tr>			
</table>

<!-------Save button --------->	
<table align='center'>
<tr><td>				
<input type="submit" id="FMEAData_Submit" name="FMEAData_Submit" value="Save" class="Save_Button" style="height:28px; margin-top:10px;"  onClick="Hidden_SubmitButton(this)"/>
</td></tr>
</table> 

</form>
</div>	
	
<?php
	}		//close for "if clicked on "save" button
}		//close for "if clicked on Mitigationaction button"
?>


<!--------------------------When Clicked on "Recommended Mitigations" button (8)----------------------------------> 
<!---------------------------------------------------------------------------------------------------------------->
<?php
if ($Clicked_Cross == 'MitigationAction')
{

   if (isset($_POST['FMEAData_Submit']) && $_POST['FMEAData_Submit'] == 'Save')	
   {	
	 				
		
	   	if ($_POST['MitigationAction_Image'] == "")												//if button "choose file" not selected
		{
		$MitigationAction_Design = $_POST['MitigationAction_Design'];
		$MitigationAction_Design = addslashes($MitigationAction_Design);
	    $MitigationAction_Process = $_POST['MitigationAction_Process'];
		$MitigationAction_Process = addslashes($MitigationAction_Process);
		$MitigationAction_Info = $_POST['MitigationAction_Info'];
		$MitigationAction_Info = addslashes($MitigationAction_Info);
	    $MitigationAction_Index = $_POST['MitigationAction_Index'];	

		$FMEA_Query=mysqli_query($con, "UPDATE Risk_FMEA SET
	
		MitigationAction_Design	= '$MitigationAction_Design',
		MitigationAction_Process = '$MitigationAction_Process',
		MitigationAction_Info = '$MitigationAction_Info',
		MitigationAction_Index	= '$MitigationAction_Index'

		WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Risk_ID=\"$Risk_ID\"");
		}
	   
	   
	   if ($_FILES['MitigationAction_Image'] != "")			//if button "choose file" is clicked, then ...can not use $_POST['Part_Image'] here, why can not "else"
  		{	
				
		$MitigationAction_ImageName      = $_FILES['MitigationAction_Image']['name'];
		$MitigationAction_ImageName_Type = $_FILES['MitigationAction_ImageName']['type'];
		$MitigationAction_ImageName_Size = $_FILES['MitigationAction_ImageName']['size'];
		$MitigationAction_ImageName_Temp = $_FILES['MitigationAction_Image']['tmp_name'];			//temperary name always changed
		
		
		$folder = 'FMEA_Images/';
		$path = $folder.$MitigationAction_ImageName;
		if ($_FILES['MitigationAction_ImageName']['error'] > 0)
		{
			$Msg_Title = "Upload_Failed";
			echo "<script>window.location='Info_SR1.php?Msg_Title=$Msg_Title'</script>";
		}
		else if (($_FILES['MitigationAction_ImageName']['size']/1024)>3072)
		{
			$Msg_Title = "Upload_Size3";
			echo "<script>window.location='Info_SR1.php?Msg_Title=$Msg_Title'</script>";	
		}
		else
		{
			if (move_uploaded_file($MitigationAction_ImageName_Temp,$path))
			{
				
			$MitigationAction_Design = $_POST['MitigationAction_Design'];
			$MitigationAction_Design = addslashes($MitigationAction_Design);
	    	$MitigationAction_Process = $_POST['MitigationAction_Process'];
			$MitigationAction_Process = addslashes($MitigationAction_Process);
			$MitigationAction_Info = $_POST['MitigationAction_Info'];
			$$MitigationAction_Info = addslashes($$MitigationAction_Info);
	    	$MitigationAction_Index = $_POST['MitigationAction_Index'];
			
			$MitigationAction_Image = $MitigationAction_ImageName;
		
		
			$FMEA_Query=mysqli_query($con, "UPDATE Risk_FMEA SET
	
			MitigationAction_Design	= '$MitigationAction_Design',
			MitigationAction_Process = '$MitigationAction_Process',
			MitigationAction_Info = '$MitigationAction_Info',
			MitigationAction_Index	= '$MitigationAction_Index',
			MitigationAction_Image	= '$MitigationAction_Image'
			
			WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Risk_ID=\"$Risk_ID\"");
			}
			else 
			{
			//echo ('uploaded failed');
			//echo $_FILES['$MitigationAction_Image']['error'];
			}
		}
	}
  }						//close if the button "save" not clicked
else					// else for the button "save" not clicked 
{
		
$query_GetMitigationRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Risk_ID=\"$Risk_ID\"");
$MitigationRow_Row = mysqli_fetch_array($query_GetMitigationRow);
	
$MitigationAction_Design = $MitigationRow_Row['MitigationAction_Design'];
$MitigationAction_Process = $MitigationRow_Row['MitigationAction_Process'];
$MitigationAction_Info = $MitigationRow_Row['MitigationAction_Info'];
$MitigationAction_Index = $MitigationRow_Row['MitigationAction_Index'];
$MitigationAction_Image = $MitigationRow_Row['MitigationAction_Image'];

		
?>
<div class="FMEAPopUp_Div" style="width:800px; height:400px;">


<!--------------------display head section (icon, title)------------------------->	
<div>	
<div class='FMEA_PopUp_Head'>
<img src="Images/11394.gif" class='FMEA_PopUp_Head_Image'/>
<span class='FMEA_PopUp_Head_Title'>Recommended Mitigating Actions(reference to any applicable documents)</span>
</div>

<div ID="PopUp_Window_Owner">
<span class='PopUp_Window_Owner_Title'>Risk ID: <?php echo $Risk_ID;?></span>           
</div>
</div>
<!--------------------display data section (issue, contents)------------------------->
<form name="RdP_NewForm" action="" method="post" enctype="multipart/form-data">
<table class="FMEAPopUp_Table1" style="width:750px" align='center'>
<tr class="NewUser_Table2_DecorationLine">
    	<td width="20%">&nbsp;</td>
    	<td width="50%">&nbsp;</td>  
    	<td width="30%">&nbsp;</td> 	
</tr>	
	
		
<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">Mitigation by Design</td>    
    	<td colspan="2"><textarea rows="3" name="MitigationAction_Design" style="width:97%; background-color:#FFF;"><?php echo $MitigationAction_Design;?></textarea></td>
</tr>				
<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">Mitigation by Process</td>    
    	<td colspan="2"><textarea rows="3" name="MitigationAction_Process" style="width:97%; background-color:#FFF;"><?php echo $MitigationAction_Process;?></textarea></td>
</tr>	
<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">Mitigation by Info</td>    
    	<td colspan="2"><textarea rows="3" name="MitigationAction_Info" style="width:97%; background-color:#FFF;"><?php echo $MitigationAction_Info;?></textarea></td>
</tr>
<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">Mitigation Index</td>    
    	<td colspan="2"><input type="number" name="MitigationAction_Index" value="<?php echo $MitigationAction_Index;?>" style="width:97%; background-color:#FFF;" /></td>
</tr>
<tr> 	
  		<td class="FMEA_UploadImageTitle">Image:<img src="Images/open.gif" align="absmiddle" width="20" height="20"/></td> 
        <td style='font-size:12px; font-weight:500; color:#066; text-indent:1em; margin-bottom:10px;'>
        <input type="file" id="MitigationAction_Image" name="MitigationAction_Image" Value="" style="width:96%; background-color:#FFF; margin-left:-5px;" onchange="CheckImg(this,'MitigationAction_Image')"/> 
        </td> 
        <td style='text-align:left;'><a href="javascript:void(0)" onclick="FMEAImage_PopUp('<?php echo $MitigationAction_Image;?>')"><?php echo $MitigationAction_Image;?></a></td>	
</tr>				
</table>

<!-------Save button --------->	
<table align='center'>
<tr><td>				
<input type="submit" id="FMEAData_Submit" name="FMEAData_Submit" value="Save" class="Save_Button" style="height:28px; margin-top:10px;"  onClick="Hidden_SubmitButton(this)"/>
</td></tr>
</table> 

</form>
</div>	
	
<?php
	}		//close for "if clicked on "save" button
}			//close if cliced on button "mitigation"
?>

<!-------------------------------When Clicked on "Verification check" button (11)------------------------------> 
<!---------------------------------------------------------------------------------------------------------------->
<?php
if ($Clicked_Cross == 'VerificationCheck')
{


if (isset($_POST['FMEAData_Submit']))	
	{		
		
		$Verification_Check = $_POST['Verification_Check'];
		$Verification_Check = addslashes($Verification_Check);
	    $Effectiveness_Check = $_POST['Effectiveness_Check'];
		$Effectiveness_Check = addslashes($Effectiveness_Check);
		$Verification_Result = $_POST['Verification_Result'];
		$Verification_Result = addslashes($Verification_Result);	

$FMEA_Query=mysqli_query($con, "UPDATE Risk_FMEA SET
	
Verification_Check	= '$Verification_Check',
Effectiveness_Check = '$Effectiveness_Check',
Verification_Result = '$Verification_Result'

WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Risk_ID=\"$Risk_ID\"");
	}
else
	{
		
$query_GetVerificationRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Risk_ID=\"$Risk_ID\"");
$VerificationRow_Row = mysqli_fetch_array($query_GetVerificationRow);
$Verification_Check = $VerificationRow_Row['Verification_Check'];
$Effectiveness_Check = $VerificationRow_Row['Effectiveness_Check'];
$Verification_Result = $VerificationRow_Row['Verification_Result'];		
		
?>
<div class="FMEAPopUp_Div" style="width:800px; height:400px;">


<!--------------------display head section (icon, title)------------------------->	
<div>	
<div class='FMEA_PopUp_Head'>
<img src="Images/11394.gif" class='FMEA_PopUp_Head_Image'/>
<span class='FMEA_PopUp_Head_Title'>Implementation Verification & Effectiveness Check</span>
</div>

<div ID="PopUp_Window_Owner">
<span class='PopUp_Window_Owner_Title'>Risk ID: <?php echo $Risk_ID;?></span>           
</div>
</div>
<!--------------------display data section (issue, contents)------------------------->
<form name="RdP_NewForm" action="" method="post">
<table class="FMEAPopUp_Table1" style="width:750px" align='center'>
<tr class="NewUser_Table2_DecorationLine">
    	<td width="20%">&nbsp;</td>
    	<td width="80%">&nbsp;</td>   	
</tr>	
	
		
<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">Verification Check</td>    
    	<td><textarea rows="3" name="Verification_Check" style="width:97%; background-color:#FFF;"><?php echo $Verification_Check;?></textarea></td>
</tr>				
<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">Effectiveness Check</td>    
    	<td><textarea rows="3" name="Effectiveness_Check" style="width:97%; background-color:#FFF;"><?php echo $Effectiveness_Check;?></textarea></td>
</tr>	
<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">Verification Result</td>    
    	<td><input type="text" name="Verification_Result" value="<?php echo $Verification_Result;?>" style="width:97%; background-color:#FFF; margin-bottom:10px;" /></td>
</tr>			
</table>

<!-------Save button --------->	
<table align='center'>
<tr><td>				
<input type="submit" id="FMEAData_Submit" name="FMEAData_Submit" value="Save" class="Save_Button" style="height:28px; margin-top:10px;"  onClick="Hidden_SubmitButton(this)"/>
</td></tr>
</table> 

</form>
</div>	
	
<?php
	}		//close for "if clicked on "save" button
}		//close for "if clicked on Mitigationaction button"
?>

<!-------------------------------When Clicked on "RBA" button (10)------------------------------> 
<!---------------------------------------------------------------------------------------------------------------->
<?php
if ($Clicked_Cross == 'RBA')
{


if (isset($_POST['FMEAData_Submit']))	
	{		
		
		$RBA_Statement = $_POST['RBA_Statement'];
		$RBA_Statement = addslashes($RBA_Statement);
	    $RBA_Result = $_POST['RBA_Result'];
		$RBA_Result = addslashes($RBA_Result);	

$FMEA_Query=mysqli_query($con, "UPDATE Risk_FMEA SET
	
RBA_Statement	= '$RBA_Statement',
RBA_Result = '$RBA_Result'

WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Risk_ID=\"$Risk_ID\"");

	}
else
	{
		
$query_GetRBARow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Risk_ID=\"$Risk_ID\"");
$RBA_Row = mysqli_fetch_array($query_GetRBARow);
$RBA_Statement = $RBA_Row['RBA_Statement'];
$RBA_Result = $RBA_Row['RBA_Result'];
		
?>
<div class="FMEAPopUp_Div" style="width:800px; height:400px;">


<!--------------------display head section (icon, title)------------------------->	
<div>	
<div class='FMEA_PopUp_Head'>
<img src="Images/11394.gif" class='FMEA_PopUp_Head_Image'/>
<span class='FMEA_PopUp_Head_Title'>Risk Benefit Analysis and Disclosure</span>
</div>

<div ID="PopUp_Window_Owner">
<span class='PopUp_Window_Owner_Title'>Risk ID: <?php echo $Risk_ID;?></span>           
</div>
</div>

<!--------------------display data section (issue, contents)------------------------->
<form name="RdP_NewForm" action="" method="post">
<table class="FMEAPopUp_Table1" style="width:750px" align='center'>
<tr class="NewUser_Table2_DecorationLine">
    	<td width="20%">&nbsp;</td>
    	<td width="80%">&nbsp;</td>   	
</tr>	
	
		
<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">RBA Statement</td>    
    	<td><textarea rows="3" name="RBA_Statement" style="width:97%; background-color:#FFF;"><?php echo $RBA_Statement;?></textarea></td>
</tr>				
<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">RBA Result</td>    
    	<td><input type="text" name="RBA_Result" value="<?php echo $RBA_Result;?>" style="width:97%; background-color:#FFF; margin-bottom:10px;" /></td>
</tr>	
			
</table>

<!-------Save button --------->	
<table align='center'>
<tr><td>				
<input type="submit" id="FMEAData_Submit" name="FMEAData_Submit" value="Save" class="Save_Button" style="height:28px; margin-top:10px;"  onClick="Hidden_SubmitButton(this)"/>
</td></tr>
</table> 

</form>
</div>	
	
<?php
	}		//close for "if clicked on "save" button
}		//close for "if clicked on RBA button"
?>
<!-------------------------------When Clicked on "New Hazard" button (11)-----------------------------------------> 
<!---------------------------------------------------------------------------------------------------------------->
<?php
if ($Clicked_Cross == 'NewHazard')
{


if (isset($_POST['FMEAData_Submit']))	
	{		
		
		$NewHazard_Statement = $_POST['NewHazard_Statement'];
		$NewHazard_Statement = addslashes($NewHazard_Statement);
	    $NewHazard_Result = $_POST['NewHazard_Result'];
		$NewHazard_Result = addslashes($NewHazard_Result);

$FMEA_Query=mysqli_query($con, "UPDATE Risk_FMEA SET
	
NewHazard_Statement	= '$NewHazard_Statement',
NewHazard_Result = '$NewHazard_Result'

WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Risk_ID=\"$Risk_ID\"");
	}
else
	{
		
$query_GetNewHazardRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Risk_ID=\"$Risk_ID\"");
$NewHazard_Row = mysqli_fetch_array($query_GetNewHazardRow);
$NewHazard_Statement = $NewHazard_Row['NewHazard_Statement'];
$NewHazard_Result = $NewHazard_Row['NewHazard_Result'];
		
?>
<div class="FMEAPopUp_Div" style="width:800px; height:400px;">


<!--------------------display head section (icon, title)------------------------->	
<div>	
<div class='FMEA_PopUp_Head'>
<img src="Images/11394.gif" class='FMEA_PopUp_Head_Image'/>
<span class='FMEA_PopUp_Head_Title'>New Failure Modes/Hazards</span>
</div>

<div ID="PopUp_Window_Owner">
<span class='PopUp_Window_Owner_Title'>Risk ID: <?php echo $Risk_ID;?></span>           
</div>
</div>

<!--------------------display data section (issue, contents)------------------------->
<form name="RdP_NewForm" action="" method="post">
<table class="FMEAPopUp_Table1" style="width:750px" align='center'>
<tr class="NewUser_Table2_DecorationLine">
    	<td width="25%">&nbsp;</td>
    	<td width="75%">&nbsp;</td>   	
</tr>	
	
		
<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">New Hazard Statement</td>    
    	<td><textarea rows="3" name="NewHazard_Statement" style="width:97%; background-color:#FFF;"><?php echo $NewHazard_Statement;?></textarea></td>
</tr>				
<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em; margin-bottom:5px;">New Hazard Result</td>    
    	<td><input type="text" name="NewHazard_Result" value="<?php echo $NewHazard_Result;?>" style="width:97%; background-color:#FFF; margin-bottom:5px;" /></td>
</tr>	
			
</table>

<!-------Save button --------->	
<table align='center'>
<tr><td>				
<input type="submit" id="FMEAData_Submit" name="FMEAData_Submit" value="Save" class="Save_Button" style="height:28px; margin-top:10px;"  onClick="Hidden_SubmitButton(this)"/>
</td></tr>
</table> 

</form>
</div>	
	
<?php
	}		//close for "if clicked on "save" button
}		//close for "if clicked on New Hazard button"
?>


<!-------------------------------When Clicked on "Comment" button (14)-----------------------------------------> 
<!---------------------------------------------------------------------------------------------------------------->
<?php
if ($Clicked_Cross == 'Comment')
{


if (isset($_POST['FMEAData_Submit']))	
	{		
		
		$Comment = $_POST['Comment'];
		$Comment = addslashes($Comment);
	    $CAPA_Info = $_POST['CAPA_Info'];						//need to create at database
		$CAPA_Info = addslashes($CAPA_Info);
		$Complaint_Info = $_POST['Complaint_Info'];			//need to create at database
		$Complaint_Info= addslashes($Complaint_Info);

$FMEA_Query=mysqli_query($con, "UPDATE Risk_FMEA SET
	
Comment	= '$Comment',
CAPA_Info = '$CAPA_Info',
Complaint_Info = '$Complaint_Info'

WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Risk_ID=\"$Risk_ID\"");
	}
else
	{
		
$query_GetCommentRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Risk_ID=\"$Risk_ID\"");
$Comment_Row = mysqli_fetch_array($query_GetCommentRow);
		
$Comment = $Comment_Row['Comment'];
$CAPA_Info = $Comment_Row['CAPA_Info'];
$Complaint_Info = $Comment_Row['Complaint_Info'];
		
?>
<div class="FMEAPopUp_Div" style="width:800px; height:400px;">


<!--------------------display head section (icon, title)------------------------->	
<div>	
<div class='FMEA_PopUp_Head'>
<img src="Images/11394.gif" class='FMEA_PopUp_Head_Image'/>
<span class='FMEA_PopUp_Head_Title'>Comments</span>
</div>

<div ID="PopUp_Window_Owner">
<span class='PopUp_Window_Owner_Title'>Risk ID: <?php echo $Risk_ID;?></span>           
</div>
</div>

<!--------------------display data section (issue, contents)------------------------->
<form name="RdP_NewForm" action="" method="post">
<table class="FMEAPopUp_Table1" style="width:750px" align='center'>
<tr class="NewUser_Table2_DecorationLine">
    	<td width="25%">&nbsp;</td>
    	<td width="75%">&nbsp;</td>   	
</tr>	
	
		
<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">Comments</td>    
    	<td><textarea rows="3" name="Comment" style="width:97%; background-color:#FFF;"><?php echo $Comment;?></textarea></td>
</tr>				
<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">CAPA Info</td>
   		<td><textarea rows="2" name="CAPA_Info" style="width:97%; background-color:#FFF;"><?php echo $CAPA_Info;?></textarea></td>
</tr>
		
<tr class="FMEA_PopUp_Row">	
		<td class="FMEA_PopUp_InputTitle" style="text-indent:0.7em">Customer Complaints</td>
   	    <td><textarea rows="2" name="Complaint_Info" style="width:97%; background-color:#FFF; margin-bottom:10px;"><?php echo $Complaint_Info;?></textarea></td>
</tr>	
			
</table>

<!-------Save button --------->	
<table align='center'>
<tr><td>				
<input type="submit" id="FMEAData_Submit" name="FMEAData_Submit" value="Save" class="Save_Button" style="height:28px; margin-top:10px;"  onClick="Hidden_SubmitButton(this)"/>
</td></tr>
</table> 

</form>
</div>	
	
<?php
	}		//close for "if clicked on "save" button
}		//close for "if clicked on New Hazard button"
?>
<!---------------------------- Popup (not for image popup, for all------------------------------------------------->

<div id="FMEAImage_POP_DW" class="FMEA_PopUPImage_DW">		<!-- Data Window (DW) is a small window to list contents on task popup window, normally disappeared due to display=none -->

    <div id="FMEAImage_POP_Grey">								<!-- a grey zone on the top of pop-up window--> 
    <div id="FMEAImage_POP_CloseSign">[ <a href="javascript:void(0)" style="color:#09C; font-size:12px; font-weight:600; vertical-align:baseline;" onclick="FMEAImage_POP_Close()"> Close <img style='vertical-align:middle;' border='0' src="Images/clear.png" height="16" width="16" /></a> ]</div>														<!-- close button at grey zone-->
    </div>
    
    <iframe id="FMEAImage_POPUPFrame" name="FMEAImage_POPUPFrame" width="100%" src="" ></iframe> <!-- create a 400pxX200px window to show an image height="85%"-->   
</div>  																													<!--width and height control the size to dislay image inside window-->
                          
<div id="FMEAImage_POP_BG" class="FMEA_PopUPImage_BG"></div> 	
											<!-- Back ground(BG) defines a darked roadmap as a background when task popup window display, normally disappeared due to display=none -->
<!-- End Popup -->
<!-----------------------------------------Program closed---------------------------------------------------------> 
<!---------------------------------------------------------------------------------------------------------------->

<?php
mysqli_close ($con);
?>


