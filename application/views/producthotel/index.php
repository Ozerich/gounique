<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a href="product">produkt</a></li>
            <li><span>hotelverwaltung</span></li>
        </ul>
    </div>
</div>

<div id="hoteldaten-page" class="content">

    <div class="hotellist-top">
        <div class="hotel-search">
            <label for="search">Search:</label>
            <input class="search-hotel" type="text" id="search"/>
            <div class="search-loading"></div>
        </div>
        <a href="product/hotel/create" class="new-hotel button-link">neueu hotel</a>
        <br class="clear"/>
    </div>
    <table class="product-list" id="hotel-list">
        <thead>
        <th class="code">Code</th>
        <th class="name">Name</th>
        <th class="land">Land</th>
        <th class="ort">Ort</th>
        <th class="zielgebiet">Zielgebiet</th>
        <th class="kat">Kat</th>
        <th class="status">Status</th>
        <th class="submenu">&nbsp;</th>
        </thead>
        <tbody>
        <?=$hotel_list?>
        </tbody>
</div>
</div>

</table>

</div>