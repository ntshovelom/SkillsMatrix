<?php
include './main_navigation.html';
include './DBManager.php';
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
    <?php
    $queryCateG = "SELECT  ID ,CATEG_DESCRIPTION FROM skill_category;";
    $allCateG = executeSQLQuery($queryCateG);
    $faildF = FALSE;

    if (isset($_POST['AddSkill'])) {

        $query1 = "SELECT * FROM skills WHERE SKILL_DESCRIPTION = '$_POST[skill]'";
        $result = executeSQLQuery($query1);
        $data = mysqli_fetch_array($result, MYSQLI_NUM);

        if ($data[0] > 1) {
            $faild = '<div class="alert alert-danger">'
                    . '<strong>Skill Already in Exists!</strong>'
                    . '</div>';
            $faildF = True;
        } else {
            $newSkill = "INSERT INTO skills(SKILL_DESCRIPTION,CATEG_ID) values('" . $_POST['skill'] . "'," . $_POST['category'] . ")";
            executeSQLQuery($newSkill);

            $success = '<div class="alert alert-success">'
                    . '<strong>Skill Add!</strong>'
                    . '</div>';
        }
    }
    ?>
    <body>
        <div class="container">
            <form method="POST">
                <h2>Add new Skill</h2>
                <br></br>
                <div class="input-group">
                    <span class="input-group-addon">Skill</span>
                    <input id="msg" type="text" class="form-control" name="skill" placeholder="Enter Skill Name" required>
                </div>
                </p>
                <div class="input-group">
                    <span class="input-group-addon">Select Skill Category</span>
                    <select class="form-control" name="category">
                        <?php
                        while ($row = mysqli_fetch_array($allCateG)) {
                            echo '<option value="' . $row['ID'] . '">' . $row['CATEG_DESCRIPTION'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <br></br>
                <?php
                if (isset($_POST['AddSkill'])) {
                    if ($faildF) {
                        echo $faild;
                    } else {
                        echo $success;
                    }
                }
                ?>
                <button type="submit" onclick="this.form.submit();" class="btn btn-primary btn-block" name="AddSkill">Add Skill</button>
        </div>
    </body>
</html>












