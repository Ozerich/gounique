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
    $total['stats']['flight'] += $formular->invoice_stats['flight']['amount'];
    $total['stats']['hotel'] += $formular->invoice_stats['hotel']['amount'];
    $total['stats']['rundreise'] += $formular->invoice_stats['rundreise']['amount'];
    $total['stats']['transfer'] += $formular->invoice_stats['transfer']['amount'];
    $total['stats']['other'] += $formular->invoice_stats['other']['amount'];
    $total['stats']['total'] += $formular->invoice_stats['total']['amount'];
?>
<tr class="rechnung-line">
    <input type="hidden" class="formular_id" value="<?=$formular->id?>"/>
    <td><?=($ind + 1)?></td>
    <td class="rg-num"><a href="reservierung/final/<?=$formular->id?>"><?=$formular->r_num?></a></td>
    <td><?=$formular->v_num?></td>
    <td><?=$formular->departure_date->format('d.M.Y')?></td>
    <td><?=@number_format($formular->brutto, 2, ',', '.')?></td>
    <td><?=@number_format($formular->total_diff, 2, ',', '.')?></td>
    <td><?=number_format($formular->invoice_stats['flight']['amount'], 2, ',', '.')?></td>
    <td><?=number_format($formular->invoice_stats['hotel']['amount'], 2, ',', '.')?></td>
    <td><?=number_format($formular->invoice_stats['rundreise']['amount'], 2, ',', '.')?></td>
    <td><?=number_format($formular->invoice_stats['transfer']['amount'], 2, ',', '.')?></td>
    <td><?=number_format($formular->invoice_stats['other']['amount'], 2, ',', '.')?></td>
    <td><?=number_format($formular->invoice_stats['total']['amount'] + $formular->provision_amount, 2, ',', '.')?></td>
    <td><?=$formular->departure_date->sub(new DateInterval('P14D'))->format('d.M.y')?></td>
</tr>
<? endforeach; ?>

<tr class="total">
    <td colspan="4">&nbsp;</td>
    <td><?=num($total['brutto'])?></td>
    <td><?=num($total['diff'])?></td>
    <td><?=num($total['stats']['flight'])?></td>
    <td><?=num($total['stats']['hotel'])?></td>
    <td><?=num($total['stats']['rundreise'])?></td>
    <td><?=num($total['stats']['transfer'])?></td>
    <td><?=num($total['stats']['other'])?></td>
    <td><?=num($total['stats']['total'])?></td>
    <td><?=num($total['ergebnis'])?></td>
</tr>