<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a href="kundenverwaltung">kundenverwaltung</a></li>
            <li><span>provisionierung</span></li>
        </ul>
    </div>
</div>

<div id="provisionierung-page" class="content kundenverwaltung-rasdel">

    <ul class="tabs" id="agenturen-tabs">
        <li><a href="agenturen">Agenturendaten</a></li>
        <li><a href="stammkunden">Stammkunden</a></li>
        <li><a href="incoming">Incoming</a></li>
        <li><a href="ketten">Ketten</a></li>
        <li class="active"><span>Provisionierung</span></li>
    </ul>

    <table class="product-list" id="provisionlevels-list">
        <thead>
        <tr>
            <th>№</th>
            <th>Ab</th>
            <th>Bis</th>
            <th>%</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?=$provision_levels?>
        </tbody>
    </table>

</div>

<div id="delete-confirm" style="display:none">
    Are you sure?
</div>