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
  *@return array
  * file che ristituisce l`array dei posts tramite l`id
  */
  public function findPost(int $id): Post
  {
    $queryPost = "SELECT * FROM usersdb.post WHERE id = :id";

    $results = $this->databaseManager->executeQuery($queryPost,
    ['id' => $id]);

    if(count($results) < 1) {
      return null;
    }

    $firstRow = $results[0];

    return $this->buildPostbySingleResult($firstRow);
  }




  /**
  *@return Post
  * file che legge i posts su loadPost(),e fa l update su updatePost()
  */
  public function addPost($title, $content, user $user = null): Post
  {
    // istanzia un nuovo oggetto post

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
    $creationDate = (new DateTime('now'))->format('Y-m-d H:i:s');

    // insert into database del post - query
    $query = "INSERT INTO usersdb.post (title, content, publication_date, users_id)
    VALUES (:postTitle, :postContent, :creationDate, :userId)";

    $executionQuery = $this->databaseManager->executeQuery($query,
  [ 'postTitle' => $postTitle,
    'postContent' => $postContent,
    'creationDate' => $creationDate,
    'userId'=> $userId]);
    return $post;
  }




  /**
  *@return array
  *@throws Exception
  * estrapola i posts dal database e ritorna dei posts in un array di oggetti
  */
  public function loadPosts():array
  {
    $connection = $this->databaseManager->getConnection();

    $query = "SELECT * FROM usersdb.post";

    try {
      $statement = $connection->query($query);
    } catch (\Exception $e) {
      print "Error!: " . $e->getMessage() . "<br/>";
      die();
    }

    $posts = $statement->fetchAll();
    $output = [];
    foreach ($posts as $key => $post) {
      $creationDate = DateTime::createFromFormat("Y-m-d H:i:s", $post["publication_date"]);
      $output[] = new Post(
        $post["title"],
        $post["content"],
        $creationDate
      );
    }

    return $output;
}





  /**
  *@param user
  *@param post
  * elimina un post
  */
  public function deletePost(user $user,Post $post)
  {
    $userId = $user->getId();
    $postId = $post->getId();

    $queryPostId = "SELECT * FROM usersdb.post WHERE id = :postId";
    $result = $this->databaseManager->executeQuery($queryPostId,
    ['postId' => $postId]);

    if((int)$userId === (int)$result[0]["users_id"]) {
      $this->deletePostafterCondiction($postId);
    } else {
      return null;
    }

  }


  public function deletePostafterCondiction($postId):void
  {
    $query = "DELETE FROM usersdb.post WHERE id = ?";
    $deleteResult = $this->databaseManager->executeQuery($query,
    [$postId]);
  }




  /**
  *@return void
  * aggiorna il post con un nuovo post
  */
  public function updatePost(Post $post, string $title, string $content):void
  {
    $postId = $post->getId();

    $query ="UPDATE usersdb.post SET title = :title, content = :content WHERE id = :postId";

    $result = $this->databaseManager->executeQuery($query,
    [ 'title' => $title,
      'content' => $content,
      'postId' => $postId
      ]);
    }





  public function getPostsByAuthor(string $username):array
  {

    $query = "SELECT * FROM usersdb.post_and_authors WHERE username = :username ORDER BY publication_date DESC";

    $result = $this->databaseManager->executeQuery($query,
    [  'username' => $username  ] );

    return $this->buildPostbySelectedResults($result);

    // 1 option
    // $connection = $this->databaseManager->getConnection();
    //
    // $query = "SELECT * FROM usersdb.post_and_authors WHERE username = '$username' ORDER BY publication_date DESC";
    // $result = $this->databaseManager->executeQuery($query);
    //
    // $resultArray = $result->fetchAll();
    //
    // return $this->buildPostbySelectedResults($resultArray);




    // 2 option
    // $query = "SELECT id FROM people WHERE username = '$username'";

    // $result = $this->databaseManager->executeQuery($query);

    // $idsArray = $statement->fetchAll();
    //
    // if(count($idsArray) > 0) {
    //   $userId = $idsArray[0]['id'];
    // } else {
    //   // se l utente non ha scritto post ritorniamo un array vuoto
    //   return [];
    // }

    // $queryPosts = "SELECT * FROM post WHERE users_id = $userId ORDER BY publication_date DESC";

    // $result = $this->databaseManager->executeQuery($queryPosts);

    // $postArray = $postStatement->fetchAll();

    // return $this->buildPostbySelectedResults($resultArray);

  }





  /**
  *@return array
  * costruisce un array di oggetti con dei records passati
  */
    private function buildPostbySelectedResults(array $records) {
      $posts = [];
      // costruisce un array di oggetti post
      foreach ($records as $key => $result) {
        $posts[] = $this->buildPostbySingleResult($result);
      }

      return $posts;
  }




  /**
  *@return Post
  * elabora l array di posts, e restituisce un singolo post
  */
  private function buildPostbySingleResult(array $records):Post
  {
    // costruisce un array di un post
    foreach ($records as $key => $result) {
      $creationDate = DateTime::createFromFormat("Y-m-d H:i:s", $records["publication_date"]);
      $post = new Post(
        $records["title"],
        $records["content"],
        $creationDate
      );

      if(array_key_exists("id", $records)) {
        $post->setId($records["id"]);
      }

  }
  return $post;
  }





/*prende la path assoluta del posts.json*/
    public function getPostsPathAbsolute() {
      $root = $_SERVER["DOCUMENT_ROOT"];
      $postPath = sprintf('%s/websiteExPhp/posts.json',$root);

      return $postPath;
    }
}
