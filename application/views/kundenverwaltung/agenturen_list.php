<? foreach ($agencies as $agency): ?>
<tr>
    <td><?=$agency->k_num?></td>
    <td><?=$agency->name?></td>
    <td><?=$agency->provision?></td>
    <td><?=$agency->changed_user ? $agency->changed_user->fullname : '-'?> <?=$agency->changed_date ? $agency->changed_date->format('d.M.Y') : '-'?></td>

    <td class="submenu">
        <ul>
            <li><a href="agenturen/<?=$agency->id?>">verwalten</a></li>
            <li><a href="kundenverwaltung/historie/<?=$agency->id?>">historie</a></li>
            <li><a href="kundenverwaltung/buchen/<?=$agency->id?>">buchen</a></li>
            <li><a class="delete-link" href="kundenverwaltung/delete/agenturen/<?=$agency->id?>">loeschen</a></li>
        </ul>
    </td>
</tr>
<? endforeach; ?>
 