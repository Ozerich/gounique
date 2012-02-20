<? if (!$stammkunden): ?>
<tr>
    <td colspan="10">No Stammkunden</td>
</tr>
<? else: ?>
<? foreach ($stammkunden as $kunde): ?>
    <tr>
        <td><?=$kunde->k_num?></td>
        <td><?=$kunde->name?></td>
        <td><?=$kunde->changed_user ? $kunde->changed_user->fullname : '-'?> <?=$kunde->changed_date ? $kunde->changed_date->format('d.M.Y') : '-'?></td>
        <td class="submenu">
            <ul>
                <li><a href="stammkunden/<?=$kunde->id?>">verwalten</a></li>
                <li><a class="delete-link" href="kundenverwaltung/delete/stammkunden/<?=$kunde->id?>">loeschen</a></li>
            </ul>
        </td>
    </tr>
    <? endforeach; ?>
<? endif; ?>
 