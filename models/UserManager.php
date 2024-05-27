<?php
include_once "PDO.php";

function GetOneUserFromId($id)
{
  global $PDO;
  $stmt = $PDO->prepare("SELECT * FROM user WHERE id = :id");
  $stmt->bindParam(':id', $id);
  $stmt->execute();
  return $stmt->fetch();
}

function GetAllUsers()
{
  global $PDO;
  $stmt = $PDO->prepare("SELECT * FROM user ORDER BY nickname ASC");
  $stmt->execute();
  return $stmt->fetchAll();
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

function IsNicknameFree($nickname)
{
  global $PDO;
  $response = $PDO->prepare("SELECT * FROM user WHERE nickname = :nickname ");
  $response->execute(
    array(
      "nickname" => $nickname
    )
  );
  return $response->rowCount() == 0;
}

function CreateNewUser($nickname, $password)
{
  global $PDO;
  $response = $PDO->prepare("INSERT INTO user (nickname, password) values (:nickname , :password )");
  $response->execute(
    array(
      "nickname" => $nickname,
      "password" => $password
    )
  );
  return $PDO->lastInsertId();
}
