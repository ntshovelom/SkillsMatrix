<?php
include './DBManager.php';

/**
 * 
 */
if (isset($_POST['txt_search']) && $_POST['txt_search'] != null) {
    $_SESSION['search_text'] = $_POST['txt_search'];
    $_SESSION['skills'] = array();
}

if (isset($_POST['s_skill']) && $_POST['s_skill'] != "View skill") {
    $_SESSION['skills'][] = $_POST['s_skill'];
}

if ($_SESSION['search_text'] === "*") {
    getAllEmployees();
} else {
    search($_SESSION['search_text']);
}

function array_remove_by_value($array, $value) {
    return array_values(array_diff($array, array($value)));
}

foreach ($_SESSION['skills'] as $skill) {
    if (isset($_POST[$skill])) {
        unset($_SESSION['skills'][$skill]);
        $_SESSION['skills'] = array_remove_by_value($_SESSION['skills'], $skill);
        break;
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
        <link href="Style.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php
        include './main_navigation.html';
        ?>
        <div class="container">
            <div class="row">
                <div>
                    <h2>DashBoard</h2>
                    <form method="POST">
                        <input type="text" class="form-control" name="txt_search" placeholder="Enter Employee Name"><br></br>                   
                        <div style="overflow-x:auto;">
                            <table class="table">

                                <thead>
                                    <tr>
                                        <th>First Name</th>
                                        <th>Shore</th>
                                        <?php if ($_SESSION['search']) { ?>
                                            <th>Skill Description</th>
                                            <th>LEVEL Description</th>
                                        <?php } ?>
                                        <?php
                                        $counter = 1;
                                        foreach ($_SESSION['skills'] as $skill) {
                                            echo "<th><form method=\"POST\">" . $skill . "<button onclick=\"this.form.submit()\" name=\"" . $skill . "\" type=\"submit\" class=\"close\" aria-label=\"Close\">
                                    <span aria-hidden=\"true\" style=\" float: right;\">&times;</span>
                                    </button></form></th>";
                                            $counter = $counter + 1;
                                        }
                                        ?>
                                        <th>

                                <form method="POST">
                                    <select class="form-control" onchange="this.form.submit();" name="s_skill" style="width: 120px; float: right">
                                        <option style="color: grey">View skill</option>
                                        <?php
                                        //$result = getSkillsRemaining();
                                        //if (strlen($_SESSION['search_text']) > 0) {
                                        $result = getSkillsAssociated($_SESSION['search_text']);
                                        //}

                                        while ($row = mysqli_fetch_array($result)) {
                                            echo "<option class=\"form-control form-control-sm\" value=\"" . $row['SKILL_DESCRIPTION'] . "\">" . $row['SKILL_DESCRIPTION'] . "</option>";
                                        }
                                        ?>

                                    </select>
                                </form></th>

                                </tr>
                                </thead>
                                <?php while ($row = mysqli_fetch_array($search_result)): ?>
                                    <tr>
                                        <td><?php echo $row['NAMES']; ?></td>
                                        <td><?php echo $row['SHORE']; ?></td>


                                        <?php
                                        foreach ($_SESSION['skills'] as $skill) {

                                            echo "<td>" . getEmployeeSkillLevel($row['emp_id'], $skill) . "</td>";
                                        }
                                        ?>


                                        <?php if ($_SESSION['search']) { ?>
                                            <td><?php echo $row['SKILL_DESCRIPTION']; ?></td>
                                            <td><?php echo $row['LEVEL_DESCR']; ?></td>
                                        <?php } ?>
                                        <td></td>
                                    </tr>
                                <?php endwhile; ?>
                            </table>
                            <p> Create report<p>
                        </div>
                        <br>
                    </form>
                </div>
            </div>
        </div>
        <div class="jumbotron text-center" style="margin-bottom:0">
            <p>@zensar.com</p>
        </div>
    </body>
</html>
