<?php

require_once "Post.php";
/**
 *
 */
class blogManager
{

  public function getPost(): array
  {
    return $this->loadPosts();
  }


  public function addPost($title, $content): Post
  {
    $post = new Post($title, $content);

    $posts = $this->loadPosts();

    $posts[] = $post;

    $this->updatePosts($posts);
    return $post;
  }



  /*prende la path assoluta del posts.json*/
  public function getPostsPathAbsolute() {
    $root = $_SERVER["DOCUMENT_ROOT"];
    $postPath = sprintf('%s/websiteExPhp/posts.json',$root);

    return $postPath;
  }



  /**
  *@return array
  *@throws Exception
  * estrapola i posts dal file posts.json e ritorna dei posts in un array di oggetti(decodificati in arrays)
  */
  public function loadPosts():array
  {
    $postPathAbsolute = $this->getPostsPathAbsolute();

    if(!file_exists($postPathAbsolute)){
      return [];
    }

    $content = file_get_contents($postPathAbsolute);
    $posts = json_decode($content, true);

    if($posts === null) {
      echo "Impossibile caricare i posts ", json_last_error_msg();
    }

  // costruisce un array di oggetti post
    foreach ($posts as $key => $post) {
      $postsObjects = new Post(
        $post["title"],
        $post["content"]
      );

      $posts[$key] = $postsObjects;
    }

    return $posts;
  }




  /*carica sul nostro database il nuovo users [],(users di array di istanze user) su file json */
  private function updatePosts(array $posts) {

    $postPathAbsolute = $this->getPostsPathAbsolute();

    $output = [];

    foreach ($posts as $post) {
      $output[] = [
        "title" => $post->getTitle(),
        "content" => $post->getContent()
      ];

    }
    // convertiamo users in array, da un array di oggetti
    file_put_contents($postPathAbsolute, json_encode($output));
  }

}
