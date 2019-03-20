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

class GamaCorrectImage extends Save 
{
    /*-------------------------------------------------------------------------------------
    * Attributes
    *-------------------------------------------------------------------------------------*/

    /**
     * Inputgrama
     *
     * @var float
     */
    private $inputgamma = 0;

    /**
     * Outputgamma
     *
     * @var float
     */
    private $outputgamma = 0;

    /*-------------------------------------------------------------------------------------
    * GET and SET methods
    *-------------------------------------------------------------------------------------*/

    /**
     * Set inputgrama
     *
     * @param float $inputgamma
     * @return GamaCorrectImage
     */
    public function setInputgamma(float $inputgamma) : GamaCorrectImage
    {
        $this->inputgamma = $inputgamma;

        return $this;
    }

    /**
     * Set outputgamma
     *
     * @param float $outputgamma
     * @return GamaCorrectImage
     */
    public function setOutputgamma(float $outputgamma) : GamaCorrectImage
    {
        $this->outputgamma = $outputgamma;

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
        //valid inputgamma
        if (!isset($this->inputgamma)) {
            throw new \UnexpectedValueException("setInputgamma() required");
        }

        //valid outputgamma
        if (!isset($this->outputgamma)) {
            throw new \UnexpectedValueException("setOutputgamma() required");
        }
    }

    /**
     * Image gama correct
     *
     * @return bool
     */
    public function execute() : bool
    {
        //image create
        if(!$this->getImageGd()->imageCreateFrom($this->getFile()['mimeType'], $this->getFile()['temp'])){
            return false;
        }

        //image gama correct
        if(!imagegammacorrect($this->getImageGd()->getImageResource(), $this->inputgamma, $this->outputgamma)) {
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