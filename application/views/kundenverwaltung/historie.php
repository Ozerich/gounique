<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a href="kundenverwaltung">kundenverwaltung</a></li>
            <li><a href="<?=$kunde->type?>"><?=$kunde->type?></a></li>
            <li><span>historie <?=$kunde->type?> <?=$kunde->k_num?></span></li>
        </ul>
    </div>
</div>


<div id="kundenverwaltung-historie" class="content">

    <div class="kunde-view">

        <div class="topinfo">
            <div class="address block">
                <span class="header">Adresse</span>
                <div class="kundeblock-content"><?=$kunde->plain_text;?></div>
            </div>

            <div class="kundeperson block">
                <span class="header">Ansprechpartner</span>

                <div class="kundeblock-content">
                    <?=$kunde->person_name.' '." - ".$kunde->sex?><br/>
                    e-mail: <a href="mailto:<?=$kunde->email?>"><?=$kunde->email?></a><br/>
                    phone: <?=$kunde->phone?><br/>
                    fax: <?=$kunde->fax?><br/>
                    www: <a href="<?=$kunde->website?>"><?=$kunde->website?></a> <br/>
                </div>
            </div>

            <br class="clear"/>
        </div>


        <div class="provision">Provision:  <?=$kunde->provision?>%</div>

        <div class="about block">
            <span class="header">Comment</span>

            <div class="kundeblock-content">
                <pre><?=$kunde->about?></pre>
            </div>
        </div>

        <a href="kundenverwaltung/vervalten/<?=$kunde->id?>" class="common-button edit-button">vervalten</a>
        <br class="clear"/>

    </div>

    <table class="kunde-list" id="kunde-formulars">
        <thead>
        <th>vorgangsnummer</th>
        <th>rechnungsnummer</th>
        <th>date created</th>
        <th>&nbsp;</th>
        </thead>
        <? foreach($kunde->formulars as $formular): ?>
        <tr>
            <td class="v_num"><?=$formular->v_num?></td>
            <td><?=($formular->r_num) ? $formular->r_num : '-' ?></td>
            <td><?=$formular->created_date->format('d.m.Y');?></td>
            <td width="50px">
                <a href="reservierung/final/<?=$formular->id?>" class="view-link">view</a>
            </td>
        </tr>
        <? endforeach; ?>
    </table>
    <input type="hidden" name="kunde_id" value="<?=$kunde->id?>" id="kunde_id"/>

    <a href="reservierung/create/<?=$kunde->id?>" class="common-button edit-button">formular</a>
</div>

