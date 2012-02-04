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

<div id="hoteldaten-page" class="content kundenverwaltung-rasdel">

    <div class="left-block">
        <?=form_open("product/hotel/search");?>
        <div class="search-block">
            <label for="search" class="header">hotel suchen</label>
            <input type="text" id="search" value="<?=isset($search_text) ? $search_text : ''?>" name="search_text"/>
            <button id="search-zimmer" class="search-button">suchen</button>
            <br class="clear"/>
        </div>
        </form>

        <a href="product/hotel/create" class="new-button">hotel neu</a>
    </div>

    <div class="list-block">
        <span class="list-header">hotel</span>

        <div class="list">

            <? foreach ($hotels as $hotel): ?>

            <div class="item">
                <span class="text"><?=$hotel->code?> - <?=$hotel->name?></span>
                <span class="arrow arrow-e"></span>
                <br class="clear"/>
                <ul class="submenu">
                    <li><a href="product/hotel/edit/<?=$hotel->id?>">verwalten</a></li>
                    <li><a href="product/hotel/rooms/<?=$hotel->id?>">zimmerdaten</a></li>
                    <li><a href="product/hotel/delete/<?=$hotel->id?>">loeschen</a></li>
                </ul>
            </div>

            <? endforeach; ?>

        </div>
    </div>

    <br class="clear"/>

</div>