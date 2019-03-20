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

use FzUpload\ImageGd\CropImage;
use FzUpload\ImageGd\ResizeImage;
use FzUpload\ImageGd\FlipImage;
use FzUpload\ImageGd\FilterImage;
use FzUpload\ImageGd\GamaCorrectImage;
use FzUpload\ImageGd\RotateImage;
use FzUpload\ImageGd\TextImage;
use FzUpload\ImageGd\WatermarksImage;
use FzUpload\UploadFile;

class Core extends File
{
    /*-------------------------------------------------------------------------------------
    * Attributes
    *-------------------------------------------------------------------------------------*/

    /**
     * Save image as permitted
     *
     * @var array
     */
    private $saveImageAsPermitted = ['jpge','jpg', 'png', 'gif', 'webp'];

    /**
     * Image mime type reference
     *
     * @var array
     */
    private $imageMimeTypeReference = [
        'jpge' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'webp' => 'image/webp'
    ];

    /**
     * Directory upload
     *
     * @var array
     */
    private $saveDirectory = [];

    /**
     * Save image as
     *
     * @var array
     */
    private $saveImageAs = [];

    /**
     * Original name
     *
     * @var bool
     */
    private $originalName;

    /**
     * Saved files
     *
     * @var array
     */
    private $savedFiles = [];

    /**
     * Action
     *
     * @var \FzUpload\Save
     */
    private $action;

    /*-------------------------------------------------------------------------------------
    * GET and SET methods
    *-------------------------------------------------------------------------------------*/

    /**
     * Set save directory upload
     *
     * @param array $saveDirectory
     * @return Core
     */
    public function setSaveDirectory(array $saveDirectory) : Core
    {
        if(empty($saveDirectory) || count($saveDirectory) == 0) {
            throw new \UnexpectedValueException("setSaveDirectory() required");
        }

        foreach ($saveDirectory as $key => $value) {
            if(!is_dir($value)){
                if(!mkdir($value, 0777, true)) {
                    throw new \Exception("setSaveDirectory() directory");
                }
            }
        }

        $this->saveDirectory = $saveDirectory;

        return $this;
    }

    /**
     * Get save directory upload
     *
     * @return array
     */ 
    public function getSaveDirectory() : array
    {
        if(empty($this->saveDirectory)) {
            throw new \UnexpectedValueException("setSaveDirectory() required");
        }

        return $this->saveDirectory;
    }

    /**
     * Set save image as
     *
     * @param array $saveImageAs 
     * @return Core
     */
    public function setSaveImageAs(array $saveImageAs) : Core
    {
        foreach ($saveImageAs as $key => $value) {
            $value = explode('|', $value);

            if (!in_array($value[0], $this->saveImageAsPermitted)) {
                throw new \UnexpectedValueException("setSaveImageAs() function only allows values ​​(".implode(',', $this->saveImageAsPermitted).")");
            }

            if($value[0] != 'gif' && isset($value[1])) {
                if($value[1] < -1 || $value[1] > 100) {
                    throw new \UnexpectedValueException("Quality image {$value[0]} must be from 0 to 100");
                }
            }
        }

        //valid type files
        $imageCount = 0;
        foreach ($this->getFile() as $key => $file) {
            if(isset($file['image'])) {
                $imageCount++;
            }
        }
        if(count($this->getFile()) != $imageCount) {
            throw new \UnexpectedValueException("setFile() to save as an image all uploaded files must be an image file");
        }

        $this->saveImageAs = $saveImageAs;

        return $this;
    }  

    /**
     * Get save image as
     *
     * @return array
     */ 
    public function getSaveImageAs() : array
    {
        if(empty($this->saveImageAs)) {
            throw new \UnexpectedValueException("setSaveImageAs() required");
        }

        return $this->saveImageAs;
    }

    /**
     * Set original name
     *
     * @param boolean $originalName
     * @return Core
     */
    public function setOriginalName(bool $originalName) : Core
    {
        $this->originalName = $originalName;

        return $this;
    }

    /*-------------------------------------------------------------------------------------
    * General methods
    *-------------------------------------------------------------------------------------*/

    /**
     * Save local
     *
     * @return void
     */
    public function saveLocal() 
    {
        //execute
        $executes = 0;
        foreach ($this->getFile() as $key => $file) {
            $this->action->setFile($file);

            foreach ($this->getSaveDirectory() as $key1 => $directory) {
                $this->action->setSaveDirectory($directory);

                //------------------------------------------
                //image save
                if(isset($file['image'])) {

                    foreach ($this->getSaveImageAs() as $key2 => $saveImageAs) {
                        $saveImageAs = explode('|', $saveImageAs);
                        $pathSave = $this->pathSave($directory, $file, $saveImageAs[0]); 
                        $this->action->setSaveTo($pathSave);
                        $this->action->setSaveMimeTypeImageAs($this->imageMimeTypeReference[$saveImageAs[0]], $saveImageAs[1] ?? 100);

                        if($this->action->execute()) {
                            $this->savedFiles[] = $pathSave;
                            $executes++;
                        }
                    }
                    
                //------------------------------------------
                //file save
                }else{
                    $pathSave = $this->pathSave($directory, $file);
                    $this->action->setSaveTo($pathSave);

                    if($this->action->execute()) {
                        $this->savedFiles[] = $pathSave;
                        $executes++;
                    }
                }
            }
        }

        //------------------------------------------

        //save success
        $totalSaveDirectory = count($this->getSaveDirectory()) ?? 0; 
        if($this->saveImageAs && count($this->getSaveImageAs()) > 0) {
            $totalSaveImageAs = count($this->getSaveImageAs());
            $total = ($totalSaveImageAs * $totalSaveDirectory) * (count($this->getFile()));
        }else{
            $total = $totalSaveDirectory * count($this->getFile());
        }
        if($total == $executes) {
            $this->resetConfigsSaveLocal();

            return true;

        //save error
        }else{
            $this->deleteSavedFiles();

            return false;
        }
    }

    /**
     * Reset configs save local
     *
     * @return void
     */
    private function resetConfigsSaveLocal()
    {
        $this->savedFiles = [];
    }

    /**
     * Delete files 
     *
     * @return void
     */
    private function deleteSavedFiles() 
    {
        if(!empty($this->savedFiles)) {
            foreach ($this->savedFiles as $key => $value) {
                if(!unlink($value)) {
                    throw new \UnexpectedValueException("Error deleting file: {$value}");
                }
            }
        }
    }

    /**
     * Path file save
     *
     * @param string $directory
     * @param array $file
     * @param string $saveImageAs
     * @return string
     */
    private function pathSave(string $directory, array $file, string $saveImageAs = '') : string
    {
        if($this->originalName) {
            $fileName = $saveImageAs ? $file['name'].'.'.$saveImageAs : $file['completeName'];
        }else{
            $fileName = $saveImageAs ? $file['randomName'].'.'.$saveImageAs : $file['completeRandomName'];
        }

        return $directory.DIRECTORY_SEPARATOR.$fileName;
    }

    /*-------------------------------------------------------------------------------------
    * Upload methods
    *-------------------------------------------------------------------------------------*/

    /**
     * Upload file
     *
     * @return Core
     */
    public function uploadFile() : Core
    {
        $instance = new UploadFile();
        $this->action = $instance;
        $this->action->validate();

        return $this;
    }

    /**
     * Image crop
     *
     * @param integer $x
     * @param integer $y
     * @param integer $width
     * @param integer $height
     * @return Core
     */
    public function imageCrop(int $x, int $y, int $width, int $height) : Core
    {
        $instance = new CropImage();
        $instance->setX($x);
        $instance->setY($y);
        $instance->setWidth($width);
        $instance->setHeight($height);
        $this->action = $instance;
        $this->action->validate();

        return $this;
    }

    /**
     * Image resize
     *
     * @param integer $width
     * @param integer $height
     * @param boolean $proportion
     * @return Core
     */
    public function imageResize(int $width, int $height, bool $proportion = true) : Core
    {
        $instance = new ResizeImage();
        $instance->setWidth($width);
        $instance->setHeight($height);
        $instance->setProportion($proportion);
        $this->action = $instance;
        $this->action->validate();

        return $this;
    }

    /**
     * Image flip
     *
     * @param integer $mode IMG_FLIP_HORIZONTAL, IMG_FLIP_VERTICAL, IMG_FLIP_BOTH
     * @return Core
     */
    public function imageFlip(int $mode) : Core
    {
        $instance = new FlipImage();
        $instance->setMode($mode);
        $this->action = $instance;
        $this->action->validate();

        return $this;
    }

    /**
     * Image filter
     *
     * @param integer $filtertype IMG_FILTER_NEGATE, IMG_FILTER_GRAYSCALE, IMG_FILTER_BRIGHTNESS, IMG_FILTER_CONTRAST,
     * IMG_FILTER_COLORIZE, IMG_FILTER_EDGEDETECT, IMG_FILTER_EMBOSS, IMG_FILTER_GAUSSIAN_BLUR, IMG_FILTER_SELECTIVE_BLUR,
     * IMG_FILTER_MEAN_REMOVAL, IMG_FILTER_SMOOTH, IMG_FILTER_PIXELATE
     * @param integer $arg1 IMG_FILTER_BRIGHTNESS, IMG_FILTER_CONTRAST, IMG_FILTER_COLORIZE, IMG_FILTER_SMOOTH, IMG_FILTER_PIXELATE
     * @param integer $arg2 IMG_FILTER_COLORIZE, IMG_FILTER_PIXELATE
     * @param integer $arg3 IMG_FILTER_COLORIZE
     * @param integer $arg4 IMG_FILTER_COLORIZE
     * @return Core
     */
    public function imageFilter(int $filtertype, $arg1 = null, $arg2 = null, $arg3 = null, $arg4 = null) : Core
    {
        $instance = new FilterImage();
        $instance->setFilter($filtertype);
        if($arg1) {
            $instance->setArg1((int) $arg1);
        }
        if($arg2) {
            $instance->setArg2((int) $arg2);
        }
        if($arg3) {
            $instance->setArg3((int) $arg3);
        }
        if($arg4) {
            $instance->setArg4((int) $arg4);
        }
        $this->action = $instance;
        $this->action->validate();

        return $this;
    }

    /**
     * Image gamma correct
     *
     * @param float $inputgamma
     * @param float $outputgamma
     * @return Core
     */
    public function imageGammaCorrect(float $inputgamma, float $outputgamma) : Core
    {
        $instance = new GamaCorrectImage();
        $instance->setInputgamma($inputgamma);
        $instance->setOutputgamma($outputgamma);
        $this->action = $instance;
        $this->action->validate();

        return $this;
    }
    
    /**
     * Image rotate
     *
     * @param integer $rotate
     * @return Core
     */
    public function imageRotate(int $rotate) : Core
    {
        $instance = new RotateImage();
        $instance->setRotate($rotate);
        $this->action = $instance;
        $this->action->validate();

        return $this;
    }

    /**
     * Image text
     *
     * @param array $rgbColor
     * @param integer $angle
     * @param string $fontFile
     * @param integer $size
     * @param string $text
     * @param integer $x
     * @param integer $y
     * @return Core
     */
    public function imageText(string $text, string $fontFile, int $size, array $rgbColor, int $angle, int $x, int $y) : Core
    {
        $instance = new TextImage();
        $instance->setRgbColor($rgbColor);
        $instance->setAngle($angle);
        $instance->setFontFile($fontFile);
        $instance->setSize($size);
        $instance->setText($text);
        $instance->setX($x);
        $instance->setY($y);
        $this->action = $instance;
        $this->action->validate();

        return $this;
    }

    /**
     * Image watermarks
     *
     * @param integer $bottom
     * @param integer $right
     * @param string $imageLogo
     * @return Core
     */
    public function imageWatermarks(int $bottom, int $right, $imageLogo) : Core
    {
        $instance = new WatermarksImage();
        $instance->setBottom($bottom);
        $instance->setRight($right);
        $instance->setImageLogo($imageLogo);
        $this->action = $instance;
        $this->action->validate();

        return $this;
    }

}