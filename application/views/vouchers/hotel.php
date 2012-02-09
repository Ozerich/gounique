<? for ($i = 1; $i <= 4; $i++): ?>
<div class="item" id="item<?=$i?>">
    <div class="code"><?=$formular->r_num;?></div>


    <div class="left">
        <div class="hotelname"><?=$item->hotel_name?></div>

        <div class="infant">
            <?=$incoming->plain_text?>
        </div>

        <div class="persons">
            <? foreach ($persons as $person): ?>
            <div class="person"><?=$person->english_sex." ".$person->name . " / " . $person->surname?></div>
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
        <div class="datestart"><?=$item->date_start->format('d. M Y');?></div>
        <div class="dateend"><?=$item->date_end->format('d. M Y');?></div>
        <div class="remark"><?=$item->voucher_remark?></div>
    </div>

    <div class="right">
        <div class="line"><?=$item->days_count . " Nights " . $item->hotel_name?></div>
        <div class="line"><?=$item->plain_roomtype?></div>
        <div class="line empty">&nbsp;</div>
        <div class="line"><?=$item->file_roomcapacity . ' / ' . $item->plain_hotelservice?></div>
        <? if ($item->transfer != "kein"): ?>
        <div class="line">inkl. Transfer <?=$item->plain_transfer?></div>
        <? endif; ?>
        <div class="line empty">&nbsp;</div>
        <div class="bottom">Unique World GmbH</div>
        <div class="line"><?=$formular->kunde->type == "agenturen" ? $formular->kunde->name : "Private"?></div>
    </div>
</div>
<? endfor; ?>