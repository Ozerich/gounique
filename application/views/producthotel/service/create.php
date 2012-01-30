<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a href="product">product</a></li>
            <li><a href="product/hotels/main">hotelverwaltung</a></li>
            <li><a href="product/hotels/service">verpflegungsdaten</a></li>
        </ul>
    </div>
</div>

<div id="verpflegungscreate-page" class="content product-create">
    <?=form_open("product/hotels/service/create")?>
    <div class="param">
        <label for="code">Code</label>
        <input name="code" type="text" id="code" class="high-letters" maxlength="4"/>
    </div>
    <div class="param">
        <label for="name">Name</label>
        <input name="name" type="text" id="name" class="high-letters" />
    </div>
    <div class="submit">
        <input type="submit" name="verpflegungs_create" value="Apply">
    </div>
    <br class="clear"/>
    </form>
</div>