<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a href="kundenverwaltung">kundenverwaltung</a></li>
            <li><span>agenturen</span></li>
        </ul>
    </div>
</div>

<div id="agenturen-page" class="content kundenverwaltung-rasdel">

    <div class="left-block">
        <div class="search-block">
            <label for="search" class="header">agentur suchen</label>
            <input type="text" id="search" name="search"/>
            <button id="search-agentur" class="search-button">suchen</button>
            <br class="clear"/>
        </div>

        <a href="agenturen/new" class="new-button">agentur neu</a>
    </div>

    <div class="list-block">
        <span class="list-header">agenturen</span>

        <div class="list">

            <? foreach (Kunde::find_all_by_type('agenturen') as $client): ?>

            <div class="item">
                <span class="text"><?=$client->k_num?> - <?=$client->name?></span>
                <span class="arrow arrow-e"></span>
                <br class="clear"/>
                <ul class="submenu">
                    <li><a href="kundenverwaltung/vervalten/<?=$client->id?>">vervalten</a></li>
                    <li><a href="kundenverwaltung/historie/<?=$client->id?>"">historie</a></li>
                    <li><a href="kundenverwaltung/buchen/<?=$client->id?>"">buchen</a></li>
                </ul>
            </div>

            <? endforeach; ?>

        </div>
    </div>

    <br class="clear"/>

</div>