<?php

namespace src\Controller;

use FrameWork\database\DatabaseConnection;
use FrameWork\HTTP\Request;
use PDO;
use src\Model\User;

class LoginController
{


    public function loginUser(Request $request){


        $email = $request->getPost('email');
        $password = $request->getPost('password');

        $getUserCred = $this->findUser($email, 'user');


        if (!$getUserCred || !password_verify($password, $getUserCred->getPassword())) {

        } else {
            // Als de inloggegevens geldig zijn dan begin een session
            session_start();
            $_SESSION['user_id'] = $getUserCred->getId();
            header('Location: /home');
        }

    }


    public function logout(){
        session_start();
        session_unset();
        session_destroy();
    }

    public function findUser(string $email, string $tabel): User
    {
        $conn = new DatabaseConnection();
        $pdo = $conn->getConnector();
        $sql = "SELECT * FROM $tabel WHERE email = :email";
        $queryEX = $pdo->prepare($sql);
        $queryEX->execute([':email' => $email]);
        $result = $queryEX->fetch(PDO::FETCH_ASSOC);

        return $result;

    }}