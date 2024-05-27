<?php

$action = $_GET["action"] ?? "display";

switch ($action) {

  case 'register':
    if (isset($_SESSION['userId'])) {
      unset($_SESSION['userId']);
    }
    header('Location: ?action=display');
    break;

  case 'logout':
    // code...
    break;

  case 'login':
    // code...
    break;

  case 'newMsg':
    // code...
    break;

  case 'newComment':
    // code...
    break;

    case 'display':
      default:
          include "../models/PostManager.php";
          if (isset($_GET['search'])) {
            $posts = SearchInPosts($_GET['search']);
          } else {
            $posts = GetAllPosts();
          }
          
          include "../models/CommentManager.php";

    // ===================HARDCODED PART===========================
    // format idPost => array of comments
    foreach ($posts as $post) {
      $postId = $post['id'];
      $comments[$postId] = GetAllCommentsFromPostId($postId);
  }
    // =============================================================

    include "../views/DisplayPosts.php";
    break;
}
