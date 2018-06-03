<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Helpers
 *
 * @author Allan
 */
class Helpers
{

    /**
     * Get Application root path
     * 
     * @return string
     */
    public static function app_path()
    {
        return APP_PATH;
    }

    /**
     * Get Application base_url
     * 
     * @return string
     */
    public static function base_url()
    {
        return HOST_URL;
    }

    /**
     * Get the current URL
     * 
     * @return string
     */
    public static function current_url()
    {
        $url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        $valid_URL = str_replace("&", "&amp;", $url);

        return $valid_URL;
    }

    /**
     * Generate a CSV output from an Array
     * 
     * @param array $data
     * @param string $delimiter
     * @param string $enclosure
     * @return file
     */
    public static function generateCsv($data, $delimiter = ',', $enclosure = '"')
    {
        $handle = fopen('php://temp', 'r+');

        foreach ($data as $line) {
            fputcsv($handle, $line, $delimiter, $enclosure);
        }

        rewind($handle);

        while (!feof($handle)) {
            $contents .= fread($handle, 8192);
        }

        fclose($handle);

        return $contents;
    }

    /**
     * Upload file
     * 
     * @param string $upload_path
     * @param file $input_name
     * @param integer $max_file_size
     * @param array $allowed_mimes
     * @param boolean $rename optional - Rename file if the file already exists
     * @return any
     */
    public static function upload($upload_path, $input_name, $max_file_size, $allowed_mimes = [], $rename = true)
    {
        $target_dir = APP_PATH . '/' . $upload_path;

        $target_file = $target_dir . basename($_FILES[$input_name]["name"]);

        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
        
        if (!isset($input_name)) {
            return ['error' => "Mime type not allowed"];
        }
      
        if ($_FILES["fileToUpload"]["size"] > $max_file_size) {
            return ['error' => "File size is too large. Upto {$max_file_size} accepted"];
        }
        
        if (!in_array($imageFileType, $allowed_mimes)) {
            return ['error' => "Mime type not allowed"];
        }
        
        if (file_exists($target_file) && $rename == false) {
            return ['error' => "Sorry, file already exists."];
        }

        $filename = $_FILES[$input_name]["name"];

        $extension = end(explode(".", $filename));

        $unique_file_name = uniqid().'.'.$extension;

        $fname = $target_dir.$unique_file_name;
        
        if($rename == false){
            $fname = $target_file;
        }

        if (move_uploaded_file($_FILES[$input_name]["tmp_name"], $fname)) {
            return true;
        } else {
            return false;
        }
    }

}
