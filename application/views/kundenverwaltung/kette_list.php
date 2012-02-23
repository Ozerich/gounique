<? if (!$kettens): ?>
<tr>
    <td colspan="10">No ketten</td>
</tr>
<? else:
    foreach ($kettens as $ketten): ?>
    <tr>
        <td><?=$ketten->id?></td>
        <td><?=$ketten->name?></td>
        <td><?=$ketten->changed_user->fullname?> <?=$ketten->changed_date->format('d.M.Y')?></td>
        <td class="submenu">
            <ul>
                <li><a href="ketten/<?=$ketten->id?>">verwalten</a></li>
                <li><a class="delete-link" href="ketten/delete/<?=$ketten->id?>">loeschen</a></li>
            </ul>
        </td>
    </tr>
    <? endforeach;
endif;
?>

 