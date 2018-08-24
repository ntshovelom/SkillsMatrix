<?php
if (isset($_POST['valueToSearch'])) {
    $valueToSearch = $_POST['valueToSearch'];
    $query = "SELECT e.NAMES, e.SHORE, SKILL_DESCRIPTION 
                FROM employees e, b_employee_skills es, skills s
                WHERE e.EMP_ID = es.EMPLOYEE_ID
                AND es.SKILL_ID = s.SKILL_ID";
    
    $search_result = filterTable($query);
} else {
    $query = "SELECT * FROM `employees`";
    $search_result = filterTable($query);
}

function filterTable($query) {
    $connect = mysqli_connect("localhost", "root", "", "matrix");
    $filter_Result = mysqli_query($connect, $query);
    return $filter_Result;
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
                <div class="col-sm-8">
                    <h2>DashBoard</h2>
                    <form action="index.php" method="POST">
                        <input type="text" class="form-control" name="valueToSearch" placeholder="Enter Employee Name"><br></br>                   
                        <div style="overflow-x:auto;">
                            <table>
                                <tr>
                                    <th>First Name</th>
                                    <th>Role</th>
                                    <th>Skill 1</th>
                                    <th>Skill 2</th>
                                    <th>Skill 3</th>
                                </tr>
                                <?php while ($row = $search_result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $row['NAMES']; ?></td>
                                        <td><?php echo $row['SHORE']; ?></td>
                                        <td><?php echo $row['SKILL_DESCRIPTION']; ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </table>
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
