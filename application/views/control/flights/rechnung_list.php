<?
$total = array('amount' => 0, 'status' => 0, 'paid' => 0);

foreach ($formulars as $ind => $formular):
    $total['amount'] += $formular->flight_stats['amount'];
    $total['paid'] += $formular->flight_stats['paid'];
    $total['status'] += $formular->flight_stats['status'];
    ?>
<tr class="rechnung-line">
    <input type="hidden" class="formular_id" value="<?=$formular->id?>"/>
    <td><?=($ind + 1)?></td>
    <td class="rg-num"><a href="reservierung/final/<?=$formular->id?>"><?=$formular->r_num?></a></td>
    <td><?=$formular->plain_ownertype?></td>
    <td><?=$formular->v_num?></td>
    <td class="person"><?=$formular->person?></td>
    <td class="right"><?=$formular->departure_date->format('d.M.y')?></td>
    <td class="right reisedatum"><?=$formular->arrival_date ? $formular->arrival_date->format('d.M.y') : '-'?></td>
    <td class="right"><?=num($formular->flight_stats['amount'])?></td>
    <td class="right"><?=num($formular->flight_stats['paid'])?></td>
    <td class="right flightstatus"><?=$formular->flight_stats['status'] >= 0 ? "OK" : num($formular->flight_stats['status'])?></td>
    <td class="right"><?=$formular->departure_date->sub(new DateInterval('P14D'))->format('d.M.y')?></td>
    <td class="finance-comment-block no-popup">
        <div style="position:relative">
        <a class="finance-comment" onmouseout="return hide_comment_baloon(event);" onmouseover="return show_comment_baloon(event);" onclick="return open_comment(event);"></a>
        <div class="finance-new-comment">
            <textarea class="finance-new-comment-text"><?=$formular->payment_flight_comment?></textarea>
            <button class="finance-comment-close" onclick="close_comment(event)">Close</button>
            <button class="finance-comment-save" onclick="save_comment(event, 'flight');">Save</button>
        </div>
        <div class="comment-baloon"><pre><?=$formular->payment_flight_comment?></pre></div>
            </div>
    </td>
</tr>
<? endforeach; ?>

<tr class="total">
    <td colspan="5">&nbsp;</td>
    <td><?=num($total['amount'])?></td>
    <td><?=num($total['paid'])?></td>
    <td><?=num($total['status'])?></td>
    <td colspan="10">&nbsp;</td>
</tr>