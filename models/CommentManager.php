<?php
include_once "PDO.php";

function GetOneCommentFromId($id)
{
  global $PDO;
  $stmt = $PDO->prepare("SELECT * FROM comment WHERE id = :id");
  $stmt->bindParam(':id', $id);
  $stmt->execute();
  return $stmt->fetch();
}

function GetAllComments()
{
  global $PDO;
  $stmt = $PDO->prepare("SELECT * FROM comment ORDER BY created_at ASC");
  $stmt->execute();
  return $stmt->fetchAll();
}

function GetAllCommentsFromUserId($userId)
{
  global $PDO;
  $stmt = $PDO->prepare(
    "SELECT comment.*, user.nickname "
      . "FROM comment LEFT JOIN user ON (comment.user_id = user.id) "
      . "WHERE comment.user_id = :userId "
      . "ORDER BY comment.created_at ASC"
  );
  $stmt->bindParam(':userId', $userId);
  $stmt->execute();
  return $stmt->fetchAll();
}

function GetAllCommentsFromPostId($postId)
{
  global $PDO;
  $stmt = $PDO->prepare(
    "SELECT comment.*, user.nickname "
      . "FROM comment LEFT JOIN user ON (comment.user_id = user.id) "
      . "WHERE comment.post_id = :postId "
      . "ORDER BY comment.created_at ASC"
  );
  $stmt->bindParam(':postId', $postId);
  $stmt->execute();
  return $stmt->fetchAll();
}

function CreateNewComment($userId, $postId, $comment)
{
  global $PDO;
  $stmt = $PDO->prepare("INSERT INTO comment(user_id, post_id, content) VALUES (:userId, :postId, :comment)");
  $stmt->bindParam(':userId', $userId);
  $stmt->bindParam(':postId', $postId);
  $stmt->bindParam(':comment', $comment);
  $stmt->execute();
}
