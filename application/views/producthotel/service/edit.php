<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a href="product">product</a></li>
            <li><a href="product/hotels/main">hotelverwaltung</a></li>
            <li><a href="product/hotels/service">zimmerdaten</a></li>
        </ul>
    </div>
</div>

<div id="verpflegungscreate-page" class="content product-create">
    <?=form_open("product/hotels/service/edit/".$service->id)?>
    <div class="param">
        <label for="code">Code</label>
        <input name="code" type="text" id="code" class="high-letters" maxlength="4" value="<?=$service->code?>"/>
    </div>
    <div class="param">
        <label for="name">Name</label>
        <input name="name" type="text" id="name" class="high-letters" value="<?=$service->name?>"/>
    </div>

    <div class="submit">
        <input type="submit" name="verpflegungs_edit" value="Apply">
    </div>
    <br class="clear"/>
    </form>
</div>