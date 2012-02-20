<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a href="kundenverwaltung">kundenverwaltung</a></li>
            <li><span>ketten</span></li>
        </ul>
    </div>
</div>

<div id="agenturen-page" class="content kundenverwaltung-rasdel">

    <ul class="tabs" id="agenturen-tabs">
        <li><a href="agenturen">Agenturendaten</a></li>
        <li><a href="stammkunden">Stammkunden</a></li>
        <li><a href="incoming">Incoming</a></li>
        <li class="active"><span>Ketten</span></li>
        <li><a href="provisionierung">Provisionierung</a></li>
        <li class="last"><a href="ketten/new">Neueu Kette</a></li>
    </ul>

    <table class="product-list" id="ketten-list">
        <thead>
        <tr>
            <th>Kette Num</th>
            <th>Kette Name</th>
            <th class="ag-changed">Changed</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?=$kette_list?>
        </tbody>
    </table>

</div>


<div id="delete-confirm" style="display:none">
    Are you sure?
</div>