<table id="agency-all" class="agency-list">
    <thead>
    <th width="120px">Kundennummer</th>
    <th>Name</th>
    <th width="50px">Typ</th>
    <th width="50px">PLZ</th>
    <th width="100px">Phone</th>
    <th width="135px">Actions</th>
    </thead>
    <tbody>
    <? foreach($agency_list as $agency): ?>
    <tr agency_id="<?=$agency->id?>">
    <td class="kundennummer"><?=$agency->id?></td>
    <td class="name"><a href="agency/<?=$agency->id?>"><?=$agency->name?></a></td>
    <td><?=$agency->type?></td>
    <td class="city"><?=$agency->plz?></td>
    <td class="phone"><?=$agency->phone?></td>
    <td>
        <button class="btn btn-small btn-blue edit-button">Edit</button>
        <button class="btn btn-small btn-green createformular-button">New</button>
    </td>
    </tr>
    <? endforeach; ?>
    </tbody>
</table>
<div class="add-button-wr">
    <button class="btn btn-small btn-blue" id="add_agency-button">Add agency</button>
</div>
