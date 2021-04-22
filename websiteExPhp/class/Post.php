<?php

/**
 *
 */
class Post
{
  private $title;
  private $content;
  private $authorUsername;
  private $creationDate;

  public function __construct($title, $content, DateTime $creationDate)
  {
    $this->title = $title;
    $this->content = $content;
    $this->creationDate = $creationDate;
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
  public function setAuthorUsername($username) {
    $this->authorUsername = $username;
  }

  public function getCreationDate() {
    return $this->creationDate;
  }
}
