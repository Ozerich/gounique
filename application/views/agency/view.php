<div class="kunde-item">
    <div class="kunde-view">
        <? if ($kunde->type == 'kunde'): ?>
        <div class="topinfo">

            <div class="address block">
                <span class="header">Adresse</span>

                <div class="kundeblock-content">
                    <?=$kunde->name?><br/>
                    <?=$kunde->address?><br/>
                    <?=$kunde->plz." ".$kunde->ort?>
                </div>
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
        <br/> <span class="bold">Provision: </span> <?=$kunde->provision?>%<br/>

        <? else: ?>
        <div class="topinfo">

            <div class="address block">
                <span class="header">Adresse</span>

                <div class="kundeblock-content">
                    <?=$kunde->address?><br/>
                    <?=$kunde->plz.' '.$kunde->ort?>
                </div>
            </div>
            <div class="kundeperson block">
                <span class="header">Ansprechpartner</span>

                <div class="kundeblock-content">
                    <?=$kunde->person_name." ".$kunde->person_surname.' - '.$kunde->sex.' ('.$kunde->name.')'?><br/>
                    e-mail: <a href="mailto:<?=$kunde->email?>"><?=$kunde->email?></a><br/>
                    phone: <?=$kunde->phone?><br/>
                    fax: <?=$kunde->fax?><br/>
                </div>
            </div>
            <br class="clear"/>
        </div>
        <? endif; ?>
        <div class="about block">
            <span class="header">Comment</span>

            <div class="kundeblock-content">
                <pre><?=$kunde->about?></pre>
            </div>
        </div>
        <div class="edit-button-wr">
            <button class="btn btn-small btn-blue" id="edit_kunde-button">Edit <?if($kunde->type == 'person') echo 'kundenelsekunde'?>
            </button>
        </div>

    </div>
    <table class="kunde-list" id="kunde-formulars">
        <thead>
        <th>Vorgangsnummer</th>
        <th>Rechnungsnummer</th>
        <th>Date created</th>
        <th>View</th>
        </thead>
        <? foreach($kunde->formulars as $formular): ?>
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
    <input type="hidden" name="kunde_id" value="<?=$kunde->id?>" id="kunde_id"/>

    <div class="add-button-wr">
        <button class="btn btn-small btn-blue" id="add_formular-button">Add Formular</button>
    </div>
</div>

