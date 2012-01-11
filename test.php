<?php
    if(isset($_GET['search']))
    {
        $data = array(
            array("text" => "1", "value" => "2"),
            array("text" => "2", "value" => "3"),
            array("text" => "4", "value" => "5"));
        echo json_encode($data);
        exit();
    }
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
    <script src="js/jquery-1.7.1.min.js"></script>
    <script src="js/jquery-livesearch.js"></script>
<script>
    $(document).ready(function(){$('#text').liveSearch({url:"test.php?search="});});
</script>
</head>

<body>
    <input type="text" id="text"/>
</body>
</html>
