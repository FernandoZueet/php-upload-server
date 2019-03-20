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

class FilterImage extends Save
{
    /*-------------------------------------------------------------------------------------
     * Attributes
     *-------------------------------------------------------------------------------------*/

    /**
     * Filter image
     *
     * @var integer
     */
    private $filter;

    /**
     * Arg1
     *
     * @var integer
     */
    private $arg1;

    /**
     * Arg2
     *
     * @var integer
     */
    private $arg2;

    /**
     * Arg3
     *
     * @var integer
     */
    private $arg3;

    /**
     * Arg4
     *
     * @var integer
     */
    private $arg4;

    /*-------------------------------------------------------------------------------------
     * GET and SET methods
     *-------------------------------------------------------------------------------------*/

    /**
     * Set filter
     *
     * @param integer $filter
     * @return FilterImage
     */
    public function setFilter(int $filter) : FilterImage
    {
        $this->filter = $filter;

        return $this;
    }

    /**
     * Set arg1
     *
     * @param integer $arg1
     * @return FilterImage
     */
    public function setArg1(int $arg1) : FilterImage
    {
        $this->arg1 = $arg1;

        return $this;
    }

    /**
     * Set arg2
     *
     * @param integer $arg2
     * @return FilterImage
     */
    public function setArg2(int $arg2) : FilterImage
    {
        $this->arg2 = $arg2;

        return $this;
    }

    /**
     * Set arg3
     *
     * @param integer $arg3
     * @return FilterImage
     */
    public function setArg3(int $arg3) : FilterImage
    {
        $this->arg3 = $arg3;

        return $this;
    }

    /**
     * Set arg4
     *
     * @param integer $arg4
     * @return FilterImage
     */
    public function setArg4(int $arg4) : FilterImage
    {
        $this->arg4 = $arg4;

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
        //valid filter
        if (!isset($this->filter)) {
            throw new \UnexpectedValueException("setFilter() required");
        }

        //valid filter brightness
        if($this->filter == IMG_FILTER_BRIGHTNESS) {
            if (!$this->arg1) {
                throw new \UnexpectedValueException("setArg1() required");
            }
            if ($this->arg1 < -255 || $this->arg1 > 255) {
                throw new \UnexpectedValueException("setArg1() must be between -255 to 255");
            }
        }

        //valid filter contrast
        if($this->filter == IMG_FILTER_CONTRAST) {
            if (!$this->arg1) {
                throw new \UnexpectedValueException("setArg1() required");
            }
            if ($this->arg1 < -100 || $this->arg1 > 100) {
                throw new \UnexpectedValueException("setArg1() must be between -100 to 100");
            }
        }

        //valid filter pixelate
        if($this->filter == IMG_FILTER_PIXELATE) {
            if (!$this->arg1) {
                throw new \UnexpectedValueException("setArg1() required");
            }
        }

        //valid filter colorize
        if($this->filter == IMG_FILTER_COLORIZE) {
            if (!$this->arg1) {
                throw new \UnexpectedValueException("setArg1() required");
            }
            if (!$this->arg2) {
                throw new \UnexpectedValueException("setArg2() required");
            }
            if (!$this->arg3) {
                throw new \UnexpectedValueException("setArg3() required");
            }
            if ($this->arg1 && $this->arg1 < -0 || $this->arg1 > 255) {
                throw new \UnexpectedValueException("setArg1() must be between 0 to 255");
            }
            if ($this->arg2 && $this->arg2 < -0 || $this->arg2 > 255) {
                throw new \UnexpectedValueException("setArg2() must be between 0 to 255");
            }
            if ($this->arg3 && $this->arg3 < -0 || $this->arg3 > 255) {
                throw new \UnexpectedValueException("setArg3() must be between 0 to 255");
            }
            if ($this->arg4 && $this->arg4 < -0 || $this->arg4 > 127) {
                throw new \UnexpectedValueException("setArg4() must be between 0 to 127");
            }
        }
    }

    /**
     * Image filter
     *
     * @return bool
     */
    public function execute() : bool
    {
        //image create
        if(!$this->getImageGd()->imageCreateFrom($this->getFile()['mimeType'], $this->getFile()['temp'])){
            return false;
        }

        //image filter 
        $arg1A = [IMG_FILTER_BRIGHTNESS, IMG_FILTER_CONTRAST, IMG_FILTER_SMOOTH];
        if($this->filter == IMG_FILTER_COLORIZE) {
            if(!imagefilter($this->getImageGd()->getImageResource(), $this->filter, $this->arg1 ?? 0, $this->arg2 ?? 0, $this->arg3 ?? 0, $this->arg4 ?? 0)) {
                return false;
            }
        
        }else if($this->filter == IMG_FILTER_PIXELATE) {
            if(!imagefilter($this->getImageGd()->getImageResource(), $this->filter, $this->arg1, $this->arg2 ?? 0)) {
                return false;
            }

        }else if(in_array($this->filter, $arg1A)) {
            if(!imagefilter($this->getImageGd()->getImageResource(), $this->filter, $this->arg1)) {
                return false;
            }
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