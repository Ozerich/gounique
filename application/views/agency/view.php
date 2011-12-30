<div class="agency-item">
    <div class="agency-view">
        <? if ($agency->type == 'agency'): ?>
        <div class="topinfo">

            <div class="address block">
                <span class="header">Adresse</span>

                <div class="agencyblock-content">
                    <?=$agency->name?><br/>
                    <?=$agency->address?><br/>
                    <?=$agency->plz." ".$agency->ort?>
                </div>
            </div>
            <div class="agencyperson block">
                <span class="header">Ansprechpartner</span>

                <div class="agencyblock-content">
                    <?=$agency->person_name.' '." - ".$agency->sex?><br/>
                    e-mail: <a href="mailto:<?=$agency->email?>"><?=$agency->email?></a><br/>
                    phone: <?=$agency->phone?><br/>
                    fax: <?=$agency->fax?><br/>
                    www: <a href="<?=$agency->website?>"><?=$agency->website?></a> <br/>
                </div>
            </div>
            <br class="clear"/>
        </div>
        <br/> <span class="bold">Provision: </span> <?=$agency->provision?>%<br/>

        <? else: ?>
        <div class="topinfo">

            <div class="address block">
                <span class="header">Adresse</span>

                <div class="agencyblock-content">
                    <?=$agency->address?><br/>
                    <?=$agency->plz.' '.$agency->ort?>
                </div>
            </div>
            <div class="agencyperson block">
                <span class="header">Ansprechpartner</span>

                <div class="agencyblock-content">
                    <?=$agency->person_name." ".$agency->person_surname.' - '.$agency->sex.' ('.$agency->name.')'?><br/>
                    e-mail: <a href="mailto:<?=$agency->email?>"><?=$agency->email?></a><br/>
                    phone: <?=$agency->phone?><br/>
                    fax: <?=$agency->fax?><br/>
                </div>
            </div>
            <br class="clear"/>
        </div>
        <? endif; ?>
        <div class="about block">
            <span class="header">Comment</span>

            <div class="agencyblock-content">
                <pre><?=$agency->about?></pre>
            </div>
        </div>
        <div class="edit-button-wr">
            <button class="btn btn-small btn-blue" id="edit_agency-button">Edit <?if($agency->type == 'person') echo 'kundenelseagency'?>
            </button>
        </div>

    </div>
    <table class="agency-list" id="agency-formulars">
        <thead>
        <th>Vorgangsnummer</th>
        <th>Rechnungsnummer</th>
        <th>Date created</th>
        <th>View</th>
        </thead>
        <? foreach($agency->formulars as $formular): ?>
        <tr>
            <td class="v_num"><?=$formular->v_num?></td>
            <td><?=$formular->r_num?></td>
            <td><?=$formular->created_date->format('d.m.Y');?></td>
            <td width="50px">
                <a href="formular/<?=$formular->id?>" class="btn btn-small btn-blue">View</a>
            </td>
        </tr>
        <? endforeach; ?>
    </table>
    <input type="hidden" name="agency_id" value="<?=$agency->id?>" id="agency_id"/>

    <div class="add-button-wr">
        <button class="btn btn-small btn-blue" id="add_formular-button">Add Formular</button>
    </div>
</div>

