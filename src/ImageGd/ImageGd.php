<?php

/**
 * This file is part of the FzUpload package
 *
 * @link http://github.com/fernandozueet/php-upload-server
 * @copyright 2019
 * @license MIT License
 * @author Fernando Zueet <fernandozueet@hotmail.com>
 */

namespace FzUpload\ImageGd;

class ImageGd
{
    /*-------------------------------------------------------------------------------------
    * GET and SET methods
    *-------------------------------------------------------------------------------------*/

    /**
     * Image resource
     *
     * @var resource
     */
    private $imageResource;

    /**
     * Set image resource 
     *
     * @param resource $image
     * @return resource|bool
     */
    public function setImageResource($image) 
    {
        $this->imageResource = $image;

        if($this->imageResource === false) {
            return false;
        }

        return $this->imageResource;
    }

    /**
     * Get image resource
     *
     * @return resource
     */
    public function getImageResource()
    {
        return $this->imageResource;
    }

    /*-------------------------------------------------------------------------------------
    * General methods
    *-------------------------------------------------------------------------------------*/

    /**
     * Image generate
     *
     * @param string $mimeType
     * @param mixed $to
     * @param integer $quality
     * @param resource $image
     * @return boolean
     */
    public function imageGenerate(string $mimeType, $to, int $quality, $image = null) : bool
    {
        if ($image == null) {
            $image = $this->imageResource;
        }

        if ($image === false) {
            return false;
        }

        if ($mimeType == "image/jpeg") {
            return imagejpeg($image, $to, $quality);
        }

        if ($mimeType == "image/gif") {
            return imagegif($image, $to);
        }

        if ($mimeType == "image/png") {
            if($quality == 100) {
                $quality = 9;
            }else{
                if(strlen($quality) > 1) {
                    $quality = (int) substr($quality, 0, 1);
                }else{
                    $quality = 1;
                }
            }
            return imagepng($image, $to, $quality);
        }

        if ($mimeType == "image/webp") {
            return imagewebp($image, $to, $quality);
        }
    }

    /**
     * Image create from
     *
     * @param string $mimeType
     * @param string $filename
     * @return resource|bool
     */
    public function imageCreateFrom(string $mimeType, string $filename) 
    {
        if ($mimeType == "image/jpeg") {
            return $this->setImageResource(imagecreatefromjpeg($filename));
        }

        if ($mimeType == "image/gif") {
            return $this->setImageResource(imagecreatefromgif($filename));
        }

        if ($mimeType == "image/png") {
            return $this->setImageResource(imagecreatefrompng($filename));
        }

        if ($mimeType == "image/webp") {
            return $this->setImageResource(imagecreatefromwebp($filename));
        }
    } 
    
    /**
     * Image adjustments
     *
     * @param resource $image
     * @return boolean
     */
    public function imageAdjustments($image = null) : bool
    {
        if ($image == null) {
            $image = $this->imageResource;
        }
        
        if(!imagepalettetotruecolor($image)) {
            return false;
        };

        if(!imagealphablending($image, true)) {
            return false;
        }

        if(!imagesavealpha($image, true)) {
            return false;
        }

        return true;
    }
    
}