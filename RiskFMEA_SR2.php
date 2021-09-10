<?php
session_start(); 
/*$_SESSION["RdPDM_MofT"] = $AUP_Row["RdU_MofT"];*/
/*--succeed to insert data 5/30/2017)*/

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
<meta charset="utf-8">
<link href="CSS/ShowRoom.css" rel="stylesheet" type="text/css" />
<link href="SCRIPTS/easyui.css" rel="stylesheet" type="text/css"  />
<script type="text/javascript" src="SCRIPTS/jquery-1.6.1.min.js"></script>
<script type="text/javascript" src="SCRIPTS/jquery.easyui.min.js"></script>


<title>RDPDM</title>
<style type="text/css">

/*---Global---*/
*{margin:0;padding:0}
	</style>

<script>

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

/*								standard statement for creating a function
function FMEA_Y() {
	if (xmlhttp)
		{
		var f_v =document.getElementById("ABC").value;
		xmlhttp.open('get', 'X_Get_f_v.php?f_v='+f_v);	
		xmlhttp.onreadystatechange = Set_Respond_Value;
		xmlhttp.send(null);
		}
}
*/
	
function Set_Respond_Value() {
	if(xmlhttp.readyState == 4)
	{
	var response = xmlhttp.responseText;
	//alert (response);
	//document.getElementById("ABC").value='response';
	}
}
	
/*
$(function(){
	$('.Task_Individual').draggable({
		revert:true,
		proxy:'move' //'clone'
	});
	

	$('.Task_Individual').droppable({
		accept: '.Task_Individual',
		onDragEnter:function(){
			$(this).addClass('over');
		},
		onDragLeave:function(){
			$(this).removeClass('over');
		},
		onDrop:function(e,source){
			$(this).removeClass('over');
			
			
			$(this).append(source);		
				
			//alert(source.innerHTML);
			//alert(source.style.backgroundColor); //rgb(nnn,nnn,nnn)
			var Task_Abb = source.innerHTML;
			Task_POP_UP(source.innerHTML);
		}
		

	});
						

});
*/
function Hazard_CaseCodePopup(xSource_Link) //after clicked on "submit"/"close" button from Hazard_Popup.php, through this parent link to manage DIVs(DW, BG) visibility: close dark background, display the sorted table in DW.
{			
	document.getElementById("Task_POP_BG").style.display='none'; //darked background window(big)
	document.getElementById("Task_POP_DW").style.display='none'; //Popup sort window (small)
	
	window.open(xSource_Link, "_self");	//refresh RiskFMEA_SR2.php to update column "hazard"
	
}
	
//the reason to take two steps (functions) is to add extra variables (e.g. selected_project) belows	
function FMEA_Popup(RiskID, Cell_Id) 	
{
	Task_POP_UP(RiskID, Cell_Id);
}


function Task_POP_UP(RiskID, Clicked_Cross) //activiate displays of two windows (hidden before), point to new php, send out the variable 
{			
	document.getElementById('Task_POP_DW').style.display='block'; 
	
	if (Clicked_Cross=='Hazard' || Clicked_Cross=='HazardSituation' || Clicked_Cross=='FMHarm')		//Those three popup window have no "close" window
	{
	document.getElementById('Task_POP_CloseSign').style.display='none';	
	}
	
	document.getElementById('Task_POP_BG').style.display='block';
	var Selected_Document = document.getElementById("Document_No").value;
 	var Selected_Revision = document.getElementById("Document_Revision").value;
	var Selected_TaskAbb = document.getElementById("Doc_TaskAbb").value;
	
   document.getElementById("Rd_Task_POPUP").src= "RiskFMEA_Popup.php?Document="+Selected_Document+"&Revision="+Selected_Revision+"&TaskAbb="+Selected_TaskAbb+"&Risk_ID="+RiskID+"&Cross="+Clicked_Cross;
}
	
function Task_POP_Close()			//close the first level popup
{
	document.getElementById('Task_POP_DW').style.display='none'; 
	document.getElementById('Task_POP_BG').style.display='none';
	document.getElementById("Rd_Task_POPUP").src= "";
	window.location.reload();												//refresh windows to show updated severity from database
}

function Select_a_Document()
{
 	var Selected_Document = document.getElementById("Document_No").value;
 	window.open("RiskFMEA_SR2.php?Document="+Selected_Document, "_self"); 
} 
	
function Select_a_Revision()
{
 	var Selected_Document = document.getElementById("Document_No").value;
 	var Selected_Revision = document.getElementById("Document_Revision").value;
	var Selected_TaskAbb = document.getElementById("Doc_TaskAbb").value;
	var Selected_Description = document.getElementById("Doc_Description").value;

 	window.open("RiskFMEA_SR2.php?Document="+Selected_Document+"&Revision="+Selected_Revision+"&TaskAbb="+Selected_TaskAbb+"&Description="+Selected_Description, "_self"); 
} 	

function Add_a_New_Row()
{	
	var Selected_Document = document.getElementById("Document_No").value;
 	var Selected_Revision = document.getElementById("Document_Revision").value;
	var Selected_ChangeNumber = document.getElementById("Change_Number").value;
	//alert(Selected_Project);
	
	var NextRisk_No = document.getElementById("NextRisk_Hidden").value;
	var NextRow = document.getElementById("NextRow").value;
	NextRow = parseInt(NextRow);
	//alert (NextRow);
	document.getElementById("New_Output2_"+NextRow).style.display = "table-row";	//display the row which was non-displayed
	NextRow++;
	
	document.getElementById("NextRow").value = NextRow;
	if (NextRow == 10)
	{alert ('You reach the max rows, please refresh before adding new rows.');}
	if (xmlhttp)
		{
		xmlhttp.open('get', 'RiskFMEA_InsertRiskID.php?DocumentNo='+Selected_Document+'&DocumentRevision='+Selected_Revision+'&ChangeNumber='+Selected_ChangeNumber);	
		xmlhttp.onreadystatechange = Set_Respond_Value;
		xmlhttp.send(null);	
		}
	NextRisk_No++;
	//alert (NextRisk_No);
	document.getElementById("NextRisk_Hidden").value = NextRisk_No;
}
	
			
function Select_a_Sort()
{
	var Selected_Document = document.getElementById("Document_No").value;
 	var Selected_Revision = document.getElementById("Document_Revision").value; 
	var Selected_Sort = document.getElementById("Sort_No").value;
	var Selected_TaskAbb = document.getElementById("Doc_TaskAbb").value;
	var Selected_Description = document.getElementById("Doc_Description").value;

	window.open("RiskFMEA_SR2.php?Document="+Selected_Document+"&Revision="+Selected_Revision+"&Sort="+Selected_Sort+"&TaskAbb="+Selected_TaskAbb+"&Description="+Selected_Description, "_self"); 
}
	
function Select_a_Rank()
{
	var Selected_Document = document.getElementById("Document_No").value;
 	var Selected_Revision = document.getElementById("Document_Revision").value; 
	var Selected_Sort = document.getElementById("Sort_No").value;
	var Selected_Rank = document.getElementById("Rank_No").value;
	var Selected_TaskAbb = document.getElementById("Doc_TaskAbb").value;
	var Selected_Description = document.getElementById("Doc_Description").value;

	window.open("RiskFMEA_SR2.php?Document="+Selected_Document+"&Revision="+Selected_Revision+"&Rank="+Selected_Rank+"&Sort="+Selected_Sort+"&TaskAbb="+Selected_TaskAbb+"&Description="+Selected_Description, "_self"); 
}	
	
function FMEA_Exit()
	{window.open("Home_SR2.php", "_self");}  	
	

function FMEA_Export()
{
	var Selected_Document = document.getElementById("Document_No").value;
 	var Selected_Revision = document.getElementById("Document_Revision").value;
	var Selected_ChangeNumber = document.getElementById("Change_Number").value;
	
	window.open("RiskFMEA_ExportToExcel.php?Document="+Selected_Document+"&Revision="+Selected_Revision); 
	/*
	if (xmlhttp)
		{
		xmlhttp.open('get', 'RiskFMEA_ExportButton.php?Project='+Selected_Project+'&Document='+Selected_Document+'&Revision='+Selected_Revision+'&ChangeNumber='+Selected_ChangeNumber);		
		xmlhttp.onreadystatechange = Set_Respond_Value;   		//does not send to another php file without this sentence     
		xmlhttp.send(null);
		}*/
}
	
function FMEA_Report()
{
	var Selected_Document = document.getElementById("Document_No").value;
 	var Selected_Revision = document.getElementById("Document_Revision").value;
	var Selected_ChangeNumber = document.getElementById("Change_Number").value;
	
	window.open("RiskFMEA_FMEAWord.php?Document="+Selected_Document+"&Revision="+Selected_Revision);
}
	
function FMEA_Save()
{ 

	var SaveButtonClicked = document.getElementById("Form_SaveButton").value;
	var T_FMEAContent = document.getElementById("FMEA_TableContents"); 		//define a table to maintain FMEA Data content (all displayed rows)
	
	var Selected_Document = document.getElementById("Document_No").value;
 	var Selected_Revision = document.getElementById("Document_Revision").value;
	var Selected_ChangeNumber = document.getElementById("Change_Number").value;

												
	//var Selected_P1Pre = [];					//create an array rather than a variable*
	//var Selected_P2Pre = [];
	var Selected_PPre = [];
	var Selected_SPre = [];	
	var Selected_RiskRankPre = [];	
	var Selected_ControlType = [];	
	//var Selected_P1Post = [];	
	//var Selected_P2Post = [];
	var Selected_PPost = [];
	var Selected_SPost = [];	
	var Selected_RiskRankPost = [];
		
	for(var i=3; i<T_FMEAContent.rows.length-1; i++) 	// i defines rows: first row is a decoration line, second and third rows are titles, last row is nondisplay  	
	{
    	var j = i-2;

		var Add_PPre = document.getElementById("PPre_"+j).value;		
		Selected_PPre.push(Add_PPre);
		
		var Add_SPre = document.getElementById("SPre_"+j).value;		
		Selected_SPre.push(Add_SPre);
		
		var Add_RiskRankPre = document.getElementById("RiskRankPre_"+j).value;		
		Selected_RiskRankPre.push(Add_RiskRankPre);
		
		var Add_ControlType = document.getElementById("ControlType_"+j).value;		
		Selected_ControlType.push(Add_ControlType);
		
		
		var Add_P2Post = document.getElementById("PPost_"+j).value;		
		Selected_P2Post.push(Add_P2Post);
		
		var Add_SPost = document.getElementById("SPost_"+j).value;		
		Selected_SPost.push(Add_SPost);
		
		var Add_RiskRankPost = document.getElementById("RiskRankPost_"+j).value;		
		Selected_RiskRankPost.push(Add_RiskRankPost);

	}
	
	if (xmlhttp)
		{
		xmlhttp.open('get', 'RiskFMEA_SaveButton.php?Document='+Selected_Document+'&Revision='+Selected_Revision+'&ChangeNumber='+Selected_ChangeNumber+'&PPre='+Selected_PPre+'&SPre='+Selected_SPre+'&RiskRankPre='+Selected_RiskRankPre+'&ControlType='+Selected_ControlType+'&PPost='+Selected_PPost+'&SPost='+Selected_SPost+'&RiskRankPost='+Selected_RiskRankPost);
		
		xmlhttp.onreadystatechange = Set_Respond_Value;   //does not send to another php file without this sentence     
		xmlhttp.send(null);
		alert("Your data has been successfully saved. Thanks!");
		}	
}


function Calculate_RiskRankingPre(P_Pre, S_Pre)
	{
		if (P_Pre==1 && (S_Pre>=1 && S_Pre<=3))			//for P_Pre=1 case
			{return "A";}
		else if (P_Pre==1 && (S_Pre>=4 && S_Pre<=5))
			{return "B";}
		
		else if (P_Pre==2 && (S_Pre>=1 && S_Pre<=2))		//for P_Pre=2 case
			{return "A";}
		else if (P_Pre==2 && (S_Pre>=3 && S_Pre<=4))		
			{return "B";}
		else if (P_Pre==2 && (S_Pre==5))		
			{return "C";}
		
		else if (P_Pre==3 && (S_Pre==1))				//for P_Pre=3 case
			{return "A";}
		else if (P_Pre==3 && (S_Pre>=2 && S_Pre<=3))		
			{return "B";}
		else if (P_Pre==3 && (S_Pre>=4 && S_Pre<=5))		
			{return "C";}
		
		else if (P_Pre==4 && (S_Pre>=1 && S_Pre<=2))		//for P_Pre=4 case
			{return "B";}
		else if (P_Pre==4 && (S_Pre>=3 && S_Pre<=5))		
			{return "C";}

		else if (P_Pre==5 && (S_Pre==1))				//for P_Pre=5 case
			{return "B";}
		else if (P_Pre==5 && (S_Pre>=2 && S_Pre<=5))		
			{return "C";}	
		else
			{return "N/A";}
	}

function Calculate_RiskRankingPost(P_Post, S_Post)
	{
		if (P_Post==1 && (S_Post>=1 && S_Post<=5))				//for P_Post=1 case
			{return "A";}

		
		else if (P_Post==2 && (S_Post>=1 && S_Post<=4))		    //for P_Post=2 case
			{return "A";}
		else if (P_Post==2 && (S_Post==5))		
			{return "C";}
		
		else if (P_Post==3 && (S_Post>=1 && S_Post<=3))		//for P_Post=3 case
			{return "A";}
		else if (P_Post==3 && (S_Post>=4 && S_Post<=5))		
			{return "C";}
		
		else if (P_Post==4 && (S_Post>=1 && S_Post<=2))		//for P_Post=4 case
			{return "A";}
		else if (P_Post==4 && (S_Post>=3 && S_Post<=5))		
			{return "C";}

		else if (P_Post==5 && (S_Post==1))				//for P_Post=5 case
			{return "A";}
		else if (P_Post==5 && (S_Post>=2 && S_Post<=5))		
			{return "C";}
		else
			{return "N/A";}
	}	
	
	
function Save_SameTime(Risk_ID, Collumn_Id)										//validate inputs and save to database in real time
{																				//8 variables shall be imported to database (6 variables are here)
	var Selected_Document = document.getElementById("Document_No").value;
 	var Selected_Revision = document.getElementById("Document_Revision").value;
	var Selected_ChangeNumber = document.getElementById("Change_Number").value;
	
	
	if (Collumn_Id == "PPre")													//2 variables are obtained below: Selected_Cellsave, riskrank_changed
		{
			var Selected_CellSave = document.getElementById("PPre_"+Risk_ID).value;
			if (Selected_CellSave > 5 || Selected_CellSave < 1)
				{alert("The data out of range [1,5], please check again!");		//after clicked "ok" on popup window, the program execuate the following codes
				//document.getElementById("RiskRankPre_"+Risk_ID).value = "error";
				//var RiskRank_Changed = document.getElementById("RiskRankPre_"+Risk_ID).value;  
				//document.getElementById("RiskRankPre_"+Risk_ID).style.color = "red";
				//document.getElementById("RiskRankPre_"+Risk_ID).style.backgroundColor = "white";
				 
				 //program will assign "error" at risk ranking area and return without save to database
				return false;
				}
			else
				{

			var S = document.getElementById("SPre_"+Risk_ID).value;			
			var RiskRank_Changed = Calculate_RiskRankingPre(Selected_CellSave, S);	
			document.getElementById("RiskRankPre_"+Risk_ID).value = RiskRank_Changed;
			
			if (RiskRank_Changed == "C")
				{document.getElementById("RiskRankPre_"+Risk_ID).style.backgroundColor = "pink";}
			else if (RiskRank_Changed == "B")
				{document.getElementById("RiskRankPre_"+Risk_ID).style.backgroundColor = "yellow";}
			else 
				{document.getElementById("RiskRankPre_"+Risk_ID).style.backgroundColor = "white";}
				}
		}
	
	else if (Collumn_Id == "SPre")	
		{
			var Selected_CellSave = document.getElementById("SPre_"+Risk_ID).value;
			if (Selected_CellSave > 5 || Selected_CellSave < 1)
				{alert("The data out of range [1,5], please check again!");		//after clicked "ok" on popup window, the program execuate the following codes
																	//program will not execuate the following codes
				document.getElementById("RiskRankPre_"+Risk_ID).value = "error";
				var RiskRank_Changed = document.getElementById("RiskRankPre_"+Risk_ID).value;  
				document.getElementById("RiskRankPre_"+Risk_ID).style.color = "red";
				document.getElementById("RiskRankPre_"+Risk_ID).style.backgroundColor = "white";
				return false; 		 
				}
			else
				{
			
			var PPre = document.getElementById("PPre_"+Risk_ID).value;
			var RiskRank_Changed = Calculate_RiskRankingPre(PPre, Selected_CellSave);
			document.getElementById("RiskRankPre_"+Risk_ID).value = RiskRank_Changed;
				}
			
			if (RiskRank_Changed == "C")
				{document.getElementById("RiskRankPre_"+Risk_ID).style.backgroundColor = "pink";}
			else if (RiskRank_Changed == "B")
				{document.getElementById("RiskRankPre_"+Risk_ID).style.backgroundColor = "yellow";}
			else 
				{document.getElementById("RiskRankPre_"+Risk_ID).style.backgroundColor = "white";}
		}
	
	
	else if (Collumn_Id == "ControlType")	
		{var Selected_CellSave = document.getElementById("ControlType_"+Risk_ID).value;}
	
	else if (Collumn_Id == "PPost")	
		{
			var Selected_CellSave = document.getElementById("PPost_"+Risk_ID).value;
			if (Selected_CellSave > 5 || Selected_CellSave < 1)
				{alert("The data out of range [1,5], please check again!");		//after clicked "ok" on popup window, the program execuate the following codes
				return false;}
			
			if (document.getElementById("PPre_"+Risk_ID).value < document.getElementById("PPost_"+Risk_ID).value)	//catch user error to have increased occurrence of harm
				{alert("The occurrence of Harm shall not be increased after mitigation, please check your input!");		
				return false;}
			
			var S = document.getElementById("SPost_"+Risk_ID).value;			
			var RiskRank_Changed = Calculate_RiskRankingPost(Selected_CellSave, S);	
			document.getElementById("RiskRankPost_"+Risk_ID).value = RiskRank_Changed;
			
			if (RiskRank_Changed == "C")
				{document.getElementById("RiskRankPost_"+Risk_ID).style.backgroundColor = "pink";}
			else if (RiskRank_Changed == "B")
				{document.getElementById("RiskRankPre_"+Risk_ID).style.backgroundColor = "yellow";}
			else 
				{document.getElementById("RiskRankPost_"+Risk_ID).style.backgroundColor = "white";}
		}
		
	else if (Collumn_Id == "SPost")	
		{
			var Selected_CellSave = document.getElementById("SPost_"+Risk_ID).value;	//catch user error when input is out of spec [1,5]
			if (Selected_CellSave > 5 || Selected_CellSave < 1)
				{alert("The data out of range [1,5], please check again!");
				 return false;}	
			
			if (document.getElementById("SPre_"+Risk_ID).value < document.getElementById("SPost_"+Risk_ID).value)	//catch user error to have increased severity of harm
				{alert("The severity of harm shall not be increased after mitigation, please check your input!");		
				return false;}		
			
			var PPost = document.getElementById("PPost_"+Risk_ID).value;
			var RiskRank_Changed = Calculate_RiskRankingPost(PPost, Selected_CellSave);
			document.getElementById("RiskRankPost_"+Risk_ID).value = RiskRank_Changed;
			
			if (RiskRank_Changed == "C")
				{document.getElementById("RiskRankPost_"+Risk_ID).style.backgroundColor = "pink";}
			else if (RiskRank_Changed == "B")
				{document.getElementById("RiskRankPre_"+Risk_ID).style.backgroundColor = "yellow";}
			else 
				{document.getElementById("RiskRankPost_"+Risk_ID).style.backgroundColor = "white";}
		}
	
	
	if (xmlhttp)
		{
		xmlhttp.open('get', 'RiskFMEA_SaveSameTime.php?Document='+Selected_Document+'&Revision='+Selected_Revision+'&ChangeNumber='+Selected_ChangeNumber+"&RiskID="+Risk_ID+"&CollumnId="+Collumn_Id+"&CellSave="+Selected_CellSave+"&RiskRank="+RiskRank_Changed);
		
			
		xmlhttp.onreadystatechange = Set_Respond_Value;   		//does not send to another php file without this sentence     
		xmlhttp.send(null);
		}
}	

	
function Goto_Pages()											//input a page number, and click on the green arrow, program will turn to this page
{
	var Page_Limit = 15;
	var nPages= document.getElementById('Goto_Page').value;
	var nStart=(nPages-1)*Page_Limit;							//nStart is the row before the first row of the destination page
	//alert(nStart);
	var Selected_Document = document.getElementById("Document_No").value;
 	var Selected_Revision = document.getElementById("Document_Revision").value; 
	var Selected_Sort = document.getElementById("Sort_No").value;
	var Selected_Rank = document.getElementById("Rank_No").value;
	var Selected_NumTotal = document.getElementById("Num_Total").value;

	window.open("RiskFMEA_SR2.php?Document="+Selected_Document+"&Revision="+Selected_Revision+"&Rank="+Selected_Rank+"&Sort="+Selected_Sort+"&Rec_Start="+nStart+"&Num_Total="+Selected_NumTotal, '_self'); 
}
	
function Turn_Pages(TPage)						//click on one of four arrow icons, turn to first/last/next/previous page
{
	var Page_Limit = 15;
	var nStart = TPage;							//nStart is the row before the first row of the destination page
	//alert(nStart);
	var Selected_Document = document.getElementById("Document_No").value;
 	var Selected_Revision = document.getElementById("Document_Revision").value; 
	var Selected_Sort = document.getElementById("Sort_No").value;
	var Selected_Rank = document.getElementById("Rank_No").value;
	var Selected_NumTotal = document.getElementById("Num_Total").value;

	window.open("RiskFMEA_SR2.php?Document="+Selected_Document+"&Revision="+Selected_Revision+"&Rank="+Selected_Rank+"&Sort="+Selected_Sort+"&Rec_Start="+nStart+"&Num_Total="+Selected_NumTotal, '_self'); 
}	
				
</script>
</head>


<body>
<?php
//$Output_Doc_Description = = $_REQUEST['Description'];   //for showing the FMEA title on the first row
$Document_No = $_REQUEST['Document'];
$Document_Revision = $_REQUEST['Revision'];
$Task_Abb = $_REQUEST['TaskAbb'];	
$Output_Doc_Description = $_REQUEST['Description'];
$Sort_No = $_REQUEST['Sort'];
$Rank_No = $_REQUEST['Rank'];
$Rec_Start = $_REQUEST['Rec_Start'];
$Num_Total = $_REQUEST['Num_Total'];	
	
//echo $Token_RiskID = $_REQUEST['Token_RiskID'];	//pass from Hzard_popup.php for tracing changes from code icon
//echo $Token = $_REQUEST['Token'];		
	
	
include "Showroom_DB.php";
	
function Calculate_RiskRankingPre($P_Pre, $S_Pre)
	{
		if ($P_Pre==1 && ($S_Pre>=1 && $S_Pre<=3))			//for P_Pre=1 case
			{return "A";}
		else if ($P_Pre==1 && ($S_Pre>=4 && $S_Pre<=5))
			{return "B";}
		
		else if ($P_Pre==2 && ($S_Pre>=1 && $S_Pre<=2))		//for P_Pre=2 case
			{return "A";}
		else if ($P_Pre==2 && ($S_Pre>=3 && $S_Pre<=4))		
			{return "B";}
		else if ($P_Pre==2 && ($S_Pre==5))		
			{return "C";}
		
		else if ($P_Pre==3 && ($S_Pre==1))				//for P_Pre=3 case
			{return "A";}
		else if ($P_Pre==3 && ($S_Pre>=2 && $S_Pre<=3))		
			{return "B";}
		else if ($P_Pre==3 && ($S_Pre>=4 && $S_Pre<=5))		
			{return "C";}
		
		else if ($P_Pre==4 && ($S_Pre>=1 && $S_Pre<=2))		//for P_Pre=4 case
			{return "B";}
		else if ($P_Pre==4 && ($S_Pre>=3 && $S_Pre<=5))		
			{return "C";}

		else if ($P_Pre==5 && ($S_Pre==1))				//for P_Pre=5 case
			{return "B";}
		else if ($P_Pre==5 && ($S_Pre>=2 && $S_Pre<=5))		
			{return "C";}	
		else
			{return "N/A";}
	}
	
function Calculate_RiskRankingPost($P_Post, $S_Post)
	{
		if ($P_Post==1 && ($S_Post>=1 && $S_Post<=5))				//for P_Post=1 case
			{return "A";}
		
		else if ($P_Post==2 && ($S_Post>=1 && $S_Post<=4))		    //for P_Post=2 case
			{return "A";}
		else if ($P_Post==2 && ($S_Post==5))		
			{return "C";}
		
		else if ($P_Post==3 && ($S_Post>=1 && $S_Post<=3))		//for P_Post=3 case
			{return "A";}
		else if ($P_Post==3 && ($S_Post>=4 && $S_Post<=5))		
			{return "C";}
		
		else if ($P_Post==4 && ($S_Post>=1 && $S_Post<=2))		//for P_Post=4 case
			{return "A";}
		else if ($P_Post==4 && ($S_Post>=3 && $S_Post<=5))		
			{return "C";}

		else if ($P_Post==5 && ($S_Post==1))				//for P_Post=5 case
			{return "A";}
		else if ($P_Post==5 && ($S_Post>=2 && $S_Post<=5))		
			{return "C";}
		else
			{return "N/A";}
	}
	
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
?>


<!--------------------------------------------------------------------------------------------------------------------------------->        
<!--------------------------------Part 1: Disply FMEA Headings and table heads-----------------------------------------------------> 
<!---------------------------------------------------------------------------------------------------------------------------------> 

<div class="FMEA_Container">		<!--width 1315px-->
<!--------Table 1: Heads (FMEA worksheet, project_ID, Project_Name, Revision, Logo, Button-------------------------------->
<table class="FMEA_HeadTable"> 
            	<tr style="line-height:3px;">
                <td width="4.5%">&nbsp;</td>
                <td width="4.5%">&nbsp;</td>
                <td width="4.5%">&nbsp;</td>
                <td width="4.5%">&nbsp;</td>
                <td width="4.5%">&nbsp;</td>
                <td width="4.5%">&nbsp;</td>
                <td width="4.5%">&nbsp;</td>
                <td width="4.5%">&nbsp;</td>
                <td width="4.5%">&nbsp;</td>
                <td width="4.5%">&nbsp;</td>
                <td width="4.5%">&nbsp;</td>
                <td width="4.5%">&nbsp;</td>
                <td width="4.5%">&nbsp;</td>
                <td width="4.5%">&nbsp;</td>
                <td width="4.5%">&nbsp;</td>
                <td width="4.5%">&nbsp;</td>
                <td width="4.5%">&nbsp;</td>
                <td width="4.5%">&nbsp;</td>
                <td width="4.5%">&nbsp;</td>
                <td width="4.5%">&nbsp;</td>
                <td width="4.5%">&nbsp;</td>
                <td width="4.5%">&nbsp;</td>             		      		
            </tr>
            

<tr class="FMEA_FirstBlank"><td colspan="22">&nbsp;</td></tr>

<tr style="line-height:26px">
    <td colspan="2" style="text-align: left;">
		<span><img src="Images/Roadmap_Icon1.png" class="FMEA_HeadTable_Image" /></span></td>
   
<?php
   if ($Task_Abb=="")
   { 
    echo '<td colspan="20" class="FMEA_HeadTable_Title" align="center;" style="padding-right:120px;">FMEA Worksheet</td>';
   }
	else
	{
?>
	<td colspan="20" class="FMEA_HeadTable_Title" align="center;" style="padding-right:120px;"><?php echo $Output_Doc_Description;?></td>	
<?php
	}	   
?>
</tr>   
	

 <!------------------------FMEA Document Number selection -------------------------------------------->
<?php 
	
	
$query_GetDocumentName = mysqli_query($con, "SELECT DISTINCT (Document_No) FROM DocumentReview_Approval WHERE Task_Abb LIKE '%FMEA'");	//Market_Status='Post Market' can not be used here since one doc may have multiple versions, some pre-market doc, some many post-market docs.														

$Document_Num = mysqli_num_rows($query_GetDocumentName);
for ($i=0; $i<$Document_Num; $i++)
	{
	$Document_Row = mysqli_fetch_array($query_GetDocumentName);
	$Document_Nos[$i] = $Document_Row['Document_No'];			//create a new array to store all project documents
	//$Document_Desc[$i] = $Document_Row['Output_Doc_Description'];
	//$DocNos_Desc[$i] = $Document_Nos[$i].$Document_Desc[$i];	
	}
?>

<tr style="line-height:9px; font-size:10px;">
	<td colspan="18">&nbsp;</td>
		<td colspan="1" style="text-align:right;">Document:</td>
		<td colspan="3">
		<Select ID="Document_No" name="Document_No" style="width:99%; font:10px; text-align:left;" OnChange="Select_a_Document()">		
<?php
$Operation = 'Document';
$Operation_Title = 'Select a Document';
$Operation_Ary_Desc = $Document_Nos;				//use for display $Document_Nos
$Operation_Ary_Value = $Document_Nos;				//use for variables	$Document_Nos
Select_ButtonOption($Operation, $Operation_Title, $Operation_Ary_Desc, $Operation_Ary_Value);	
?>
		</select>	 			<!--function ending point---->
	</td>
</tr>

<!----------------FMEA Document version Selected -(version data taken from above--------------------->
<?php
	
													//each Project_ID takes only one row in table Project_Info
$query_GetDocVersionNo = mysqli_query($con, "SELECT * FROM DocumentReview_Approval WHERE Document_No=\"$Document_No\" AND Document_Status !='Expired'");			
$DocumentVersionNo_Num = mysqli_num_rows($query_GetDocVersionNo);
for ($i=0; $i<$DocumentVersionNo_Num; $i++)
	{
	$DocVersion_Row = mysqli_fetch_array($query_GetDocVersionNo);
	$Document_Revisions[$i] = $DocVersion_Row['Document_Revision'];		
	}
	
//derive the task_abb and description to change the title by taking the first rocord in the table	
$query_GetDocVersionNo = mysqli_query($con, "SELECT * FROM DocumentReview_Approval WHERE Document_No=\"$Document_No\" ORDER BY Document_Revision DESC LIMIT 1");		
$DocVersion_Row = mysqli_fetch_array($query_GetDocVersionNo);
$Task_Abb = $DocVersion_Row['Task_Abb'];
$Output_Doc_Description = $DocVersion_Row['Output_Doc_Description'];	
?>

<input type="hidden" id="Doc_TaskAbb" name="Doc_TaskAbb" value="<?php echo $Task_Abb;?>" />
<input type="hidden" id="Doc_Description" name="Doc_Description" value="<?php echo $Output_Doc_Description;?>" />
	 
<tr style="line-height:9px; font-size:10px;">	
<td colspan="18">&nbsp;</td>
<td colspan="1" style="text-align:right;">Revision:</td>
<td colspan="3">
<Select ID="Document_Revision" name="Document_Revision" style="width:99%; font:10px; text-align:left;" OnChange="Select_a_Revision()">		
<?php
$Operation = 'Revision'; 
$Operation_Title = 'Select a Revision';
$Operation_Ary_Desc = $Document_Revisions;				//use for display
$Operation_Ary_Value = $Document_Revisions;				//use for variables	
Select_ButtonOption($Operation, $Operation_Title, $Operation_Ary_Desc, $Operation_Ary_Value);	
?>
</select>	 			<!--function ending point---->
</td>
</tr>

<!----------------auto display "Market status" pre-makret/post market --------------------->
		
<?php	
$query_GetRegTitle = mysqli_query($con, "SELECT * FROM DocumentReview_Approval WHERE Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\"");
$RegTitle_Row = mysqli_fetch_array($query_GetRegTitle);
$Market_Status = $RegTitle_Row['Market_Status'];
$Change_Number = $RegTitle_Row['Change_Number'];	
?> 
<input type="hidden" id="Change_Number"	name="Change_Number" value="<?php echo $Change_Number;?>"/> 

<tr style="line-height:9px; font-size:10px;">	
<td colspan="17">&nbsp;</td>
<td colspan="2" style="text-align:right;">Market Status:</td>
<td colspan="3" style="padding-left:0.6em; padding-top:4px; padding-bottom:4px; width:88%; height:14px; border:solid black 1px; text-align:left; font-size:13px;"><?php echo $Market_Status;?></td>
</tr> 						
	
<!-----------------------set a button "Add new row", set button "sort", set button "order"----------------------->	

<tr style="line-height:9px; font-size:10px;">
	<td colspan="2" style="text-align:left; color:red;"><input type="button" value="Add a New Row" style="color:red; width:92%;" onClick="Add_a_New_Row()"/></td>
	
	<td colspan="2" style="text-align:right; font-size:16px; font-weight:500;">Sort</td>
	<td colspan="2" style="text-align:left;">
		<Select ID="Sort_No" name="Sort_No" style="width:98%; font:10px; text-align:left; margin-left:8px;" OnChange="Select_a_Sort()">		
<?php
$Operation = 'Sort';
$Operation_Title = 'Select a Sort';
$Operation_Ary_Desc = array('All Table', 'C Risk(Pre)', 'C Risk(Post)','Verification Fail', 'RBA Fail', 'New Hazards');					//use for display
$Operation_Ary_Value = array('All', 'RiskRank_Pre', 'RiskRank_Post','Verification_Result', 'RBA_Result', 'NewHazard_Result');								//use for variables	
Select_ButtonOption($Operation, $Operation_Title, $Operation_Ary_Desc, $Operation_Ary_Value);	
?>
		</select>	 			
	</td>
	
	
	<td colspan="2" style="text-align:right; font-size:16px; font-weight:500;">Rank</td>
	<td colspan="2" style="text-align:left;">
		<Select ID="Rank_No" name="Rank_No" style="width:98%; font:10px; text-align:left; margin-left:6px;" OnChange="Select_a_Rank()">		
<?php
$Operation = 'Rank';
$Operation_Title = 'Select a Rank';
$Operation_Ary_Desc = array('Risk ID', 'High Risk(Pre)', 'High Risk(Post)');				        //use for display
$Operation_Ary_Value = array('Risk_ID','RiskRank_Pre', 'RiskRank_Post');								//use for variables	
Select_ButtonOption($Operation, $Operation_Title, $Operation_Ary_Desc, $Operation_Ary_Value);	
?>
		</select>	 			
	</td>
	

	<td colspan="12">&nbsp;</td>					
</tr>
</table>
  

<!----------Table 2 Table First level titles (description, risk analysis, estimation, iso 14385) ---------------------------------->
 <table ID="FMEA_TableContents">
 	<tr style="line-height:1px;">
                <td width="4.5%">&nbsp;</td>	<!--Description 4-->
                <td width="4.5%">&nbsp;</td>
                <td width="4.5%">&nbsp;</td>
                <td width="4.5%">&nbsp;</td>
                <td width="4.5%">&nbsp;</td>	<!--risk analysis 5-->
                <td width="4.5%">&nbsp;</td>
                <td width="4.5%">&nbsp;</td>
                <td width="4.5%">&nbsp;</td>
                <td width="4.5%">&nbsp;</td>
                <td width="2.3%">&nbsp;</td>	<!--risk evaluation pre 5-->
                <td width="2.3%">&nbsp;</td>
                <td width="2.3%">&nbsp;</td>
                <td width="2.3%">&nbsp;</td>
                <td width="4.5%">&nbsp;</td>
                <td width="4.5%">&nbsp;</td>	<!--risk control 4-->
                <td width="4.5%">&nbsp;</td>
                <td width="4.5%">&nbsp;</td>
                <td width="4.5%">&nbsp;</td>
                <td width="2.3%">&nbsp;</td>	<!--risk evaluation post 5-->
                <td width="2.3%">&nbsp;</td>
                <td width="2.3%">&nbsp;</td>
                <td width="2.3%">&nbsp;</td> 
                <td width="4.5%">&nbsp;</td>
                <td width="4.5%">&nbsp;</td>	<!--risk benefit 1-->
                <td width="4.5%">&nbsp;</td>	<!--New failure mode 1-->
   		        <td width="4.5%">&nbsp;</td>   	<!--comment 1-->  		
 	</tr>
 	
 	<tr style="font-size:13px; text-align:center;">
        <td colspan="4" style="background-color: white;  border:solid #000000 1px;">Identification</td>
        <td colspan="5" style="background-color:#F1AFB0; border:solid #000000 1px;">Risk Analysis</td> 
        <td colspan="5" style="background-color:#CD761F; border:solid #000000 1px;">Initial Risk Estimation & Evaluation (Pre)</td>
        <td colspan="4" style="background-color:#8BB9EF; border:solid #000000 1px;">Risk Controls</td>  
        <td colspan="5" style="background-color:#F1D6A9; border:solid #000000 1px;">Final Risk Estimation & Evaluation (Post)</td>
        <td colspan="1" style="background-color:#36970E; border:solid #000000 1px;">RBA</td>  
        <td colspan="1" style="background-color:#E3B8F3; border:solid #000000 1px;">New Hazards</td> 
        <td colspan="1" style="background-color:#E3B8F3; border:solid #000000 1px;">Comments</td> 
     </tr>
       
      <tr style="font-size:11px; text-align:center; background-color:#C3BABA;">
		<td class="FMEA_CellBorder">Risk ID</td>       
        <td class="FMEA_CellBorder">Function</td>   <!-- Description-->
        <td class="FMEA_CellBorder">Model Affected</td>       
        <td class="FMEA_CellBorder">Documents</td> 
        
       	<td class="FMEA_CellBorder">Failure Mode</td>       
        <td class="FMEA_CellBorder">Failure Cause</td>
        <td class="FMEA_CellBorder">Hazard</td>
        <td class="FMEA_CellBorder">Hazardous Situations</td>        
        <td class="FMEA_CellBorder">Harm to Patients</td> 
          
       	<td class="FMEA_CellBorder">S</td>
       	<td class="FMEA_CellBorder">P1</td>       
        <td class="FMEA_CellBorder">P2</td>
        <td class="FMEA_CellBorder">P</td>              
        <td class="FMEA_CellBorder">Risk Ranking</td> 
           
        <td class="FMEA_CellBorder">Current Controls</td>       
        <td class="FMEA_CellBorder">Recommended Mitigations</td>
        <td class="FMEA_CellBorder">Types of Controls</td>       
        <td class="FMEA_CellBorder">Verification & Effective Check</td> 
        
        <td class="FMEA_CellBorder">S</td>
       	<td class="FMEA_CellBorder">P1</td>       
        <td class="FMEA_CellBorder">P2</td>
        <td class="FMEA_CellBorder">P</td>      
        <td class="FMEA_CellBorder">Risk Ranking</td> 
		  
       	<td class="FMEA_CellBorder">Risk Benefit Analysis</td> 
       	<td class="FMEA_CellBorder">or New Failure Modes</td>      
        <td style="border-bottom:solid #000000 1px;">Comments</td>
	 </tr>   
         
<!--------------------------------------------------------------------------------------------------------------------------------->        
<!--------------------------------Part 2: Disply all existing risk rows from database----------------------------------------------> 
<!---------------------------------------------------------------------------------------------------------------------------------> 																
																	<!---------------extract data from databse--->																					
<?php
	 
if (empty($Rec_Start))
	{
	$Rec_Start = 0; 															//use to record the current page (through Javascript)
	}
																						//prepare all variables for outputs
$Page_Limit = 15; 																//15 rows per page

	 
	 
if ($Sort_No=="All" || $Sort_No=="")
{
	$query_TotalRiskRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\"");
	$Num_Total = mysqli_num_rows($query_TotalRiskRow);
	
	
	if($Rank_No=="Risk_ID" || $Rank_No=="")
	{$query_GetRiskRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" ORDER BY Risk_ID ASC LIMIT 15 OFFSET $Rec_Start");}	
	else if($Rank_No=="RiskRank_Pre")
	{$query_GetRiskRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\"  ORDER BY RiskRank_Pre DESC LIMIT 15 OFFSET $Rec_Start");}
	else if($Rank_No=="RiskRank_Post")
	{$query_GetRiskRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\"  ORDER BY RiskRank_Post DESC LIMIT 15 OFFSET $Rec_Start");}
}
		
else if	($Sort_No=="RiskRank_Pre")
{
	
	$query_TotalRiskRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND RiskRank_Pre='C'");
	$Num_Total = mysqli_num_rows($query_TotalRiskRow);
	
	
	if($Rank_No=="Risk_ID" || $Rank_No=="RiskRank_Pre" || $Rank_No=="")
    {$query_GetRiskRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND RiskRank_Pre='C' ORDER BY Risk_ID ASC LIMIT 15 OFFSET $Rec_Start");}
	else if($Rank_No=="RiskRank_Post")
    {$query_GetRiskRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND RiskRank_Pre='C' ORDER BY RiskRank_Post DESC LIMIT 15 OFFSET $Rec_Start");} 
}
	 				
else if ($Sort_No=="RiskRank_Post")
{
	
	$query_TotalRiskRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND RiskRank_Post='C'");
	$Num_Total = mysqli_num_rows($query_TotalRiskRow);
	
	
	if($Rank_No=="Risk_ID" || $Rank_No=="RiskRank_Post" || $Rank_No=="")
    {$query_GetRiskRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND RiskRank_Post='C' ORDER BY Risk_ID ASC LIMIT 15 OFFSET $Rec_Start");}
	else if($Rank_No=="RiskRank_Pre")
    {$query_GetRiskRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND RiskRank_Post='C' ORDER BY RiskRank_Pre DESC LIMIT 15 OFFSET $Rec_Start");}
}
	 
else if ($Sort_No=="Verification_Result")
{
	
	$query_TotalRiskRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Verification_Result='Fail'");
	$Num_Total = mysqli_num_rows($query_TotalRiskRow);
	
	
	if($Rank_No=="Risk_ID" || $Rank_No=="RiskRank_Pre" || $Rank_No=="")
    {$query_GetRiskRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Verification_Result='Fail' ORDER BY Risk_ID ASC LIMIT 15 OFFSET $Rec_Start");}
	else if($Rank_No=="RiskRank_Post")
    {$query_GetRiskRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Verification_Result='Fail' ORDER BY RiskRank_Post DESC LIMIT 15 OFFSET $Rec_Start");}
}

else if ($Sort_No=="RBA_Result")
{
	
	$query_TotalRiskRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND RBA_Result='Fail'");
	$Num_Total = mysqli_num_rows($query_TotalRiskRow);
	
	
	if($Rank_No=="Risk_ID" || $Rank_No=="RiskRank_Pre" || $Rank_No=="")
    {$query_GetRiskRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND RBA_Result='Fail' ORDER BY Risk_ID ASC LIMIT 15 OFFSET $Rec_Start");}
	else if($Rank_No=="RiskRank_Post")
    {$query_GetRiskRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND RBA_Result='Fail' ORDER BY RiskRank_Post DESC LIMIT 15 OFFSET $Rec_Start");}
}	
	 
else if ($Sort_No=="NewHazard_Result")
{
	
	$query_TotalRiskRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND NewHazard_Result='Yes'");
	$Num_Total = mysqli_num_rows($query_TotalRiskRow);
	
	
	if($Rank_No=="Risk_ID" || $Rank_No=="RiskRank_Pre" || $Rank_No=="")
    {$query_GetRiskRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND NewHazard_Result='Yes' ORDER BY Risk_ID ASC LIMIT 15 OFFSET $Rec_Start");}
	else if($Rank_No=="RiskRank_Post")
    {$query_GetRiskRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND NewHazard_Result='Yes' ORDER BY RiskRank_Post DESC LIMIT 15 OFFSET $Rec_Start");}
}	
	 
$Sorted_Num = mysqli_num_rows($query_GetRiskRow);		//$Sorted_Num =< 15
		
?>
<input type="hidden" id="Num_Total" name="Num_Total" value="<?php echo $Num_Total;?>"/>
<?php	
for ($RiskID=$Rec_Start+1; $RiskID<$Rec_Start+$Sorted_Num+1; $RiskID++)		
														//$Rec_Start+1: starting riskID number for the current page
														//$RiskID means the sequenctial of sorted risks, random number
	{
		
	$Risk_Row = mysqli_fetch_array($query_GetRiskRow);
	$Change_Number = $Risk_Row['Change_Number'];	
		
$Risk_ID[$RiskID] = $Risk_Row['Risk_ID']; 				    //$Risk_ID is a fixed number for each failure mode (row)
$Risk_Indicator = $Risk_ID[$RiskID];						//$Risk_Indicator is for the fixed actual risk No.(transfer to clicked button) 
$Document_No[$RiskID] = $Risk_Row['Document_No'];
$Document_Revision[$RiskID] = $Risk_Row['Document_Revision'];	
$Change_Number[$RiskID] = $Risk_Row['Change_Number'];
		
$Description[$RiskID] = $Risk_Row['Description'];		
$Level[$RiskID] = $Risk_Row['Level'];
$Operation[$RiskID] = $Risk_Row['Operation'];
$Requirement[$RiskID] = $Risk_Row['Requirement'];	
$Specification[$RiskID] = $Risk_Row['Specification'];				
$Desc_Image[$RiskID] = $Risk_Row['Desc_Image'];
$Model[$RiskID] = $Risk_Row['Model'];	
$Document[$RiskID] = $Risk_Row['Desc_Document'];		
		
$FailureMode[$RiskID] = $Risk_Row['Failure_Mode'];
$FailureMode_Image[$RiskID] = $Risk_Row['FailureMode_Image'];			
$Failure_Cause[$RiskID] = $Risk_Row['Failure_Cause'];		
$Problem_Category[$RiskID] = $Risk_Row['Problem_Category'];	
$Sub_Category[$RiskID] = $Risk_Row['Sub_Category'];		
$Hazard[$RiskID] = $Risk_Row['Hazard'];	
$Hazard_Desc[$RiskID] = $Risk_Row['Hazard_Desc'];
$FDA_Code[$RiskID] = $Risk_Row['FDA_Code'];	
$NCI_Code[$RiskID] = $Risk_Row['NCI_Code'];
$Hazard_Situation[$RiskID] = $Risk_Row['Hazard_Situation'];	
$HS_Definition[$RiskID] = $Risk_Row['HS_Definition'];	
$Harm[$RiskID] = $Risk_Row['Harm'];
$Harm_Severity[$RiskID] = $Risk_Row['Harm_Severity'];
$Harm_Intervention[$RiskID] = $Risk_Row['Harm_Intervention'];
		
$P1_Pre[$RiskID] = $Risk_Row['P1_Pre'];	
$P2_Pre[$RiskID] = $Risk_Row['P2_Pre'];
$P_Pre[$RiskID] = $Risk_Row['P_Pre'];
$S_Pre[$RiskID] = $Risk_Row['S_Pre'];	
//$RiskRank_Pre[$RiskID] = $Risk_Row['RiskRank_Pre'];
$RiskRank_Pre[$RiskID] = Calculate_RiskRankingPre($P_Pre[$RiskID], $S_Pre[$RiskID]);	
		//variable is calculated in real time rather than extracted from database to deal with severity level changes
		
$CurrentControl_Design[$RiskID] =$Risk_Row['CurrentControl_Design'];		
$CurrentControl_Process[$RiskID] = $Risk_Row['CurrentControl_Process'];
$CurrentControl_Info[$RiskID] = $Risk_Row['CurrentControl_Info'];	
$MitigationAction_Design[$RiskID] = $Risk_Row['MitigationAction_Design'];
$MitigationAction_Process[$RiskID] = $Risk_Row['MitigationAction_Process'];	
$MitigationAction_Info[$RiskID] = $Risk_Row['MitigationAction_Info'];
$MitigationAction_Image[$RiskID] = $Risk_Row['MitigationAction_Image'];	
$MitigationAction_Index[$RiskID] = $Risk_Row['MitigationAction_Index'];
$Control_Type[$RiskID] = $Risk_Row['Control_Type'];		
$Verification_Check[$RiskID] = $Risk_Row['Verification_Check'];
$Effectiveness_Check[$RiskID] = $Risk_Row['Effectiveness_Check'];
$Verification_Result[$RiskID] = $Risk_Row['Verification_Result'];
		
$P1_Post[$RiskID] = $Risk_Row['P1_Post'];	
$P2_Post[$RiskID] = $Risk_Row['P2_Post'];
$P_Post[$RiskID] = $Risk_Row['P_Post'];
$S_Post[$RiskID] = $Risk_Row['S_Post'];	
//$RiskRank_Post[$RiskID] = $Risk_Row['RiskRank_Post'];
$RiskRank_Post[$RiskID] = Calculate_RiskRankingPost($P_Post[$RiskID], $S_Post[$RiskID]);
		
$RBA_Statement[$RiskID] = $Risk_Row['RBA_Statement'];
$RBA_Result[$RiskID] = ['RBA_Result'];	
$NewHazard_Statement[$RiskID] = $Risk_Row['NewHazard_Statement'];	
$NewHazard_Result[$RiskID] = $Risk_Row['NewHazard_Result'];					
$Comment[$RiskID] = $Risk_Row['Comment'];	
$CAPA_Info[$RiskID] = $Risk_Row['CAPA_Info'];
$Complaint_Info[$RiskID] = $Risk_Row['Complaint_Info'];
$Update_Name[$RiskID] = $Risk_Row['Update_Name'];
$Update_Date[$RiskID] = $Risk_Row['Update_Date'];	
		
?>
																		<!---------------display on screen--->
<tr id="New_Output_<?php echo $RiskID;?>" align="center" style="padding-bottom:3px;">

	<td class="FMEA_CellBorder">
   		<input type="number" name="Risk_ID" value="<?php echo $Risk_ID[$RiskID];?>" class="FMEA_CellInput" readonly/></td>
   		
   	<td class="FMEA_CellBorder">
    <input type="button" name="Description" value=" &nbsp;" class="FMEA_CellCross" title="<?php echo $Description[$RiskID];?>" onClick="FMEA_Popup('<?php echo $Risk_Indicator;?>','Description')"/></td> 	
    
    <td class="FMEA_CellBorder">
    <input type="button" name="Model" value=" &nbsp;" class="FMEA_CellCross" title="<?php echo $Model[$RiskID];?>" onClick="FMEA_Popup('<?php echo $Risk_Indicator;?>','Model')"/></td> 
    
    <td class="FMEA_CellBorder">
    <input type="button" name="Document" value=" &nbsp;" class="FMEA_CellCross" title="<?php echo $Document[$RiskID];?>" onClick="FMEA_Popup('<?php echo $Risk_Indicator;?>','Desc_Document')"/></td> 
        
    <td class="FMEA_CellBorder">
    <input type="button" name="FailureMode" value=" &nbsp;" class="FMEA_CellCross" title="<?php echo $FailureMode[$RiskID];?>" onClick="FMEA_Popup('<?php echo $Risk_Indicator;?>','FailureMode')"/></td>
    
    <td class="FMEA_CellBorder">
     <input type="button" name="FMCause" value=" &nbsp;" class="FMEA_CellCross" title="<?php echo $Failure_Cause[$RiskID];?>" onClick="FMEA_Popup('<?php echo $Risk_Indicator;?>','FMCause')"/></td>
     
    <td class="FMEA_CellBorder">
     <input type="button" name="Hazard" value=" &nbsp;" class="FMEA_CellCross" title="<?php echo $Hazard[$RiskID];?>" onClick="FMEA_Popup('<?php echo $Risk_Indicator;?>','Hazard')"/></td> 
    
    <td class="FMEA_CellBorder">
     <input type="button" name="HazardSituation" value=" &nbsp;" class="FMEA_CellCross" title="<?php echo $Hazard_Situation[$RiskID];?>" onClick="FMEA_Popup('<?php echo $Risk_Indicator;?>','HazardSituation')"/></td>       
   	         
  	<td class="FMEA_CellBorder">
 	<input type="button" name="FMHarm" value=" &nbsp;" class="FMEA_CellCross" title="<?php echo $Harm[$RiskID];?>" onClick="FMEA_Popup('<?php echo $Risk_Indicator;?>','FMHarm')"/></td>   
  	
  	<td class="FMEA_CellBorder">
    <input type="number" ID="SPre_<?php echo $RiskID;?>" value="<?php echo $S_Pre[$RiskID];?>" class="FMEA_CellInput" readonly/></td>    
 	                                                   
       
    <td class="FMEA_CellBorder">
    <input type="number" ID="P1Pre_<?php echo $RiskID;?>" value="<?php echo $P1_Pre[$RiskID];?>" class="FMEA_CellInput" readonly/></td> 
    
    <td class="FMEA_CellBorder">
    <input type="number" ID="P2Pre_<?php echo $RiskID;?>" value="<?php echo $P2_Pre[$RiskID];?>" class="FMEA_CellInput" readonly/></td>
    
    <td class="FMEA_CellBorder">
    <input type="number" min="1" max="5" ID="PPre_<?php echo $RiskID;?>" value="<?php echo $P_Pre[$RiskID];?>" class="FMEA_CellInput" onChange="Save_SameTime('<?php echo $RiskID;?>','PPre')"/></td>
     
    <?php
		if ($RiskRank_Pre[$RiskID] == 'C')								//add background color for "A" from database
		{
	?>
    <td class="FMEA_CellBorder">
    <input type="text" ID="RiskRankPre_<?php echo $RiskID;?>" value="<?php echo $RiskRank_Pre[$RiskID];?>" style="background: pink" class="FMEA_CellInput" readonly/></td>			
	<?php
		}
		
		else if ($RiskRank_Pre[$RiskID] == 'B')								//add background color for "B" from database
		{
	?>
    <td class="FMEA_CellBorder">
    <input type="text" ID="RiskRankPre_<?php echo $RiskID;?>" value="<?php echo $RiskRank_Pre[$RiskID];?>" style="background: yellow" class="FMEA_CellInput" readonly/></td>			
	<?php
		}
		else 					//if "A", "error", "", put the value with white backgrond
		{
	?>	
    <td class="FMEA_CellBorder">
    <input type="text" ID="RiskRankPre_<?php echo $RiskID;?>" value="<?php echo $RiskRank_Pre[$RiskID];?>" class="FMEA_CellInput" readonly/></td>  
    
    <?php	
		}
	?>                    
                                                                                                                                                                      
    <td class="FMEA_CellBorder">
    <input type="button" name="CurrentControl" value=" &nbsp;" class="FMEA_CellCross" title="<?php echo $CurrentControl_Design[$RiskID];?>" onClick="FMEA_Popup('<?php echo $Risk_Indicator;?>','CurrentControl')"/></td> 
                       
    <td class="FMEA_CellBorder">
    <input type="button" name="MitigationAction" value=" &nbsp;" class="FMEA_CellCross" title="<?php echo $MitigationAction_Design[$RiskID];?>" onClick="FMEA_Popup('<?php echo $Risk_Indicator;?>', 'MitigationAction')"/></td>
                             
    <td class="FMEA_CellBorder">
    <input type="text" ID="ControlType_<?php echo $RiskID;?>" value="<?php echo $Control_Type[$RiskID];?>" class="FMEA_CellInput" onChange="Save_SameTime('<?php echo $RiskID;?>','ControlType')"/></td>
                                                                                                                                                                                                                                                                         
    <td class="FMEA_CellBorder">
    <input type="button" name="VerificationCheck" value=" &nbsp;" class="FMEA_CellCross" title="<?php echo $Verification_Check[$RiskID];?>" onClick="FMEA_Popup('<?php echo $Risk_Indicator;?>', 'VerificationCheck')"/></td> 
    
    <td class="FMEA_CellBorder">
    <input type="number" ID="SPost_<?php echo $RiskID;?>" value="<?php echo $S_Post[$RiskID];?>" class="FMEA_CellInput" readonly/></td>  
  
       
    <td class="FMEA_CellBorder">
    <input type="number" ID="P1Post_<?php echo $RiskID;?>" value="<?php echo $P1_Post[$RiskID];?>" class="FMEA_CellInput" readonly/></td>
        
    
    <td class="FMEA_CellBorder">
    <input type="number" ID="P2Post_<?php echo $RiskID;?>" value="<?php echo $P2_Post[$RiskID];?>" class="FMEA_CellInput" readonly/></td>
    
    <td class="FMEA_CellBorder">
    <input type="number" min="1" max="5" ID="PPost_<?php echo $RiskID;?>" value="<?php echo $P_Post[$RiskID];?>" class="FMEA_CellInput" onChange="Save_SameTime('<?php echo $RiskID;?>','PPost')"/></td>
          
     
     <?php
		if ($RiskRank_Post[$RiskID] == 'C')
		{
	?>
    <td class="FMEA_CellBorder">
    <input type="text" ID="RiskRankPost_<?php echo $RiskID;?>" value="<?php echo $RiskRank_Post[$RiskID];?>" style="background: pink" class="FMEA_CellInput" readonly/></td>			
	<?php
		}
		else			//if "", "A", "error", show the value with white background
		{
	?>	
    <td class="FMEA_CellBorder">
    <input type="text" ID="RiskRankPost_<?php echo $RiskID;?>" value="<?php echo $RiskRank_Post[$RiskID];?>" class="FMEA_CellInput" readonly/></td>  
    
    <?php	
		}
	?>  
      
     
    <td class="FMEA_CellBorder">
    <input type="button" name="RBA" value=" &nbsp;" class="FMEA_CellCross" title="<?php echo $RBA_Statement[$RiskID];?>" onClick="FMEA_Popup('<?php echo $Risk_Indicator;?>','RBA')"/></td> 
    
    <td class="FMEA_CellBorder">
    <input type="button" name="NewHazard" value=" &nbsp;" class="FMEA_CellCross" title="<?php echo $NewHazard_Statement[$RiskID];?>" onClick="FMEA_Popup('<?php echo $Risk_Indicator;?>','NewHazard')"/></td> 
    
    <td style="border-bottom:solid #000000 1px;">
    <input type="button" name="Comment" value=" &nbsp;" class="FMEA_CellCross" title="<?php echo $Comment[$RiskID];?>" onClick="FMEA_Popup('<?php echo $Risk_Indicator;?>','Comment')"/></td>            
</tr>
<?php
} //--close "for"--

?>

<!-------------------------------------------------------------------------------------------------------------------------------------------------------------->        
<!-------Part 3: once clicked on button "Add a new row", create a new row in database, then collect input data (duplicated codes from above---------------------> 
<!--------------------------------------------------------------------------------------------------------------------------------------------------------------> 

<?php
	$Document_No = $_REQUEST['Document'];
	$Document_Revision = $_REQUEST['Revision'];
	$query_GetRiskRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\"");
	$SortAdd_Num = mysqli_num_rows($query_GetRiskRow);
	$NextRiskID = $SortAdd_Num+1;
?>

<input type="hidden" id="NextRisk_Hidden" name="NextRisk_Hidden" value="<?php echo $NextRiskID;?>"/>
<input type="hidden" id="NextRow" name="NextRow" value="0"/>

<?php
	for ($p=0; $p<10; $p++)
	{
	
?>		
	<tr id="New_Output2_<?php echo $p;?>" align="center" value="" style="padding-bottom:3px; display:none;"> 
	

	<td name="Risk_ID" class="FMEA_CellBorder">
   		<input type="number" id="NewRisk_Input_<?php echo $p;?>" name="Risk_ID" value="<?php echo $NextRiskID;?>" class="FMEA_CellInput" readonly/></td>
       
    <td class="FMEA_CellBorder">
    <input type="button" name="Description" value=" &nbsp;" class="FMEA_CellCross" onClick="FMEA_Popup('<?php echo $NextRiskID;?>','Description')"></td> 				<!-- this onclick to activate the popup window on the new added row-->
    
    <td class="FMEA_CellBorder">
    <input type="button" name="Model" value=" &nbsp;" class="FMEA_CellCross" onClick="FMEA_Popup('<?php echo $NextRiskID;?>','Model')"></td> 
    
	<td class="FMEA_CellBorder">
    <input type="button" name="Document" value=" &nbsp;" class="FMEA_CellCross" onClick="FMEA_Popup('<?php echo $NextRiskID;?>','Document')"></td> 
        
    <td class="FMEA_CellBorder">
    <input type="button" name="FailureMode" value=" &nbsp;" class="FMEA_CellCross" onClick="FMEA_Popup('<?php echo $NextRiskID;?>','FailureMode')"></td>
    
    <td class="FMEA_CellBorder">
     <input type="button" name="FMCause" value=" &nbsp;" class="FMEA_CellCross" onClick="FMEA_Popup('<?php echo $NextRiskID;?>','FMCause')"></td>
     
    <td class="FMEA_CellBorder">
     <input type="button" name="Hazard" value=" &nbsp;" class="FMEA_CellCross" onClick="FMEA_Popup('<?php echo $NextRiskID;?>','Hazard')"></td> 
    
    <td class="FMEA_CellBorder">
     <input type="button" name="HazardSituation" value=" &nbsp;" class="FMEA_CellCross" onClick="FMEA_Popup('<?php echo $NextRiskID;?>','HazardSituation')"></td>       
   	         
  	<td class="FMEA_CellBorder">
 	<input type="button" name="FMHarm" value=" &nbsp;" class="FMEA_CellCross" onClick="FMEA_Popup('<?php echo $NextRiskID;?>','FMHarm')"></td>   
    
    <td class="FMEA_CellBorder">
    <input type="number" class="FMEA_CellInput" readonly/></td>

    <td class="FMEA_CellBorder">
    <input type="number" class="FMEA_CellInput"/></td> 
        
    <td class="FMEA_CellBorder">
    <input type="number" class="FMEA_CellInput"/></td>
    
    <td class="FMEA_CellBorder">
    <input type="number" class="FMEA_CellInput"/></td>    
	
    <td class="FMEA_CellBorder">
    <input type="text" class="FMEA_CellInput" readonly/></td> 
    
    <td class="FMEA_CellBorder">
    <input type="button" name="CurrentControl" value=" &nbsp;" class="FMEA_CellCross" onClick="FMEA_Popup('<?php echo $NextRiskID;?>','CurrentControl')"></td> 
                       
    <td class="FMEA_CellBorder">
    <input type="button" name="MitigationAction" value=" &nbsp;" class="FMEA_CellCross" onClick="FMEA_Popup('<?php echo $NextRiskID;?>','MitigationAction')"></td>
                             
    <td class="FMEA_CellBorder">
    <input type="text" class="FMEA_CellInput"/></td>
                                                                                                                                                                                                                                                                         
    <td class="FMEA_CellBorder">
    <input type="button" name="VerificationCheck" value=" &nbsp;" class="FMEA_CellCross" onClick="FMEA_Popup('<?php echo $NextRiskID;?>','VerificationCheck')"></td> 
    
    <td class="FMEA_CellBorder">
    <input type="number" class="FMEA_CellInput"/></td>  
    
	<td class="FMEA_CellBorder">
    <input type="number" class="FMEA_CellInput"/></td>
        
    <td class="FMEA_CellBorder">
    <input type="number" class="FMEA_CellInput"/></td>
    
    <td class="FMEA_CellBorder">
    <input type="number" class="FMEA_CellInput"/></td>         

    <td class="FMEA_CellBorder">
    <input type="text" class="FMEA_CellInput" readonly/></td>  
        
    <td class="FMEA_CellBorder">
    <input type="button" name="RBA" value=" &nbsp;" class="FMEA_CellCross" onClick="FMEA_Popup('<?php echo $NextRiskID;?>','RBA')"></td> 
    
    <td class="FMEA_CellBorder">
    <input type="button" name="NewHazard" value=" &nbsp;" class="FMEA_CellCross" onClick="FMEA_Popup('<?php echo $NextRiskID;?>','NewHazard')"></td> 
    
    <td style="border-bottom:solid #000000 1px;">
    <input type="button" name="Comment" value=" &nbsp;" class="FMEA_CellCross" onClick="FMEA_Popup('<?php echo $NextRiskID;?>','Comment')"></td>            
</tr>

<?php
$NextRiskID++;
}
?>

<!-------------------------------------------------------------------------------------------------------------------------------------------------------------->        
<!-------Part 4: Turn pages (forware, backward)-----------------------------------------------------------------------------------------------------------------> 
<!--------------------------------------------------------------------------------------------------------------------------------------------------------------> 
<tr style="line-height:20px;">
	<td colspan="26" style="background-color:#EAF2FF; border-top:solid #15B4FF 1px;">
   
   
    <?php
		echo "<div style='height:3px; width:100%; line-height:0; font-size:0; margin:2px 0px 0px 0px; padding:0; clear:both;'>&nbsp;</div>";
		
		$xPage="RiskFMEA_SR2.php";
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
			
$LastPage=($TotalPage-1)*$Page_Limit;
if ($CurrentPage<$TotalPage)							//determine if "turn to last page" sign is able to be activiated(bright)
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
 
<!--------------------------------------------------------------------------------------------------------------------------------->        
<!----------------------------------------------------Part 5: Table bottom with save button----------------------------------------> 
<!--------------------------------------------------------------------------------------------------------------------------------->  


<table id="Foot_Table">
<tr style="line-height:10px"><td>&nbsp;</td></tr>

<tr><td align="right"> 
<input type="button" value="Save" name="Form_Saved" id="Form_SaveButton" class="RdPDM_Button" onClick="FMEA_Save()">
<input type="button" value="Report" name="Report" id="Form_ExportButton" class="RdPDM_Button" onClick="FMEA_Report()">
<input type="button" value="Export" name="Form_Export" id="Form_ExportButton" class="RdPDM_Button" onClick="FMEA_Export()">
<input type="button" value="Exit" name="Form_Exit" id="Form_ExitButton" class="RdPDM_Button" onClick="FMEA_Exit()">

<!--<input type="hidden" id="Moved_Item_Records" name="Moved_Item_Records" value="" />-->
</td></tr>

<tr style="line-height:20px;"><td>&nbsp;</td></tr>
</table> 

<!--------------------------------------------------------------------------------------------------------------------------------->        
<!----------------------------------------------------Part 6: Hidden popup windows-------------------------------------------------> 
<!---------------------------------------------------------------------------------------------------------------------------------> 


<div id="Task_POP_DW" class="FMEA_PopUP_DW">				<!-- Data Window (DW) is a small window to list contents on task popup window -->

    <div id="Task_POP_Grey">								<!-- a grey zone on the top of pop-up window--> 
    
    <div id="Task_POP_CloseSign">[ <a href="javascript:void(0)" style="color:#09C; font-size:12px; font-weight:600; vertical-align:baseline;" onclick="return Task_POP_Close()"> Close <img style='vertical-align:middle;' border='0' src="Images/clear.png" height="16" width="16" /></a> ]</div>
    		
    <!--remove "close" button on top to avoid error-->							<!-- close button at grey zone-->
    </div>
    
    <iframe id="Rd_Task_POPUP" name="Rd_Task_POPUP" frameborder='0' width="810px" height="450px" src="" ></iframe> <!--width="810px" height="370px"-->
 															<!-- create a 800pxX520px size scroll bar at right side to see rest of data -->   
</div>  
                          
<div id="Task_POP_BG" class="FMEA_PopUP_BG"></div> 	
											<!-- Back ground(BG) defines a darked roadmap as a background when task popup window display -->
<!-- End Popup -->

<!--</form>-->
</div>			<!--FMEA container closed here-->


<?php
mysqli_close ($con);
?>
</body>
</html>