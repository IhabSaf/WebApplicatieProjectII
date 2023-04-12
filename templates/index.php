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
      align-items: center;
    }

    nav {
      display: flex;
      justify-content: space-between;
      align-items: center;
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
{% block navbar %}
<header>
  <h1>Student Portal</h1>
  <nav>
    <ul>
      <li><a href="#">Home</a></li>
      <li><a href="adduser.html">Add User</a></li>
      <li><a href="register_exam.html">Register for Exam</a></li>
      <li><a href="view_grades.html">View Grades</a></li>
      <li><a href="add_grades.html">Add Grades</a></li>
    </ul>
    <a href="#">Logout</a>
  </nav>
</header>
{% endblock %}

<main>
  {% block content %}
  <h2>Welcome, student!</h2>
  <p>This is the student portal, where you can manage your account, register for exams, view your grades, and more.</p>
  {% endblock %}
</main>

<footer>
  {% block footer %}
  <p>&copy; 2023 Student Portal</p>
  {% endblock %}
</footer>
</body>
</html>
