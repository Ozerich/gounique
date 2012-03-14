<table class="product-list" id="statistics-list">
    <thead>
    <tr>
        <th class="num">№</th>
        <?if (!isset($fields) || isset($fields['r_num'])): ?>
        <th class="r_num">RG-NR</th><? endif;?>
        <?if (!isset($fields) || isset($fields['ag_num'])): ?>
        <th class="a_num">AG-NR</th><? endif;?>
        <?if (!isset($fields) || isset($fields['v_num'])): ?>
        <th class="v_num">Vorg-NR</th><? endif;?>
        <?if (!isset($fields) || isset($fields['rg_date'])): ?>
        <th class="rg_date">RG-Datum</th><? endif;?>
        <?if (!isset($fields) || isset($fields['type'])): ?>
        <th class="type">BG-Art</th><? endif;?>
        <?if (!isset($fields) || isset($fields['departure'])): ?>
        <th class="abreise">Abreise</th><? endif;?>
        <?if (!isset($fields) || isset($fields['arrive'])): ?>
        <th class="ruckreise">Rückreise</th><? endif;?>
        <?if (!isset($fields) || isset($fields['person'])): ?>
        <th class="person">Person</th><? endif;?>
        <?if (!isset($fields) || isset($fields['total'])): ?>
        <th class="total">Total-RG</th><? endif;?>
    </tr>
    </thead>
    <tbody>
    <? foreach ($formulars as $ind => $formular): ?>
    <tr>
        <td class="num"><?=($ind + 1)?></td>
        <?if (!isset($fields) || isset($fields['r_num'])): ?>
        <td class="r_num"><?=$formular->r_num?></td><? endif;?>
        <?if (!isset($fields) || isset($fields['ag_num'])): ?>
        <td class="a_num"><?=$formular->kunde->k_num?></td><? endif;?>
        <?if (!isset($fields) || isset($fields['v_num'])): ?>
        <td class="v_num"><?=$formular->v_num?></td><? endif;?>
        <?if (!isset($fields) || isset($fields['rg_date'])): ?>
        <td class="rg_date"><?=$formular->rechnung_date ? $formular->rechnung_date->format('d.M.Y') : '';?></td><? endif;?>
        <?if (!isset($fields) || isset($fields['type'])): ?>
        <td class="type"><?=$formular->type?></td><? endif;?>
        <?if (!isset($fields) || isset($fields['departure'])): ?>
        <td class="abreise"><?=$formular->departure_date ? $formular->departure_date->format('d.M.Y') : '-'?></td><? endif;?>
        <?if (!isset($fields) || isset($fields['arrive'])): ?>
        <td class="ruckreise"><?=$formular->arrival_date ? $formular->arrival_date->format('d.M.Y') : '-'?></td><? endif;?>
        <?if (!isset($fields) || isset($fields['person'])): ?>
        <td class="person"><?=$formular->person_count;?></td><? endif;?>
        <?if (!isset($fields) || isset($fields['total'])): ?>
        <td class="total"><?=num($formular->brutto);?></td><? endif;?>
    </tr>
        <? endforeach; ?>
    </tbody>
</table>