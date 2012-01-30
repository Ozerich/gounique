<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a href="product">product</a></li>
            <li><a href="product/hotels/main">hotelverwaltung</a></li>
            <li><span>verpflegungsdaten</span></li>
        </ul>
    </div>
</div>

<div id="verpflegungsdaten-page" class="content kundenverwaltung-rasdel">

    <div class="left-block">
        <?=form_open("product/hotels/service/search");?>
        <div class="search-block">
            <label for="search" class="header">verpflegungs suchen</label>
            <input type="text" id="search" value="<?=isset($search_text) ? $search_text : ''?>" name="search_text"/>
            <button id="search-zimmer" class="search-button">suchen</button>
            <br class="clear"/>
        </div>
        </form>

        <a href="product/hotels/service/create" class="new-button">verpflegungs neu</a>
    </div>

    <div class="list-block">
        <span class="list-header">verpflegungs</span>

        <div class="list">

            <? foreach ($services as $service): ?>

            <div class="item">
                <span class="text"><?=$service->code?> - <?=$service->name?></span>
                <span class="arrow arrow-e"></span>
                <br class="clear"/>
                <ul class="submenu">
                    <li><a href="product/hotels/service/edit/<?=$service->id?>">verwalten</a></li>
                    <li><a href="product/hotels/service/delete/<?=$service->id?>">loeschen</a></li>
                </ul>
            </div>

            <? endforeach; ?>

        </div>
    </div>

    <br class="clear"/>

</div>