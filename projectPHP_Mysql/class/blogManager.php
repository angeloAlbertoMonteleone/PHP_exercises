<?php

require_once "Post.php";
/**
 *
 */
class blogManager
{

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
    $post = new Post(
      $title,
      $content,
      new DateTime('now'));

    // $username = $user->getUsername();
    // se avevessi avuto un og user avrei fatto, $post->setAuthorUsername($user->getUsername)
    if($user !== null) {
      $post->setAuthorUsername($user->getUsername());
    }

    // insert into database del post - query
    
    return $post;
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
      $creationDate = DateTime::createFromFormat("Y-m-d H:i:s", $post["creation_date"]);
      $postsObjects = new Post(
        $post["title"],
        $post["content"],
        $creationDate
      );

      if(array_key_exists("author_username",$post)) {
        $postsObjects->setAuthorUsername($post["author_username"]);
      }

      $posts[$key] = $postsObjects;
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





    /*prende la path assoluta del posts.json*/
    public function getPostsPathAbsolute() {
      $root = $_SERVER["DOCUMENT_ROOT"];
      $postPath = sprintf('%s/websiteExPhp/posts.json',$root);

      return $postPath;
    }
}
