<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><span>statistik</span></li>
        </ul>
    </div>
</div>

<div id="statistics-page">
    <fieldset class="date-search">

        <legend>Search Date</legend>

        <div class="search-wr">
            <label for="search-von">von</label>
            <input type="text" maxlength="8" id="search-von"/>
            <label for="search-bis">bis</label>
            <input type="text" maxlength="8" id="search-bis"/>

            <select id="datesearch-type">
                <option value="anzahlung">Abreise</option>
                <option value="restzahlung">Rückreise</option>
            </select>

            <div class="agenturen-wr">
                <label for="ag_num">AG-NR:</label>
                <input type="text" id="ag_num" maxlength="5" size="5"/>
            </div>

        </div>
    </fieldset>

    <div id="statistik_table-wr">
        <?=$stats_list?>
    </div>
</div>