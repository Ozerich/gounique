<? foreach ($formulars as $formular): ?>
<tr>
    <td><?=$formular->v_num?></td>
    <td><?=$formular->r_num?></td>
    <td><?=$formular->created_date->format('d.M.Y')?></td>
    <td><?=$formular->rechnung_date->format('d.M.Y')?></td>
    <td><?=$formular->departure_date->format('d.M.Y')?></td>
    <td><?=$formular->arrival_date ? $formular->arrival_date->format('d.M.Y') : ''?></td>
    <? if ($formular->is_sofort): ?>
    <td colspan="3">SOFORT</td>
    <? else: ?>
    <td><?=$formular->prepayment_amount?></td>
    <td><?=$formular->prepayment_date ? $formular->prepayment_date->format('d.M.Y') : ''?></td>
    <td>-</td>
    <? endif; ?>
    <td><?=$formular->finalpayment_amount?></td>
    <td><?=$formular->finalpayment_date ? $formular->finalpayment_date->format('d.M.Y') : ''?></td>
    <td>-</td>
    <td>-</td>
    <td>-</td>
    <td>-</td>
    <input type="hidden" class="formular_id" value="<?=$formular->id?>"/>
</tr>
<? endforeach; ?>
