<? foreach ($tours as $tour): ?>
<tr>
    <td><?=$tour->code?></td>
    <td><?=$tour->name?></td>
    <td><?=$tour->land?></td>
    <td><?=$tour->ort?></td>
    <td><?=$tour->zielgebiet?></td>
    <td><?=$tour->stars?></td>
    <td class="status <?=$tour->active == 1 ? 'active' : 'inactive'?>"><?=$tour->active == 1 ? 'Aktiv' : 'Inaktiv'?></td>
    <td class="submenu">
        <ul>
            <li><a href="product/rundreise/edit/<?=$tour->id?>">verwalten</a></li>
            <li><a href="product/rundreise/rooms/<?=$tour->id?>">zimmerdaten</a></li>
            <li><a href="product/rundreise/delete/<?=$tour->id?>">loeschen</a></li>
        </ul>
    </td>
</tr>
    <? endforeach; ?>
