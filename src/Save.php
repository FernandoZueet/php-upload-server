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

use FzUpload\ImageGd\ImageGd;

abstract class Save
{
    /**
     * ImageGd
     *
     * @var ImageGd
     */
    private $imageGd;

    /**
     * File
     *
     * @var array
     */
    private $file;

    /**
     * Save mime type image as
     *
     * @var string
     */
    private $saveMimeTypeImageAs;

    /**
     * Save quality image
     *
     * @var integer
     */
    private $saveQualityImage;

    /**
     * Save to
     *
     * @var string
     */
    private $saveTo;

    /**
     * Save directory
     *
     * @var string
     */
    private $saveDirectory;

    /**
     * Set file
     *
     * @param array $file 
     * @return  Save
     */
    public function setFile(array $file) : Save
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return array
     */
    public function getFile() : array
    {
        return $this->file;
    }

    /**
     * Set save mime type image as
     *
     * @param string $saveMimeTypeImageAs
     * @return Save
     */ 
    public function setSaveMimeTypeImageAs(string $saveMimeTypeImageAs, int $saveQualityImage = 100) : Save
    {
        $this->saveMimeTypeImageAs = $saveMimeTypeImageAs;
        $this->saveQualityImage = $saveQualityImage;

        return $this;
    }

    /**
     * Get save mime type image as
     * 
     * @return string
     */ 
    public function getSaveMimeTypeImageAs() : string
    {
        return $this->saveMimeTypeImageAs;
    }

    /**
     * Get save quality image
     *
     * @return int
     */ 
    public function getSaveQualityImage() : int
    {
        return $this->saveQualityImage;
    }

    /**
     * Set save to
     *
     * @param string $saveTo 
     * @return Save
     */ 
    public function setSaveTo(string $saveTo) : Save
    {
        $this->saveTo = $saveTo;

        return $this;
    }

    /**
     * Get save to
     *
     * @return string
     */ 
    public function getSaveTo() : string
    {
        return $this->saveTo;
    }

    /**
     * Set save directory
     *
     * @param string $saveDirectory
     * @return Save
     */ 
    public function setSaveDirectory(string $saveDirectory) : Save
    {
        $this->saveDirectory = $saveDirectory;

        return $this;
    }

    /**
     * Get save directory
     *
     * @return string
     */ 
    public function getSaveDirectory() : string
    {
        return $this->saveDirectory;
    }

    /**
     * Get imageGd
     *
     * @return ImageGd
     */ 
    public function getImageGd() : ImageGd
    {
        return $this->imageGd;
    }

    /**
     * Construct
     */
    public function __construct() 
    {
        $this->imageGd = new ImageGd();
    }

    /**
     * Executes validate
     *
     * @return void
     */
    public abstract function validate();

    /**
     * Execute function
     *
     * @return bool
     */
    public abstract function execute() : bool;
    
}