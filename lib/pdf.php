<?php

define("BLANK_FILE", "UNI_Briefpapier.pdf");

require_once dirname(__FILE__) . "/MPDF/mpdf.php";
require_once LIB_DIR."search.php";

function WriteToPdf($vorgangnummer, $type)
{
    global $smarty;
    $pdf = new mPDF('utf-8', 'A4', '8', '', 4, 4, 25, 25, 0, 0);
    $pdf->SetImportUse();
    $pdf->AddPage();
    $pagecount = $pdf->SetSourceFile(BLANK_FILE);
    $tplId = $pdf->ImportPage($pagecount);
    $actualsize = $pdf->UseTemplate($tplId);

    FIllSmarty($vorgangnummer);


    $template = "";
    if($type == 1)
        $template = "angebot.html";
    elseif($type == 2)
        $template = "angebotK.html";
    elseif($type == 3)
        $template = "rechnung.html";
    elseif($type == 4)
        $template = "rechnungK.html";

    $html = $smarty->fetch("email/".$template);

    $stylesheet = file_get_contents(dirname(__FILE__) . '/../css/pdf.css');
    $pdf->WriteHTML($stylesheet, 1);
    $pdf->list_indent_first_level = 0;
    $pdf->WriteHTML($html, 2);

    $pdf->Output("pdf/".$vorgangnummer."_".$type.'.pdf', 'F');
}

?>