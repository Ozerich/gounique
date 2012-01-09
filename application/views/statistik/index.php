<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><span>statistik</span></li>
        </ul>
    </div>
</div>

<div id="statistik-page">
    <table>
        <thead>
        <th>Lfdnr</th>
        <th>Berater</th>
        <th>Kundenummer</th>
        <th>Name</th>
        <th>Prov%</th>
        <th>Vorg-NR</th>
        <th>RG-Nr</th>
        <th>Buc.Datum</th>
        <th>RG-Datum</th>
        <th>KD-Name</th>
        <th>Abreise</th>
        <th>Rückreise</th>
        <th>Brutto</th>
        </thead>
        <tbody>
        <? foreach ($formulars as $ind => $formular): ?>
        <tr>
            <td class="num"><?=($ind + 1)?></td>
            <td class="berater"><?=$formular->berater?></td>
            <td class="k_num"><?=$formular->kunde->k_num?></td>
            <td class="name"><?=$formular->kunde->name?></td>
            <td class="provision"><?=$formular->provision?></td>
            <td class="v_num"><?=$formular->v_num?></td>
            <td class="r_num"><?=$formular->r_num?></td>
            <td class="date"><?=$formular->created_date->format('d.m.y')?></td>
            <td class="date"><?=$formular->rechnung_date->format('d.m.y')?></td>
            <td class="kd-name"><?=$formular->plain_persons?></td>
            <td class="date"><?=$formular->departure_date->format('d.m.y')?></td>
            <td class="date"><?=$formular->arrival_date->format('d.m.y')?></td>
            <td class="brutto"><?=$formular->price['brutto']?></td>
        </tr>
            <? endforeach; ?>
        </tbody>
    </table>

    <div id="brutto-count">
        <div class="input">
            <label for="datestart">Date start</label>
            <input type="text" id="datestart" name="datestart"/>
        </div>

        <div class="input">
            <label for="dateend">Date end</label>
            <input type="text" id="dateend" name="dateend"/>
        </div>

        <button id="brutto-submit">Count</button>
        <span class="result">Result: <span class="value">0</span> &euro;</span>
    </div>
</div>