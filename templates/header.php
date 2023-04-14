<!DOCTYPE html>
<html>
<head>
    <title>My Website</title>
    <link rel="stylesheet" type="text/css" href="./templates/css/header.css">
</head>
<body>
<nav>
    <ul>
        <li><a href="home">Home</a></li>
        <?php

        if(\FrameWork\security\CurrentUser::isAdmin()) {
            echo '<li><a href="registration">AddUser</a></li>';
        }

        if(\FrameWork\security\CurrentUser::isAdmin() || \FrameWork\security\CurrentUser::isStudent()) {
            echo '<li><a href="registerExam">Register for Exam</a></li>';
        }

        if(\FrameWork\security\CurrentUser::isInloged()) {
            echo '<li><a href="showStudentData">View Grades</a></li>';
        }

        if(\FrameWork\security\CurrentUser::isAdmin() || \FrameWork\security\CurrentUser::isDocent()) {
            echo '<li><a href="addGradeInfo">Add Grades</a></li>';
        }

        ?>

    </ul>
    <div class="right">
        <?php
        if(\FrameWork\security\CurrentUser::isInloged()) {
            echo '<a href="logout" class="uitlog">Logout</a>';
            echo '<a href="" class="inlog">' .'Welkom: '. \FrameWork\security\CurrentUser::get_user_name(). '</a>';

        } else {
            echo '<a href="login" class="inlog">Log In</a>';
        }
        ?>
    </div>
</nav>
</body>
</html>
