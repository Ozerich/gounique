<table class="product-list" id="flight_list">
    <thead>
    <th class="num">Flug Nr.</th>
    <th class="tlc">Von</th>
    <th class="tlc">Nach</th>
    <th class="status">Active</th>
    <th class="actions">Actions</th>
    <th class="actions">Price</th>
    </thead>
    <tbody>
        <? if($flights): ?>
            <? foreach($flights as $flight): ?>
                <tr>
                    <td class="num"><?=$flight->carrier."-".$flight->flug_num?></td>
                    <td class="tlc"><?=$flight->tlc_from?></td>
                    <td class="tlc"><?=$flight->tlc_to?></td>
                    <td class="tlc <?=$flight->active ? 'active' : 'inactive'?>"><?=$flight->active ? 'YES' : 'NO'?></td>
                    <td class="actions">
                        <a href="#" onclick="return open_edit_flight(<?=$flight->id?>)" class="edit-action"></a>

                    </td>
                    <td class="actions">                        <a href="product/flight/<?=$flight->id?>" class="money-action"></a></td>
                </tr>
            <? endforeach; ?>
        <? else: ?>
            <tr class="empty"><td colspan="100">No Flights</td></tr>
        <? endif; ?>
    </tbody>
</table>
