<?php
include './DBManager.php';
$faild = "";
if (isset($_POST['btn_login'])) {
    $user = $_POST['txt_user'];
    $pass = $_POST['pwd'];

    $query1 = "SELECT * FROM users WHERE username = '$user' AND PASS = '$pass'";
    $result = executeSQLQuery($query1);
    $data = mysqli_fetch_array($result, MYSQLI_NUM);
    if ($result->num_rows < 1) {
        $faild = '<div class="alert alert-danger">'
                . '<strong>Wrong Username or Password!</strong>'
                . '</div>';
    } else {
        session_start();

        $_SESSION['user'] = $user;
        $_SESSION['pass'] = $pass;

        $_SESSION['search_text'] = 'MS Word';
        $_SESSION['search'] = false;
        $_SESSION['reporting'] = false;
        $_SESSION['show_offshore'] = true;
        $_SESSION['show_onshore'] = true;
        $_SESSION['show_role'] = false;
        $_SESSION['show_division'] = false;
        $_SESSION['show_action'] = true;

        $_SESSION['skills'] = array();
        $_SESSION['skills_ids'] = array();

        $_SESSION['add_skills'] = array();
        $_SESSION['add_levels'] = array();

        $_SESSION['update_id'] = '-1';

        header("Location: dashboard.php");
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
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>

        <div class="container">
            <form method="POST">
                <h1>Login</h1>
                <?php echo $faild; ?>
                <div class="input-group">
                    <span class="input-group-addon">Username</span>
                    <input id="msg" type="text" class="form-control" value="root" name="txt_user" placeholder="Please enter username" required>
                </div>
                </p>
                <div class="input-group">
                    <span class="input-group-addon">Password</span>
                    <input id="msg" type="password" class="form-control" value="S3qcsSG" name="pwd" placeholder="Password" required>
                </div>
                <br></br>
                <button type="submit" onclick="this.form.submit();" class="btn btn-primary btn-block" name="btn_login">Login</button>
                <br/>
                <p>
                    <button  type="submit" class="btn btn-link">Forgot password? click here.</button>
                </p>
        </div>
    </body>
</html>
<style>
    body {
        background-color: #f1f1f1;
        font: serif;
    }
    h1 {
        text-align: center;  
    }
</style>











