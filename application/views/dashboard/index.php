<div id="dashboard-page" class="content">

    <a href="dashboard" id="header-logo"></a>

    <? if ($this->user->id == 9): ?>
    <div class="nav">
        <div class="row">
            <a href="control" class="center">finance & controlling</a>
            <a href="statistik">statistik</a>
			
        </div>
    </div>
    <? else: ?>
    <div class="nav">

        <div class="row">
            <a href="reservierung">reservierung</a>
            <a href="agenturen">kundenverwaltung</a>
            <a href="product" class="last">produkt</a>
        </div>

        <div class="row">
            <a href="control">finance & controlling</a>
            <a href="statistik">statistik</a>
            <a href="versand" class="last">versand</a>
        </div>

        <div class="row">
            <a class="center disabled">systemverwaltung</a>
        </div>

    </div>
    <? endif; ?>

</div>