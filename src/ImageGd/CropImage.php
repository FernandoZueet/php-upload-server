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

class CropImage extends Save
{
    /*-------------------------------------------------------------------------------------
     * Attributes
     *-------------------------------------------------------------------------------------*/

    /**
     * X crop
     *
     * @var integer
     */
    private $x = 0;

    /**
     * Y crop
     *
     * @var integer
     */
    private $y = 0;

    /**
     * Width crop
     *
     * @var integer
     */
    private $width = 0;

    /**
     * Height crop
     *
     * @var integer
     */
    private $height = 0;

    /*-------------------------------------------------------------------------------------
     * GET and SET methods
     *-------------------------------------------------------------------------------------*/

    /**
     * Set x crop
     *
     * @param integer $x
     * @return CropImage
     */
    public function setX(int $x) : CropImage
    {
        $this->x = $x;

        return $this;
    }

    /**
     * Set y crop
     *
     * @param integer $y
     * @return CropImage
     */
    public function setY(int $y) : CropImage
    {
        $this->y = $y;

        return $this;
    }

    /**
     * Set width crop
     *
     * @param integer $width
     * @return CropImage
     */
    public function setWidth(int $width) : CropImage
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Set height crop
     *
     * @param integer $height
     * @return CropImage
     */
    public function setHeight(int $height) : CropImage
    {
        $this->height = $height;

        return $this;
    }

    /*-------------------------------------------------------------------------------------
     * Other Methods
     *-------------------------------------------------------------------------------------*/

    /**
     * Validate
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
     * Image crop
     * 
     * @return bool
     */
    public function execute() : bool
    {   
        //image create
        if(!$this->getImageGd()->imageCreateFrom($this->getFile()['mimeType'], $this->getFile()['temp'])){
            return false;
        }

        //image crop
        if(!$this->getImageGd()->setImageResource(imagecrop($this->getImageGd()->getImageResource(), ['x' => $this->x, 'y' => $this->y, 'width' => $this->width, 'height' => $this->height]))) {
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