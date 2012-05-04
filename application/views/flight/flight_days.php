<table class="product-list" id="flight_days_list">
    <thead>
    <th class="flug_num">Flug Nr.</th>
    <th class="tag">Tag</th>
    <th class="datetime">Abflug</th>
    <th class="datetime">Ankunft</th>
    <th class="konti">Konti</th>
    <th class="rel">Rel</th>
    <th class="hidden_data">&nbsp;</th>
    </thead>
    <tbody>
    <? if ($days): ?>
        <? foreach ($days as $day): ?>
        <tr onclick="return select_flight_day(this)">
            <td class="datetime"><?=$day->flight->carrier . '-' . $day->flight->flug_num?></td>
            <td class="tag"><?=day_of_week($day->date)?></td>
            <td class="datetime"><?=$day->plain_departure?></td>
            <td class="datetime"><?=$day->plain_arrival?></td>
            <td class="datetime"><?=$day->konti?></td>
            <td class="datetime"><?=$day->release?></td>
            <td class="hidden_data">
                <input type="hidden" class="hid_date" value="<?=$day->date->format('dmY')?>"/>
                <input type="hidden" class="hid_dayofweek" value="<?=day_of_week($day->date, false)?>"/>
                <input type="hidden" class="hid_time_departure" value="<?=substr($day->time_departure, 0, 5)?>"/>
                <input type="hidden" class="hid_time_arrival" value="<?=substr($day->time_arrive, 0, 5)?>"/>
                <input type="hidden" class="hid_konti" value="<?=$day->konti?>"/>
                <input type="hidden" class="hid_release" value="<?=$day->release?>"/>
                <input type="hidden" class="hid_max_dauer" value="<?=$day->max_dauer?>"/>
                <? foreach (unserialize($day->class_discounts) as $ind => $val): ?>
                <input type="hidden" class="hid_class_discounts" ind="<?=$ind?>" value="<?=$val?>"/>
                <? endforeach; ?>

                <select class="hid_prices" style="display:none;">
                    <? foreach (unserialize($day->price) as $days => $price): ?>
                    <option value="<?=$days.'_'.$price?>"><?=$days . ' Tg. ' . $price . ' EUR'?></option>
                    <? endforeach; ?>
                </select>
            </td>
        </tr>
            <? endforeach; ?>
        <? else: ?>
    <tr class="empty">
        <td colspan="100">No Flights</td>
    </tr>
        <? endif; ?>
    </tbody>
</table>
