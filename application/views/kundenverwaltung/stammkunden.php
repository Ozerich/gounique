<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a href="kundenverwaltung">kundenverwaltung</a></li>
            <li><span>stammkunden</span></li>
        </ul>
    </div>
</div>

<div id="agenturen-page" class="content kundenverwaltung-rasdel">

    <ul class="tabs" id="agenturen-tabs">
        <li><a href="agenturen">Agenturdaten</a></li>
        <li class="active"><span>Stammkunden</span></li>
        <li><a href="incoming">Incoming</a></li>
        <li><a href="ketten">Ketten</a></li>
        <li><a href="provisionierung">Provisionierung</a></li>
        <li><a href="mitarbeiter">Mitarbeiter</a></li>
        <li class="last"><a href="stammkunden/new">Neue Stammkunden</a></li>
    </ul>

    <div class="search-block">
        <label for="search-input">Search:</label>
        <input type="text" id="search-input"/>
        <input type="hidden" id="search-type" value="stammkunden"/>
    </div>

    <table class="product-list" id="stammkunden-list">
        <thead>
        <tr>
            <th>№</th>
            <th class="inc-num">Stam. Num</th>
            <th class="inc-name">Stam. Name</th>
            <th class="inc-changed">Changed</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?=$stammkunden_list?>
        </tbody>
    </table>

</div>
<div id="delete-confirm" style="display:none">
    Are you sure?
</div>