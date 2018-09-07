<?php
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
    <body>
        <div class="container">
            <form method="POST">
                <h1>Login</h1>
                <div class="input-group">
                    <span class="input-group-addon">Email</span>
                    <input id="msg" type="text" class="form-control" name="txt_email" placeholder="John.Smith@gmail.com" required>
                </div>
                </p>
                <div class="input-group">
                    <span class="input-group-addon">Password</span>
                    <input id="msg" type="password" class="form-control" name="pwd" placeholder="Password" required>
                </div>
                <br></br>
                <button type="submit" onclick="this.form.submit();" class="btn btn-primary btn-block" name="AddSkill">Login</button>
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











