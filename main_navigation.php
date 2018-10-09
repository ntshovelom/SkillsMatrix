<!DOCTYPE html>
<?php
session_start();
if (isset($_SESSION['user'])) {
    
} else {
    header("Location: login.php");
}
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <nav class="navbar navbar-inverse ">
        <div class="container-fluid bg-light navbar-light">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>                        
                </button>
                <a class="navbar-brand" href="dashboard.php">Skills Matrix</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <!--                    <li class="active"><a href="dashboard.php">Home</a></li>-->
                    <li><a href="new_resource_1.php">New Resource</a></li>
                    <li><a href="new_role.php">New Role</a></li>
                    <li><a href="new_skill.php">New Skill</a></li>
                    <li><a href="adding_employees.php">SIYA FILE</a></li>
                </ul>
            </div>
        </div>
    </nav>
</html>


