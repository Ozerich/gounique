<table class="product-list" id="statistics-list">
    <thead>
    <tr>
        <th class="num">№</th>
        <th class="r_num">RG-NR</th>
        <th class="a_num">AG-NR</th>
        <th class="v_num">Vorg-NR</th>
        <th class="rg_date">RG-Datum</th>
        <th class="type">BG-Art</th>
        <th class="abreise">Abreise</th>
        <th class="ruckreise">Rückreise</th>
        <th class="person">Person</th>
        <th class="total">Total-RG</th>
    </tr>
    </thead>
    <tbody>
        <? foreach($formulars as $ind => $formular): ?>
            <tr>
                <td class="num"><?=($ind + 1)?></td>
                <td class="r_num"><?=$formular->r_num?></td>
                <td class="a_num"><?=$formular->kunde->k_num?></td>
                <td class="v_num"><?=$formular->v_num?></td>
                <td class="rg_date"><?=$formular->rechnung_date->format('d.M.Y');?></td>
                <td class="type"><?=$formular->type?></td>
                <td class="abreise"><?=$formular->departure_date->format('d.M.Y')?></td>
                <td class="ruckreise"><?=$formular->arrival_date ? $formular->arrival_date->format('d.M.Y') : '-'?></td>
                <td class="person"><?=$formular->person_count;?></td>
                <td class="total"><?=num($formular->brutto);?></td>
            </tr>
        <? endforeach; ?>
    </tbody>
</table>