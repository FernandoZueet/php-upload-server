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

use FzUpload\Save;

class UploadFile extends Save 
{
    /*-------------------------------------------------------------------------------------
    * Attributes
    *-------------------------------------------------------------------------------------*/

    /*-------------------------------------------------------------------------------------
    * GET and SET methods
    *-------------------------------------------------------------------------------------*/

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
        //
    }
    
    /**
     * Upload file
     *
     * @return bool
     */
    public function execute() : bool
    {
        $images = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if(in_array($this->getFile()['mimeType'], $images)) {

            //image create
            if(!$this->getImageGd()->imageCreateFrom($this->getFile()['mimeType'], $this->getFile()['temp'])){
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

        }else{

            //upload
            if(copy($this->getFile()['temp'], $this->getSaveTo())) {
                return true;
            }
        }

        return false;
    }
    
}