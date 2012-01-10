<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a href="kundenverwaltung/historie/<?=$formular->kunde->id?>"><?=$formular->kunde->plain_type;?> <?=$formular->kunde->k_num?></a></li>
             </li>
            <li><a href="reservierung/final/<?=$formular->id?>">formular <?=$formular->v_num?></a></li>
            <li><span>statuses</span></li>
        </ul>
    </div>
</div>

<div id="status-page" class="reservierung-page content">
    <div class="formular-header">
        <div class="left-block">
            <div class="param">
                <span class="param-name">Kundennummer:</span>
                <a href="#"><?=$formular->kunde->k_num?></a>
            </div>

            <div class="param">
                <span class="param-name">Typ:</span>
                <span class="param-value" id="formulartype-value"><?=$formular->type?></span>
            </div>

            <div class="param">
                <span class="param-name">Vorgangsnummer:</span>
                <span class="param-value" id="vorgangsnummer-value"><?=$formular->v_num?></span>
            </div>

        </div>

        <div class="right-block">

            <div class="param">
                <span class="param-name">Status:</span>
                <span class="param-value"><?=$formular->plain_status?></span>
            </div>

            <? if($formular->status == "rechnung" || $formular->status == "freigabe"): ?>
            <div class="param">
                <span class="param-name">Rechnungsnummer:</span>
                <span class="param-value"><?=$formular->r_num?></span>
            </div>
            <? endif; ?>

        </div>
        <br class="clear"/>

    </div>
    <input type="hidden" name="formular_id" value="<?=$formular->id?>"/>
    <? foreach ($formular->hotels_and_manuels as $ind => $hotel): ?>
    <div class="item">
        <input type="hidden" name="item_type" value="<?=$hotel->type;?>"/>
        <input type="hidden" name="item_id" value="<?=$hotel->id?>"/>

        <div class="item-info">
            <span class="num"><?=($ind + 1)?></span>
            <span
                class="date"><?=$hotel->date_str?></span>

            <p><?=$hotel->nodate_text?></p>

            <div class="status">
                <span>Current status: <span class="value"><?=$hotel->plain_status?></span></span>

                <div class="buttons">
                    <button class="change-button btn btn-blue btn-small">?ndern</button>
                    <button class="openlog btn btn-blue btn-small">Log</button>
                </div>
                <br class="clear"/>
            </div>
        </div>
        <div class="item-edit">
            <div class="status-top">
                <label class="input-header">New status: </label>

                <div class="status-radio">
                    <input type="radio" name="status"
                           id="status<?=($ind + 1)?>_rq" <?if ($hotel->status == 'rq') echo 'checked';?>
                           value="rq"><label for="status<?=($ind + 1)?>_rq">RQ</label>
                    <input type="radio" name="status"
                           id="status<?=($ind + 1)?>_wl" <?if ($hotel->status == 'wl') echo 'checked';?>
                           value="wl"><label for="status<?=($ind + 1)?>_wl">WL</label>
                    <input type="radio" name="status"
                           id="status<?=($ind + 1)?>_ok" <?if ($hotel->status == 'ok') echo 'checked';?>
                           value="ok"><label for="status<?=($ind + 1)?>_ok">OK</label>
                </div>

                <div class="comment">
                    <label for="comment" class="input-header">Kommentar:</label>
                    <textarea id="comment"></textarea>
                </div>

                <button class="cancel-button btn btn-blue btn-small">Abbrechen</button>
                <button class="ok-button btn btn-blue btn-small">OK</button>
                <span class="error"></span>
            </div>
        </div>
        <div class="status-log">
            <? foreach ($hotel->status_logs as $log_ind => $log): ?>
            <div class="log">
                <div class="header">
                    <span class="date"><?=$log->datetime->format('d.m.Y H:i:s');?></span>
                    <span class="path"><?=$log->old_status . " -> " . $log->new_status;?></span>
                    <span class="user"><?=$log->user->fullname;?></span>
                </div>
                <p class="comment"><?=$log->comment;?></p>
            </div>
            <? endforeach; ?>
            <button class="closelog">Close log</button>
        </div>
    </div>
    <? endforeach; ?>

    <div class="buttons">
        <a href="reservierung/final/<?=$formular->id?>" class="button-link">Back</a>
    </div>
</div>