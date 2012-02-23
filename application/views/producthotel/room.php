<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a href="product">produkt</a></li>
            <li><a href="product/hotel">hotelverwaltung</a></li>
            <li><span>hoteldaten</span></li>
        </ul>
    </div>
</div>

<div id="createroom-page" class="content room-page">
    <h2 class="hotel-name"><a href="product/hotel/edit/<?=$hotel->id?>"><?=$hotel->name?></a></h2>
    <?=form_open("product/hotel/room/" . $hotel->id.($room ? '/'.$room->id : ''));?>
    <div class="room-mainoptions">
        <div class="roomname-param">
            <label for="roomname">Zimmer Category</label>
            <input type="text" name="roomname" value="<?=$room ? $room->name : ''?>"/>
        </div>
        <div class="room-checkboxes">
            <div class="checkbox-block">
                <div class="block-header">Belegung</div>
                <? for ($i = 0; $i <= Config::get('max_zimmer_count'); $i++): ?>
                <div class="checkbox-item">
                    <label><?=$i?></label>
                    <input type="checkbox" name="room_count[<?=$i?>]" <?=$room && $room->is_count_active($i) ? "checked" : ''?>/>
                </div>
                <? endfor; ?>
            </div>
            <div class="checkbox-block">
                <div class="block-header">Verpflegungsart</div>
                <? foreach (Service::all() as $service): ?>
                <div class="checkbox-item">
                    <label><?=$service->short_name?></label>
                    <input type="checkbox" name="room_service[<?=$service->id?>]" <?=$room && $room->is_service_active($service->id) ? "checked" : ''?>/>
                </div>
                <? endforeach; ?>
            </div>
            <br class="clear"/>
        </div>
        <div class="button-wr">
            <input type="submit" value="Save"/>
        </div>
    </div>
    </form>
</div>