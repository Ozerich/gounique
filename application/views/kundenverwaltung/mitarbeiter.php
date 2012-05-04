<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a href="kundenverwaltung">kundenverwaltung</a></li>
            <li><span>incoming</span></li>
        </ul>
    </div>
</div>

<div id="agenturen-page" class="content kundenverwaltung-rasdel">

    <ul class="tabs" id="agenturen-tabs">
        <li><a href="agenturen">Agenturdaten</a></li>
        <li><a href="stammkunden">Stammkunden</a></li>
        <li><a href="incoming">Incoming</a></li>
        <li><a href="ketten">Ketten</a></li>
        <li><a href="provisionierung">Provisionierung</a></li>
        <li class="active"><span>Mitarbeiter</span></li>
        <li class="last"><a href="mitarbeiter/new">Neue Mitarbeiter</a></li>
    </ul>

    <div class="search-block">
        <label for="search-input">Search:</label>
        <input type="text" id="search-input"/>
        <input type="hidden" id="search-type" value="incoming"/>
    </div>

    <table class="product-list" id="incoming-list">
        <thead>
        <tr>
            <th class="inc-num">Name </th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?=$user_list?>
        </tbody>
    </table>

</div>

<div id="delete-confirm" style="display:none">
    Are you sure?
</div>