<?php

require 'lib/kint/Kint.class.php';

// you can put this in a common/settings file or something
define('DOCUMENT_UPLOAD_DIR', 'uploads');

$allowed_upload_type = array('passport', '485', 'ielts', 'qualification', 'transcript', 'completion');

function getUploadPath($email, $type, $filename)
{
  global $allowed_upload_type;
  if (!in_array($type, $allowed_upload_type))
  {
    throw new Exception('Unknown document type');
  }
  $folder = DOCUMENT_UPLOAD_DIR . '/' . md5(strtolower(trim($email)));
  if (!file_exists($folder))
  {
    if (!mkdir($folder))
    {
      throw new Exception("Oh noes!");
    }
    else
    {
      file_put_contents($folder . '/userdetails.txt', strtolower(trim($email)));
    }
  }
  return $folder . '/' . $type . '-' . strtolower(pathinfo($filename, PATHINFO_FILENAME)) . '.' . strtolower(pathinfo($filename, PATHINFO_EXTENSION));
}

//var_dump($_SESSION);

//d($_FILES);

// TODO filename extension checking, throw error

// get the user's email address
// error checking goes here
//$email = $_SESSION['userdetails']['email'];
$email = $_GET['email'];

// get a path corresponding to that email address
// this function will return some MD5 path or something
// and it will ensure that it exists
// we also give it a document type to give us the name of
// it will also check the document type specified
$type = $_GET['type'];
$path = getUploadPath($email, $type, $_FILES['file']['name']);

// move the file there, rename it to whatever we want to rename it to
move_uploaded_file($_FILES['file']['tmp_name'], $path);

echo($path);

?>