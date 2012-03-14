<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><span>statistik</span></li>
        </ul>
    </div>
</div>

<div id="statistics-page">
    <form id="search-form">
        <fieldset class="search-block">

            <legend>Search</legend>

            <div class="search-wr">

                <div class="param">
                    <label for="search-von">von</label>
                    <input type="text" maxlength="8" name="from-date" id="search-von"/>
                </div>

                <div class="param">
                    <label for="search-bis">bis</label>
                    <input type="text" maxlength="8" name="to-date" id="search-bis"/>
                </div>

                <div class="param">
                    <select id="datesearch-type" name="search-type">
                        <option value="anzahlung">Abreise</option>
                        <option value="restzahlung">Rückreise</option>
                    </select>
                </div>

                <div class="param agenturen-wr">
                    <label for="ag_num">AG-NR:</label>
                    <input type="text" id="ag_num" name="agency_num" maxlength="5" size="5"/>
                </div>

                <br class="clear"/>

                <div class="type-checkboxes">

                    <input type="checkbox" id="is_pauschalreise" name="is_pauschalreise" checked/>
                    <label for="is_pauschalreise">Pauschalreise:</label>

                    <input type="checkbox" id="is_bausteinreise" name="is_bausteinrese" checked/>
                    <label for="is_bausteinreise">Bausteinreise:</label>

                    <input type="checkbox" id="is_nurflug" name="is_nurflug" checked/>
                    <label for="is_nurflug">Nurflug:</label>

                </div>

            </div>
        </fieldset>
        <fieldset class="table-fields">
            <legend>Table columns</legend>
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
                <input type="checkbox" checked id="field_9" name="field[total]"><label for="field_9">Total-RG</label>
            </div>
        </fieldset>
    </form>
    <br class="clear">
    <button id="search_button">Search</button>
    <br class="clear">

    <div id="statistics-loader"></div>
    <div id="statistik_table-wr">
        <?=$stats_list?>
    </div>
</div>