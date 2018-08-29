<?php
include './main_navigation.html';
?>

<html>
    <head>
        <title>
            New Resource
        </title>
    </head>
    <body>
        <div class="container col-lg-5">
            <form>

                <div class="form-group">
                    <label for="usr">Names:</label>
                    <input type="text" class="form-control" id="usr" placeholder="Please Enter Employee Full Names">
                </div>
                <div class="form-group">
                    <label for="pwd">Password:</label>
                    <input type="password" class="form-control" id="pwd">
                </div>
                <div class="form-group">
                    <label for="pwd">Skills:</label>
                    <select multiple class="form-control">
                        <option>Java</option>
                        <option>HTML</option>
                        <option>PHP</option>
                        <option>MySQL</option>
                        <option>Javascript</option>
                    </select>
                </div>

            </form>

        </div>
    </body>
</html>