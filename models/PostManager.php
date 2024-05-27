<?php
include_once "PDO.php";

function GetOnePostFromId($id)
{
  global $PDO;
  $stmt = $PDO->prepare("SELECT * FROM post WHERE id = :id");
  $stmt->bindParam(':id', $id);
  $stmt->execute();
  return $stmt->fetch();
}

function GetAllPosts()
{
  global $PDO;
  $stmt = $PDO->prepare("SELECT post.*, user.nickname FROM post LEFT JOIN user on (post.user_id = user.id) ORDER BY post.created_at DESC");
  $stmt->execute();
  return $stmt->fetchAll();
}


function GetAllPostsFromUserId($userId)
{
  global $PDO;
  $stmt = $PDO->prepare("SELECT * FROM post WHERE user_id = :userId ORDER BY created_at DESC");
  $stmt->bindParam(':userId', $userId);
  $stmt->execute();
  return $stmt->fetchAll();
}

function SearchInPosts($search)
{
  global $PDO;
  $stmt = $PDO->prepare("SELECT post.*, user.nickname FROM post LEFT JOIN user on (post.user_id = user.id) WHERE content like :search ORDER BY post.created_at DESC");
  $searchParam = "%$search%";
  $stmt->bindParam(':search', $searchParam);
  $stmt->execute();
  return $stmt->fetchAll();
}

function CreateNewPost($userId, $msg)
{
  global $PDO;
  $response = $PDO->prepare("INSERT INTO post(user_id, content) values (:userId, :msg)");
  $response->execute(
    array(
      "userId" => $userId,
      "msg" => $msg
    )
  );
}