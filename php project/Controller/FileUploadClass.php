<?php
/**
 * Created by PhpStorm.
 * User: rmalekar
 * Date: 8/3/15
 * Time: 4:09 PM
 */

class FileUploadClass {
    private  $FILES, $targetPath;
    public function  __construct($targetPath){
        $this->targetPath = $targetPath;
    }

    function fileUpload($FILES){
        $this->FILES = $FILES;
        try {
            // Undefined | Multiple Files | $_FILES Corruption Attack
            // If this request falls under   any of them, treat it invalid.
            if (
                !isset($this->FILES['error']) ||
                is_array($this->FILES['error'])
            ) {
                throw new RuntimeException('Invalid parameters.');
            }

            // Check $_FILES['error'] value.
            switch ($this->FILES['error']) {
                case UPLOAD_ERR_OK:
                    break;
                case UPLOAD_ERR_NO_FILE:
                    throw new RuntimeException('No file sent.');
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    throw new RuntimeException('Exceeded file size limit.');
                default:
                    throw new RuntimeException('Unknown errors.');
            }

            // You should also check filesize here.
            if ($this->FILES['size'] > 10000000) {
                throw new RuntimeException('Exceeded file size limit.'.$this->FILES['size'] );
            }
            // DO NOT TRUST $_FILES['mime'] VALUE !!
            // Check MIME Type by yourself.
            /*$finfo = new finfo(FILEINFO_MIME_TYPE);
            $ext = array_search(
                $finfo->file($this->FILES['tmp_name']),
                array(
                    'jpg' => 'image/jpeg',
                    'png' => 'image/png',
                    'gif' => 'image/gif',
                ),
                true
            );*/
            $ext = array_search($this->FILES['type'],
                array('image/jpeg', 'image/png', 'image/gif', 'image/jpg'), true);

            if (false === $ext ) {
                throw new RuntimeException('Invalid file format.');
            }

            $ext=$ext = pathinfo($this->FILES['name'], PATHINFO_EXTENSION);
           // var_dump("sssss");exit;
            // You should name it uniquely.
            // DO NOT USE $_FILES['name'] WITHOUT ANY VALIDATION !!
            // On this example, obtain safe unique name from its binary data.
            $fileName =sha1_file($this->FILES['tmp_name']);
            $filePath = sprintf($this->targetPath.'%s.%s', $fileName, $ext);


            if (!move_uploaded_file($this->FILES['tmp_name'], $filePath)) {
                throw new RuntimeException('Failed to move uploaded file.');
            }
            else {
                return sprintf("%s.%s",$fileName, $ext);
            }

            echo 'File is uploaded successfully.';

        } catch (RuntimeException $e) {

            echo $e->getMessage();

        }

    }

}