<?php 

if (!empty($_POST)) {// if we have a post request from Github or Bitbucket

  # execute git pull
  shell_exec("git pull");

  # if you don't use Github, commit the next line
  $theCommitMessage = json_decode($_POST['payload'])->head_commit->message ; // get the commit from Github

  # if you don't use Bitbucket, uncommit the next line
  //$theCommitMessage = json_decode($_POST['payload'])->commits[0]->message; // get the commit from Bitbucket

  # retrieve the command
  $pattern = '/\[(.*?)\]/';
  preg_match( $pattern, $theCommitMessage, $match );

  if (!empty($match)) { // if we have somthing like "my commit [rm file]"
    $theCommand = $match[1]; // get the command
    shell_exec($theCommand); // Execute the command 
  }

}
