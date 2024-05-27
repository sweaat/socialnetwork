<?php
include_once "PDO.php";

function GetOneUserFromId($id)
{
  global $PDO;
  $response = $PDO->query("SELECT * FROM user WHERE id = $id");
  return $response->fetch();
}

function GetAllUsers()
{
  global $PDO;
  $response = $PDO->query("SELECT * FROM user ORDER BY nickname ASC");
  return $response->fetchAll();
}


function GetUserIdFromUserAndPassword($username, $password) {
    global $PDO;

    // Préparer la requête SQL pour sélectionner l'utilisateur par nom d'utilisateur
    $stmt = $PDO->prepare("SELECT id, password FROM user WHERE nickname = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    // Récupérer le résultat de la requête
    $user = $stmt->fetch();

    // Vérifier si l'utilisateur existe et si le mot de passe est correct
    if ($user && password_verify($password, $user['password'])) {
        return $user['id'];  // Retourner l'id de l'utilisateur
    } else {
        return -1;  // Retourner -1 si l'utilisateur n'existe pas ou si le mot de passe est incorrect
    }
}

