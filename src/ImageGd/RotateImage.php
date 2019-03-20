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

class RotateImage extends Save 
{
    /*-------------------------------------------------------------------------------------
    * Attributes
    *-------------------------------------------------------------------------------------*/

    /**
     * Rotate image
     *
     * @var integer
     */
    private $rotate = 0;

    /*-------------------------------------------------------------------------------------
    * GET and SET methods
    *-------------------------------------------------------------------------------------*/

    /**
     * Set rotate image
     *
     * @param integer $rotate
     * @return RotateImage
     */
    public function setRotate(int $rotate) : RotateImage
    {
        $this->rotate = $rotate;

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
        //valid rotate
        if (!$this->rotate) {
            throw new \UnexpectedValueException("setRotate() required");
        }       

        //valid rotate
        if ($this->rotate > 360 || $this->rotate < 0) {
            throw new \UnexpectedValueException("setRotate() value should be between 0 and 360");
        }
    }

    /**
     * Image rotate
     *
     * @return bool
     */
    public function execute() : bool
    {
        //image create
        if(!$this->getImageGd()->imageCreateFrom($this->getFile()['mimeType'], $this->getFile()['temp'])){
            return false;
        }

        //image rotate
        if(!$this->getImageGd()->setImageResource(imagerotate($this->getImageGd()->getImageResource(), $this->rotate, imageColorAllocateAlpha($this->getImageGd()->getImageResource(), 0, 0, 0, 127)))) {
            return false;
        }

        //image adjustments
        if (!$this->getImageGd()->imageAdjustments()) {
            return false;
        }
      
        //image generate
        if ($this->getImageGd()->imageGenerate($this->getSaveMimeTypeImageAs(), $this->getSaveTo(), $this->getSaveQualityImage())) {
            return true;
        }

        return false;
    }
    
}