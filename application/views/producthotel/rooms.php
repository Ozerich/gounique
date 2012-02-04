<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a href="product">product</a></li>
            <li><a href="product/hotel">hotelverwaltung</a></li>
            <li><span>hoteldaten</span></li>
        </ul>
    </div>
</div>

<div id="zimmerlist-page" class="content room-page">

    <h2 class="hotel-name"><?=$hotel->name?> - <?=$room ? $room->cat_name : ' no zimmer'?></h2>

    <div class="zimmer-new">
        <a href="product/hotel/create_room/<?=$hotel->id?>" class="button-link">Add Zimmer</a>
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
        <fieldset class="datum-block">
            <legend>Datum</legend>
            <div class="param">
                <label for="von">von</label>
                <input type="text" name="von" id="von"/>
            </div>
            <div class="param last">
                <label for="bis">bis</label>
                <input type="text" name="bis" id="bis"/>
            </div>
            <div class="param">
                <label for="zimmerkontigent">Zimm. Kont.</label>
                <input type="text" name="zimmerkontigent" id="zimmerkontigent"/>
            </div>
            <div class="param last">
                <label for="relis">Relis</label>
                <input type="text" name="relis" id="relis">
            </div>
        </fieldset>
        <fieldset class="price-block">
            <legend>Preis p.P p.Nacht</legend>
            <table class="price-table">
                <thead>
                <tr>
                    <th colspan="5">&nbsp;</th>
                    <th colspan="10">Meal</th>
                </tr>
                <tr>
                    <th>&nbsp;</th>
                    <th>Preis</th>
                    <th>&nbsp;</th>
                    <th>Discount</th>
                    <th>&nbsp;</th>
                    <? foreach ($room->services as $service): ?>
                    <th><?=$service->short_name?></th>
                    <? endforeach; ?>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="name">Erw</td>
                    <td class="price"><input type="text"/></td>
                    <td class="percent top">% 1</td>
                    <td class="price">&nbsp;</td>
                    <td class="percent top">% 2</td>
                    <? foreach ($room->services as $service): ?>
                    <td class="meal"><input type="text"/></td>
                    <? endforeach; ?>
                </tr>
                    <? foreach ($hotel->child_types as $child): ?>
                <tr>
                    <td class="name"><?=$child->name?></td>
                    <td class="price"><input type="text"/></td>
                    <td class="percent"><input type="text"/></td>
                    <td class="price"><input type="text"/></td>
                    <td class="percent"><input type="text"/></td>
                    <? foreach ($room->services as $service): ?>
                    <td class="meal"><input type="text"/></td>
                    <? endforeach; ?>
                </tr>

                    <? endforeach; ?>
                <tr class="bottom">
                    <td>&nbsp;</td>
                    <td colspan="15">
                        <div class="marge-price bottom-block">
                            <label for="marge_price">Marge %</label>
                            <input type="text" name="marge_price" id="marge_price"/>
                        </div>
                        <div class="rbs-price bottom-block">
                            <label for="erm_price">ERM %</label>
                            <input type="text" name=erm_price id="erm_price"/>
                        </div>
                        <div class="marge-meal bottom-block">
                            <label for="marge_meal">Marge %</label>
                            <input type="text" name="marge_meal" id="marge_meal"/>
                        </div>
                        <br class="clear"/>
                    </td>
                </tr>
                </tbody>
            </table>
        </fieldset>
        <br class="clear"/>

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
                <td class="name"><input type="text" maxlength="1" value="<?=$dif[$child->id]?>"
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