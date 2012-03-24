<table class="product-list" id="previewstats-list">
    <thead>
    <tr>
        <th>BG-ART</th>
        <th>Anzahl</th>
        <th>Persons</th>
        <th>Total</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="type">Pausschalreise</td>
        <td><?=$type_stats['pausschalreise']['count']?></td>
        <td><?=$type_stats['pausschalreise']['persons']?></td>
        <td><?=num($type_stats['pausschalreise']['total'])?></td>
    </tr>
    <tr>
        <td class="type">Bausteinreise</td>
        <td><?=$type_stats['bausteinreise']['count']?></td>
        <td><?=$type_stats['bausteinreise']['persons']?></td>
        <td><?=num($type_stats['bausteinreise']['total'])?></td>
    </tr>
    <tr>
        <td class="type">Nur Flug</td>
        <td><?=$type_stats['nurflug']['count']?></td>
        <td><?=$type_stats['nurflug']['persons']?></td>
        <td><?=num($type_stats['nurflug']['total'])?></td>
    </tr>
    <tr class="total">
        <td class="type">Total</td>
        <td><?=$type_stats['pausschalreise']['count'] + $type_stats['bausteinreise']['count'] + $type_stats['nurflug']['count']?></td>
        <td><?=$type_stats['pausschalreise']['persons'] + $type_stats['bausteinreise']['persons'] + $type_stats['nurflug']['persons']?></td>
        <td><?=num($type_stats['pausschalreise']['total'] + $type_stats['bausteinreise']['total'] + $type_stats['nurflug']['total'])?></td>
    </tr>
    </tbody>
</table>
<table class="product-list" id="statistics-list">
    <thead>
    <tr>
        <th class="num">№</th>
        <?if (!isset($fields) || isset($fields['owner_type'])): ?>
        <th class="owner_type">BQ</th><? endif;?>
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
    <? if (!$formulars): ?>
    <tr class="empty">
        <td colspan="20">No formulars found</td>
    </tr>
        <? else:
        $total = $total_person = 0;
        foreach ($formulars as $ind => $formular):
            $total += $formular->brutto;
            $total_person += $formular->person_count;
        ?>
    <tr>
        <td class="num"><?=($ind + 1)?></td>
        <?if (!isset($fields) || isset($fields['owner_type'])): ?>
        <td class="owner_type"><?=$formular->plain_ownertype?></td><? endif;?>
        <?if (!isset($fields) || isset($fields['r_num'])): ?>
        <td class="r_num"><?=$formular->r_num?></td><? endif;?>
        <?if (!isset($fields) || isset($fields['ag_num'])): ?>
        <td class="a_num"><?=$formular->kunde ? $formular->kunde->k_num : '-'?></td><? endif;?>
        <?if (!isset($fields) || isset($fields['v_num'])): ?>
        <td class="v_num"><?=$formular->v_num?></td><? endif;?>
        <?if (!isset($fields) || isset($fields['rg_date'])): ?>
        <td class="rg_date"><?=$formular->rechnung_date ? $formular->rechnung_date->format('d.M.Y') : '';?></td><? endif;?>
        <?if (!isset($fields) || isset($fields['type'])): ?>
        <td class="type"><?=$formular->stats_type?></td><? endif;?>
        <?if (!isset($fields) || isset($fields['departure'])): ?>
        <td class="abreise"><?=$formular->departure_date ? $formular->departure_date->format('d.M.Y') : '-'?></td><? endif;?>
        <?if (!isset($fields) || isset($fields['arrive'])): ?>
        <td class="ruckreise"><?=$formular->arrival_date ? $formular->arrival_date->format('d.M.Y') : '-'?></td><? endif;?>
        <?if (!isset($fields) || isset($fields['person'])): ?>
        <td class="person"><?=$formular->person_count;?></td><? endif;?>
        <?if (!isset($fields) || isset($fields['total'])): ?>
        <td class="total money"><?=num($formular->brutto);?></td><? endif;?>
    </tr>
        <? endforeach; endif;?>
    </tbody>
</table>