<? foreach ($items as $item): ?>
<div class="reservierung-item">
    <p class="text"><?=$item->plain_text?></p>
    <a href="#" class="delete_16 delete" onclick="return delete_item(<?=$item->id?>, '<?=$item->type?>');"></a>
            <a href="#" class="edit_16 edit" onclick="return edit_item(<?=$item->id?>, '<?=$item->type?>');"></a>
    <br class="clear"/>
</div>
<? endforeach ?>