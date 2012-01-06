<div id="status-page">
    <input type="hidden" name="formular_id" value="<?=$formular->id?>"/>
    <? foreach ($formular->hotels_and_manuels as $ind => $hotel): ?>
    <div class="item">
        <input type="hidden" name="item_type" value="<?=$hotel->type;?>"/>
        <input type="hidden" name="item_id" value="<?=$hotel->id?>"/>

        <div class="item-info">
            <span class="num"><?=($ind + 1)?></span>
            <span
                class="date"><?=$hotel->date_start->format('d.m.Y') . ' - ' . $hotel->date_end->format('d.m.Y'); ?></span>

            <p><?=$hotel->nodate_text?></p>

            <div class="status">
                <span>Current status: <span class="value"><?=$hotel->plain_status?></span></span>

                <div class="buttons">
                    <button class="change-button btn btn-blue btn-small">Change</button>
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
                    <label for="comment" class="input-header">Comment:</label>
                    <textarea id="comment"></textarea>
                </div>

                <button class="cancel-button btn btn-blue btn-small">Cancel</button>
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
            <button class="closelog btn btn-small btn-blue">Close log</button>
        </div>
    </div>
    <? endforeach; ?>

    <div class="buttons">
        <a href="formular/<?=$formular->id?>" class="btn btn-blue btn-small">Back</a>
    </div>
</div>