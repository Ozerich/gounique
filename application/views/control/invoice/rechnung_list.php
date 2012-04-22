<?
$total = array('brutto' => 0, 'diff' => 0, 'provision' => 0, 'ergebnis' => 0, 'stats' => array(
    'flight' => 0, 'hotel' => 0, 'rundreise' => 0, 'transfer' => 0, 'other' => 0, 'total' => 0,
));
foreach ($formulars as $ind => $formular):
    $total['brutto'] += $formular->brutto;
    $total['diff'] += $formular->total_diff;
    $total['provision'] += 0;
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
    <td class="person"><?=$formular->person?></td>
    <td class="right"><?=$formular->departure_date->format('d.M.y')?></td>
    <td class="right"><?=@number_format($formular->brutto, 2, ',', '.')?></td>
    <td class="right"><?=number_format($formular->invoice_stats['hotel']['amount'], 2, ',', '.')?></td>
    <td class="right"><?=number_format($formular->invoice_stats['rundreise']['amount'], 2, ',', '.')?></td>
    <td class="right"><?=number_format($formular->invoice_stats['transfer']['amount'], 2, ',', '.')?></td>
    <td class="right"><?=number_format($formular->invoice_stats['other']['amount'], 2, ',', '.')?></td>
    <td class="right"><?=number_format($formular->invoice_stats['total']['amount'], 2, ',', '.')?></td>
    <td class="right"><?=$formular->departure_date->sub(new DateInterval('P14D'))->format('d.M.y')?></td>
    <td class="finance-comment-block no-popup">
        <a class="finance-comment" onmouseout="return hide_comment_baloon(event);" onmouseover="return show_comment_baloon(event);" onclick="return open_comment(event);"></a>
        <div class="finance-new-comment">
            <textarea class="finance-new-comment-text"><?=$formular->payment_land_comment?></textarea>
            <button class="finance-comment-close" onclick="close_comment(event)">Close</button>
            <button class="finance-comment-save" onclick="save_comment(event, 'land');">Save</button>
        </div>
        <div class="comment-baloon"><pre><?=$formular->payment_land_comment?></pre></div>
    </td>
</tr>
<? endforeach; ?>

<tr class="total">
    <td colspan="4">&nbsp;</td>
    <td class="right"><?=num($total['brutto'])?></td>
    <td class="right"><?=num($total['stats']['hotel'])?></td>
    <td class="right"><?=num($total['stats']['rundreise'])?></td>
    <td class="right"><?=num($total['stats']['transfer'])?></td>
    <td class="right"><?=num($total['stats']['other'])?></td>
    <td class="right"><?=num($total['stats']['total'])?></td>
    <td class="right"><?=num($total['ergebnis'])?></td>
    <td>&nbsp;</td>
</tr>