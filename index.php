<?php
//include './DBConnect.php';
if (isset($_POST['sb_send'])) {
    echo '<script> alert("'
    . $_POST['select']
    . '") </script>';
}
$val = "hello world";
?>
<html>
    <head>
        <meta charset="UTF-8">
        <!--        <link rel="stylesheet" href="./Bootstrap/css/bootstrap.min.css">
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                <script src="./Bootstrap/js/bootstrap.min.js"></script>-->
        <title></title>
    </head>
    <body>

        <?php
        session_start();
        //include './side.php';
        include './dashboard.php';
        ?>  

    </div>
</body>
</html>
