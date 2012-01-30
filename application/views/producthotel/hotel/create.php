<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a href="product">product</a></li>
            <li><a href="product/hotels/main">hotelverwaltung</a></li>
            <li><a href="product/hotels">hoteldaten</a></li>
        </ul>
    </div>
</div>

<div id="hotelcreate-page" class="content product-create">
    <?=form_open("product/hotel/create")?>

    <ul id="tabs">
        <li class="active"><span for="page1">CRS Daten</span></li>
        <li><span for="page2">Klassen u. Extras</span></li>
        <li><span for="page3">Kontaktdaten</span></li>
    </ul>

    <div class="page" id="page1">
        <div class="param">
            <label for="code">Hotelcode</label>
            <input name="code" class="high-letters" type="text" id="code" maxlength="10"/>
        </div>
        <div class="param">
            <label for="name">Hotelname</label>
            <input name="name" type="text" id="name"/>
        </div>

        <div class="param">
            <label for="category">Kategorie</label>
            <input name="stars" type="text" id="category"/>
        </div>

        <div class="param">
            <label for="tlc">Hotel TLC</label>
            <input name="tlc" type="text" id="tlc"/>
        </div>

        <div class="param">
            <label for="zielgibiet">Zielgebiet</label>
            <input name="zielgibiet" type="text" id="zielgibiet"/>
        </div>

        <div class="param">
            <label for="ort">Hotel Ort</label>
            <input name="ort" type="text" id="ort"/>
        </div>

        <div class="param">
            <label for="land">Hotel Land</label>
            <input name="land" type="text" id="land"/>
        </div>

        <div class="param">
            <div class="left">
                <label for="min_auf">Min.Auf.</label>
                <input name="min_auf" type="text" id="min_auf"/>
            </div>
            <div class="right">
                <label for="max_auf">Max.Auf.</label>
                <input type="text" name="max_auf" id="max_auf"/>
            </div>
            <br class="clear"/>
        </div>

        <div class="param">
            <label for="service">Hotel Verpflegungs</label>

            <div class="checkbox-block">
                <? foreach (ProductService::all() as $service): ?>
                <div class="checkbox">
                    <input type="checkbox" name="service" value="<?=$service->id?>"/><span><?=$service->name?><span>
                </div>
                <? endforeach; ?>
            </div>
        </div>

        <div class="param zimmer-block">
            <label for="zimmer">Hotelzimmer</label>

            <div class="zimmer-new">
                <input type="text" id="zimmer-value"/>
                <button id="zimmer-add">Add</button>
                <input type="hidden" id="zimmer_id"/>
            </div>

            <div class="zimmer-list">
                <div class="item">
                    <span class="value">Room type 1</span>
                    <a href="#" class="zimmer-delete"></a>
                </div>

                <div class="item">
                    <span class="value">Room type 2</span>
                    <a href="#" class="zimmer-delete"></a>
                </div>

                <div class="item">
                    <span class="value">Room type 3</span>
                    <a href="#" class="zimmer-delete"></a>
                </div>

            </div>
        </div>

        <div class="param radios">
            <div class="left">
                <label for="flugbindung">Flugbindung</label>

                <div class="buttonset">
                    <input type="radio" value="on" id="flug-on" name="flugbindung"/><label for="flug-on">On</label>
                    <input type="radio" value="off" id="flug-off" name="flugbindung" checked/><label
                    for="flug-off">Off</label>
                </div>
            </div>
            <div class="right">
                <label for="crs">CRS Status</label>

                <div class="buttonset">
                    <input type="radio" value="on" id="crs-on" name="crs"/><label for="crs-on">On</label>
                    <input type="radio" value="off" id="crs-off" name="crs" checked/><label for="crs-off">Off</label>
                </div>
            </div>
            <br class="clear"/>
        </div>
    </div>

    <div class="page" id="page2" style="display: none">
        2
    </div>

    <div class="page" id="page3" style="display:none">
        3
    </div>

    <div class="submit">
        <input type="submit" name="zimmer_create" value="Apply">
    </div>
    <br class="clear"/>
    </form>
</div>