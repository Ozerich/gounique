<?
if (!$incomings): ?>
<tr>
    <td colspan="10">No Incomings</td>
</tr>
<? else: ?>
<? foreach ($incomings as $ind=>$incoming): ?>
    <tr>
        <td><?=$incoming->id?></td>
        <td><?=$incoming->name?></td>
        <td><?=$incoming->changed_user->fullname?> <?=$incoming->changed_date->format('d.M.Y')?></td>
        <td class="submenu">
            <ul>
                <li><a href="incoming/<?=$incoming->id?>">verwalten</a></li>
                <li><a class="delete-link" href="kundenverwaltung/delete/incoming/<?=$incoming->id?>">loeschen</a></li>
            </ul>
        </td>
    </tr>
    <? endforeach; ?>
<? endif; ?>