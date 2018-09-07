<?php
include './main_navigation.html';
include './DBManager.php';
session_start();
?>
<!DOCTYPE html>
<html>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <?php
    if (isset($_POST['btn_finish'])) {
        addResource($_POST['name'], $_POST['shore'], $_POST['empRole'], $_POST['skill'], $_POST['level']);
    }


    $queryRoles = "SELECT ROLE_ID, ROLE_DESCRIPTION FROM roles ORDER BY ROLE_DESCRIPTION";
    $allRoles = executeSQLQuery($queryRoles);
    $name = "";
    $shore = "";
    $role = "";
    if (isset($_POST['skill']) && $_POST['skill'] != "Choose Skill") {
        $_SESSION['add_skills'][] = $_POST['skill'];
        $_SESSION['add_levels'][] = $_POST['level'];
        if (isset($_POST['name'])) {
            $name = $_POST['name'];
            $shore = $_POST['shore'];
            $role = $_POST['empRole'];
        }
    }

    foreach ($_SESSION['add_skills'] as $skill) {
//        if (isset($_POST[$skill . '_delete'])) {
//
//            $index = array_search($skill, $_SESSION['add_skills']);
//            //$l = $_SESSION['add_levels'][$index];
//
//            unset($_SESSION['add_skills'][$skill]);
//            //unset($_SESSION['add_levels'][$index]);
//            $_SESSION['add_skills'] = array_remove_by_value($_SESSION['add_skills'], $skill);
//            break;
//        }
    }

    function array_remove_by_value($array, $value) {
        return array_values(array_diff($array, array($value)));
    }

    $allSkills = getSkillsRemaining($_SESSION['add_skills']);
    $levels = getLevels();
    ?>
    <body>
        <div class="container">
            <form method="POST">
                <h1>New Resource</h1>
                <div class="input-group">
                    <span class="input-group-addon">Resource</span>
                    <input class="form-control" type="text" placeholder="Please enter full names" <?php
                    if (strlen($name) > 0) {
                        echo 'value="' . $name . '"';
                    }
                    ?> name="name" required>
                </div>
                </p>
                <div class="input-group">
                    <span class="input-group-addon">Shore</span>
                    <select class="form-control" id="shore" name="shore" >
                        <option  value="Onshore">Onshore</option>
                        <option <?php
                        if ($shore === "Offshore") {
                            echo 'selected';
                        }
                        ?> value="Offshore">Offshore</option>
                    </select>
                </div>
                </p>
                <div class="input-group">
                    <span class="input-group-addon">Role :</span>
                    <select  class="form-control" name="empRole">
                        <?php
                        while ($row = $allRoles->fetch_assoc()) :
                            $selected = "";
                            if ($row['ROLE_DESCRIPTION'] === getRoleByID($role)) {
                                $selected = "selected";
                            }
                            echo '<option ' . $selected . ' value="' . $row['ROLE_ID'] . '">' . $row['ROLE_DESCRIPTION'] . '</option>';
                        endwhile;
                        ?>
                    </select>
                </div>
                </p>
                <div>
                    <button type="button" class="btn-default btn-lg" data-toggle="modal" data-target="#myModal">Add Skill</button>

                    <!-- Modal -->
                    <div class="modal fade" id="myModal" role="dialog">
                        <div class="modal-dialog modal-lg">
                            <form method="POST">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Select Skill and Level</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p> <select class="form-control" name="skill">
                                                <option>Choose Skill</option>
                                                <?php
                                                while ($row = mysqli_fetch_array($allSkills)) {
                                                    echo '<option value="' . $row['SKILL_ID'] . '">' . $row['SKILL_DESCRIPTION'] . '</option>';
                                                }
                                                ?>
                                            </select></p>
                                        <select class="form-control" name="level">
                                            <?php while ($row = mysqli_fetch_array($levels)) { ?>
                                                <option value="<?php echo $row['LEVEL_ID']; ?>"> <?php echo $row['LEVEL_DESCR'] ?> </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    </p>
                                    <div class="modal-footer">
                                        <button type="button" onclick="this.form.submit()" id="btnSave" class="btn btn-default" data-dismiss="modal" name="btn_save">Save</button>
                                    </div>
                                </div>
                                </p>
                            </form>
                        </div>
                    </div>
                    </p>
                    <div style="max-height: 50%; overflow-y: scroll">
                        <?php
                        $counter = 0;
                        while ($counter < sizeof($_SESSION['add_skills'])) {
                            ?>
                            <form method="POST">
                                <div class="alert alert-info" >
                                    <strong><?php echo getSkillByID($_SESSION['add_skills'][$counter]); ?></strong>: <?php echo getLevelByID($_SESSION['add_levels'][$counter]); ?>
                                    <button onclick="" name="<?php echo $_SESSION['add_skills'][$counter] . '_delete' ?>"  type="button" class="close" aria-label="Close">
                                        <span  aria-hidden="true" >&times;</span>
                                    </button>

                                </div>
                            </form>
                            <?php
                            $counter++;
                        }
                        ?>
                    </div>
                    </p>
                    <button name="btn_finish" style="float: right;" type="submit" class="btn btn-block btn-primary">Add Resource</button>
                </div>
            </form>
        </div>
    </body>
</html>

<style>
    * {
        box-sizing: border-box;
    }

    body {
        background-color: #f1f1f1;
    }

    #regForm {
        background-color: #ffffff;
        margin: 100px auto;
        font-family: Raleway;
        padding: 40px;
        width: 70%;
        min-width: 300px;
    }

    h1 {
        text-align: center;  
    }

    input {
        padding: 10px;
        width: 100%;
        font-size: 17px;
        font-family: Raleway;
        border: 1px solid #aaaaaa;
    }

    /* Mark input boxes that gets an error on validation: */
    input.invalid {
        background-color: #ffdddd;
    }

    /* Hide all steps by default: */
    .tab {
        display: none;
    }

    button {
        background-color: #4CAF50;
        color: #ffffff;
        border: none;
        padding: 10px 20px;
        font-size: 17px;
        font-family: Raleway;
        cursor: pointer;
    }

    button:hover {
        opacity: 0.8;
    }

    #prevBtn {
        background-color: #bbbbbb;
    }

    /* Make circles that indicate the steps of the form: */
    .step {
        height: 15px;
        width: 15px;
        margin: 0 2px;
        background-color: #bbbbbb;
        border: none;  
        border-radius: 50%;
        display: inline-block;
        opacity: 0.5;
    }

    .step.active {
        opacity: 1;
    }

    /* Mark the steps that are finished and valid: */
    .step.finish {
        background-color: #4CAF50;
    }
</style>