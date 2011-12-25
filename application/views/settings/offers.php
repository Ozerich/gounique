<? if(isset($upload_error)): ?>
    <h1><?=$upload_error;?></h1>

<? endif; if(isset($upload_data)):?>

Файл <?=$upload_data['file_name']?> загружен

<? else: ?>

<?=form_open_multipart("settings/offers");?>
    <label for="file"> CSV file with hotel offers</label>
    <input type="file" id="file" name="offers_file">
    <input type="submit" name="offer_load" value="Load">
</form>

<?endif?>