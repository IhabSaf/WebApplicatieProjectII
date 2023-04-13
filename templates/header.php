<!DOCTYPE html>
<html>
<head>
    <title>My Website</title>
    <style>
        /* Set background color of body to white and font color to black */
        body {
            background-color: #FFFFFF;
            color: #000000;
        }
        /* Style the navigation bar */
        nav {
            background-color: #000000;
            color: #FFFFFF;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
        }
        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
        }
        nav li {
            margin: 0 10px;
            font-size: 20px; /* Make the font size bigger for the navigation links */
        }
        nav a {
            color: #FFFFFF;
            text-decoration: none;
            display: block;
            padding: 10px;
        }
        .inlog, .uitlog {
            font-size: 20px; /* Make the font size bigger for the "Inlog" and "Uitlog" buttons */
            margin: 0 10px;
        }
        .right {
            margin-left: auto; /* Align the "Inlog" and "Uitlog" buttons to the right */
        }
    </style>
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
            echo '<li><a href="ShowStudentData">View Grades</a></li>';
        }

        if(\FrameWork\security\CurrentUser::isAdmin() || \FrameWork\security\CurrentUser::isDocent()) {
            echo '<li><a href="CijferToevoegen">Add Grades</a></li>';
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
