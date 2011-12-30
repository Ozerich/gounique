<div id="status-page">
    <? foreach ($formular->hotels as $ind => $hotel): ?>
    <div class="item">
        <div class="item-info">
            <span
                class="date"><?=$hotel->date_start->format('d.m.Y') . ' ' . $hotel->date_end->format('d.m.Y'); ?></span>

            <p><?=$hotel->plain_text?></p>

            <div class="status">
                <span><?=$hotel->status?></span>
                <button class="change-button btn btn-blue btn-small"></button>
                <a href="#" id="openlog-button">Log</a>
            </div>
        </div>
        <div class="item-edit">
            <div class="status-top">
                <span>New status: </span>

                <div class="status-radio">
                    <input type="radio" name="status" <?if($hotel->status == 'rq') echo 'checked';?> value="rq"><label>RQ</label>
                    <input type="radio" name="status" <?if($hotel->status == 'wl') echo 'checked';?> value="wl"><label>WL</label>
                    <input type="radio" name="status" <?if($hotel->status == 'ok') echo 'checked';?> value="ok"><label>OK</label>
                </div>

                <div class="comment">
                    <label for="comment">Comment:</label>
                    <textarea id="comment"></textarea>
                </div>

                <button class="cancel-button btn btn-blue btn-small">Cancel</button>
                <button class="ok-button btn btn-blue btn-small">OK</button>
            </div>
        </div>
        <div class="status-log">
            <div class="log" style="display:none">
                <div class="header">
                    <span class="date"></span>
                    <span class="path"></span>
                    <span class="user"></span>
                </div>
                <p class="comment"></p>
            </div>
            <? foreach ($hotel->status_log as $log_ind => $log): ?>
            <div class="log">
                <div class="header">
                    <span class="date"><?=$log->datetime->format('d.m.Y H:i:s');?></span>
                    <span class="path"><?=$log->old_status . " -> " . $log->new_status;?></span>
                    <span class="user"><?=$log->user->name . " " . $log->user->surname;?></span>
                </div>
                <p class="comment"><?=$log->comment;?></p>
            </div>
            <? endforeach; ?>
        </div>
    </div>
    <? endforeach; ?>

    <div class="buttons">
        <a href="formular/<?=$formular->id?>" class="btn btn-blue btn-small">Back</a>
    </div>
</div>