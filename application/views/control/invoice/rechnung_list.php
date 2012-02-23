<? foreach ($formulars as $ind=>$formular): ?>
<tr class="rechnung-line">
    <input type="hidden" class="formular_id" value="<?=$formular->id?>"/>
    <td><?=($ind + 1)?></td>
    <td><?=$formular->r_num?></td>
    <td><?=$formular->v_num?></td>
</tr>

<? endforeach; ?>
