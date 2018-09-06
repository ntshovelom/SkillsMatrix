<?php
include './main_navigation.html';
include './DBManager.php';
?>
<!DOCTYPE html>
<html>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    
    <?php
    $queryRoles = "SELECT ROLE_DESCRIPTION FROM roles";
    $allRoles = executeSQLQuery($queryRoles);
    $querySkills = "SELECT SKILL_DESCRIPTION FROM skills";
    $allSkills = executeSQLQuery($querySkills);

    if (isset($_POST['btn_save'])) {
        echo '<script>alert("ghjgj")</script>';
    }

    function funkx() {
        // 
        header("Location: dashboard.php");
    }
    ?>
    <body>
        <div class="container">
            <form method="POST">
                <h1>Register New Employee</h1>
                <hr>
                <label for="email"><b>Employee Name</b></label>
                <input type="text" placeholder="Enter Name" name="name" required="">

                <label for="psw"><b>Shore :</b></label>
                <p><select class="form-control" id="shore"><option>OnShore</option>
                        <option>OffShore</option></select></p>

                <label for="psw-repeat"><b>Employee Role :</b></label>
                <p><select  class="form-control" name="empRole">
                        <?php
                        while ($row = $allRoles->fetch_assoc()) :
                            echo "<option>" . $row['ROLE_DESCRIPTION'] . "</option>";
                        endwhile;
                        ?>
                    </select></p>
                <hr>
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
                                                <?php
                                                while ($row = mysqli_fetch_array($allSkills)) {
                                                    echo '<option value="' . $row['skill_id'] . '">' . $row['SKILL_DESCRIPTION'] . '</option>';
                                                }
                                                ?>
                                            </select></p>
                                        <p><select class="form-control" name="level">
                                                <option>Entry Level</option>
                                                <option>Intermediate</option>
                                                <option>Advanced</option>
                                                <option>Certified</option>
                                            </select></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" onclick="this.form.submit()" id="btnSave" class="btn btn-default" data-dismiss="modal" name="btn_save">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
        </div>
    </form>
</div>
</body>
</html>


<script>
    function abc() {
        var skill = document.getElementById("skill").value;
        alert("hello");
<?php funkx(); ?>
    }
</script>



















































































































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