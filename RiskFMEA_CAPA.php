<?php

/**
 * Export FMEA Worksheet to Excel spreadsheet.
 * 
 * @author Kevin Sawicke <kevin@rinconmountaintech.com>
 *
 * @since 1.0
 *
 * */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

date_default_timezone_set('America/Phoenix');

require_once dirname(__FILE__) . '/PHPExcel/Classes/PHPExcel.php';

$RiskFMEAData = getRiskFMEAData();
$spreadsheetRows = getSpreadsheetRows($RiskFMEAData['query_GetRiskRow'], $RiskFMEAData['Sorted_Num']);

outputFMEAWorksheetToExcel($spreadsheetRows, $RiskFMEAData['Project_ID'], $RiskFMEAData['Document_No'], $RiskFMEAData['Document_Revision']);

/**
 * Gets the RiskFMEAData from the database.
 */
function getRiskFMEAData() {
    include "Showroom_DB.php";
    
    $Project_ID = (isset($_REQUEST['Project']) ? $_REQUEST['Project'] : '');
    $Document_No = (isset($_REQUEST['Document']) ? $_REQUEST['Document'] : '');
    $Document_Revision = (isset($_REQUEST['Revision']) ? $_REQUEST['Revision'] : '');
    $Sort_No = (isset($_REQUEST['Sort']) ? $_REQUEST['Sort'] : '');
    $Rank_No = (isset($_REQUEST['Rank']) ? $_REQUEST['Rank'] : '');
    $Rec_Start = (isset($_REQUEST['Rec_Start']) ? $_REQUEST['Rec_Start'] : '');

    $query_GetProjectName = mysqli_query($con, "SELECT Project_ID FROM Project_Info");	

    $Project_Num = mysqli_num_rows($query_GetProjectName);

    while ($Project_Row = mysqli_fetch_array($query_GetProjectName)) {
        $Project_Lists[] = $Project_Row['Project_ID'];
    }

    $query_GetDocumentName = mysqli_query($con, "SELECT Document_No FROM DocumentReview_Approval WHERE Project_ID=\"$Project_ID\" AND Task_Abb = 'FMEA'");

    $Document_Num = mysqli_num_rows($query_GetDocumentName);

    while ($Document_Row = mysqli_fetch_array($query_GetDocumentName)) {
        $Document_Nos[] = $Document_Row['Document_No'];
    }

    $query_GetDocVersionNo = mysqli_query($con, "SELECT * FROM DocumentReview_Approval WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\"");

    $DocumentVersionNo_Num = mysqli_num_rows($query_GetDocVersionNo);

    while ($DocVersion_Row = mysqli_fetch_array($query_GetDocVersionNo)) {
        $Document_Revisions[] = $DocVersion_Row['Document_Revision'];
    }

    if (empty($Rec_Start)) {
        $Rec_Start = 0;                //use to record the current page (through Javascript)
    }
    //prepare all variables for outputs
    $Page_Limit = 15;

    if ($Sort_No == "All" || $Sort_No == "") {
        $query_TotalRiskRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\"");

        $Num_Total = mysqli_num_rows($query_TotalRiskRow);

        if ($Rank_No == "Risk_ID" || $Rank_No == "") {
            $query_GetRiskRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" ORDER BY Risk_ID ASC LIMIT 15 OFFSET $Rec_Start");
        } else if ($Rank_No == "RiskRank_Pre") {
            $query_GetRiskRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\"  ORDER BY RiskRank_Pre DESC LIMIT 15 OFFSET $Rec_Start");
        } else if ($Rank_No == "RiskRank_Post") {
            $query_GetRiskRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\"  ORDER BY RiskRank_Post DESC LIMIT 15 OFFSET $Rec_Start");
        }
    } else if ($Sort_No == "RiskRank_Pre") {
        $query_TotalRiskRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND RiskRank_Pre='INT'");
        $Num_Total = mysqli_num_rows($query_TotalRiskRow);

        if ($Rank_No == "Risk_ID" || $Rank_No == "RiskRank_Pre" || $Rank_No == "") {
            $query_GetRiskRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND RiskRank_Pre='INT' ORDER BY Risk_ID ASC LIMIT 15 OFFSET $Rec_Start");
        } else if ($Rank_No == "RiskRank_Post") {
            $query_GetRiskRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND RiskRank_Pre='INT' ORDER BY RiskRank_Post DESC LIMIT 15 OFFSET $Rec_Start");
        }
    } else if ($Sort_No == "RiskRank_Post") {
        $query_TotalRiskRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND RiskRank_Post='INT'");

        $Num_Total = mysqli_num_rows($query_TotalRiskRow);

        if ($Rank_No == "Risk_ID" || $Rank_No == "RiskRank_Post" || $Rank_No == "") {
            $query_GetRiskRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND RiskRank_Post='INT' ORDER BY Risk_ID ASC LIMIT 15 OFFSET $Rec_Start");
        } else if ($Rank_No == "RiskRank_Pre") {
            $query_GetRiskRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND RiskRank_Post='INT' ORDER BY RiskRank_Pre DESC LIMIT 15 OFFSET $Rec_Start");
        }
    } else if ($Sort_No == "Verification_Result") {
        $query_TotalRiskRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Verification_Result='Fail'");

        $Num_Total = mysqli_num_rows($query_TotalRiskRow);

        if ($Rank_No == "Risk_ID" || $Rank_No == "RiskRank_Pre" || $Rank_No == "") {
            $query_GetRiskRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Verification_Result='Fail' ORDER BY Risk_ID ASC LIMIT 15 OFFSET $Rec_Start");
        } else if ($Rank_No == "RiskRank_Post") {
            $query_GetRiskRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND Verification_Result='Fail' ORDER BY RiskRank_Post DESC LIMIT 15 OFFSET $Rec_Start");
        }
    } else if ($Sort_No == "RBA_Result") {
        $query_TotalRiskRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND RBA_Result='Fail'");

        $Num_Total = mysqli_num_rows($query_TotalRiskRow);

        if ($Rank_No == "Risk_ID" || $Rank_No == "RiskRank_Pre" || $Rank_No == "") {
            $query_GetRiskRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND RBA_Result='Fail' ORDER BY Risk_ID ASC LIMIT 15 OFFSET $Rec_Start");
        } else if ($Rank_No == "RiskRank_Post") {
            $query_GetRiskRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND RBA_Result='Fail' ORDER BY RiskRank_Post DESC LIMIT 15 OFFSET $Rec_Start");
        }
    } else if ($Sort_No == "NewHazard_Result") {
        $query_TotalRiskRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND NewHazard_Result='Yes'");

        $Num_Total = mysqli_num_rows($query_TotalRiskRow);

        if ($Rank_No == "Risk_ID" || $Rank_No == "RiskRank_Pre" || $Rank_No == "") {
            $query_GetRiskRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND NewHazard_Result='Yes' ORDER BY Risk_ID ASC LIMIT 15 OFFSET $Rec_Start");
        } else if ($Rank_No == "RiskRank_Post") {
            $query_GetRiskRow = mysqli_query($con, "SELECT * FROM Risk_FMEA WHERE Project_ID=\"$Project_ID\" AND Document_No=\"$Document_No\" AND Document_Revision=\"$Document_Revision\" AND NewHazard_Result='Yes' ORDER BY RiskRank_Post DESC LIMIT 15 OFFSET $Rec_Start");
        }
    }

    $Sorted_Num = mysqli_num_rows($query_GetRiskRow);

    return ['query_GetRiskRow' => $query_GetRiskRow,
        'Sorted_Num' => $Sorted_Num,
        'Project_ID' => $Project_ID,
        'Document_No' => $Document_No,
        'Document_Revision' => $Document_Revision
    ];
}

function getSpreadsheetRows($query_GetRiskRow, $Sorted_Num) {
    $spreadsheetRows = [];
    $i = 0;
    $lfcr = chr(13);

    for ($RiskID = 1; $RiskID < $Sorted_Num + 1; $RiskID++) {  //$RiskID means the sequenctial of sorted risks, random number
        $Risk_Row = mysqli_fetch_array($query_GetRiskRow);

        $spreadsheetRows[$i][0] = $Risk_Row['Risk_ID'];
        $spreadsheetRows[$i][1] = $Risk_Row['Level'];
        $spreadsheetRows[$i][2] = $Risk_Row['Model'];
        $spreadsheetRows[$i][3] = $Risk_Row['Desc_Document'];
		$spreadsheetRows[$i][4] = $Risk_Row['Description'];
        $spreadsheetRows[$i][5] = $Risk_Row['Failure_Mode'];
        $spreadsheetRows[$i][6] = $Risk_Row['Failure_Cause'];
        $spreadsheetRows[$i][7] = $Risk_Row['Problem_Category'];
        $spreadsheetRows[$i][8] = $Risk_Row['Sub_Category'];
		$spreadsheetRows[$i][9] = $Risk_Row['Hazard'];
		$spreadsheetRows[$i][10] = $Risk_Row['NCI_Code'];
		$spreadsheetRows[$i][11] = $Risk_Row['Hazard_Situation'];
		$spreadsheetRows[$i][12] = $Risk_Row['Harm'];
		$spreadsheetRows[$i][13] = $Risk_Row['CurrentControl_Design'];
		
        $spreadsheetRows[$i][14] = $Risk_Row['S_Pre'];
		$spreadsheetRows[$i][15] = $Risk_Row['P1_Pre'];
        $spreadsheetRows[$i][16] = $Risk_Row['P2_Pre'];
		$spreadsheetRows[$i][17] = $Risk_Row['P_Pre'];
        $spreadsheetRows[$i][18] = $Risk_Row['RiskRank_Pre'];

        $spreadsheetRows[$i][19] = 
        $Risk_Row['MitigationAction_Design'];
		
      
        $spreadsheetRows[$i][20] =
		$Risk_Row['S_Post'];
		$spreadsheetRows[$i][21] =
        $Risk_Row['P1_Post'];
        $spreadsheetRows[$i][22] = $Risk_Row['P2_Post'];
		$spreadsheetRows[$i][23] = $Risk_Row['P_Post'];
 

        $i++;
    }

    return $spreadsheetRows;
}

function printSpreadSheetRows($spreadsheetRows) {
    echo'<pre>';
    print_r($spreadsheetRows);
    echo'</pre>';
    die;
}

function outputFMEAWorksheetToExcel($spreadsheetRows = [], $Project_ID = '', $Document_No = '', $Document_Revision = '') {
    /**
     * Include PHPExcel
     */
    $objPHPExcel = new PHPExcel();

    // Initialize spreadsheet
    $objPHPExcel->setActiveSheetIndex(0);
    $worksheet = $objPHPExcel->getActiveSheet();
    $worksheet->getStyle('A1:Y100')->getAlignment()->setWrapText(true);
    $worksheet->getStyle("A1:Y100")->applyFromArray(
            array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => 'ffffff')
                    )
                )
            )
    );
	
	    $worksheet->getStyle("B5:Y6")->applyFromArray(
            array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => 'F0F8FF')
                    )
                )
            )
    );

    $lfcr = chr(13);

    $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('B7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('G7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('P7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('V7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	
    $objPHPExcel->getActiveSheet()->getStyle('U4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('U5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('U6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	
    $objPHPExcel->getActiveSheet()->getStyle('V4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('V5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('V6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    
    $objPHPExcel->getActiveSheet()->getStyle('B8:AA8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    
    $objPHPExcel->getActiveSheet()->freezePane('B7');
    // $objPHPExcel->getActiveSheet()->setShowGridlines(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("10");
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("12.43");
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth("12.71");
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth("12.71");
	
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth("18.71");
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth("18.71");
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth("18.71");
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth("18.71");
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth("16.86");
    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth("12.");
    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth("18.86");
    $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth("10");
    $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth("10");
    $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth("10");
    $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth("10");
    $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth("12");
    $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth("22");
    $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth("10");
    $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth("10");
    $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth("10");
    $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth("10");
    $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth("12");
	$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth("12");
	$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth("16");

    
	
	$objPHPExcel->getActiveSheet()->mergeCells('B3:Y3');
    $objPHPExcel->getActiveSheet()->mergeCells('B1:Y2');
    $objPHPExcel->getActiveSheet()->mergeCells('A1:A8');
    //$worksheet->getRowDimension(8)->setRowHeight("48.00");
    $objPHPExcel->getActiveSheet()->mergeCells('B5:E5');
    $objPHPExcel->getActiveSheet()->mergeCells('F5:W5');
    $objPHPExcel->getActiveSheet()->mergeCells('X5:Y5');
    
    $worksheet->setCellValue('B3', "CAPA TRIGGER WORKSHEET");
    $worksheet->setCellValue('B5', "Trigger Condition");
    $worksheet->setCellValue('F5', "Hazard Description");
    $worksheet->setCellValue('X5', "CAPA Results");
   

    $worksheet->setCellValue('B6', "Trigger ID");
	$worksheet->setCellValue('C6', "Trigger Cause");
	$worksheet->setCellValue('D6', "Trigger by");
	$worksheet->setCellValue('E6', "Trigger Date");
	
    $worksheet->setCellValue('F6', "FMEA Document");
    $worksheet->setCellValue('G6', "Risk ID");
    $worksheet->setCellValue('H6', "Hazard");
    $worksheet->setCellValue('I6', "Hazardous Situations");
    $worksheet->setCellValue('J6', "Harm");
    $worksheet->setCellValue('K6', "NCI Code");
    $worksheet->setCellValue('L6', "Sub-Process Control");
    $worksheet->setCellValue('M6', "Pre_S");
    $worksheet->setCellValue('N6', "Pre_P1");
    $worksheet->setCellValue('O6', "Pre_P2");
    $worksheet->setCellValue('P6', "Pre_P");
    $worksheet->setCellValue('Q6', "Pre_RR");
    $worksheet->setCellValue('R6', "Risk Control Measure");
    $worksheet->setCellValue('S6', "Post_S");
    $worksheet->setCellValue('T6', "Post_P1");
	$worksheet->setCellValue('U6', "Post_P2");
	$worksheet->setCellValue('V6', "Post_P");
	$worksheet->setCellValue('W6', "Post_RR");
	
	$worksheet->setCellValue('X6', "CAPA");
	$worksheet->setCellValue('Y6', "Comments");
    

    $worksheet->getStyle('E9')->getAlignment()->setWrapText(true);
    $worksheet->getStyle('F9')->getAlignment()->setWrapText(true);
    $worksheet->getStyle('G9')->getAlignment()->setWrapText(true);
    $worksheet->getStyle('H9')->getAlignment()->setWrapText(true);
    $worksheet->getStyle('I9')->getAlignment()->setWrapText(true);
    $worksheet->getStyle('J9')->getAlignment()->setWrapText(true);
    $styleArray = array('borders' => array('outline' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '000000'))));
    for ($i = 5; $i <= 20; $i++) {
        $worksheet->getStyle("B" . $i)->applyFromArray($styleArray);
        $worksheet->getStyle("C" . $i)->applyFromArray($styleArray);
        $worksheet->getStyle("D" . $i)->applyFromArray($styleArray);
        $worksheet->getStyle("E" . $i)->applyFromArray($styleArray);
        $worksheet->getStyle("F" . $i)->applyFromArray($styleArray);
        $worksheet->getStyle("G" . $i)->applyFromArray($styleArray);
        $worksheet->getStyle("H" . $i)->applyFromArray($styleArray);
        $worksheet->getStyle("I" . $i)->applyFromArray($styleArray);
        $worksheet->getStyle("J" . $i)->applyFromArray($styleArray);
        $worksheet->getStyle("K" . $i)->applyFromArray($styleArray);
        $worksheet->getStyle("L" . $i)->applyFromArray($styleArray);
        $worksheet->getStyle("M" . $i)->applyFromArray($styleArray);
        $worksheet->getStyle("N" . $i)->applyFromArray($styleArray);
        $worksheet->getStyle("O" . $i)->applyFromArray($styleArray);
        $worksheet->getStyle("P" . $i)->applyFromArray($styleArray);
        $worksheet->getStyle("Q" . $i)->applyFromArray($styleArray);
        $worksheet->getStyle("R" . $i)->applyFromArray($styleArray);
        $worksheet->getStyle("S" . $i)->applyFromArray($styleArray);
        $worksheet->getStyle("T" . $i)->applyFromArray($styleArray);
        $worksheet->getStyle("U" . $i)->applyFromArray($styleArray);
        $worksheet->getStyle("V" . $i)->applyFromArray($styleArray);
        $worksheet->getStyle("W" . $i)->applyFromArray($styleArray);
        $worksheet->getStyle("X" . $i)->applyFromArray($styleArray);
		$worksheet->getStyle("Y" . $i)->applyFromArray($styleArray);

        
        $objPHPExcel->getActiveSheet()->getStyle('B' . $i . ':Y' . $i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		
		$objPHPExcel->getActiveSheet()->getStyle('B' . $i . ':Y' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			
    }
	
	$objPHPExcel->getActiveSheet()->getStyle('B5:Y6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	
	$objPHPExcel->getActiveSheet()->getStyle('B5:Y6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	
    $styleArr = array('borders' => array('outline' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => 'FFFFFF'),),),);
    $worksheet->getStyle("B6")->applyFromArray($styleArr);
    $worksheet->getStyle("U6")->applyFromArray($styleArr);
    $worksheet->getStyle("V6")->applyFromArray($styleArr);

    $objPHPExcel->getActiveSheet()->getStyle("B3:W3")->getFont()->setSize(16);

    $worksheet->getStyle('B5:Y6')
            ->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('1E90FF');
	
	$worksheet->getStyle('B5:Y6')
            ->getFont()
            ->setBold(True)
            ->getColor()
            ->setRGB('FFFFFF');

    foreach ($spreadsheetRows as $key => $spreadsheetRow) {
        if ($spreadsheetRow[11] == 'C') {
            $worksheet->getStyle('M' . ($key + 9))
                    ->getFill()
                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('f9ec4d');
        } elseif ($spreadsheetRow[11] == 'C') {
            $worksheet->getStyle('M' . ($key + 9))
                    ->getFill()
                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('de1c1c');
        }

        if ($spreadsheetRow[19] == 'A') {
            $worksheet->getStyle('U' . ($key + 9))
                    ->getFill()
                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('f9ec4d');
        } elseif ($spreadsheetRow[19] == 'C') {
            $worksheet->getStyle('U' . ($key + 9))
                    ->getFill()
                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('de1c1c');
        }

        $worksheet->setCellValue('B' . ($key + 9), $spreadsheetRow[0]);
        $worksheet->setCellValue('C' . ($key + 9), $spreadsheetRow[1]);
        $worksheet->setCellValue('D' . ($key + 9), $spreadsheetRow[2]);
        $worksheet->setCellValue('E' . ($key + 9), $spreadsheetRow[3]);
        $worksheet->setCellValue('F' . ($key + 9), $spreadsheetRow[4]);
        $worksheet->setCellValue('G' . ($key + 9), $spreadsheetRow[5]);
        $worksheet->setCellValue('H' . ($key + 9), $spreadsheetRow[6]);
        $worksheet->setCellValue('I' . ($key + 9), $spreadsheetRow[7]);
        $worksheet->setCellValue('J' . ($key + 9), $spreadsheetRow[8]);
        $worksheet->setCellValue('K' . ($key + 9), $spreadsheetRow[9]);
        $worksheet->setCellValue('L' . ($key + 9), $spreadsheetRow[10]);
        $worksheet->setCellValue('M' . ($key + 9), $spreadsheetRow[11]);
        $worksheet->setCellValue('N' . ($key + 9), $spreadsheetRow[12]);
        $worksheet->setCellValue('O' . ($key + 9), $spreadsheetRow[13]);
        $worksheet->setCellValue('P' . ($key + 9), $spreadsheetRow[14]);
        $worksheet->setCellValue('Q' . ($key + 9), $spreadsheetRow[15]);
        $worksheet->setCellValue('R' . ($key + 9), $spreadsheetRow[16]);
        $worksheet->setCellValue('S' . ($key + 9), $spreadsheetRow[17]);
        $worksheet->setCellValue('T' . ($key + 9), $spreadsheetRow[18]);
        $worksheet->setCellValue('U' . ($key + 9), $spreadsheetRow[19]);
        $worksheet->setCellValue('V' . ($key + 9), $spreadsheetRow[20]);
        $worksheet->setCellValue('W' . ($key + 9), $spreadsheetRow[21]);
        $worksheet->setCellValue('X' . ($key + 9), $spreadsheetRow[22]);
		$worksheet->setCellValue('Y' . ($key + 9), $spreadsheetRow[23]);
    }

    // Redirect output to a client’s web browser (Excel2007)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="FMEACAPAWorksheet.xlsx"');
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

    // If you're serving to IE over SSL, then the following may be needed
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	ob_end_clean();
    $objWriter->save('php://output');
    exit;
}
