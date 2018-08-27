<?php
if (isset($_POST['valueToSearch'])) {
    $valueToSearch = $_POST['valueToSearch'];
    $query = "SELECT  e.NAMES, e.SHORE, s.SKILL_DESCRIPTION, sl.LEVEL_DESCR
            FROM employees e, b_employee_skills es, skills s, m_skills_level sl
            WHERE  e.EMP_ID = es.EMPLOYEE_ID
            AND es.SKILL_ID = s.SKILL_ID
            AND es.LEVEL_ID = sl.LEVEL_ID
            AND CONCAT (e.NAMES, s.SKILL_DESCRIPTION,sl.LEVEL_DESCR) 
            LIKE '%" . $valueToSearch . "%'";
    
    $search_result = filterTable($query);
} else {
    $query = "SELECT  e.NAMES, e.SHORE, SKILL_DESCRIPTION, sl.LEVEL_DESCR
                FROM employees e, b_employee_skills es, skills s, m_skills_level sl
                WHERE e.EMP_ID = es.EMPLOYEE_ID
                AND es.LEVEL_ID = sl.LEVEL_ID
                AND es.SKILL_ID = s.SKILL_ID";
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
                            <table class="table table-bordered">
                             
                                <thead>
                                    <tr>
                                        <th>First Name</th>
                                        <th>Shore</th>
                                        <th>Skill Description</th>
                                        <th>LEVEL Description</th>
                                    </tr>
                                </thead>
                                <?php while($row = mysqli_fetch_array($search_result)):?>
                                    <tr>
                                        <td><?php echo $row['NAMES'];?></td>
                                        <td><?php echo $row['SHORE']; ?></td>
                                        <td><?php echo $row['SKILL_DESCRIPTION']; ?></td>
                                        <td><?php echo $row['LEVEL_DESCR']; ?></td>
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
