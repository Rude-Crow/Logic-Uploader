<?php
$save_dir = "Uploads/";
$save_image = $save_dir . basename($_FILES["fileToUpload"]["name"]);
$upload_check = 1;
$upload_Msg = "";
$imageFileType = strtolower(pathinfo($save_image,PATHINFO_EXTENSION));

// Checks if the file is an image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    $upload_Msg = "File is an image - " . $check["mime"] . ".";
    $upload_check = 1;
  } else {
    $upload_Msg = "File is not an image.";
    $upload_check = 0;
  }
}

// Check if a file of the same name already exists
if (file_exists($save_image)) {
  $upload_Msg = "Sorry a image of this name already exist, please change the name and try again.";
  $upload_check = 0;
}

// Check the image size
if ($_FILES["fileToUpload"]["size"] > 500000) {
  $upload_Msg = "Sorry, your image is too large.";
  $upload_check = 0;
}

// Allow only image formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  $upload_Msg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $upload_check = 0;
}

// Check if _check is set to 0 by an error
if ($upload_check == 0) {
  $upload_Msg = "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $save_image)) {
    $upload_Msg = "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
  } else {
    $upload_Msg = "Sorry, there was an error uploading your file.";
  }
}

// sends email with page link
$url = "localhost/".$save_image;
$msg = wordwrap($url,70);
$email = basename(["email"]["name"]);
mail($email,"Your Image Link",$msg);

header( "Location: index.html" )
?>
