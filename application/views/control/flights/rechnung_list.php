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
    <td><?=$formular->v_num?></td>
    <td class="right"><?=$formular->departure_date->format('d.M.y')?></td>
    <td class="right"><?=num($formular->flight_stats['amount'])?></td>
    <td class="right"><?=num($formular->flight_stats['paid'])?></td>
    <td class="right"><?=$formular->flight_stats['status'] >= 0 ? "OK" : num($formular->flight_stats['status'])?></td>
    <td class="right"><?=$formular->departure_date->sub(new DateInterval('P14D'))->format('d.M.y')?></td>
</tr>
<? endforeach; ?>

<tr class="total">
    <td colspan="4">&nbsp;</td>
    <td><?=num($total['amount'])?></td>
    <td><?=num($total['paid'])?></td>
    <td><?=num($total['status'])?></td>
    <td colspan="10">&nbsp;</td>
</tr>