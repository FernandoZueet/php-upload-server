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

class FlipImage extends Save 
{
    /*-------------------------------------------------------------------------------------
    * Attributes
    *-------------------------------------------------------------------------------------*/

    /**
     * Mode
     *
     * @var integer
     */
    private $mode;

    /*-------------------------------------------------------------------------------------
    * GET and SET methods
    *-------------------------------------------------------------------------------------*/

    /**
     * Set flip mode
     *
     * @param integer $mode
     * @return FlipImage
     */
    public function setMode(int $mode) : FlipImage
    {
        $this->mode = $mode;
        
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
        if (!$this->mode) {
            throw new \UnexpectedValueException("setMode() required");
        }
    }
    
    /**
     * Image flip
     *
     * @return bool
     */
    public function execute() : bool
    {
        //image create
        if(!$this->getImageGd()->imageCreateFrom($this->getFile()['mimeType'], $this->getFile()['temp'])){
            return false;
        }

        //image flip
        if(!imageflip($this->getImageGd()->getImageResource(), $this->mode)) {
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