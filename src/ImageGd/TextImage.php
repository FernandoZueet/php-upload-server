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

class TextImage extends Save 
{
    /*-------------------------------------------------------------------------------------
    * Attributes
    *-------------------------------------------------------------------------------------*/

    /**
     * Rgb color text
     *
     * @var array
     */
    private $rgbColor = [0,0,0];

    /**
     * Size font text
     *
     * @var integer
     */
    private $size = 16;

    /**
     * Angle text
     *
     * @var integer
     */
    private $angle = 0;

    /**
     * X
     *
     * @var integer
     */
    private $x = 50;

    /**
     * Y
     *
     * @var integer
     */
    private $y = 50;

    /**
     * Font file text
     *
     * @var string
     */
    private $fontFile = "";

    /**
     * Text image
     *
     * @var string
     */
    private $text = "";
   
    /*-------------------------------------------------------------------------------------
    * GET and SET methods
    *-------------------------------------------------------------------------------------*/

    /**
     * Set rgb color text
     *
     * @param array $rgbColor
     * @return TextImage
     */
    public function setRgbColor(array $rgbColor) : TextImage
    {
        $this->rgbColor = $rgbColor;

        return $this;
    }

    /**
     * Set size font
     *
     * @param integer $size
     * @return TextImage
     */
    public function setSize(int $size) : TextImage
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Set angle font
     *
     * @param integer $angle
     * @return TextImage
     */
    public function setAngle(int $angle) : TextImage
    {
        $this->angle = $angle;

        return $this;
    }

    /**
     * Set x font
     *
     * @param integer $x
     * @return TextImage
     */
    public function setX(int $x) : TextImage
    {
        $this->x = $x;

        return $this;
    }

    /**
     * Set y font
     *
     * @param integer $y
     * @return TextImage
     */
    public function setY(int $y) : TextImage
    {
        $this->y = $y;

        return $this;
    }

    /**
     * Set font file
     *
     * @param string $fontFile
     * @return TextImage
     */
    public function setFontFile(string $fontFile) : TextImage
    {
        $this->fontFile = $fontFile;

        return $this;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return TextImage
     */
    public function setText(string $text) : TextImage
    {
        $this->text = $text;

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
        //valid size
        if ($this->size < 0) {
            throw new \UnexpectedValueException("setSize() required");
        }

        //valid font file
        if (!$this->fontFile) {
            throw new \UnexpectedValueException("setFontFile() required");
        }

        //valid angle
        if ($this->angle && $this->angle < 0 || $this->angle > 90) {
            throw new \UnexpectedValueException("setAngle() must be between 0 to 90");
        }

        //valid rgb color
        if (($this->rgbColor) && ($this->rgbColor[0] < 0 || $this->rgbColor[0] > 255) && ($this->rgbColor[1] < 0 || $this->rgbColor[1] > 255) && ($this->rgbColor[2] < 0 || $this->rgbColor[2] > 255)) {
            throw new \UnexpectedValueException("setRgbColor() invalid");
        }
    }

    /**
     * Image text
     *
     * @return bool
     */
    public function execute() : bool
    {
        //image create
        if(!$this->getImageGd()->imageCreateFrom($this->getFile()['mimeType'], $this->getFile()['temp'])){
            return false;
        }

        //image text
        $image = $this->getImageGd()->getImageResource();
        if(!imagettftext($image, $this->size, $this->angle, $this->x, $this->y, imagecolorallocate($image, $this->rgbColor[0], $this->rgbColor[1], $this->rgbColor[2]), $this->fontFile, $this->text)) {
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