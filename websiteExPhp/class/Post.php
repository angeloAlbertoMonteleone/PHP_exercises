<?php

/**
 *
 */
class Post
{
  private $title;
  private $content;
  private $authorUsername;

  public function __construct($title, $content)
  {
    $this->title = $title;
    $this->content = $content;
  }

  public function getTitle(){
    return $this->title;
  }

  public function getContent() {
    return $this->content;
  }

  public function getAuthorUsername() {
    return $this->authorUsername;
  }
}
