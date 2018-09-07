<?php
include './main_navigation.html';
include './DBManager.php';
$queryCateG = "SELECT  DIVISION_ID ,DIV_DESCRIPTION FROM divisions ORDER BY DIV_DESCRIPTION;";
$allCateG = executeSQLQuery($queryCateG);
$faildF = FALSE;

if (isset($_POST['AddRole'])) {

    $query1 = "SELECT * FROM roles WHERE ROLE_DESCRIPTION = '$_POST[role]'";
    $result = executeSQLQuery($query1);
    $data = mysqli_fetch_array($result, MYSQLI_NUM);

    if ($data[0] > 1) {
        $faild = '<div class="alert alert-danger">'
                . '<strong>Role Already in Exists!</strong>'
                . '</div>';
        $faildF = True;
    } else {
        $newSkill = "INSERT INTO roles(ROLE_DESCRIPTION,DIVISION_ID) values('" . $_POST['role'] . "'," . $_POST['division'] . ")";
        executeSQLQuery($newSkill);

        $success = '<div class="alert alert-success">'
                . '<strong>Role Add!</strong>'
                . '</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>

    <body>
        <div class="container">
            <form method="POST">
                <h1>New Role</h1>
                <div class="input-group">
                    <span class="input-group-addon">Role</span>
                    <input id="msg" type="text" class="form-control" name="role" placeholder="Enter role Name" required>
                </div>
                </p>
                <div class="input-group">
                    <span class="input-group-addon">Division</span>
                    <select class="form-control" name="division">
                        <?php
                        while ($row = mysqli_fetch_array($allCateG)) {
                            echo '<option value="' . $row['DIVISION_ID'] . '">' . $row['DIV_DESCRIPTION'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <br></br>
                <?php
                if (isset($_POST['AddRole'])) {
                    if ($faildF) {
                        echo $faild;
                    } else {
                        echo $success;
                    }
                }
                ?>
                <button type="submit" onclick="this.form.submit();" class="btn btn-primary btn-block" name="AddRole">Add Role</button>
            </form>
        </div>
    </body>
</html>
<style>

    body {
        background-color: #f1f1f1;
    }
    h1 {
        text-align: center;  
    }
</style>











