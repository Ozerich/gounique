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

    <ul class="tabs" id="agenturen-tabs">
        <li class="active"><span>Agenturedaten</span></li>
        <li><a href="stammkunden">Stammkunden</a></li>
        <li><a href="incoming">Incoming</a></li>
        <li><a href="ketten">Ketten</a></li>
        <li><a href="provisionierung">Provisionierung</a></li>
        <li class="last"><a href="agenturen/new">Neueu Agenturen</a></li>
    </ul>

    <div class="search-block">
        <label for="search-input">Search:</label>
        <input type="text" id="search-input"/>
        <input type="hidden" id="search-type" value="agenturen"/>
    </div>

    <table class="product-list" id="agenturen-list">
        <thead>
        <tr>
            <th>№</th>
            <th class="ag-num">AG Nummer</th>
            <th class="ag-name">Name</th>
            <th class="ag-provision">Provision</th>
            <th class="ag-changed">Changed</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?=$agenturen_list?>
        </tbody>
    </table>

</div>

<div id="delete-confirm" style="display:none">
    Are you sure?
</div>