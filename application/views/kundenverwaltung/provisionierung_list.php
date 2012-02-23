<? if (!$levels): ?>
<tr>
    <td colspan="5">No Provisionierung</td>
</tr>
<? else:
    foreach ($levels as $ind => $level): ?>
    <tr>
        <input type="hidden" class="level_id" value="<?=$level->id?>"/>
        <td><?=($ind + 1)?></td>
        <td class="from">
            <span class="value"><?=$level->from?></span>
            <input type="text" value="<?=$level->from?>" maxlength="7"/>
        </td>
        <td class="to">
            <span class="value"><?=$level->to?></span>
            <input type="text" value="<?=$level->to?>" maxlength="7"/>
        </td>
        <td class="percent">
            <span class="value"><?=$level->percent?></span>
            <input type="text" value="<?=$level->percent?>" maxlength="4"/>
        </td>
        <td>
            <a href="#" class="save">Save</a>
            <img class="loading" src="img/loader.gif"/>
            <a href="#" class="delete-icon delete-level"></a>
        </td>
    </tr>
    <? endforeach;
endif; ?>

<tr class="new-line">
    <td>&nbsp;</td>
    <td class="from">
        <input type="text" maxlength="7"/>
    </td>
    <td class="to">
        <input type="text" maxlength="7"/>
    </td>
    <td class="percent">
        <input type="text" maxlength="4"/>
    </td>
    <td>
        <a href="#" class="add-new">Add</a>
        <img class="loading" src="img/loader.gif"/>
        <a href="#" class="new-level">New</a>
    </td>
</tr>
 