<script>
    var skill_list = [];
    var level_list = [];
</script>

<?php
include './main_navigation.php';
include './DBManager.php';
$abc = "HELLO WORLD";
?>
<!DOCTYPE html>
<html>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <?php
    $error = '';
    if (isset($_POST['btn_finish'])) {
        if (sizeof($_SESSION['add_skills']) > 0) {
            addResource($_POST['name'], $_POST['shore'], $_POST['empRole'], $_POST['skill'], $_POST['level']);
        } else {
            $error = '<div class="alert alert-danger">'
                    . '<strong>Please include some of the skills of the resource</strong>'
                    . '</div>';
        }
    }
    $allRoles = getRoles();
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
    } else if ($_SESSION['update_id'] != '-1') {
        $name = getEmpNameByID($_SESSION['update_id']);
        $shore = getEmpShoreByID($_SESSION['update_id']);
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

    $skills_for_js = getSkillsAssociated("*");
    $skills_options_html = array();
    $x = 0;
    while ($row = mysqli_fetch_array($skills_for_js)) {
        $option = $row['SKILL_DESCRIPTION'];
        $ID = $row['SKILL_ID'];
        echo '<script> skill_list[' . $x . '] = "<option value=\"' . $ID . '\">' . $option . '</option>";</script>';
        $x++;
    }
    $x = 0;
    $levels_for_js = getLevels();
    while ($row = mysqli_fetch_array($levels_for_js)) {
        $option = $row['LEVEL_DESCR'];
        echo '<script> level_list[' . $x . '] = "<option>' . $option . '</option>";</script>';
        $x++;
    }
    ?>
    <body>
        <div class="container">
            <form method="POST">
                <h1>New Resource</h1>
                <?php echo $error; ?>
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
                    <span class="input-group-addon">Role</span>
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
                    <br/>
                    <br/>
                    <!--                    <button type="button" class="btn-default btn-lg" data-toggle="modal" data-target="#myModal">Add Skill</button>-->
                    <!-- SIYA CODE ====================================================================================-->
                    <div >
                        <div class="table-title">
                            <div class="row">
                                <div class="col-sm-8"><h2>Skills</h2></div>
                                <div class="col-sm-4">
                                    <button type="button" class="btn btn-primary add-new"><i class="fa fa-plus"></i> Add Skill</button>
                                </div>
                            </div>
                        </div>
                        <div style="width: 1140px; height: 400px; overflow: auto">
                            <table  class="table table-active">
                                <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th>Level</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <a class="add" title="Add" id="adding" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
                                            <!--<a class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>-->
                                            <a class="delete " title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- SIYA CODE ====================================================================================-->
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











<script type="text/javascript">
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
        var actions = $("table td:last-child").html();

        // Append table with add row form on add new button click
        $(".add-new").click(function () {
            $(this).attr("disabled", "disabled");
            var index = $("table tbody tr:last-child").index();
//            var row = '<tr>' +
//                    '<td><input type="text" class="form-control" name="staff_Id" id="Staff_ID"></td>' +
//                    '<td><input type="text" class="form-control" name="name" id="Emp_Name"></td>' +
//                    '<td><input type="text" class="form-control" name="surname" id="Emp_Surname"></td>' +
//                    '<td><input type="text" class="form-control" name="idnum" id="Emp_IDNo"></td>' +
//                    '<td>' + actions + '</td>' +
//                    '</tr>';

            var row = '<tr>'
                    + '<td> '
                    + '<select class="form-control"> '
            var x = 0;
            while (x < skill_list.length) {
                row += skill_list[x];
                x++;
            }
            row += '</select>'
                    + ' </td> '
                    + '<td> '
                    + '<select class="form-control"> ';

            x = 0;
            while (x < level_list.length) {
                row += level_list[x];
                x++;
            }


            row += '</select>'
                    + ' </td> '
                    + '<td>' + actions + '</td>'
                    + ' </tr>';
            $("table").append(row);
            $("table tbody tr").eq(index + 1).find(".add, .edit").toggle();
            $('[data-toggle="tooltip"]').tooltip();
        });
        // Add row on add button click
        $(document).on("click", ".add", function () {
            var empty = false;
            var input = $(this).parents("tr").find('input[type="text"]');
            input.each(function () {
                if (!$(this).val()) {
                    $(this).addClass("error");
                    empty = true;
                } else {
                    $(this).removeClass("error");
                }
            });
            $(this).parents("tr").find(".error").first().focus();
            if (!empty) {
                input.each(function () {
                    $(this).parent("td").html($(this).val());
                });
                $(this).parents("tr").find(".add, .edit").toggle();
                $(".add-new").removeAttr("disabled");
            }
        });
        // Edit row on edit button click
        $(document).on("click", ".edit", function () {
            $(this).parents("tr").find("td:not(:last-child)").each(function () {
                $(this).html('<input type="text" class="form-control" value="' + $(this).text() + '">');
            });
            $(this).parents("tr").find(".add, .edit").toggle();
            $(".add-new").attr("disabled", "disabled");
        });
        // Delete row on delete button click
        $(document).on("click", ".delete", function () {
            $(this).parents("tr").remove();
            $(".add-new").removeAttr("disabled");
        });
    });
</script>





<style type="text/css">


    body {
        color: #404E67;
        background: #F5F7FA;
        font-family: 'Open Sans', sans-serif;
    }

    .table-wrapper {
        width: 700px;
        margin: 30px auto;
        background: #fff;
        padding: 20px;	
        box-shadow: 0 1px 1px rgba(0,0,0,.05);
    }

    .table-title {
        padding-bottom: 10px;
        margin: 0 0 10px;
    }

    .table-title h2 {
        margin: 6px 0 0;
        font-size: 22px;
    }

    .table-title .add-new {
        float: right;
        height: 30px;
        font-weight: bold;
        font-size: 12px;
        text-shadow: none;
        min-width: 100px;
        border-radius: 50px;
        line-height: 13px;
    }

    .table-title .add-new i {
        margin-right: 4px;
    }

    table.table {
        table-layout: fixed;
    }

    table.table tr th, table.table tr td {
        border-color: #e9e9e9;
    }

    table.table th i {
        font-size: 13px;
        margin: 0 5px;
        cursor: pointer;
    }

    table.table th:last-child {
        width: 100px;
    }

    table.table td a {
        cursor: pointer;
        display: inline-block;
        margin: 0 5px;
        min-width: 24px;
    }  

    table.table td a.add {
        color: #27C46B;
    }

    table.table td a.edit {
        color: #FFC107;
    }

    table.table td a.delete {
        color: #E34724;
        position: right;
    }

    table.table td i {
        font-size: 19px;
    }

    table.table td a.add i {
        font-size: 24px;
        margin-right: -1px;
        position: relative;
        top: 3px;
    }    

    table.table .form-control {
        height: 32px;
        line-height: 32px;
        box-shadow: none;
        text-align: right;
        border-radius: 2px;
    }

    table.table .form-control.error {
        border-color: #f50000;
    }

    table.table td .add {
        display: none;
    }

    #button{

        text-align: center
    }


</style>
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



