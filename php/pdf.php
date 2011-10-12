<?php

define("BLANK_FILE", "blank.pdf");

require_once dirname(__FILE__) . "/MPDF/mpdf.php";


function WriteToPdf($vorgansnummer, $persons, $tours, $flugplan, $priceperson)
{

    $pdf = new mPDF('utf-8', 'A4', '8', '', 4, 4, 5, 0, 0, 0);

    $html = '<div id="page">
    <div id="header"></div>
    <div id="content">
        <h1>REISEANGEBOT</h1>

        <div class="vorgansnummer-wr">
            <div class="left">
                <div class="header">Vorgansnummer</div>
                <div class="nummer">' . $vorgansnummer . '</div>
            </div>
            <div class="right">
                <div>Datum: ' . date('d.m.Y') . '</div>
                <div>Sachbearbeiter: Paul Rawluschko</div>
            </div>

        </div>
        <div class="mainblock">
            <div class="persons">
                <span class="header">Reiseteilnehmer:</span>
                ';
    foreach ($persons as $ind => $person)
        $html .= '<div class="person"><div class="num">' . ($ind + 1) . '</div><div class="sex">' . $person['sex'] . '</div><div class="name">' . $person['name'] . '</div></div>';
    $html .= '
                <br class="clear"/>
            </div>
            <div class="tours">
                <span class="header">Leistung:</span>
                ';
    foreach ($tours as $ind => $tour)
        $html .= '<div class="tour"><div class="date">' . $tour['date'] . '</div><div class="content">' . $tour['date'] . '</div></div>';
    $html .= '
            </div>
            <div class="flugplan">
                <span class="header">Flugplan:</span>

                <div class="content"><pre>'.$flugplan.'</pre>
                </div>
            </div>
            <div class="price-wr">
                Preis p.P:
                <span class="price">'.$priceperson.',-&euro;</span>
            </div>
        </div>
        <div class="priceblock">
            Gesamptreis: <span class="price">'.($priceperson * count($persons)).'&euro;</span>
        </div>
        <div class="bottomblock">
            <div class="signature">
                <span>Bei Buchungswunsch bitte unterschrieben zurückfaxen:</span>

                <div class="line"></div>
            </div>
            <p>Mit freundlichen Grüßen</p>

            <span>Paul Rawluschko<br/>Unique World GmbH</span>
        </div>
    </div>
    <div id="footer"></div>
</div>';


    $stylesheet = file_get_contents(dirname(__FILE__) . '../css/pdf.css');

    $pdf->WriteHTML($stylesheet, 1);
    $pdf->list_indent_first_level = 0;
    $pdf->WriteHTML($html, 2);
    $pdf->Output('result.pdf', 'I');
}

?>