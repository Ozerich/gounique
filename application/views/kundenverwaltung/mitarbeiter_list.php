<? if (!$users): ?>
<tr>
    <td colspan="10">No Users</td>
</tr>
<? else: ?>
<? foreach ($users as $ind=>$user): ?>
    <tr>
        <td><?=($ind + 1)?></td>
        <td><?=$user->name." ".$user->surname?></td>
        <td class="submenu">
            <ul>
                <li><a href="mitarbeiter/<?=$user->id?>">verwalten</a></li>
            </ul>
        </td>
    </tr>
    <? endforeach; ?>
<? endif; ?>
 