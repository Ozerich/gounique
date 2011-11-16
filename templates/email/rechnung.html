<div id="page">
    <div id="header">
        <br/><br/><br/><br/><br/><br/><br/><br/>

        <div class="address">
            {if $agency.type eq 'agency'}
            {$agency.contactperson} {$agency.surname} - {$agency.sex}<br/>
            e-mail: <a href="mailto:{$agency.email}">{$agency.email}</a><br/>
            phone: {$agency.phone}<br/>
            fax: {$agency.fax}<br/>
            www: <a href="{$agency.website}">{$agency.website}</a> <br/>
            {else}
            {$agency.name} {$agency.surname} - {$agency.sex} ({$agency.contactperson})<br/>
            e-mail: <a href="mailto:{$agency.email}">{$agency.email}</a><br/>
            phone: {$agency.phone}<br/>
            fax: {$agency.fax}<br/>
            {/if}
        </div>
    </div>
    <div id="content">
        <h1>RECHNUNG / BESTÄTIGUNG</h1>

        <div class="vorgansnummer-wr">
            <div class="left">
                <div class="header">Vorgangsnummer {$vorgansnummer}</div>
                <br/>
                <div class="nummer"><strong>Rechnungsnummer: {$rechnungsnummber}</strong></div>
                <div class="nummer"><strong>Abreisedatum: {$abreisedatum}</strong></div>
            </div>
            <div class="right">
                <div>Datum: {$today}</div>
                <div>Sachbearbeiter: {$user.fullname}</div>
            </div>
        </div>
        <div class="mainblock">
            <div class="persons">
                <span class="header">Reiseteilnehmer:</span>
                {foreach $persons as $ind => $person}
                <div class="person">
                    <div class="num">{$ind + 1}</div>
                        <div class="num">{$ind + 1}</div>
                  {if $person.name neq ''}
                    <div class="sex">{$person.sex}</div>
                    <div class="name">{$person.name}</div>
                 {/if}

                </div>
                {/foreach}
                <br class="clear"/>
            </div>
            <div class="tours">
                <span class="header">Leistung:</span>
                {foreach $hotels as $ind => $hotel}
                <div class="tour">
                    <div class="date"> {$hotel.datestartformatted} - {$hotel.dateendformatted}</div>
                    <div class="content"> {$hotel.dayscount}N HOTEL: {$hotel.hotelname} /
                        {$hotel.roomcapacity} / {$hotel.roomtype} / {$hotel.service} / TRANSFER {$hotel.transfer} /
                        {$hotel.remark}
                    </div>
                </div>
                {/foreach}
                {foreach $manuels as $ind => $manuel}
                <div class="tour">
                    <div class="date"> {$manuel.datestartformatted} - {$manuel.dateendformatted}</div>
                    <div class="content"> {$manuel.text}</div>
                </div>
                {/foreach}
            </div>
            {if $flightplan.content neq ''}
            <div class="flugplan">
                <span class="header">Flugplan:</span>
                <div class="content">
                    <pre>{$flightplan.content}</pre>
                </div>
            </div>
            {/if}
        </div>
        {if $print_under}
        <div class="undertable">
        {if $price.anzahlung==0}
        
        {else}
            {$price.anzahlung}% Anzahlung ({$price.anzahlung_value} &euro;) nach Erhalt der Rechnung. 
           {if $price.anzahlung!=100} Restzahlung bis {$zahlungsdatum} ({$price.brutto - $price.anzahlung_value}&euro;) {/if}
         {/if}
        </div>
        {/if}
        <div class="commentblock">
            <pre>
                {$bigcomment}
            </pre>
        </div>
        <div class="priceblock">
            <div class="price-item">Preis p.P. brutto: {$price.person} &euro;</div>
            <div class="price-item">Gesamtpreis brutto: {$price.brutto} &euro;</div>
            {if $type eq 'A'}
            <div class="price-item">{$provision} % Provision: {$price.provision} &euro;</div>
            <div class="price-item">19 % Mwst: {$price.percent} &euro;</div>
            {/if}
            <div class="price-item"><b>Gesamtpreis netto: {$price.netto} &euro;</b></div>
        </div>
        <div class="bottomblock">
            <div class="signature">
                <span>Bei Buchungswunsch bitte unterschrieben zurückfaxen:</span>
                <div class="line"></div>
            </div>
            <p>Mit freundlichen Grüßen</p>
            <span>{$user.fullname} <br/>Unique World GmbH</span>
        </div>
    </div>
    <div id="footer"></div>
</div>