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
        <li><a href="agenturen">Agenturedaten</a></li>
        <li><a href="stammkunden">Stammkunden</a></li>
        <li class="active"><span>Incoming</span></li>
        <li><a href="ketten">Ketten</a></li>
        <li><a href="provisionierung">Provisionierung</a></li>
        <li class="last"><a href="incoming/new">Neueu Incoming</a></li>
    </ul>

    <div class="search-block">
        <label for="search-input">Search:</label>
        <input type="text" id="search-input"/>
        <input type="hidden" id="search-type" value="incoming"/>
    </div>

    <table class="product-list" id="incoming-list">
        <thead>
        <tr>
            <th class="inc-num">Inc. Num</th>
            <th class="inc-name">Inc. Name</th>
            <th class="inc-changed">Changed</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?=$incoming_list?>
        </tbody>
    </table>

</div>

<div id="delete-confirm" style="display:none">
    Are you sure?
</div>