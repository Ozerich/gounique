<? foreach ($agencies as $agency): ?>
    <tr>
        <td><?=$agency->k_num?></td>
        <td><?=$agency->name?></td>
        <td><?=$agency->agenturen_type?></td>
        <td><?=$agency->provision?></td>
        <td class="status <?=$hotel->active == 1 ? 'active' : 'inactive'?>"><?=$hotel->active == 1 ? 'Aktiv' : 'Inaktiv'?></td>
        <td>&nbsp;</td>
        <td class="submenu">
            <ul>
                <li><a href="kundenverwaltung/verwalten/<?=$agency->id?>">verwalten</a></li>
                <li><a href="kundenverwaltung/historie/<?=$agency->id?>">historie</a></li>
                <li><a href="kundenverwaltung/buchen/<?=$agency->id?>">buchen</a></li>
                <li><a href="kundenverwaltung/delete/<?=$agency->id?>">loeschen</a></li>
            </ul>
        </td>
    </tr>
    <? endforeach; ?>
 