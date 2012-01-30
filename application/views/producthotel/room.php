<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a href="product">product</a></li>
            <li><a href="product/hotels/main">hotelverwaltung</a></li>
            <li><span>zimmerdaten</span></li>
        </ul>
    </div>
</div>

<div id="zimmerdaten-page" class="content kundenverwaltung-rasdel">

    <div class="left-block">
        <?=form_open("product/hotels/room/search");?>
        <div class="search-block">
            <label for="search" class="header">zimmer suchen</label>
            <input type="text" id="search" value="<?=isset($search_text) ? $search_text : ''?>" name="search_text"/>
            <button id="search-zimmer" class="search-button">suchen</button>
            <br class="clear"/>
        </div>
        </form>

        <a href="product/hotels/room/create" class="new-button">zimmer neu</a>
    </div>

    <div class="list-block">
        <span class="list-header">zimmer</span>

        <div class="list">

            <? foreach ($rooms as $room): ?>

            <div class="item">
                <span class="text"><?=$room->code?> - <?=$room->name?></span>
                <span class="arrow arrow-e"></span>
                <br class="clear"/>
                <ul class="submenu">
                    <li><a href="product/hotels/room/edit/<?=$room->id?>">verwalten</a></li>
                    <li><a href="product/hotels/room/delete/<?=$room->id?>">loeschen</a></li>
                </ul>
            </div>

            <? endforeach; ?>

        </div>
    </div>

    <br class="clear"/>

</div>