<?php

function nextCol($letter) {
    $z_ascii = ord('Z');
    $next = "";
    if (strlen($letter) === 1) {
        $letterAscii = ord($letter);
        $nextAscii = $letterAscii+= 1;
        if ($z_ascii < $nextAscii) {
            $letter = "AA";
        } else {
            $letter = chr($nextAscii);
        }
    } else if (strlen($letter) === 2) {
        $first = substr($letter, 0, 1);
        $second = substr($letter, 1, 1);

        $secondAscii = ord($second) + 1;
        if ($z_ascii < $secondAscii) {
            $second = 'A';
            $firstAscii = ord($first) + 1;
            $first = chr($firstAscii);
        } else {
            $second = chr($secondAscii);
        }
        return $first . $second;
    }
    return $letter;
}

function createReport() {
    $search_text = $_SESSION['search_text'];
    include ('PHPExcel.php');
    $phpExcel = new PHPExcel;
    $search_result = search($search_text);
    if ($search_text === "*") {
        $search_result = getAllEmployees();
    }
    $skills = getSkillsAssociated($search_text);

// Setting font to Arial Black

    $phpExcel->getDefaultStyle()->getFont()->setName('Calibri');

// Setting font size to 14

    $phpExcel->getDefaultStyle()->getFont()->setSize(11);

//Setting description, creator and title

    $phpExcel->getProperties()->setTitle("Zensar-Report");

    $phpExcel->getProperties()->setCreator("Ntshovelo Makwarela, Dynah Khama, Andile Hlophe");
//
    $phpExcel->getProperties()->setDescription("Excel SpreadSheet in PHP");

// Creating PHPExcel spreadsheet writer object
// We will create xlsx file (Excel 2007 and above)

    $writer = PHPExcel_IOFactory::createWriter($phpExcel, "Excel2007");

// When creating the writer object, the first sheet is also created
// We will get the already created sheet

    $sheet = $phpExcel->getActiveSheet();
// Setting title of the sheet

    $sheet->setTitle("Resource List");
//Creating spreadsheet header
    $sheet->getCell('A1')->setValue('Division');

    $sheet->getCell('B1')->setValue('Resource');

    $sheet->getCell('C1')->setValue("Role");

// Making headers text bold and larger
// Insert product data
// Autosize the columns
    $sheet->getColumnDimension('A')->setAutoSize(true);

    $sheet->getColumnDimension('B')->setAutoSize(true);

    $sheet->getColumnDimension('C')->setAutoSize(true);

//MERGING CELLS
//$phpExcel->getActiveSheet()->mergeCells($pRange = 'A1:A2');

    $col = 'D';
    while ($row = mysqli_fetch_array($skills)) {
        $sheet->getCell($col . 1)->setValue($row['SKILL_DESCRIPTION']);
        $sheet->getColumnDimension($col)->setAutoSize(true);
        $col = nextCol($col);
    }

    $sheet->getStyle('A1:' . $col . '1')->getFont()->setBold(true)->setSize(11);
    $x = 3;
    while ($row = mysqli_fetch_array($search_result)) {
        $sheet->getCell('B' . $x)->setValue($row['NAMES']);



        $sheet->getCell('C' . $x)->setValue($row['ROLE_DESCRIPTION']);
        $sheet->getCell('A' . $x)->setValue($row['DIV_DESCRIPTION']);
        $col1 = 'D';
        $skills = getSkillsAssociated($search_text);
        while ($row1 = mysqli_fetch_array($skills)) {
            $level = getEmployeeSkillLevel($row['EMP_ID'], $row1['SKILL_ID']);
            $sheet->getCell($col1 . $x)->setValue($level);
            $col1 = nextCol($col1);
        }
        $x++;
    }
    $filename = "Reports/".$search_text . '-report.xlsx';
    if ($search_text === "*") {
        $filename = 'All-report.xlsx';
    }

    $writer->save($filename);
    header("Location: $filename");
}
?>

