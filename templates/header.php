<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Portal</title>
    <style>
        /* common styles */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        header {
            background-color: #333;
            color: white;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start; /* changed from center to flex-start */
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: flex-start; /* changed from center to flex-start */
        }

        nav ul {
            margin: 0;
            padding: 0;
            display: flex;
            list-style-type: none;
        }

        nav li {
            margin-right: 10px;
        }

        nav a {
            color: white;
            text-decoration: none;
            padding: 5px;
        }

        footer {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
<header>
    <h1>Student Portal</h1>
    <nav>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="adduser.html">Add User</a></li>
            <li><a href="register_exam">Register for Exam</a></li>
            <li><a href="view_grades.html">View Grades</a></li>
            <li><a href="add_grades">Add Grades</a></li>
        </ul>
        <a href="logout">Logout</a>
    </nav>
</header>
<main>
