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

class ResizeImage extends Save 
{
    /*-------------------------------------------------------------------------------------
    * Attributes
    *-------------------------------------------------------------------------------------*/

    /**
     * Width resize
     *
     * @var integer
     */
    private $width = 0;

    /**
     * Height resize
     *
     * @var integer
     */
    private $height = 0;

    /**
     * Image proportion
     *
     * @var bool
     */
    private $proportion;

    /*-------------------------------------------------------------------------------------
    * GET and SET methods
    *-------------------------------------------------------------------------------------*/

    /**
     * Set width resize
     *
     * @param integer $width
     * @return ResizeImage
     */
    public function setWidth(int $width) : ResizeImage
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Set height resize
     *
     * @param integer $height
     * @return ResizeImage
     */
    public function setHeight(int $height) : ResizeImage
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Set image proportion
     *
     * @param boolean $proportion
     * @return ResizeImage
     */
    public function setProportion(bool $proportion = true) : ResizeImage
    {
        $this->proportion = $proportion;

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
        //valid width
        if ($this->width < 0) {
            throw new \UnexpectedValueException("setWidth() required");
        }

        //valid height
        if ($this->height < 0) {
            throw new \UnexpectedValueException("setHeight() required");
        }
    }

    /**
     * Image resize
     * 
     * @return bool
     */
    public function execute() : bool
    {
        $fileWidth = $this->getFile()['image']['width'];
        $fileHeight = $this->getFile()['image']['height'];
        $width = $this->width;
        $height = $this->height;

        //image create
        if(!$this->getImageGd()->imageCreateFrom($this->getFile()['mimeType'], $this->getFile()['temp'])){
            return false;
        }

        //image proportional
        if($this->proportion) {
            $ratioOrig = $fileWidth / $fileHeight;
            if ($width/$height > $ratioOrig) {
                $width = $height * $ratioOrig;
            } else {
                $height = $width / $ratioOrig;
            }
        }
        
        //resource image destiny
        $imageDst = imagecreatetruecolor($width, $height);

        //image adjustments
        if (!$this->getImageGd()->imageAdjustments($imageDst)) {
            return false;
        }

        //image resize
        if(!imagecopyresampled($imageDst, $this->getImageGd()->getImageResource(), 0, 0, 0, 0, $width, $height, $fileWidth, $fileHeight)) {
            return false;
        }

        //image generate
        if ($this->getImageGd()->imageGenerate($this->getSaveMimeTypeImageAs(), $this->getSaveTo(), $this->getSaveQualityImage(), $imageDst)) {
            return true;
        }

        return false;
    }
    
}