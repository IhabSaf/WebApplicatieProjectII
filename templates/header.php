<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="/templates/css/header.css">
</head>
<body>
<nav>
    <ul>
        <li><a href="/home">Home</a></li>
        <?php
        if($request->getSessionValueByName('user_role') === 'admin') {
            echo '<li><a href="/registration">AddUser</a></li>';
        }

        if($request->getSessionValueByName('user_role') === 'admin' || $request->getSessionValueByName('user_role') === 'student') {
            echo '<li><a href="/registerExam">Register for Exam</a></li>';
        }

        if(in_array($request->getSessionValueByName('user_role'), ['admin', 'docent', 'student'])) {
            echo '<li><a href="/showStudentData">View Grades</a></li>';
        }

        if($request->getSessionValueByName('user_role') === 'admin' || $request->getSessionValueByName('user_role') === 'docent') {
            echo '<li><a href="/addGradeInfo">Add Grades</a></li>';
        }

        ?>

    </ul>
    <div class="right">
        <?php
        if(in_array($request->getSessionValueByName('user_role'), ['admin', 'docent', 'student'])) {
            echo '<a href="/logout" class="uitlog">Logout</a>';
            echo '<a href="" class="inlog">' .'Welkom: '. $request->getSessionValueByName('user_name'). '</a>';

        } else {
            echo '<a href="/login" class="inlog">Log In</a>';
        }
        ?>
    </div>
</nav>
</body>
</html>
