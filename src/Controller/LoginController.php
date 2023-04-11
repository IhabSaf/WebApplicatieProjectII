<?php

namespace src\Controller;

use FrameWork\App;
use FrameWork\database\DatabaseConnection;
use FrameWork\HTTP\Request;
use PDO;
use src\Model\User;

class LoginController
{


    public function loginUser(Request $request)
    {
        $email = null;
        $password = null;
        $sesstionId= null;


        if ($request->getServer()['REQUEST_METHOD'] === 'POST') {

            $email = $request->getPostByName('username');
            $password = $request->getPostByName('password');

        $getUserCred = $this->findUser($email, 'user');

        if (!$getUserCred || !password_verify($password, $getUserCred[0]['password'])) {
            $test =  "verkeerde gegevens";
            header('Location: /login');
        } else {
            // Als de inloggegevens geldig zijn dan begin een session
            session_start();
            $_SESSION['user_id'] = $getUserCred[0]['id'];
            $_SESSION['user_rol'] = $getUserCred[0]['rol']; //moet hier nog de data van de rol tabel halen in her regesteren.
            $sesstionId = $_SESSION['user_id'];
            header('Location: /home');

        }
        }
        return [ $email, $password , $sesstionId];
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
    }

    public function findUser($email, $tabel)
    {
        $conn = new DatabaseConnection();
        $pdo = $conn->getConnector();
        $sql = "SELECT * FROM $tabel WHERE email = :email";
        $queryEX = $pdo->prepare($sql);
        $queryEX->execute([':email' => $email]);
        $results = $queryEX->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    }
}