<? foreach ($hotels as $hotel): ?>
<tr>
    <td><?=$hotel->code?></td>
    <td><?=$hotel->name?></td>
    <td><?=$hotel->land?></td>
    <td><?=$hotel->ort?></td>
    <td><?=$hotel->zielgebiet?></td>
    <td><?=$hotel->stars?></td>
    <td class="status <?=$hotel->active == 1 ? 'active' : 'inactive'?>"><?=$hotel->active == 1 ? 'Aktiv' : 'Inaktiv'?></td>
    <td><?=$hotel->changed_by ? $hotel->changed_by_user->initials : 'SYSTEM'?> <?=$hotel->changed_time ? $hotel->changed_time->format('d.m.Y') : ''?></td>
    <td class="submenu">
        <ul>
            <li><a href="product/hotel/edit/<?=$hotel->id?>">verwalten</a></li>
            <li><a href="product/hotel/rooms/<?=$hotel->id?>">pricedaten</a></li>
            <li><a href="product/hotel/delete/<?=$hotel->id?>">loeschen</a></li>
        </ul>
    </td>
</tr>
    <? endforeach; ?>
