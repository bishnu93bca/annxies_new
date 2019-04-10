<?php
$succeed = 0;
$error = 0;
$thegoodstuf = '';
foreach($_FILES["img"]["error"] as $key => $value) {
    if ($value == UPLOAD_ERR_OK){
        $succeed++;

        // get the image original name
        $name = $_FILES["img"]["name"][$key];

        // get some specs of the images
        $arr_image_details = getimagesize($_FILES["img"]["tmp_name"][$key]);
        $width = $arr_image_details[0];
        $height = $arr_image_details[1];
        $mime = $arr_image_details['mime'];

        // Replace the images to a new nice location. Note the use of copy() instead of move_uploaded_file(). I did this becouse the copy function will replace with the good file rights and  move_uploaded_file will not shame on you move_uploaded_file.
        copy($_FILES['img']['tmp_name'][$key], './upload/'.$name);

        // make some nice html to send back
        $thegoodstuf .= "
                            <br>
                            <hr>
                            <br>

                            <h2>Image $succeed - $name</h2>
                            <br>
                            specs,
                            <br>
                            width: $width  <br>
                            height: $height <br>
                            mime type: $mime <br>
                            <br>
                            <br>
                            <img src='./upload/$name' title='$name' />
        ";
    }
    else{
        $error++;
    }
}


if($error){
    echo 'shameful display! '.$error.' images where not properly uploaded!<br>';
}


echo $name;

?>