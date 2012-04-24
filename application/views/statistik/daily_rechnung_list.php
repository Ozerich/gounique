<tbody>
<? if ($days) foreach ($days as $date => $day): ?>
<tr class="day">
    <td><?=$date?></td>
    <td>Umsatz:</td>
    <td><?=num($day['total'])?></td>
    <td>B-Anzahl</td>
    <td><?=$day['count']?></td>
    <td>Person</td>
    <td><?=$day['person_count']?></td>
</tr>
<tr class="day-formulars">
    <td colspan="100">
        <table class="formulars-table">
            <thead>
            <tr>
                <th>№</th>
                <?if (!isset($fields) || isset($fields['berater'])): ?>
                <th>Berater</th><? endif;?>
                <?if (!isset($fields) || isset($fields['owner_type'])): ?>
                <th>BQ</th><? endif;?>
                <?if (!isset($fields) || isset($fields['person_name'])): ?>
                <th>KD-Name</th><? endif;?>
                <?if (!isset($fields) || isset($fields['r_num'])): ?>
                <th>RG-NR</th><? endif;?>
                <?if (!isset($fields) || isset($fields['ag_num'])): ?>
                <th>AG-NR</th><? endif;?>
                <?if (!isset($fields) || isset($fields['v_num'])): ?>
                <th>Vorg-NR</th><? endif;?>
                <?if (!isset($fields) || isset($fields['rg_date'])): ?>
                <th>RG-Datum</th><? endif;?>
                <?if (!isset($fields) || isset($fields['type'])): ?>
                <th>BG-Art</th><? endif;?>
                <?if (!isset($fields) || isset($fields['departure'])): ?>
                <th class="abreise">Abreise</th><? endif;?>
                <?if (!isset($fields) || isset($fields['arrive'])): ?>
                <th class="ruckreise">Rückreise</th><? endif;?>
                <?if (!isset($fields) || isset($fields['total'])): ?>
                <th>Reisepreis</th><? endif;?>
                <?if (!isset($fields) || isset($fields['person'])): ?>
                <th>Person</th><? endif;?>
            </tr>
            </thead>
            <tbody>
                <? foreach ($day['formulars'] as $ind => $formular): ?>
            <tr>
                <td><a target="_blank" href="reservierung/final/<?=$formular->id?>"><?=($ind + 1)?></a></td>
                <?if (!isset($fields) || isset($fields['berater'])): ?>
                <td><?=$formular->user->initials;?></td><? endif;?>
                <?if (!isset($fields) || isset($fields['owner_type'])): ?>
                <td><?=$formular->plain_ownertype?></td><? endif;?>
                <?if (!isset($fields) || isset($fields['person_name'])): ?>
                <td class="v_num"><?=$formular->person?></td><? endif;?>
                <?if (!isset($fields) || isset($fields['r_num'])): ?>
                <td><?=$formular->r_num?></td><? endif;?>
                <?if (!isset($fields) || isset($fields['ag_num'])): ?>
                <td><?=$formular->kunde ? $formular->kunde->k_num : '-'?></td><? endif;?>
                <?if (!isset($fields) || isset($fields['v_num'])): ?>
                <td><?=$formular->v_num?></td><? endif;?>
                <?if (!isset($fields) || isset($fields['rg_date'])): ?>
                <td><?=$formular->rechnung_date->format('d/m/Y')?></td><? endif;?>
                <?if (!isset($fields) || isset($fields['departure'])): ?>
                <td class="abreise right"><?=$formular->departure_date ? $formular->departure_date->format('d.M.y') : '-'?></td><? endif;?>
                <?if (!isset($fields) || isset($fields['arrive'])): ?>
                <td class="ruckreise right"><?=$formular->arrival_date ? $formular->arrival_date->format('d.M.y') : '-'?></td><? endif;?>
                <?if (!isset($fields) || isset($fields['type'])): ?>
                <td><?=$formular->stats_type?></td><? endif;?>
                <?if (!isset($fields) || isset($fields['total'])): ?>
                <td><?=num($formular->brutto)?></td><? endif;?>
                <?if (!isset($fields) || isset($fields['person'])): ?>
                <td><?=$formular->person_count?></td><? endif;?>
            </tr>
                <? endforeach; ?>
            </tbody>
        </table>
    </td>
</tr>
    <? endforeach; ?>
<tr class="total">
    <td colspan="2">&nbsp;</td>
    <td><?=num($total['amount'])?></td>
    <td>&nbsp;</td>
    <td><?=$total['count']?></td>
    <td>&nbsp;</td>
    <td><?=$total['person_count']?></td>
</tr>
</tbody>