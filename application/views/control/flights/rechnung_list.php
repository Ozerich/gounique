<?
$total = array('brutto' => 0, 'diff' => 0, 'provision' => 0, 'ergebnis' => 0, 'stats' => array(
    'flight' => 0, 'hotel' => 0, 'rundreise' => 0, 'transfer' => 0, 'other' => 0, 'total' => 0,
));
foreach ($formulars as $ind => $formular):
    $total['brutto'] += $formular->brutto;
    $total['diff'] += $formular->total_diff;
    $total['provision'] += $formular->provision_amount;
    $ergebnis = $formular->brutto - $formular->provision_amount -  $formular->invoice_stats['total']['amount'];
    $total['ergebnis'] += $ergebnis;
   ?>
<tr class="rechnung-line">
    <input type="hidden" class="formular_id" value="<?=$formular->id?>"/>
    <td><?=($ind + 1)?></td>
    <td class="rg-num"><a href="reservierung/final/<?=$formular->id?>"><?=$formular->r_num?></a></td>
    <td><?=$formular->v_num?></td>
    <td><?=$formular->departure_date->format('d.M.Y')?></td>
    <td>0</td>
    <td>0</td>
    <td>0</td>
    <td>0</td>
    <td>0</td>
    <td>0</td>
    <td><?=$formular->departure_date->sub(new DateInterval('P14D'))->format('d.M.y')?></td>
</tr>
<? endforeach; ?>

<tr class="total">
    <td colspan="4">&nbsp;</td>
    <td><?=num($total['brutto'])?></td>
    <td><?=num($total['diff'])?></td>
    </tr>