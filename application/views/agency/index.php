<table id="kunde-all" class="kunde-list">
    <thead>
    <th width="120px">Kundennummer</th>
    <th>Name</th>
    <th width="50px">Typ</th>
    <th width="50px">PLZ</th>
    <th width="100px">Phone</th>
    <th width="135px">Actions</th>
    </thead>
    <tbody>
    <? foreach($kunde_list as $kunde): ?>
    <tr kunde_id="<?=$kunde->id?>">
    <td class="kundennummer"><?=$kunde->id?></td>
    <td class="name"><a href="kunde/<?=$kunde->id?>"><?=$kunde->name?></a></td>
    <td><?=$kunde->type?></td>
    <td class="city"><?=$kunde->plz?></td>
    <td class="phone"><?=$kunde->phone?></td>
    <td>
        <button class="btn btn-small btn-blue edit-button">Edit</button>
        <button class="btn btn-small btn-green createformular-button">New</button>
    </td>
    </tr>
    <? endforeach; ?>
    </tbody>
</table>
<div class="add-button-wr">
    <button class="btn btn-small btn-blue" id="add_kunde-button">Add kunde</button>
</div>
