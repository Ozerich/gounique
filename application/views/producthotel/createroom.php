<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a href="product">product</a></li>
            <li><a href="product/hotel">hotelverwaltung</a></li>
            <li><span>hoteldaten</span></li>
        </ul>
    </div>
</div>

<div id="createroom-page" class="content room-page">
    <?=form_open("product/hotel/create_room/" . $hotel->id);?>
    <div class="room-mainoptions">
        <div class="roomname-param">
            <label for="roomname">Zimmer Category</label>
            <input type="text" name="roomname"/>
        </div>
        <div class="room-checkboxes">
            <div class="checkbox-block">
                <? for ($i = 0; $i <= Config::get('max_zimmer_count'); $i++): ?>
                <div class="checkbox-item">
                    <label><?=$i?></label>
                    <input type="checkbox" name="room_count[<?=$i?>]"/>
                </div>
                <? endfor; ?>
            </div>
            <div class="checkbox-block">
                <? foreach (Service::all() as $service): ?>
                <div class="checkbox-item">
                    <label><?=$service->short_name?></label>
                    <input type="checkbox" name="room_service[<?=$service->id?>]"/>
                </div>
                <? endforeach; ?>
            </div>
            <br class="clear"/>
        </div>
        <div class="button-wr">
            <input type="submit" value="Create"/>
        </div>
    </div>
    </form>
</div>