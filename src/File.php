<?php

/**
 * This file is part of the FzUpload package
 *
 * @link http://github.com/fernandozueet/php-upload-server
 * @copyright 2019
 * @license MIT License
 * @author Fernando Zueet <fernandozueet@hotmail.com>
 */

namespace FzUpload;

class File
{
    /*-------------------------------------------------------------------------------------
    * Reassembled file
    *-------------------------------------------------------------------------------------*/

    /**
     * File mounted
     *
     * @var array
     */
    private $fileMounted = [];

    /**
     * Set array temp file
     *
     * @param integer $pos
     * @param string $value
     * @return void
     */
    private function setFileTemp(int $pos, string $value)
    {
        $this->fileMounted[$pos]['temp'] = $value;
    }

    /**
     * Validate and set array mime type
     *
     * @param integer $pos
     * @param string $value
     * @return void
     */
    private function setFileMimeType(int $pos, string $value)
    {
        $this->fileMounted[$pos]['mimeType'] = $value;
    }

    /**
     * Set array origin name
     *
     * @param integer $pos
     * @param string $value
     * @return void
     */
    private function setFileOriginName(int $pos, string $value)
    {
        $this->fileMounted[$pos]['name'] = $value;
        $this->fileMounted[$pos]['completeName'] = $value.'.'.$this->fileMounted[$pos]['extension'];
    }

    /**
     * Set array random name
     *
     * @param integer $pos
     * @param string $value
     * @return void
     */
    private function setFileRandName(int $pos, string $value)
    {
        $this->fileMounted[$pos]['randomName'] = $value;
        $this->fileMounted[$pos]['completeRandomName'] = $value.'.'.$this->fileMounted[$pos]['extension'];
    }

    /**
     * Set array extension
     *
     * @param integer $pos
     * @param string $value
     * @return void
     */
    private function setFileExtension(int $pos, string $value)
    {
        $this->fileMounted[$pos]['extension'] = $value;
    }

    /**
     * Set array file size
     *
     * @param integer $pos
     * @param integer $value
     * @return void
     */
    private function setFileSize(int $pos, int $value)
    {
        $this->fileMounted[$pos]['size'] = $value;
    }

    /**
     * Set array file image dimension
     *
     * @param integer $pos
     * @param array $dimension
     * @return void
     */
    private function setFileImageDimension(int $pos, array $dimension)
    {
        if(!empty($dimension)) {
            $this->fileMounted[$pos]['image']['width'] = $dimension['width'];
            $this->fileMounted[$pos]['image']['height'] = $dimension['height'];
        }
    }

    /**
     * Set file
     *
     * @param mixed $file
     * @return void
     */
    public function setFile($file)
    {        
        //symfony
        if((method_exists($file, 'path')) || (isset($file[0]) && method_exists($file[0], 'path'))) {
            $this->setSymfonyFile($file);

        //url
        }elseif((is_string($file) && filter_var($file, FILTER_VALIDATE_URL)) || (isset($file[0]) && filter_var($file[0], FILTER_VALIDATE_URL))) {
            $this->setUrlFile($file);

        //slim
        }elseif((isset($file['file'])) || (isset($file[0]['file']))) {
            $this->setSlimFrameFile($file);
        
        //php file
        }elseif(isset($file['tmp_name'])) {
            $this->setPhpFile($file);

        }else{
            throw new \Exception("Could not set file");
        }
    }

    /**
     * Get file mounted
     *
     * @return array
     */ 
    public function getFile() : array
    {
        return $this->fileMounted;
    }

    /*-------------------------------------------------------------------------------------
    * Methods PHP global $_FILES
    * http://php.net/manual/pt_BR/reserved.variables.files.php
    *-------------------------------------------------------------------------------------*/

    /**
     * Set php array file
     *
     * @param array $file - Ex: setPhpFile($_FILES['picture'])
     * @return void
     */
    private function setPhpFile(array $file) 
    {
        $fileNew = $this->reorganizedPhpFile($file);

        foreach ($fileNew as $key => $value) {
            $this->validPhpFile($value);
            $nameExp = explode('.', $value['name']);
            $this->setFileTemp($key, $value['tmp_name']);
            $this->setFileExtension($key, $nameExp[1]);
            $this->setFileImageDimension($key, $this->getDimensionImage($this->fileMounted[$key]['extension'], $this->fileMounted[$key]['temp']));
            $this->setFileMimeType($key, $this->getMimeType($this->fileMounted[$key]['temp'])); 
            $this->setFileOriginName($key, $this->getFileName($this->fileMounted[$key]['temp']));
            $this->setFileRandName($key, $this->newNameFile());
            $this->setFileSize($key, $this->getFileSize($this->fileMounted[$key]['temp']));
        }
    }

    /**
     * Valid php array file
     *
     * @param array $value 
     * @return void
     */
    private function validPhpFile(array $value)
    {
        if(empty($value['name'])) {
            throw new \Exception("Attribute empty name");
        }

        if(empty($value['tmp_name'])) {
            throw new \Exception("Attribute empty tmp_name");
        }
    }

    /*-------------------------------------------------------------------------------------
    * Methods Symfony Upload Class
    * https://api.symfony.com/3.0/Symfony/Component/HttpFoundation/File/UploadedFile.html 
    *-------------------------------------------------------------------------------------*/

    /**
     * Set symfony file 
     *
     * @param mixed $params - Ex: setSymfonyFile($request->picture)
     * @return void
     */
    private function setSymfonyFile($file)
    {
        if(!is_array($file)) {
            $fileNew[0] = $file;
        }else{
            $fileNew = $file;
        }

        foreach ($fileNew as $key => $value) {
            $this->validSymfonyFile($value);
            $this->setFileTemp($key, $value->path()); 
            $this->setFileExtension($key, $value->getClientOriginalExtension());
            $this->setFileImageDimension($key, $this->getDimensionImage($this->fileMounted[$key]['extension'], $this->fileMounted[$key]['temp']));
            $this->setFileMimeType($key, $this->getMimeType($this->fileMounted[$key]['temp'])); 
            $this->setFileOriginName($key, explode('.',$value->getClientOriginalName())[0] ?? '');
            $this->setFileRandName($key, $this->newNameFile());
            $this->setFileSize($key, $this->getFileSize($this->fileMounted[$key]['temp']));
        }
    }

    /**
     * Valid php symfony file
     *
     * @param mixed $value 
     * @return void
     */
    private function validSymfonyFile($value)
    {
        if(!method_exists($value, 'path')) {
            throw new \Exception("path() method required");
        }

        if(!method_exists($value, 'getClientOriginalExtension')) {
            throw new \Exception("getClientOriginalExtension() method required");
        }
    }

    /*-------------------------------------------------------------------------------------
    * Methods Slim Framework
    * http://www.slimframework.com/docs/v3/cookbook/uploading-files.html
    *-------------------------------------------------------------------------------------*/

    /**
     * Set slim framework file
     *
     * @param array|string $file - Ex: setSlimFrameFile($request->getUploadedFiles()['picture'])
     * @return void
     */
    private function setSlimFrameFile($file) 
    {
        if(array_key_exists('name', $file)) {
            $fileNew[0] = $file;
        }else{
            $fileNew = $file;
        }

        foreach ($fileNew as $key => $value) {
            $this->validSlimFrameFile($value);
            $nameExp = explode('.', $value['name']);
            $this->setFileTemp($key, $value['file']);
            $this->setFileExtension($key, $nameExp[1]);
            $this->setFileImageDimension($key, $this->getDimensionImage($this->fileMounted[$key]['extension'], $this->fileMounted[$key]['temp']));
            $this->setFileMimeType($key, $this->getMimeType($this->fileMounted[$key]['temp'])); 
            $this->setFileOriginName($key, $this->getFileName($this->fileMounted[$key]['temp']));
            $this->setFileRandName($key, $this->newNameFile());
            $this->setFileSize($key, $this->getFileSize($this->fileMounted[$key]['temp']));
        }
    }

    /**
     * Valid slim framework file
     *
     * @param array $value 
     * @return void
     */
    private function validSlimFrameFile(array $value)
    {
        if(empty($value['name'])) {
            throw new \Exception("Attribute empty name");
        }

        if(empty($value['file'])) {
            throw new \Exception("Attribute empty file");
        }
    }

    /*-------------------------------------------------------------------------------------
    * Methods URL 
    *-------------------------------------------------------------------------------------*/

    /**
     * Set url file
     *
     * @param array|string $file - Ex: setUrlFile(['https://http2.mlstatic.com/D_Q_NP_928207-MLB27435510460_052018-AB.webp']);
     * @return void
     */
    private function setUrlFile($file)
    {
        if(!is_array($file)) {
            $fileNew[0] = $file;
        }else{
            $fileNew = $file;
        }

        foreach ($fileNew as $key => $value) {
            $this->validUrl($value);
            $infoUrl = $this->getFileInfoUrl($value);
            $this->setFileTemp($key, $value);
            $this->setFileExtension($key, $this->getExtension($this->fileMounted[$key]['temp']));
            $this->setFileImageDimension($key, $this->getDimensionImage($this->fileMounted[$key]['extension'], $this->fileMounted[$key]['temp']));
            $this->setFileMimeType($key, $infoUrl['mimeType']); 
            $this->setFileOriginName($key, $this->getFileName($this->fileMounted[$key]['temp']));
            $this->setFileRandName($key, $this->newNameFile());
            $this->setFileSize($key, $infoUrl['size']);
        }
    }

    /**
     * Valid url file
     *
     * @param string $value
     * @return void
     */
    private function validUrl(string $value)
    {
        if(empty($value) || !filter_var($value, FILTER_VALIDATE_URL)) {
            throw new \Exception("Enter a valid file url - Url: {$value}");
        }
    }

    /*-------------------------------------------------------------------------------------
    * General methods
    *-------------------------------------------------------------------------------------*/

    /**
     * Get file content type
     *
     * @param string $temp
     * @return string
     */
    public function getMimeType(string $temp) : string
    {
        $mime = mime_content_type($temp);
        
        if(!$mime) {
            throw new \Exception("Error fetching file size - File: {$temp}");
        }

        return $mime;
    }

    /**
     * Get file size
     *
     * @param string $temp
     * @return int
     */
    private function getFileSize(string $temp) : int
    {
        $size = (int) filesize($temp);

        if(!$size) {
            throw new \Exception("Error fetching file size - File: {$temp}");
        }

        return $size;
    }

    /**
     * Get dimension image
     *
     * @param string $extension
     * @param string $temp
     * @return array
     */
    private function getDimensionImage(string $extension, string $temp) : array
    {
        //I deal with webp format
        if($extension == 'webp') {
            $img = imagecreatefromwebp($temp);
            if($img) {
                return [ 'width' => imagesx($img), 'height' => imagesy($img) ];
            }

        //Other cases
        }else{
            @list($width, $height, $type, $attr) = getimagesize($temp);
            if ($width && $height) {
                return [ 'width' => $width, 'height' => $height ];
            }
        }

        return [];
    }

    /**
     * Get extension 
     *
     * @param string $temp
     * @return string
     */
    private function getExtension(string $temp) : string
    {
        $extension = pathinfo(parse_url($temp, PHP_URL_PATH), PATHINFO_EXTENSION);

        if(!$extension) {
            throw new \Exception("Error fetching file extension - File: {$temp}");
        }

        return $extension;
    }

    /**
     * Get filename 
     *
     * @param string $temp
     * @return string
     */
    private function getFileName(string $temp) : string 
    {
        $filename = pathinfo(parse_url($temp, PHP_URL_PATH), PATHINFO_FILENAME);

        if(!$filename) {
            throw new \Exception("Error fetching file name - File: {$temp}");
        }

        return $filename;
    }

    /**
     * Get file size and mime type url
     *
     * @param string $temp
     * @return array
     */
    private function getFileInfoUrl(string $temp) : array
    {
        $ch = curl_init($temp);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_NOBODY, TRUE);
       
        $data = curl_exec($ch);
        $size = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
        $mimeType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
       
        curl_close($ch);

        if(empty($size) || empty($mimeType) || $mimeType == 'text/html') {
            throw new \Exception("Error fetching file info - File: {$temp}");
        }

        return ['size' => $size, 'mimeType' => $mimeType];
    }

    /**
     * Reorganized php file array
     *
     * @param array $file
     * @return array
     */
    private function reorganizedPhpFile(array $file) : array
    {
        $newArray = [];

        foreach ($file as $key => $all) {
            if(is_array($all)) {
                foreach ($all as $i => $val) {
                    $newArray[$i][$key] = $val;
                }
            }else{
                $newArray[0][$key] = $all;
            }
        }
        
        return $newArray;
    }

    /**
     * Generate new name file
     *
     * @return string
     */
    private function newNameFile() : string
    {
        return md5(uniqid(rand(), true));
    }
    
}