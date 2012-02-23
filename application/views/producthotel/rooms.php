<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a href="product">produkt</a></li>
            <li><a href="product/hotel">hotelverwaltung</a></li>
            <li><a href="product/hotel/edit/<?=$hotel->id?>">hoteldaten</a></li>
        </ul>
    </div>
</div>

<div id="zimmerlist-page" class="content room-page">

<h2 class="hotel-name"><a href="product/hotel/edit/<?=$hotel->id?>"><?=$hotel->name?></a>
    - <?=$room ? '<a href="product/hotel/room/' . $hotel->id . '/' . $room->room_id . '">' . $room->cat_name . '</a>' : ' no zimmer'?>
</h2>

<div class="zimmer-new">
    <a href="product/hotel/room/<?=$hotel->id?>" class="button-link">Add Zimmer</a>
</div>
<? if (!$room): ?>
<p class="empty">Zimmerdaten is empty</p>
    <? else: ?>
<ul id="room-tabs">
    <? foreach ($hotel->room_types as $c_room): ?>
    <li <?if ($c_room->id == $room->id) echo 'class="active"'?>><a
        href="product/hotel/rooms/<?=$hotel->id?>/<?=$c_room->id?>"><?=$c_room->code?></a></li>
    <? endforeach; ?>
</ul>

<ul id="room-subtabs">
    <li for-page="price-page" class="active"><a href="#">Preis</a></li>
    <li for-page="persons-page"><a href="#">Persons</a></li>
</ul>

<div id="price-page">
    <?=form_open("product/hotel/rooms/" . $hotel->id . "/" . $room->id); ?>
    <div class="datum-block-wr">
        <fieldset class="datum-block">
            <legend>Datum</legend>
            <div class="param">
                <label for="von">von</label>
                <input type="text" name="von" id="von" maxlength="8"/>
            </div>
            <div class="param last">
                <label for="bis">bis</label>
                <input type="text" name="bis" id="bis" maxlength="8"/>
            </div>
            <div class="param">
                <label for="zimmerkontigent">Allotm.</label>
                <input type="text" maxlength="3" name="zimmerkontigent" id="zimmerkontigent"/>
            </div>
            <div class="param last">
                <label for="relis">Release</label>
                <input type="text" maxlength="3" name="relis" id="relis">
            </div>
        </fieldset>
        <div class="buttons">
            <input type="submit" name="save-submit" id="save-price" value="Hinzufügen"/>
            <input type="hidden" value="" name="period_id"/>
            <input type="submit" name="edit-submit" id="edit-price" style="display:none" value="Korrigieren"/>
        </div>
    </div>
    <fieldset class="price-block">
        <legend>Preis p.P p.Nacht</legend>
        <div id="price-loader" style="display: none">
            <div id="loader"></div>
        </div>
        <table class="price-input">
            <thead>
            <tr>
                <th colspan="5" class="right-line">&nbsp;</th>
                <th colspan="10">Verpflegungszuschlag</th>
            </tr>
            <tr>
                <th>&nbsp;</th>
                <th>Preis</th>
                <th>&nbsp;</th>
                <th><?=$hotel->child_types ? 'Preis' : ''?></th>
                <th class="right-line">&nbsp;</th>
                <? foreach ($room->services as $service): ?>
                <th><?=$service->short_name?></th>
                <? endforeach; ?>
            </tr>

            </thead>
            <tbody>
            <tr>
                <td class="name">Erw</td>
                <td class="price"><input type="text" maxlength="5" name="erw_price" class="base_price"/></td>
                <td class="percent top">&nbsp;</td>
                <td class="price">&nbsp;</td>
                <td class="percent top right-line">&nbsp;</td>
                <? foreach ($room->services as $service): ?>
                <td class="meal"><input maxlength="3" name="meal[0][<?=$service->id?>]" type="text"/></td>
                <? endforeach; ?>
            </tr>

            <? if ($hotel->child_types): ?>
            <tr class="header-second">
                <td>&nbsp;</td>
                <td>Kind 1</td>
                <td><span class="erm">ERM</span>%</td>
                <td>Kind 2</td>
                <td class="right-line"><span class="erm">ERM</span>%</td>
                <td colspan="100">&nbsp;</td>
                <? endif; ?>
            </tr>
                <? foreach ($hotel->child_types as $child): ?>
            <tr>
                <td class="name"><?=$child->name?></td>
                <td class="price"><input type="text" class="price1" maxlength="5" name="price1[<?=$child->id?>]"/></td>
                <td class="percent"><input maxlength="3" class="percent_price1" type="text"/>
                </td>
                <td class="price"><input maxlength="5" type="text" class="price2" name="price2[<?=$child->id?>]"/></td>
                <td class="percent right-line"><input maxlength="3" class="percent_price2" type="text"/>
                </td>
                <? foreach ($room->services as $service): ?>
                <td class="meal"><input maxlength="3" name="meal[<?=$child->id?>][<?=$service->id?>]" type="text"/></td>
                <? endforeach; ?>
            </tr>

                <? endforeach; ?>
            <tr class="bottom">
                <td>&nbsp;</td>
                <td colspan="15">
                    <div class="marge-price bottom-block">
                        <label for="marge_price">Marge %</label>
                        <input type="text" name="marge_price" maxlength="3" id="marge_price"/>
                    </div>
                    <div class="rbs-price bottom-block">
                        <label for="erm_price">ERM %</label>
                        <input type="text" name="erm_price" maxlength="3" id="erm_price"/>
                    </div>
                    <div class="marge-meal bottom-block">
                        <label for="marge_meal">Marge %</label>
                        <input type="text" name="marge_meal" maxlength="3" id="marge_meal"/>
                    </div>
                    <br class="clear"/>
                </td>
            </tr>
            </tbody>
        </table>
    </fieldset>
    <br class="clear"/>


    <table id="price-table" class="product-list">
        <thead>
        <th>Period</th>
        <th>Konti</th>
        <th>Rel</th>
        <th>Price</th>
            <?foreach ($hotel->child_types as $child): ?>
        <th><?=$child->name?></th>
            <? endforeach; ?>
        <th>Marge %</th>
        <th>ERM %</th>
            <?foreach ($room->services as $service): ?>
        <th><?=$service->short_name?></th>
            <? endforeach; ?>
        <th>Marge Meal %</th>
        </thead>
        <tbody>
            <? foreach ($room->periods as $period): ?>

        <tr>
            <input type="hidden" value="<?=$period->id?>" id="period_id"/>
            <input type="hidden" value="<?=$period->start->format('dmY');?>" class="period_start"/>
            <input type="hidden" value="<?=$period->finish->format('dmY');?>" class="period_finish"/>
            <td><?=$period->text_period?></td>
            <td class="zimmer_kontigent"><?=$period->zimmer_kontigent?></td>
            <td class="relis"><?=$period->relis?></td>
            <td class="period_price"><?=$period->price?></td>

            <?foreach ($hotel->child_types as $child): ?>
            <td><?=isset($period->child_prices[$child->id][1]) ? $period->child_prices[$child->id][1] : ''?></td>
            <? endforeach; ?>
            <td class="price_marge"><?=$period->price_marge?></td>
            <td class="price_erm"><?=$period->price_erm?></td>
            <?foreach ($room->services as $service): ?>
            <td><?=$period->service_prices[0][$service->id]?></td>
            <? endforeach; ?>
            <td class="meal_marge"><?=$period->meal_marge?></td>
        </tr>
            <? endforeach; ?>
        </tbody>
    </table>
    </form>
</div>

<div id="persons-page" style="display:none">
    <?=form_open("product/hotel/save_difference/" . $room->id)?>
    <table class="persons-list">
        <thead>
        <th class="name">Erw</th>
            <? foreach ($hotel->child_types as $child): ?>
        <th class="plus">&nbsp;</th>
        <th class="name"><?=$child->name?></th>
            <? endforeach; ?>
        <th class="delete">&nbsp;</th>
        </thead>
        <tbody>
        <tr class="example" style="display:none">
            <td class="name"><input type="text" maxlength="1" for-name="diff[0]" value="0"/></td>
            <? foreach ($hotel->child_types as $child): ?>
            <td class="plus">+</td>
            <td class="name"><input type="text" maxlength="1" value="0" for-name="diff[<?=$child->id?>]"/></td>
            <? endforeach; ?>
            <td class="delete"><a href="#" class="delete-icon"></a></td>
        </tr>
            <? foreach ($room->differencies as $ind => $dif): ?>
        <tr>
            <td class="name"><input type="text" maxlength="1" name="diff[0][<?=$ind?>]" value="<?=$dif[0]?>"/></td>
            <? foreach ($hotel->child_types as $child): ?>
            <td class="plus">+</td>
            <td class="name"><input type="text" maxlength="1" value="<?=isset($dif[$child->id]) ? $dif[$child->id] : '0'?>"
                                    name="diff[<?=$child->id?>][<?=$ind?>]"/></td>
            <? endforeach; ?>
            <td class="delete"><a href="#" class="delete-icon"></a></td>
        </tr>
            <? endforeach; ?>
        </tbody>
    </table>
    <button id="add-difference">Add</button>
    <input type="submit" value="Save"/>

    </form>
</div>
    <? endif; ?>
</div>