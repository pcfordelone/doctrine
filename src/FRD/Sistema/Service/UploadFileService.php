<?php

namespace FRD\Sistema\Service;


use FRD\Sistema\Entity\Produto;

class UploadFileService
{
    function upload()
    {
        $img = $_FILES['image'];

        $maxSize = 5242880;
        $types = array('image/jpg','image/jpeg','image/png','image/gif');

        $extensao = @end(explode('.',$img['name']));
        $new_name = rand() . ".$extensao";

        $targetDir = "../public/uploads/";
        $targetFile = $targetDir . basename($new_name);

        if (!in_array($img['type'], $types) or $img['size'] > $maxSize)
        {
            return false;
        }

        if (move_uploaded_file($img['tmp_name'], $targetFile)) {
            return "/uploads/" . $new_name;
        }
    }

} 