<?php

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

define('CLI', (PHP_SAPI == 'cli') ? true : false);
define('EOL', CLI ? PHP_EOL : '<br />');
define('SCRIPT_FILENAME', basename($_SERVER['SCRIPT_FILENAME'], '.php'));
define('IS_INDEX', SCRIPT_FILENAME == 'index');

date_default_timezone_set('America/Phoenix');

require_once 'PHPWord/bootstrap.php';

use PhpOffice\PhpWord\Settings;

//$Project_ID = (isset($_REQUEST['Project']) ? $_REQUEST['Project'] : ''); //obtain value
$Document_No = (isset($_REQUEST['Document']) ? $_REQUEST['Document'] : ''); 
$Document_Revision = $_REQUEST['Revision'];

$query_GetRegTitle = mysqli_query($con, "SELECT Project_ID FROM DocumentReview_Approval WHERE Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\"");
$RegTitle_Row = mysqli_fetch_array($query_GetRegTitle);
$Project_ID = $RegTitle_Row['Project_ID'];

//$Project_ID = 1028;

$RiskFMEAData = getRiskFMEAData();
$dataArray = getWordDocumentData($Project_ID, $Document_No, $Document_Revision);

outputFMEADataToWord($dataArray, $RiskFMEAData);

/**
 * Gets the data needed from the database for the Word document.
 */
function getRiskFMEAData() {
    include "Showroom_DB.php";
    
    /*
     * Table            Field
     *  
     * Project_Tasks    ProjectTask_NO, Layer
     * 
     * Project_Info     Project_ID, Project_Manager, Product_Manager,
     *                  Regulatory, System_Engineer, Clinical,
     *                  Quality_Engineer, Risk_Management_Engineer
     */
    
    $query_ProjectInfo = mysqli_query($con, "SELECT Project_ID, Project_Manager, Product_Manager, Regulatory, System_Engineer, Clinical, Quality_Engineer, Risk_Management_Engineer FROM Project_Info WHERE Project_ID=\"$Project_ID\"");	

    $ProjectInfo_Row = mysqli_fetch_assoc($query_ProjectInfo);
    
    $query_ProjectTasks = mysqli_query($con, "SELECT * FROM Project_Tasks");	

    while ($ProjectTask_Row = mysqli_fetch_array($query_ProjectTasks)) {
        $ProjectTask_Rows[] = $ProjectTask_Row;
    }
    
//    echo '<pre>';
//    var_dump($ProjectInfo_Row);
//    exit();
    
    /**
     * array(8) {
        ["Project_ID"]=>
        string(5) "10001"
        ["Project_Manager"]=>
        string(12) "Myra Barrera"
        ["Product_Manager"]=>
        string(9) "Jing Wang"
        ["Regulatory"]=>
        string(9) "Eliz Finn"
        ["System_Engineer"]=>
        string(17) "Cecilia Beauchamp"
        ["Clinical"]=>
        string(14) "Steven Lanford"
        ["Quality_Engineer"]=>
        string(10) "Jerry Xiao"
        ["Risk_Management_Engineer"]=>
        string(11) "Doug Jotzke"
      }
     */
    
    return [
        'ProjectInfo' => $ProjectInfo_Row,
        'ProjectTask' => $projectTask_Rows
    ];
}

/**
 * Gets an array of data to be used in creating the Word Document later.
 * 
 * @return string
 */
function getWordDocumentData($Project_ID, $Document_No, $Document_Revision) {
    $dataArray = [];

    $dataArray['App_cat'] = 'TBD';
    $dataArray['doc_desc'] = 'FMEA Report for project ' . $Project_ID;
    $dataArray['long_desc'] = 'N/A';
    $dataArray['Prepared_by'] = 'TBD';
    $dataArray['Date'] = '9/8/2017';
    $dataArray['valid_from'] = '';
    $dataArray['eco'] = 'N/A';
    $dataArray['FMEA_no'] = $Document_No;
    $dataArray['FMEA_version'] = $Document_Revision;
    $dataArray['electronic_sig'] = 'This document is electronically signed in the SAP Document Management System (DMS). Approvals are tracked and maintained in each Document Information Record (DIR).';
    $dataArray['declaration'] = 'This document contains information that is the property of RDQCC. This document may not, in whole or in part, be duplicated, disclosed, or used for design or manufacturing purposes without the prior written permission of RDQCC.';
    $dataArray['footerfirstpage'] = "<p style='text-align:center'>Form 9198036- 042 Ver B. Complete per SOP105-03.</p>";
    $dataArray['footerallnextpages'] = "<p style='text-align:center,color:#000000'><strong>FMEA</strong><span style='color:red'>1049</span> Version: <strong>B</strong>			<strong>RDQCC Confidential</strong></p><p>This document is electronically controlled. Printed copies are considered uncontrolled past the print date.</p>";

    $dataArray['alldata'][0] = array("title" => "Scope", "content" => "This FMEA report applies to management product safety risk for the project " . $Project_ID . ", throughout the product lifecycle, at RDQCC facilities, in accordance with SOP104-08.");
    $dataArray['alldata'][1] = array("title" => "Purpose", "content" => "The purpose of this FMEA is to summarize the risk management activities that will be conducted during the design, development, and commercialization.");
    $dataArray['alldata'][2] = array("title" => "Relevant Documents", "content" => "The relevant documents are associated with the FMEA report during the design, development, and commercialization.");
    $dataArray['alldata'][2]["childs"][0] = array("title" => "General Documents");
    $dataArray['alldata'][2]["childs"][0]['datatable'][0] = array("Document Number" => "SOP104-06", "Title" => "Failure Modes & Effects Analysis");
    $dataArray['alldata'][2]["childs"][0]['datatable'][1] = array("Document Number" => "DOP104-050", "Title" => "REQT, Human Factors Design and Usability");
    $dataArray['alldata'][2]["childs"][0]['datatable'][2] = array("Document Number" => "DOP104-666", "Title" => "Fault Tree Analysis");
    $dataArray['alldata'][2]["childs"][0]['datatable'][3] = array("Document Number" => "BS EN ISO 14971:2012", "Title" => "Application of Risk Management to Medical Devices");
    $dataArray['alldata'][2]["childs"][0]['datatable'][4] = array("Document Number" => "EN62304: 2006", "Title" => "Medical Device Software – Software Life-Cycle Process");
    $dataArray['alldata'][2]["childs"][1] = array("title" => "Reference Documents");
    $dataArray['alldata'][2]["childs"][1]['datatable'][0] = array("Document Number" => "RMF1049", "Title" => "Risk Management File");
    $dataArray['alldata'][2]["childs"][1]['datatable'][1] = array("Document Number" => "RAD1049", "Title" => "Risk Analysis Document");
    $dataArray['alldata'][2]["childs"][1]['datatable'][2] = array("Document Number" => "SOP104-08", "Title" => "Product Risk Management Process");
    $dataArray['alldata'][2]["childs"][1]['datatable'][3] = array("Document Number" => "SOP104-01", "Title" => "Product Development Process");
    $dataArray['alldata'][2]["childs"][1]['datatable'][4] = array("Document Number" => "ER04-3856", "Title" => "Reliability Analysis FMEA and FMECA");
    $dataArray['alldata'][2]["childs"][1]['datatable'][5] = array("Document Number" => "ER06-4682", "Title" => "PFMEA for Microbat");
    $dataArray['alldata'][2]["childs"][1]['datatable'][6] = array("Document Number" => "ER06-4682", "Title" => "Product Spec");
    $dataArray['alldata'][3] = array("title" => "Definitions");
    $dataArray['alldata'][3]['datatable'][0] = array("Term" => "FTA", "Definition" => "Fault Tree Analysis");
    $dataArray['alldata'][3]['datatable'][1] = array("Term" => "HA", "Definition" => "Hazard Analysis");
    $dataArray['alldata'][3]['datatable'][2] = array("Term" => "dFMEA", "Definition" => "Design Failure Modes and Effects Analysis");
    $dataArray['alldata'][3]['datatable'][3] = array("Term" => "pFMEA", "Definition" => "Process Failure Modes and Effects Analysis");

    $dataArray['alldata'][4] = array("title" => "Definitions");
    $dataArray['alldata'][4]['datatable'][0] = array("Model Number" => "Model-1001", "Description" => "External", "Part Number/Revision" => "All");
    $dataArray['alldata'][4]['datatable'][1] = array("Model Number" => "Model-1002", "Description" => "External", "Part Number/Revision" => "All");

    $dataArray['alldata'][5] = array("title" => "Intended Use & Essential Performance", "content" => "Add essential performance (regulatory submission package)");

    $dataArray['alldata'][6] = array("title" => "Product Characteristics Affecting Basic Safety", "content" => "{Describe the device characteristics affecting safety.}");


    $dataArray['alldata'][7] = array("title" => "Risk Analysis Methodology");
    $dataArray['alldata'][7]['datatable'][0] = array("Document Type" => "HA", "Verification Document/Rev." => "RAD1049", "Comments" => "");
    $dataArray['alldata'][7]['datatable'][1] = array("Document Type" => "DFMEA", "Verification Document/Rev." => "ER04-3856", "Comments" => "");
    $dataArray['alldata'][7]['datatable'][3] = array("Document Type" => "PFMEA", "Verification Document/Rev." => "ER06-4682", "Comments" => "");
    $dataArray['alldata'][7]['childs'][0] = array("title" => "Hazard Identification Lists");
    $dataArray['alldata'][7]['childs'][0]["para"][0] = array("content" => "{List at least hazards based on EN ISO 14971:2012 Annex C relevant to the specific product(s)/system.}");
    $dataArray['alldata'][7]['childs'][0]["para"][1] = array("content" => "{For insulin pump devices/systems, the hazard list from the FDA draft guidance on infusion pumps may be included.}");
    $dataArray['alldata'][7]['childs'][0]["para"][2] = array("content" => "{Include additional hazard lists obtained from other standards or guidances as applicable to the specific product(s)/system.}");
    $dataArray['alldata'][7]['childs'][0]["para"][3] = array("content" => "Get guidance from FMEA1111");


    $dataArray['alldata'][8] = array("title" => "Software Classification");
    $dataArray['alldata'][8]['para'][0] = array("content" => "Software Classification");
    $dataArray['alldata'][8]['datatable'][0] = array(0 => "Not applicable – no software associated with the product", 1 => "checkbox");
    $dataArray['alldata'][8]['datatable'][1] = array(0 => "Class A: No injury or damage to health is possible", 1 => "checkbox");
    $dataArray['alldata'][8]['datatable'][2] = array(0 => "Class B: Non-serious injury is possible", 1 => "checkbox");
    $dataArray['alldata'][8]['datatable'][3] = array(0 => "Class C: Death or serious injury is possible", 1 => "Xcheckbox");

    $dataArray['alldata'][9] = array("title" => "Product Lifecycle");
    $dataArray['alldata'][9]['datatable'][0] = array("Lifecycle Phase" => "Research Only", "Applies" => "checkbox", "Rationale if not applicable" => "");
    $dataArray['alldata'][9]['datatable'][1] = array("Lifecycle Phase" => "Pre-Market Design & Development", "Applies" => "checkbox", "Rationale if not applicable" => "");
    $dataArray['alldata'][9]['datatable'][2] = array("Lifecycle Phase" => "Production", "Applies" => "Xcheckbox", "Rationale if not applicable" => "For existing product");
    $dataArray['alldata'][9]['datatable'][3] = array("Lifecycle Phase" => "Packaging", "Applies" => "checkbox", "Rationale if not applicable" => "");
    $dataArray['alldata'][9]['datatable'][4] = array("Lifecycle Phase" => "Sterilization", "Applies" => "checkbox", "Rationale if not applicable" => "");
    $dataArray['alldata'][9]['datatable'][5] = array("Lifecycle Phase" => "Warehousing/Storage", "Applies" => "checkbox", "Rationale if not applicable" => "");
    $dataArray['alldata'][9]['datatable'][6] = array("Lifecycle Phase" => "Shipping", "Applies" => "checkbox", "Rationale if not applicable" => "");
    $dataArray['alldata'][9]['datatable'][7] = array("Lifecycle Phase" => "Maintenance/Servicing", "Applies" => "checkbox", "Rationale if not applicable" => "");
    $dataArray['alldata'][9]['datatable'][8] = array("Lifecycle Phase" => "Post-Market Changes", "Applies" => "checkbox", "Rationale if not applicable" => "");
    $dataArray['alldata'][9]['datatable'][9] = array("Lifecycle Phase" => "Product Decommissioning", "Applies" => "checkbox", "Rationale if not applicable" => "");
    $dataArray['alldata'][9]['datatable'][10] = array("Lifecycle Phase" => "Other:------", "Applies" => "checkbox", "Rationale if not applicable" => "");

    $dataArray['alldata'][10] = array("title" => "Planned Risk Management Activities");
    $dataArray['alldata'][10]["para"][0] = array("content" => "The following activities have been selected and a responsible individual has been assigned:");
    $dataArray['alldata'][10]["datatable"][0] = array("Activity & Document Type" => "Usability Task Analysis (ER)", "Required?" => array(0 => array("0" => "Xcheckbox", 1 => "Yes"), "1" => array(0 => "checkbox", 1 => "No"), "2" => array(0 => "checkbox", 1 => "N/A")), "Responsible Functions" => "N/A", "Comments" => "N/A");
    $dataArray['alldata'][10]["datatable"][1] = array("Activity & Document Type" => "Design FMEA (dFMEA ER)", "Required?" => array(0 => array("0" => "Xcheckbox", 1 => "Yes"), "1" => array(0 => "checkbox", 1 => "No"), "2" => array(0 => "checkbox", 1 => "N/A")), "Responsible Functions" => "Quality Engineering", "Comments" => "ER04-3856");
    $dataArray['alldata'][10]["datatable"][2] = array("Activity & Document Type" => "Process FMEA (pFMEA ER)", "Required?" => array(0 => array("0" => "Xcheckbox", 1 => "Yes"), "1" => array(0 => "checkbox", 1 => "No"), "2" => array(0 => "checkbox", 1 => "N/A")), "Responsible Functions" => "Quality Engineering", "Comments" => "ER06-4682");
    $dataArray['alldata'][10]["datatable"][3] = array("Activity & Document Type" => "Fault Tree Analysis", "Required?" => array(0 => array("0" => "checkbox", 1 => "Yes"), "1" => array(0 => "Xcheckbox", 1 => "No"), "2" => array(0 => "checkbox", 1 => "N/A")), "Responsible Functions" => "N/A", "Comments" => "N/A");
    $dataArray['alldata'][10]["datatable"][4] = array("Activity & Document Type" => "Risk Analysis", "Required?" => "Yes", "Responsible Functions" => "RM & QA", "Comments" => "");
    $dataArray['alldata'][10]["datatable"][5] = array("Activity & Document Type" => "Risk Management File", "Required?" => "Yes", "Responsible Functions" => "RM & QA", "Comments" => "");
    $dataArray['alldata'][10]["datatable"][6] = array("Activity & Document Type" => "Risk Management Report", "Required?" => "Yes", "Responsible Functions" => "RM & QA", "Comments" => "");
    $dataArray['alldata'][10]["datatable"][7] = array("Activity & Document Type" => "Design Verification & Validation", "Required?" => array(0 => array("0" => "Xcheckbox", 1 => "Yes"), "1" => array(0 => "checkbox", 1 => "No"), "2" => array(0 => "checkbox", 1 => "N/A")), "Responsible Functions" => "???", "Comments" => "QTR6302, QTR6233, QTR6234, QTR6235");
    $dataArray['alldata'][10]["datatable"][8] = array("Activity & Document Type" => "Software Verification & Validation", "Required?" => array(0 => array("0" => "Xcheckbox", 1 => "Yes"), "1" => array(0 => "checkbox", 1 => "No"), "2" => array(0 => "checkbox", 1 => "N/A")), "Responsible Functions" => "???", "Comments" => "ER11-6954");
    $dataArray['alldata'][10]["datatable"][9] = array("Activity & Document Type" => "Process Validations", "Required?" => array(0 => array("0" => "Xcheckbox", 1 => "Yes"), "1" => array(0 => "checkbox", 1 => "No"), "2" => array(0 => "checkbox", 1 => "N/A")), "Responsible Functions" => "???", "Comments" => "PVR11-1025");
    $dataArray['alldata'][10]["datatable"][9] = array("Activity & Document Type" => "Clinical Evaluations", "Required?" => array(0 => array("0" => "checkbox", 1 => "Yes"), "1" => array(0 => "checkbox", 1 => "No"), "2" => array(0 => "Xcheckbox", 1 => "N/A")), "Responsible Functions" => "N/A", "Comments" => "N/A");


    $dataArray['alldata'][11] = array("title" => "Risk Management Review");
    $dataArray['alldata'][11]["para"][0] = array("content" => "The risk management file shall be reviewed at minimum annually and risk management engineer is responsible for conducting the risk management file review on an ongoing basis.");
    $dataArray['alldata'][11]["para"][1] = array("content" => "The risk management report shall be reviewed before the risk management report is completed and the risk management engineer is responsible for conducting the risk management report review before the FMEA is completed.");
    $dataArray['alldata'][11]["para"][2] = array("content" => "The report for risk management reviews is documented in the table below.  The risk management reviews are documented in the corresponding RMF.");
    $dataArray['alldata'][11]["datatable"][0] = array("RMF Component Reviewed" => "RMF", "Review Frequency" => "Annual", "Comments" => "None");
    $dataArray['alldata'][11]["datatable"][1] = array("RMF Component Reviewed" => "RMP", "Review Frequency" => "Whenever the production report or risk management report changes.", "Comments" => "None");
    $dataArray['alldata'][11]["datatable"][2] = array("RMF Component Reviewed" => "RAD", "Review Frequency" => "Every time a new risk is identified, RAD should be analyzed and a new hazard sheet needs to be added.", "Comments" => "None");
    $dataArray['alldata'][11]["datatable"][3] = array("RMF Component Reviewed" => "RMR", "Review Frequency" => "Every time RMP is revised", "Comments" => "None");
    $dataArray['alldata'][11]["datatable"][5] = array("RMF Component Reviewed" => "Usability Task Analysis", "Review Frequency" => "Every time a new feature; software if it affects patients interface or hardware is added, the usability analysis should be performed", "Comments" => "None");
    $dataArray['alldata'][11]["datatable"][6] = array("RMF Component Reviewed" => "dFMEA", "Review Frequency" => "Every time there is a new feature of hardware or design change of an existing component", "Comments" => "None");
    $dataArray['alldata'][11]["datatable"][7] = array("RMF Component Reviewed" => "pFMEA", "Review Frequency" => "Every time there is a new process to the manufacturing", "Comments" => "None");
    $dataArray['alldata'][11]["datatable"][8] = array("RMF Component Reviewed" => "FTA", "Review Frequency" => "N/A", "Comments" => "None");


    $dataArray['alldata'][12] = array("title" => "Risk Control Verification Activities");
    $dataArray['alldata'][12]["para"][0] = array("content" => "The qualification activities shall be performed according to the product validation report(s) and the qualification results shall be documented in the product validation report(s):");
    $dataArray['alldata'][12]["datatable"][0] = array("Document Type" => "QTP/R", "Required?" => array(0 => array("0" => "Xcheckbox", 1 => "Yes"), "1" => array(0 => "checkbox", 1 => "No"), "2" => array(0 => "checkbox", 1 => "N/A")), "Responsible Function" => "QA", "Comments" => "QTR6237, QTR6302, QTR6233, QTR6234, QTR6235");
    $dataArray['alldata'][12]["datatable"][1] = array("Document Type" => "SVP/R", "Required?" => array(0 => array("0" => "Xcheckbox", 1 => "Yes"), "1" => array(0 => "checkbox", 1 => "No"), "2" => array(0 => "checkbox", 1 => "N/A")), "Responsible Function" => "QA", "Comments" => "SVR2028");
    $dataArray['alldata'][12]["datatable"][2] = array("Document Type" => "MVP/R", "Required?" => array(0 => array("0" => "checkbox", 1 => "Yes"), "1" => array(0 => "checkbox", 1 => "No"), "2" => array(0 => "Xcheckbox", 1 => "N/A")), "Responsible Function" => "None", "Comments" => "None");
    $dataArray['alldata'][12]["datatable"][3] = array("Document Type" => "ETP/R", "Required?" => array(0 => array("0" => "checkbox", 1 => "Yes"), "1" => array(0 => "checkbox", 1 => "No"), "2" => array(0 => "Xcheckbox", 1 => "N/A")), "Responsible Function" => "None", "Comments" => "ER03-3600, ER06-4682, ER04-3856, ER11-6954");
    $dataArray['alldata'][12]["datatable"][4] = array("Document Type" => "ER (usability task analysis)", "Required?" => array(0 => array("0" => "checkbox", 1 => "Yes"), "1" => array(0 => "checkbox", 1 => "No"), "2" => array(0 => "Xcheckbox", 1 => "N/A")), "Responsible Function" => "None", "Comments" => "None");
    $dataArray['alldata'][12]["datatable"][5] = array("Document Type" => "CEP/R", "Required?" => array(0 => array("0" => "checkbox", 1 => "Yes"), "1" => array(0 => "checkbox", 1 => "No"), "2" => array(0 => "Xcheckbox", 1 => "N/A")), "Responsible Function" => "None", "Comments" => "None");

    $dataArray['alldata'][13] = array("title" => "Special Risks", "content" => "N/A");

    $dataArray['alldata'][14] = array("title" => "Risk Acceptability Criteria", "content" => "See SOP104-08 for risk acceptability criteria pertaining to individual risks as well as overall residual risk.");
    $dataArray['alldata'][15] = array("title" => "Production & Post-Production Information");
    $dataArray['alldata'][15]["para"][0] = array("content" => "Production and post-production information shall be monitored and the risk analysis shall be updated based on this information as appropriate.");
    $dataArray['alldata'][15]["para"][1] = array("content" => "{Note specific types of production (manufacturing) and post-production (e.g., complaints, data from similar or competitor devices, etc.) information to be collected and analyzed beyond current monitoring activities.  Where data collection and/or analysis differs from routine surveillance, list the data and how it will be analyzed.}");

    $dataArray['alldata'][16] = array("title" => "Risk Management Team");
    $dataArray['alldata'][16]["para"][0] = array("content" => "The following table lists risk management team participants.  Participants in any given risk management activity may vary depending on the activity being conducted.");
    $dataArray['alldata'][16]["datatable"][0] = array("Required Expertise" => "Design Quality Engineering", "Expertise Required?" => "Yes", "Functional Department" => "Design Quality Engineering");
    $dataArray['alldata'][16]["datatable"][1] = array("Required Expertise" => "Operations Quality Engineering", "Expertise Required?" => "Yes", "Functional Department" => "Operations Quality Engineering");
    $dataArray['alldata'][16]["datatable"][2] = array("Required Expertise" => "Risk Management", "Expertise Required?" => "Yes", "Functional Department" => "Operations Quality Engineering");
    $dataArray['alldata'][16]["datatable"][3] = array("Required Expertise" => "R&D/Tech Leader (indicate which: Mechanical, Electrical, Software)", "Expertise Required?" => array(0 => array("0" => "Xcheckbox", 1 => "Yes"), "1" => array(0 => "checkbox", 1 => "No")), "Functional Department" => "Software, Mechanical, Electrical");
    $dataArray['alldata'][16]["datatable"][4] = array("Required Expertise" => "Systems Engineering", "Expertise Required?" => array(0 => array("0" => "Xcheckbox", 1 => "Yes"), "1" => array(0 => "checkbox", 1 => "No")), "Functional Department" => "");
    $dataArray['alldata'][16]["datatable"][5] = array("Required Expertise" => "Cybersecurity SME", "Expertise Required?" => array(0 => array("0" => "checkbox", 1 => "Yes"), "1" => array(0 => "Xcheckbox", 1 => "No")), "Functional Department" => "");
    $dataArray['alldata'][16]["datatable"][6] = array("Required Expertise" => "Human Factors/Usability Engineering", "Expertise Required?" => array(0 => array("0" => "Xcheckbox", 1 => "Yes"), "1" => array(0 => "checkbox", 1 => "No")), "Functional Department" => "");
    $dataArray['alldata'][16]["datatable"][7] = array("Required Expertise" => "Design Assurance Engineering", "Expertise Required?" => array(0 => array("0" => "Xcheckbox", 1 => "Yes"), "1" => array(0 => "checkbox", 1 => "No")), "Functional Department" => "");
    $dataArray['alldata'][16]["datatable"][8] = array("Required Expertise" => "Test/QA Engineering", "Expertise Required?" => array(0 => array("0" => "Xcheckbox", 1 => "Yes"), "1" => array(0 => "checkbox", 1 => "No")), "Functional Department" => "");
    $dataArray['alldata'][16]["datatable"][9] = array("Required Expertise" => "Manufacturing Engineering", "Expertise Required?" => array(0 => array("0" => "Xcheckbox", 1 => "Yes"), "1" => array(0 => "checkbox", 1 => "No")), "Functional Department" => "PRODUCT SUPPORT ENGINEERING");
    $dataArray['alldata'][16]["datatable"][10] = array("Required Expertise" => "Supplier Quality Engineering", "Expertise Required?" => array(0 => array("0" => "Xcheckbox", 1 => "Yes"), "1" => array(0 => "checkbox", 1 => "No")), "Functional Department" => "");
    $dataArray['alldata'][16]["datatable"][11] = array("Required Expertise" => "Regulatory Affairs", "Expertise Required?" => array(0 => array("0" => "Xcheckbox", 1 => "Yes"), "1" => array(0 => "checkbox", 1 => "No")), "Functional Department" => "");
    $dataArray['alldata'][16]["datatable"][12] = array("Required Expertise" => "Clinical Research", "Expertise Required?" => array(0 => array("0" => "checkbox", 1 => "Yes"), "1" => array(0 => "Xcheckbox", 1 => "No")), "Functional Department" => "");
    $dataArray['alldata'][16]["datatable"][13] = array("Required Expertise" => "Clinical Education", "Expertise Required?" => array(0 => array("0" => "checkbox", 1 => "Yes"), "1" => array(0 => "Xcheckbox", 1 => "No")), "Functional Department" => "");
    $dataArray['alldata'][16]["datatable"][14] = array("Required Expertise" => "Marketing", "Expertise Required?" => array(0 => array("0" => "checkbox", 1 => "Yes"), "1" => array(0 => "Xcheckbox", 1 => "No")), "Functional Department" => "");
    $dataArray['alldata'][16]["datatable"][15] = array("Required Expertise" => "Medical Affairs", "Expertise Required?" => array(0 => array("0" => "Xcheckbox", 1 => "Yes"), "1" => array(0 => "checkbox", 1 => "No")), "Functional Department" => "CLINICAL RESEARCH");
    $dataArray['alldata'][16]["datatable"][16] = array("Required Expertise" => "Technical Communications", "Expertise Required?" => array(0 => array("0" => "checkbox", 1 => "Yes"), "1" => array(0 => "Xcheckbox", 1 => "No")), "Functional Department" => "");
    $dataArray['alldata'][16]["datatable"][17] = array("Required Expertise" => "24-Hour Helpline", "Expertise Required?" => array(0 => array("0" => "checkbox", 1 => "Yes"), "1" => array(0 => "Xcheckbox", 1 => "No")), "Functional Department" => "");
    $dataArray['alldata'][16]["datatable"][18] = array("Required Expertise" => "Project/Program Management", "Expertise Required?" => array(0 => array("0" => "Xcheckbox", 1 => "Yes"), "1" => array(0 => "checkbox", 1 => "No")), "Functional Department" => "PROGRAM OFFICE");

    $dataArray['alldata'][17] = array("title" => "DOCUMENT HISTORY");
    $dataArray['alldata'][17]["datatabletitle"] = array("title" => "VERSION HISTORY");
    $dataArray['alldata'][17]["datatable"][0] = array("VERSION" => "B", "DESCRIPTION OF CHANGE" => "New FMEA template (9198037-044)");

    return $dataArray;
}

function outputFMEADataToWord($dataArray, $RiskFMEAData) {
    Settings::loadConfig();
    
    $lfcr = '<w:br/>';

    // Set writers
    $writers = array('Word2007' => 'docx');

    // Turn output escaping on
    Settings::setOutputEscapingEnabled(true);

    // Return to the caller script when runs by CLI
    if (CLI) {
        return;
    }

    // Set titles and names
    $pageHeading = str_replace('_', ' ', SCRIPT_FILENAME);
    $pageTitle = IS_INDEX ? 'Welcome to ' : "{$pageHeading} - ";
    $pageTitle .= 'PHPWord';
    $pageHeading = IS_INDEX ? '' : "<h1>{$pageHeading}</h1>";

    // Populate samples
    $files = '';
    if ($handle = opendir('.')) {
        while (false !== ($file = readdir($handle))) {
            if (preg_match('/^Sample_\d+_/', $file)) {
                $name = str_replace('_', ' ', preg_replace('/(Sample_|\.php)/', '', $file));
                $files .= "<li><a href='{$file}'>{$name}</a></li>";
            }
        }
        closedir($handle);
    }

    echo $pageHeading; // New Word Document
    echo date('H:i:s'), ' Create new PhpWord object', EOL;
    
    $phpWord = new \PhpOffice\PhpWord\PhpWord();
    $section = $phpWord->addSection(array(
        'marginLeft' => 300,
        'marginRight' => 300,
        'marginTop' => 300,
        'marginBottom' => 300,
        'headerHeight' => 400,
        'footerHeight' => 400,
    ));
    
    $textbox = $section->addTextBox(
            array(
                'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
                'width' => 650,
                'height' => 250,
                'borderSize' => 2,
                'borderColor' => 'Teal',
            )
    );

    $fancyTableStyleName = 'Fancy Table';
    $fancyTableStyle = array(/* 'borderSize' => 6, 'borderColor' => '999999','spaceAfter' => 0 */);
    $fancyTableFirstRowStyle = array();
    $fancyTableCellStyle = array('valign' => 'center');
    $fancyTableCellBtlrStyle = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
    $fancyTableFontStyle = array('bold' => true);
    $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'FFFF00');
    $cellRowContinue = array('vMerge' => 'continue');
    $cellColSpan = array('gridSpan' => 2, 'valign' => 'center', 'bgColor' => '000000', 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);
    $cellColSpan3 = array('gridSpan' => 3, 'valign' => 'center', 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);

    $cellColSpan3bgblack = array('gridSpan' => 3, 'valign' => 'center', 'bgColor' => '000000', 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);
    $cellColSpan3bgwhite = array('gridSpan' => 3, 'valign' => 'center', 'bgColor' => 'ffffff', 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);
    $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);
    $cellHleft = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT);
    $cellHright = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT);
    $cellstylebold = array('color' => '#FF0000', 'bold' => true, 'italic' => true, 'size' => 12);
    $cellstylenormal = array('color' => '#FF0000', 'size' => 12);
    $cellstylemedium = array('color' => '#FF0000', 'size' => 10);
    $cellstylesmallbold = array('color' => '#FF0000', 'bold' => true, 'size' => 10);
    $cellstylesmall = array('color' => '#FF0000', 'size' => 8);

    $cellafter = array('spaceAfter' => 0);
    $cellafterright = array('spaceAfter' => 0, 'align' => 'right');
    $cellafterleft = array('spaceAfter' => 0, 'align' => 'left');
    $cellaftercenter = array('spaceAfter' => 0, 'align' => 'center');
    $content_left = array('align' => 'left');
    $content_center = array('align' => 'center');
    $content_right = array('align' => 'right');
    $table_heading_left = array('color' => '#FF0000', 'bold' => true, 'size' => 12, 'align' => 'left');

    $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
    $table = $textbox->addTable($fancyTableStyleName);

    $table->addRow(900);

    $table->addCell(500)->addText('', $cellstylebold, $cellafter);
    $table->addCell(2500)->addText('', $cellstylebold, $cellafter);
    $table->addCell(2000)->addText('', $cellstylebold, $cellafter);
    $table->addCell(5000, $cellColSpan)->addText("FMEA {$dataArray['FMEA_no']} Version {$dataArray['FMEA_version']}", $cellstylebold, $cellaftercenter);


    $table->addRow();
    $table->addCell(500)->addText('', $cellstylebold, $cellafter);
    $table->addCell(2500, $cellHCentered)->addText("Approval Category: ", $cellstylebold, $cellafterleft);
    $table->addCell(7000, $cellColSpan3)->addText("{$dataArray['App_cat']}", $cellstylebold, $cellafterleft);

    $table->addRow();
    $table->addCell(500)->addText('', $cellstylebold, $cellafter);
    $table->addCell(2500, $cellHCentered)->addText("Document Desc: ", $cellstylebold, $cellafterleft);
    $table->addCell(7000, $cellColSpan3)->addText("{$dataArray['doc_desc']}", $cellstylebold, $cellafterleft);

    $table->addRow();
    $table->addCell(500)->addText('', $cellstylebold, $cellafter);
    $table->addCell(2500, $cellHCentered)->addText("Long Desc: ", $cellstylebold, $cellafterleft);
    $table->addCell(7000, $cellColSpan3)->addText("{$dataArray['long_desc']}", $cellstylebold, $cellafterleft);

    $table->addRow();
    $table->addCell(500)->addText('', $cellstylebold, $cellafter);
    $table->addCell(2500, $cellHCentered)->addText("Prepared By: ", $cellstylebold, $cellafterleft);
    $table->addCell(2000)->addText("{$dataArray['Prepared_by']}", $cellstylebold, $cellafterleft);

    $table->addCell(2000)->addText("Date: ", $cellstylebold, $cellafterleft);
    $table->addCell(2000)->addText("{$dataArray['Date']}", $cellstylebold, $cellafterleft);

    $table->addRow();
    $table->addCell(500)->addText('', $cellstylebold, $cellafter);
    $table->addCell(2500, $cellHCentered)->addText("Valid From: ", $cellstylebold, $cellafterleft);
    $table->addCell(2000)->addText("{$dataArray['valid_from']}", $cellstylebold, $cellafterleft);

    $table->addCell(2000)->addText("ECO: ", $cellstylebold, $cellafterleft);
    $table->addCell(2000)->addText("{$dataArray['eco']}", $cellstylebold, $cellafterleft);

    $table = $section->addTable(array(
        'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
        'borderSize' => 6,
        'borderColor' => '999999',
        'spaceAfter' => 0)
    );

    $table->addRow();
    $table->addCell(9800, $cellColSpan3bgblack)->addText("Approvals", $cellstylenormal, $cellaftercenter);

    $table->addRow();
    $table->addCell(3300, $cellHCentered)->addText('Name', $cellstylesmallbold, $cellaftercenter);
    $table->addCell(3200, $cellHCentered)->addText("Function Area", $cellstylesmallbold, $cellafterleft);
    $table->addCell(3300)->addText("Date", $cellstylesmallbold, $cellaftercenter);    
    
    $table->addRow(9000);
    
    $section = $table->addCell(3200, $cellafterleft);	//for "Name" column
    $textrun = $section->createTextRun();
    $textrun->addText($RiskFMEAData['ProjectInfo']['Product Manager'], $cellstylenormal, $cellafterleft);
    $textrun->addTextBreak();
    $textrun->addText($RiskFMEAData['ProjectInfo']['Project Manager'], $cellstylenormal, $cellafterleft);
    $textrun->addTextBreak();
    $textrun->addText($RiskFMEAData['ProjectInfo']['Quality Engineer'], $cellstylenormal, $cellafterleft);
    $textrun->addTextBreak();
    $textrun->addText($RiskFMEAData['ProjectInfo']['System Engineer'], $cellstylenormal, $cellafterleft);
    $textrun->addTextBreak();
    $textrun->addText($RiskFMEAData['ProjectInfo']['Regulatory'], $cellstylenormal, $cellafterleft);
    $textrun->addTextBreak();
    $textrun->addText($RiskFMEAData['ProjectInfo']['Clinical'], $cellstylenormal, $cellafterleft);
    $textrun->addTextBreak();
    $textrun->addText($RiskFMEAData['ProjectInfo']['Risk Management Engineer'], $cellstylenormal, $cellafterleft);
    $textrun->addTextBreak();
    
    $section = $table->addCell(3200, $cellafterleft);	//for "Function area" column
    $textrun = $section->createTextRun();
    $textrun->addText('Market', $cellstylenormal, $cellafterleft);
    $textrun->addTextBreak();
    $textrun->addText('Project', $cellstylenormal, $cellafterleft);
    $textrun->addTextBreak();
    $textrun->addText('Quality', $cellstylenormal, $cellafterleft);
    $textrun->addTextBreak();
    $textrun->addText('System', $cellstylenormal, $cellafterleft);
    $textrun->addTextBreak();
    $textrun->addText('Regulatory', $cellstylenormal, $cellafterleft);
    $textrun->addTextBreak();
    $textrun->addText('Clinical', $cellstylenormal, $cellafterleft);
    $textrun->addTextBreak();
    $textrun->addText('Risk Management Engineer', $cellstylenormal, $cellafterleft);
    
    $section = $table->addCell(3200, $cellafterleft);
    $textrun = $section->createTextRun();
    $textrun->addText("9/8/2017", $cellstylenormal, $cellafterleft);
    $textrun->addTextBreak();
    $textrun->addText("9/8/2017", $cellstylenormal, $cellafterleft);
    $textrun->addTextBreak();
    $textrun->addText("9/8/2017", $cellstylenormal, $cellafterleft);
    $textrun->addTextBreak();
    $textrun->addText("9/8/2017", $cellstylenormal, $cellafterleft);
    $textrun->addTextBreak();
    $textrun->addText("9/8/2017", $cellstylenormal, $cellafterleft);
    $textrun->addTextBreak();
    $textrun->addText("9/8/2017", $cellstylenormal, $cellafterleft);
    $textrun->addTextBreak();
    $textrun->addText("9/8/2017", $cellstylenormal, $cellafterleft);

    $table->addRow();
    $table->addCell(9800, $cellColSpan3bgwhite)->addText("{$dataArray['electronic_sig']}", $cellstylesmall, $cellafterleft);
    $table->addRow();
    $table->addCell(9800, $cellColSpan3bgwhite)->addText("{$dataArray['declaration']}", $cellstylesmall, $cellafterleft);

    if (isset($dataArray['footerfirstpage'])) {
        $sectionfooter = $section->addFooter();
        \PhpOffice\PhpWord\Shared\Html::addHtml($sectionfooter, $dataArray['footerfirstpage']);
    }
    
    $section = $phpWord->addSection(array(
        'marginLeft' => 1000,
        'marginRight' => 1000,
        'marginTop' => 1000,
        'marginBottom' => 1000,
        'headerHeight' => 400,
        'footerHeight' => 400,
    ));

    $section->addText('Contents', $cellstylebold, $cellafter);
    $multilevelNumberingStyleName = 'multilevel';
    $fontStyleName = 'content_listing';
    $fontStyleNameHeading = 'content_heading';
    $fontStyleTableHeading = 'table_heading';
    $fontStyleNamecontent = 'content';
    $paragraphStyleName = 'paragraph';
    $phpWord->addFontStyle($fontStyleName, array('color' => 'FF0000', 'size' => 11));
    $phpWord->addFontStyle($fontStyleNameHeading, array('color' => 'FF0000', 'size' => 15, 'bold' => true));
    $phpWord->addFontStyle($fontStyleTableHeading, array('color' => 'FF0000', 'size' => 12, 'bold' => true));
    $phpWord->addFontStyle($fontStyleNamecontent, array('color' => 'FF0000', 'size' => 10));
    $phpWord->addNumberingStyle(
            $multilevelNumberingStyleName, array(
        'type' => 'multilevel',
        'levels' => array(
            array('format' => 'decimal', 'text' => '%1', 'left' => 360, 'hanging' => 360, 'tabPos' => 360),
            array('format' => 'decimal', 'text' => '%1.%2', 'left' => 720, 'hanging' => 360, 'tabPos' => 720),
        ),
        'font' => array('color' => 'FF0000'),
            )
    );


// Page item listing

    foreach ($dataArray['alldata'] as $key => $_data) {
        $level_id = 0;

        $section->addListItem($_data['title'], $level_id, $fontStyleName, $multilevelNumberingStyleName);

        if (isset($_data['childs'])) {

            foreach ($_data['childs'] as $_child) {
                $level_id = 1;
                $section->addListItem($_child['title'], $level_id, $fontStyleName, $multilevelNumberingStyleName);
            }
        }
    }
    
    $section->addTextBreak(2);
    $multilevelNumberingStyleName = 'multilevel2';
    $phpWord->addNumberingStyle(
            $multilevelNumberingStyleName, array(
        'type' => 'multilevel',
        'levels' => array(
            array('format' => 'decimal', 'text' => '%1', 'left' => 360, 'hanging' => 360, 'tabPos' => 360, 'font' => $multilevelNumberingStyleName),
            array('format' => 'decimal', 'text' => '%1.%2', 'left' => 720, 'hanging' => 360, 'tabPos' => 720, 'font' => $multilevelNumberingStyleName),
        ),
            )
    );

    $phpWord->setDefaultParagraphStyle(
            array(
                'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH,
                'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(12),
                'spacing' => 120,
            )
    );
    $content_left['indentation'] = array('left' => 500);

    // Content Starts here
    foreach ($dataArray['alldata'] as $key => $_data) {
        /* 	$textbox = $section->addTextBox(
          array(
          'alignment'   => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
          'width'       => 650,
          'height'      => 30,
          'borderSize'  => 2,
          'borderColor' => 'Teal',
          'fillColor'   => 'FF0000',
          'bgColor'     => 'FF0000'
          )
          ); */
        $level_id = 0;
        $section->addListItem($_data['title'], $level_id, $fontStyleNameHeading, $multilevelNumberingStyleName, $paragraphStyleName);
        /* $textbox->addText($_data['title'],$cellstylebold,$cellafter);
         */
        if (isset($_data['content'])) {

            $section->addText($_data['content'], $cellstylemedium, $content_left);
        }

        if (isset($_data['para'])) {
            foreach ($_data['para'] as $_para) {
                $section->addText($_para['content'], $cellstylemedium, $content_left);
            }
        }
        if (isset($_data['datatable'])) {

            $table = $section->addTable(array(
                'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
                'borderSize' => 6,
                'borderColor' => '999999')
            );
            $table_width = 9000;

            $table_column = count($_data['datatable'][0]);
            $column_width = $table_width / $table_column;
            $cellColcontent = array('gridSpan' => $table_column);
            if (isset($_data['datatabletitle'])) {

                $table->addRow();
                $table->addCell($table_width, $cellColcontent)->addText($_data['datatabletitle']['title'], $cellstylemedium, $cellaftercenter);
            }

            foreach ($_data['datatable'] as $key => $tablerow) {

                $column_width = $table_width / count($tablerow);
                if ($key == 0 && !isset($tablerow[0])) {

                    $table->addRow();

                    foreach ($tablerow as $column_id => $column_value) {

                        $table->addCell($column_width)->addText($column_id, $cellstylebold, $fontStyleTableHeading);
                    }
                }

                $table->addRow();

                foreach ($tablerow as $column_id => $column_value) {
                    if (is_array($column_value)) {

                        $cell = $table->addCell($column_width);
                        foreach ($column_value as $colum_value) {
                            $textrun = $cell->addTextRun();
                            foreach ($colum_value as $_colvalue) {

                                if ($_colvalue == "Xcheckbox") {
                                    $textrun->addFormField('checkbox')->setValue(true);
                                } elseif ($_colvalue == "checkbox") {
                                    $textrun->addFormField('checkbox');
                                } else {
                                    $textrun->addText($_colvalue, $cellstylemedium, $cellafterleft);
                                }
                            }
                        }
                    } else {

                        $cell = $table->addCell($column_width);
                        $textrun = $cell->addTextRun();

                        if ($column_value == "Xcheckbox") {
                            $textrun->addFormField('checkbox')->setValue(true);
                        } elseif ($column_value == "checkbox") {
                            $textrun->addFormField('checkbox');
                        } else {
                            $textrun->addText($column_value, $cellstylemedium, $cellafterleft);
                        }
                    }
                }
            }
            $section->addTextBreak(1);
        }
        $content_left['indentation'] = array('left' => 800);
        if (isset($_data['childs'])) {
            foreach ($_data['childs'] as $_child) {
                $level_id = 1;
                $section->addListItem($_child['title'], $level_id, $fontStyleNameHeading, $multilevelNumberingStyleName, $paragraphStyleName);
                if (isset($_child['content'])) {

                    $section->addText($_child['content'], $cellstylemedium, $content_left);
                }
                if (isset($_child['para'])) {
                    foreach ($_child['para'] as $_para) {
                        $section->addText($_para['content'], $cellstylemedium, $content_left);
                    }
                }
                if (isset($_child['datatable'])) {

                    $table = $section->addTable(array(
                        'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
                        'borderSize' => 6,
                        'borderColor' => '999999',
                        'spaceAfter' => 0)
                    );
                    $table_width = 9000;

                    $table_column = count($_child['datatable'][0]);
                    $column_width = $table_width / $table_column;
                    $cellColcontent = array('gridSpan' => $table_column);
                    if (isset($_child['datatabletitle'])) {

                        $table->addRow();
                        $table->addCell($table_width, $cellColcontent)->addText($_data['datatabletitle']['title'], $cellstylemedium, $cellaftercenter);
                    }

                    foreach ($_child['datatable'] as $key => $tablerow) {

                        if ($key == 0 && !isset($tablerow[0])) {

                            $table->addRow();

                            foreach ($tablerow as $column_id => $column_value) {

                                $table->addCell($column_width)->addText($column_id, $cellstylebold, $fontStyleTableHeading);
                            }
                        }
                        $table->addRow();

                        foreach ($tablerow as $column_id => $column_value) {
                            if (is_array($column_value)) {

                                $cell = $table->addCell($column_width);
                                $textrun = $cell->addTextRun();
                                foreach ($column_value as $colum_value) {
                                    $textrun = $cell->addTextRun();
                                    foreach ($colum_value as $_colvalue) {

                                        if ($_colvalue == "Xcheckbox") {
                                            $textrun->addFormField('checkbox')->setValue(true);
                                        } elseif ($_colvalue == "checkbox") {
                                            $textrun->addFormField('checkbox');
                                        } else {

                                            $textrun->addText($_colvalue, $cellstylemedium, $cellafterleft);
                                        }
                                    }
                                }
                            } else {
                                $cell = $table->addCell($column_width);
                                $textrun = $cell->addTextRun();

                                if ($column_value == "Xcheckbox") {
                                    $textrun->addFormField('checkbox')->setValue(true);
                                } elseif ($column_value == "checkbox") {
                                    $textrun->addFormField('checkbox');
                                } else {
                                    $textrun->addText($column_value, $cellstylemedium, $cellafterleft);
                                }
                            }
                        }
                    }
                }
                $section->addTextBreak(1);
            }
        }
    }
    
    if (isset($dataArray['footerallnextpages'])) {
        $sectionfooter = $section->addFooter();
        \PhpOffice\PhpWord\Shared\Html::addHtml($sectionfooter, $dataArray['footerallnextpages']);
    }
    
    // Save file
    echo write($phpWord, basename(__FILE__, '.php'), $writers);
    if (CLI) {
        return;
    }
}

/**
 * Write documents
 *
 * @param \PhpOffice\PhpWord\PhpWord $phpWord
 * @param string $filename
 * @param array $writers
 *
 * @return string
 */
function write($phpWord, $filename, $writers) {
    $result = '';

    // Write documents
    foreach ($writers as $format => $extension) {
        $result .= date('H:i:s') . " Write to {$format} format";
        if (null !== $extension) {
            $file = "results/{$filename}.{$extension}";
            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: public");
            header("Content-Description: File Transfer");
            header("Content-Type:application/zip"); // Send type of file
            $header = "Content-Disposition: attachment; filename={$filename}.{$extension}"; // Send File Name
            header($header);
            header("Content-Transfer-Encoding: binary");
            ob_clean();
            $phpWord->save("php://output");
            exit();
        } else {
            $result .= ' ... NOT DONE!';
        }
        $result .= EOL;
    }

    $result .= getEndingNotes($writers);

    return $result;
}

/**
 * Get ending notes
 *
 * @param array $writers
 *
 * @return string
 */
function getEndingNotes($writers) {
    $result = '';

    // Do not show execution time for index
    if (!IS_INDEX) {
        $result .= date('H:i:s') . " Done writing file(s)" . EOL;
        $result .= date('H:i:s') . " Peak memory usage: " . (memory_get_peak_usage(true) / 1024 / 1024) . " MB" . EOL;
    }

    // Return
    if (CLI) {
        $result .= 'The results are stored in the "results" subdirectory.' . EOL;
    } else {
        if (!IS_INDEX) {
            $types = array_values($writers);
            $result .= '<p>&nbsp;</p>';
            $result .= '<p>Results: ';
            foreach ($types as $type) {
                if (!is_null($type)) {
                    $resultFile = 'results/' . SCRIPT_FILENAME . '.' . $type;
                    if (file_exists($resultFile)) {
                        $result .= "<a href='{$resultFile}' class='btn btn-primary'>{$type}</a> ";
                    }
                }
            }
            $result .= '</p>';
        }
    }

    return $result;
}