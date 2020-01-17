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

use FzUpload\Save;
use FzUpload\File;

class WatermarksImage extends Save 
{
    /*-------------------------------------------------------------------------------------
    * Attributes
    *-------------------------------------------------------------------------------------*/

    /**
     * Image logo path
     *
     * @var string|array
     */
    private $imageLogo = "";

    /**
     * Right position logo
     *
     * @var integer
     */
    private $right = 10;

    /**
     * Bottom position logo
     *
     * @var integer
     */
    private $bottom = 10;

    /*-------------------------------------------------------------------------------------
    * GET and SET methods
    *-------------------------------------------------------------------------------------*/

    /**
     * Set image string logo
     *
     * @param string|array $imageLogo
     * @return WatermarksImage
     */
    public function setImageLogo($imageLogo) : WatermarksImage
    {
        $this->imageLogo = $imageLogo;

        return $this;
    }

    /**
     * Set right position logo
     *
     * @param integer $right
     * @return WatermarksImage
     */
    public function setRight(int $right) : WatermarksImage
    {
        $this->right = $right;

        return $this;
    }

    /**
     * Set bottom position logo
     *
     * @param integer $bottom
     * @return WatermarksImage
     */
    public function setBottom(int $bottom) : WatermarksImage
    {
        $this->bottom = $bottom;

        return $this;
    }

    /*-------------------------------------------------------------------------------------
    * Other Methods
    *-------------------------------------------------------------------------------------*/
    
    /**
     * Executes validate
     * 
     * @throws UnexpectedValueException
     * @return void
     */
    public function validate()
    {
        //valid image logo path
        if (!$this->imageLogo) {
            throw new \UnexpectedValueException("setImageLogo() required");
        }
    }
    
    /**
     * Watermarks image
     *
     * @return bool
     */
    public function execute() : bool
    {
        //reorganized image logo array
        if (is_string($this->imageLogo)) {
            $file = new File();
            $imglogo['temp'] = $this->imageLogo; //set url
            $imglogo['mimeType'] = $file->getMimeType($this->imageLogo); //set mime type
            $this->setImageLogo($imglogo); //set new imagelogo normalized
        }

        //image create
        if(!$this->getImageGd()->imageCreateFrom($this->getFile()['mimeType'], $this->getFile()['temp'])){
            return false;
        }    
        $image = $this->getImageGd()->getImageResource();
        
        //image create stamp
        if(!$this->getImageGd()->imageCreateFrom($this->imageLogo['mimeType'], $this->imageLogo['temp'])){
            return false;
        }    
        $imageStamp = $this->getImageGd()->getImageResource();

        //set the margins for the stamp and get the height/width of the stamp image
        $marge_right  = $this->right;
        $marge_bottom = $this->bottom;
        $sx = imagesx($imageStamp);
        $sy = imagesy($imageStamp);

        //image watermarks
        if(!$this->getImageGd()->setImageResource(imagecopy($image, $imageStamp, imagesx($image) - $sx - $marge_right, imagesy($image) - $sy - $marge_bottom, 0, 0, imagesx($imageStamp), imagesy($imageStamp)))) {
            return false;
        }

        //image adjustments
        if (!$this->getImageGd()->imageAdjustments($image, $this->getFile()['mimeType'])) {
            return false;
        }
      
        //image generate
        if ($this->getImageGd()->imageGenerate($this->getSaveMimeTypeImageAs(), $this->getSaveTo(), $this->getSaveQualityImage(), $image)) {
            return true;
        }

        return false;
    }
    
}