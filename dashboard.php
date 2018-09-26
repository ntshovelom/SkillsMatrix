<?php
include './main_navigation.php';
include './DBManager.php';
include './ReportMaker.php';
$search_result;

/**
 * 
 */
foreach ($_SESSION['skills'] as $skill) {
    if (isset($_POST[$skill . '_skill_link'])) {
        $_SESSION['search_text'] = getSkillByID($skill);
        $_SESSION['skills'] = array($skill);
    }
}

if (isset($_POST['txt_search']) && $_POST['txt_search'] != null) {
    $_SESSION['search_text'] = $_POST['txt_search'];
    $_SESSION['skills'] = array();
} else {
    if (isset($_POST['sb_offshore'])) {
        if ($_SESSION['show_offshore'] === true) {
            $_SESSION['show_offshore'] = false;
        } else {
            $_SESSION['show_offshore'] = true;
        }
    }
    if (isset($_POST['sb_onshore'])) {
        if ($_SESSION['show_onshore'] === true) {
            $_SESSION['show_onshore'] = false;
        } else {
            $_SESSION['show_onshore'] = true;
        }
    }

    if (isset($_POST['sb_division'])) {
        if ($_SESSION['show_division'] === true) {
            $_SESSION['show_division'] = false;
        } else {
            $_SESSION['show_division'] = true;
        }
    }
    if (isset($_POST['sb_role'])) {
        if ($_SESSION['show_role'] === true) {
            $_SESSION['show_role'] = false;
        } else {
            $_SESSION['show_role'] = true;
        }
    }

    if (isset($_POST['sb_action'])) {
        if ($_SESSION['show_action'] === true) {
            $_SESSION['show_action'] = false;
        } else {
            $_SESSION['show_action'] = true;
        }
    }
}
if (isset($_POST['s_skill']) && $_POST['s_skill'] != "View skill") {
    $_SESSION['skills'][] = '' . $_POST['s_skill'];
}

/**
 * searches employees based on search_text
 */
if ($_SESSION['search_text'] === "*") {
    $search_result = getAllEmployees();
} else {
    $search_result = search($_SESSION['search_text']);
}

/**
 * Removes skill tab from the table
 */
foreach ($_SESSION['skills'] as $skill) {
    if (isset($_POST[$skill . '_skill_delete'])) {
        unset($_SESSION['skills'][$skill]);
        $_SESSION['skills'] = array_remove_by_value($_SESSION['skills'], $skill);
        break;
    }
}

function array_remove_by_value($array, $value) {
    return array_values(array_diff($array, array($value)));
}

if (isset($_POST['btn_report'])) {
    createReport();
}


while ($row = mysqli_fetch_array($search_result)) {
    if (isset($_POST[$row['EMP_ID'] . '_act_delete'])) {
        deleteEmpByID($row['EMP_ID']);
    } else if (isset($_POST[$row['EMP_ID'] . '_act_update'])) {
        //header("Location: new_resource.php");
    }
}
if ($_SESSION['search_text'] === "*") {
    $search_result = getAllEmployees();
} else {
    $search_result = search($_SESSION['search_text']);
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
        <div class="container">
            <div class="row">
                <div>
                    <h2>DashBoard</h2>
                    <form method="POST">
                        <input type="text" class="form-control" name="txt_search" placeholder="<?php echo $_SESSION['search_text']; ?>"><br></br>                   
                        <div style="overflow:auto; height: 440px">
                            <table class="table table-hover">
                                <thead>
                                    <tr style="max-height: 1px">
                                        <th>#</th>
                                        <th>Resource</th>
                                        <?php if ($_SESSION['show_division'] === true) { ?>
                                            <th>Division</th>
                                        <?php } if ($_SESSION['show_role'] === true) { ?>
                                            <th>Role</th>
                                        <?php } if ($_SESSION['show_action'] === true) { ?>
                                            <th></th>
                                            <th></th>
                                        <?php } foreach ($_SESSION['skills'] as $skill) { ?>
                                            <th>
                                    <div style="height: 30pt">
                                        <form method="POST">
                                            <button onclick="this.form.submit()" name="<?php echo $skill . '_skill_link' ?>" type="submit" class="btn btn-link"> <?php echo getSkillByID($skill) ?></button> 
                                            <button onclick="this.form.submit()" name="<?php echo $skill . '_skill_delete' ?>"  type="submit" class="close" aria-label="Close">
                                                <span  aria-hidden="true" >&times;</span>
                                            </button></form>
                                    </div>
                                    </th>
                                <?php } ?>
                                <th>
                                </th>

                                </tr>
                                </thead>
                                <?php
                                $counter = 0;
                                while ($row = mysqli_fetch_array($search_result)):
                                    $counter++;
                                    ?>
                                    <tr style="background-color:  <?php
                                    if ($row['SHORE'] === "Onshore") {
                                        echo '#f1f1f1';
                                    } else {
                                        echo 'white';
                                    }
                                    ?>">
                                        <td><?php echo $counter ?></td>
                                        <td ><button  type="button" class="btn btn-link"><?php echo $row['NAMES']; ?> </button></td>
                                        <?php if ($_SESSION['show_division'] === true) { ?>
                                            <td><button  type="button" class="btn btn-link"><?php echo $row['DIV_DESCRIPTION']; ?> </button></td>

                                            <?php
                                        }
                                        if ($_SESSION['show_role'] === true) {
                                            ?>
                                            <td><button  type="button" class="btn btn-link"><?php echo $row['ROLE_DESCRIPTION']; ?> </button></td>
                                        <?php } if ($_SESSION['show_action']) { ?>
                                            <td><button class="btn btn-primary" name="<?php echo $row['EMP_ID'] . '_act_update' ?>">Update</button></td>
                                            <td><button class="btn btn-danger" name="<?php echo $row['EMP_ID'] . '_act_delete' ?>">Delete</button></td>
                                            <?php ?>
                                        <?php } foreach ($_SESSION['skills'] as $skill) { ?>
                                            <td><?php echo getEmployeeSkillLevel($row['EMP_ID'], $skill) ?> </td>
                                        <?php }
                                        ?>

                                    </tr>
                                <?php endwhile; ?>
                            </table>
                        </div>
                        <div style="position: absolute; right: 100px; top: 370px">
                            <div class="color_card" style=""><button style="color: <?php
                                if ($_SESSION['show_onshore'] === false) {
                                    echo 'grey';
                                }
                                ?>" onclick="this.form.submit()" name="sb_onshore" type="submit" class="btn btn-link">Onshore</button> </div>
                            <div class="color_card" style="color: grey;background-color: white"><button style="color: <?php
                                if ($_SESSION['show_offshore'] === false) {
                                    echo 'grey';
                                }
                                ?>" onclick="this.form.submit()" name="sb_offshore" type="submit" class="btn btn-link">Offshore</button> </div>
                        </div>
                        <div id="tabs" style="display: flex;">
                            <div class="color_card" ><button style="color: <?php
                                if ($_SESSION['show_action'] === false) {
                                    echo 'grey';
                                }
                                ?>" onclick="this.form.submit()" name="sb_action" type="submit" class="btn btn-link">Action</button>
                            </div>
                            <div class="color_card" ><button style="color: <?php
                                if ($_SESSION['show_division'] === false) {
                                    echo 'grey';
                                }
                                ?>" onclick="this.form.submit()" name="sb_division" type="submit" class="btn btn-link">Division</button>
                            </div>
                            <div class="color_card" style="color: grey;"><button style="color: <?php
                                if ($_SESSION['show_role'] === false) {
                                    echo 'grey';
                                }
                                ?>" onclick="this.form.submit()" name="sb_role" type="submit" class="btn btn-link">Role</button> 
                            </div>

                            <div class="color_card" style="width: 120px"> 
                                <form method="POST">
                                    <select class="form-control" onchange="this.form.submit();" name="s_skill" style="border: none; margin: 0 auto">
                                        <?php $result = getSkillsAssociated($_SESSION['search_text']); ?>
                                        <option style="color: grey;">View skill</option>
                                        <?php while ($row = mysqli_fetch_array($result)) {
                                            ?>
                                            <option class="form-control form-control-sm" value="<?php echo $row['SKILL_ID'] ?>"> 
                                                <?php echo getSkillByID($row['SKILL_ID']) ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </form>
                            </div>

                        </div>
                        <p style="padding: 0"> <form method="POST"><button onclick="this.form.submit()" name="btn_report" style="float: right;" type="submit" class="btn btn-block btn-primary">Download Report</button></form><p>
                    </form>
                </div>
            </div>
        </div>

        <div class="jumbotron text-center" style="margin-bottom:0">
            <p>@zensar.com</p>
        </div>
    </body>
</html>




<style>
    body {
        background-color: #f1f1f1;
    }
    .color_card {
        color: #fff;
        font-family: 'Helvetica', 'Arial', sans-serif;
        font-size: 10pt;
        font-weight: bold;
        text-align: center;
        width: 80px;
        border-radius: 5px;
        border-style: solid;
        border-width: 1px;
        border-color: grey;
        margin: 5pt;
    }
    #tabs{
        width: 40%;
        margin: 0 auto;
    }
</style>


