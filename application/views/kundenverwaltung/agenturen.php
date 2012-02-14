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
        <li for-page="agenturen-data" class="active"><a href="#">Agenturendaten</a></li>
        <li for-page="ketten-data"><a href="#">Ketten</a></li>
        <li for-page="provision-data"><a href="#">Provisionierung</a></li>
    </ul>

    <div id="agenturen-data">
        <table class="product-list" id="agenturen-list">
            <thead>
                <tr>
                    <th class="ag-num">AG Nummer</th>
                    <th class="ag-name">Name</th>
                    <th class="ag-type">AG Type</th>
                    <th class="ag-provision">Provision</th>
                    <th class="ag-status">Status</th>
                    <th class="ag-changed">Changed</th>
                </tr>
            </thead>
            <tbody>
                <?=$agenturen_list?>
            </tbody>
        </table>
    </div>

    <div id="ketten-data" style="display:none">
            It is no ready now, sorry
    </div>

    <div id="provision-data" style="display:none">
            It is no ready now, sorry
    </div>

</div>