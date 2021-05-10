<?php

require_once "Post.php";
require_once "DatabaseManager.php";
/**
 *
 */
class blogManager
{

private $databaseManager;

function __construct() {
    $this->databaseManager = new DatabaseManager();
}

  /**
  *@return array
  * file che ristituisce l`array dei posts
  */
  public function getPost(): array
  {
    $posts = $this->loadPosts();
    return array_reverse($posts);

  }



  /**
  *@return Post
  * file che legge i posts su loadPost(),e fa l update su updatePost()
  */
  public function addPost($title, $content, user $user = null): Post
  {
    // istanzia un nuovo oggetto post

    $posts = $this->getPost();

    $creationDate = (new DateTime('now'))->format('Y-m-d H:i:s');
    $post = new Post(
      $title,
      $content,
      new DateTime('now')
      );

    // se avevessi avuto un og user avrei fatto, $post->setAuthorUsername($user->getUsername)
    if($user !== null) {
      $post->setAuthorUsername($user->getUsername());
    }
    $postTitle = $post->getTitle();
    $postContent = $post->getContent();
    $userId = $user->getId();

    // insert into database del post - query
    $query = "INSERT INTO post (title, content, publication_date, users_id)
    VALUES ('$postTitle', '$postContent', '$creationDate', $userId)";

    $executionQuery = $this->databaseManager->executeQuery($query);
    return $post;
  }




  /**
  *@return array
  *@throws Exception
  * estrapola i posts dal file posts.json e ritorna dei posts in un array di oggetti(decodificati in arrays)
  */
  public function loadPosts():array
  {
    // $postPathAbsolute = $this->getPostsPathAbsolute();
    //
    // if(!file_exists($postPathAbsolute)){
    //   return [];
    // }
    //
    // $content = file_get_contents($postPathAbsolute);

    // if($posts === null) {
    //   echo "Impossibile caricare i posts ", json_last_error_msg();
    // }


    $query = "SELECT * FROM post";

    try {
      $statement = $connection->query($query);
    } catch (\Exception $e) {
      print "Error!: " . $e->getMessage() . "<br/>";
      die();
    }

    $posts = $statement->fetchAll();


      // if(array_key_exists("author_username",$post)) {
      //   $postsObjects->setAuthorUsername($post["author_username"]);
      // }
      //
      // $posts[$key] = $postsObjects;
      return $postsObjects;
    }



  private function buildPostbySelectedResults(array $records) {

    $posts = [];
    // costruisce un array di oggetti post
    foreach ($records as $key => $post) {
      $creationDate = DateTime::createFromFormat("Y-m-d H:i:s", $post["publication_date"]);
      $posts[] = new Post(
        $post["title"],
        $post["content"],
        $creationDate
      );
    }


      return $posts;
  }


  /**
  *@return void
  * carica sul nostro database il nuovo users [],(users di array di istanze user) su file json
  */
  private function updatePosts(array $posts) {

    $postPathAbsolute = $this->getPostsPathAbsolute();

    $output = [];

    foreach ($posts as $post) {
      $output[] = [
        "title" => $post->getTitle(),
        "content" => $post->getContent(),
        "author_username" => $post->getAuthorUsername(),
        "creation_date" => $post->getCreationDate()->format("Y-m-d H:i:s")
      ];

    }
    // convertiamo users in array, da un array di oggetti
    file_put_contents($postPathAbsolute, json_encode($output));
  }



  public function getPostsByAuthor(string $username) {

    $query = "SELECT Id FROM people WHERE username = '$username'";
    // var_dump($query);die;

    $idsArray = $this->databaseManager->executeQuery($query);

    if(count($idsArray) > 0) {
      $userId = $ids[0]['Id'];
    } else {
      // se l utente non ha scritto post ritorniamo un array vuoto
      return [];
    }

    $queryPosts = "SELECT * FROM post WHERE users_id = $userId ORDER BY publication_date DESC";

    $postsArray = $this->databaseManager->executeQuery($queryPosts);

  }




    /*prende la path assoluta del posts.json*/
    public function getPostsPathAbsolute() {
      $root = $_SERVER["DOCUMENT_ROOT"];
      $postPath = sprintf('%s/websiteExPhp/posts.json',$root);

      return $postPath;
    }
}
