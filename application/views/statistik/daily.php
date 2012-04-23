<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a href="statistik">statistik</a></li>
            <li><span>Paymentstype / Invoicetype</span></li>
        </ul>
    </div>
</div>

<div id="daily_statistic" class="content">

    <div id="daily_statistic_filter">

        <fieldset class="date-period">
            <legend>Date Period:</legend>
            <div class="param">
                <label for="date_from">Von:</label>
                <input id="date_from" name="date_from" type="text" maxlength="8"/>
            </div>
            <div class="param">
                <label for="date_to">Bis:</label>
                <input id="date_to" name="date_to" type="text" maxlength="8"/>
            </div>
        </fieldset>

        <fieldset class="table-fields">
            <legend>Table columns</legend>
            <div class="field-item">
                <input type="checkbox" checked id="field_13" name='field[berater]'><label for="field_13">Berater</label>
            </div>
            <div class="field-item">
                <input type="checkbox" checked id="field_0" name='field[owner_type]'><label for="field_0">UW/RB</label>
            </div>
            <div class="field-item">
                <input type="checkbox" checked id="field_1" name='field[r_num]'><label for="field_1">RG-NR</label>
            </div>
            <div class="field-item">
                <input type="checkbox" checked id="field_2" name="field[ag_num]"><label for="field_2">AG-NR</label>

            </div>
            <div class="field-item">
                <input type="checkbox" checked id="field_3" name="field[v_num]"><label for="field_3">Vorg-NR</label>

            </div>
            <div class="field-item">
                <input type="checkbox" checked id="field_10" name="field[person_name]"><label
                    for="field_3">KD-Name</label>
            </div>
            <div class="field-item">
                <input type="checkbox" checked id="field_4" name="field[rg_date]"><label for="field_4">RG-Datum</label>

            </div>
            <div class="field-item">
                <input type="checkbox" checked id="field_5" name="field[type]"><label for="field_5">BG-Art</label>

            </div>
            <div class="field-item">
                <input type="checkbox" checked id="field_6" name="field[departure]"><label for="field_6">Abreise</label>

            </div>
            <div class="field-item">
                <input type="checkbox" checked id="field_7" name="field[arrive]"><label for="field_7">Rückreise</label>

            </div>
            <div class="field-item">
                <input type="checkbox" checked id="field_8" name="field[person]"><label for="field_8">Person</label>

            </div>
            <div class="field-item">
                <input type="checkbox" checked id="field_9" name="field[total]"><label for="field_9">Reisepreis</label>
            </div>
        </fieldset>

         <button id="search_button">Search</button>
        <div id="daily_statistic_loading" class="loading_32"></div>
        <br clear="all"/>
    </div>

    <div class="tabs-block">
        <ul class="tabs">
            <li class="active"><a for="statistic_rechnung_page" href="#">Tagesumsatz</a></li>
            <li><a href="#" for="statistic_angebot_page">Tagesangebot</a></li>
        </ul>
    </div>

    <div id="daily_statistic_content">
        <div class="statistic-tabpage" id="statistic_angebot_page" style="display:none">
            <table class="statictic-table product-list" id="statistics-list">
                <?=$angebot_html?>
            </table>
        </div>
        <div class="statistic-tabpage" id="statistic_rechnung_page">
            <table class="statictic-table product-list" id="statistics-list">
                <?=$rechnung_html?>
            </table>
        </div>
    </div>
</div>