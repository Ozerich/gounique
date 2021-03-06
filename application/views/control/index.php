<div id="dashboard-page" class="content">
    <a href="dashboard" id="header-logo"></a>

    <div class="nav">
        <div id="main-menu" style="display:<?=$outgoing_open ? 'none' : 'block'?>">
            <div class="row">
                <a href="control/incoming">Zahlungseingänge</a>
                <a href="#" id="open-outgoing">Zahlungsausgänge</a>
                <a href="control/profit" class="last">Profit & Loss</a>
            </div>
        </div>
        <div id="outgoing" style="display:<?=$outgoing_open ? 'block' : 'none'?>">
            <div class="row">
                <a href="#" id="close-outgoing" class="center">Zahlungsausgänge</a>
            </div>
            <div class="row">
                <a href="control/outgoing/land">Landleistungen</a>
                <a href="control/outgoing/flights">Flüge</a>
                <a href="control/provision" class="last">Provision</a>
            </div>
        </div>
    </div>
</div>