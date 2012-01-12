<? for ($i = 1; $i <= 4; $i++): ?>

<div class="item" id="item<?=$i?>">
    <div class="code"><?=$formular->r_num;?></div>


    <div class="left">
        <div class="hotelname">&nbsp;</div>

        <div class="infant">
            <?=$incoming->plain_text?>
        </div>

        <div class="persons">
            <? foreach ($persons as $person): ?>
            <div class="person"><?=$person->name . " / " . $person->surname?></div>
            <? endforeach; ?>
        </div>
    </div>

    <div class="center">
        <div class="count">
            <div class="adult"><?=$formular->adult_count?></div>
            <div class="child"><?=$formular->child_count?></div>
            <div class="infant"><?=$formular->infant_count?></div>
            <span class="clear"></span>
        </div>
        <div class="datestart"><?=($item->date_start) ? $item->date_start->format('d. M Y') : '&nbsp;';?></div>
        <div class="dateend"><?=($item->date_end) ? $item->date_end->format('d. M Y') : '&nbsp;';?></div>
        <div class="remark"><?=$item->voucher_remark?></div>
    </div>

    <div class="right">
        <div class="text">
            <?=$item->text?>
        </div>
        <div class="bottom-text">
            <div class="bottom">Unique World GmbH</div>
            <div class="line"><?=$formular->kunde->type == "agenturen" ? $formular->kunde->name : "Private"?></div>
        </div>
    </div>
</div>
<? endfor; ?>