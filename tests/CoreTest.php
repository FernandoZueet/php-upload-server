<?php

/**
 * This file is part of the FzUpload package
 *
 * @link http://github.com/fernandozueet/php-upload-server
 * @copyright 2019
 * @license MIT License
 * @author Fernando Zueet <fernandozueet@hotmail.com>
 */

namespace Tests;

use FzUpload\Core;

class CoreTest extends \PHPUnit_Framework_TestCase
{
    public function upload()
    {
        //lib instance
        $upload = new Core();

        //set file
        $upload->setFile(['https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png']);

        //save file in C:\teste\p 
        $upload->setSaveDirectory(["C:\\teste"]);

        //save image as. Possible values: (jpg|quality - 0 to 100, png|quality - 0 to 100, gif, webp|quality - 0 to 100)
        $upload->setSaveImageAs(['jpg|100', 'png|100', 'gif', 'webp|100']);

        //original name files (optional)
        //$upload->setOriginalName();

        //upload files
        $upload->uploadFile();

        //save file to local server
        if ($upload->saveLocal()) {
            return true;
        } else {
            return false;
        }
    }

    public function imageResize()
    {
        //lib instance
        $upload = new Core();

        //set file
        $upload->setFile(['https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png']);

        //save file in C:\teste\p 
        $upload->setSaveDirectory(["C:\\teste"]);

        //save image as. Possible values: (jpg|quality - 0 to 100, png|quality - 0 to 100, gif, webp|quality - 0 to 100)
        $upload->setSaveImageAs(['jpg|100', 'png|100', 'gif', 'webp|100']);

        //image resize 
        //int $width, int $height, bool $proportion = true
        $upload->imageResize(100, 200);

        //save file to local server
        if ($upload->saveLocal()) {
            return true;
        } else {
            return false;
        }
    }

    public function imageCrop()
    {
        //lib instance
        $upload = new Core();

        //set file
        $upload->setFile(['https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png']);

        //save file in C:\teste\p 
        $upload->setSaveDirectory(["C:\\teste"]);

        //save image as. Possible values: (jpg|quality - 0 to 100, png|quality - 0 to 100, gif, webp|quality - 0 to 100)
        $upload->setSaveImageAs(['jpg|100', 'png|100', 'gif', 'webp|100']);

        //image crop
        //int $x, int $y, int $width, int $height
        $upload->imageCrop(2, 2, 300, 200);

        //save file to local server
        if ($upload->saveLocal()) {
            return true;
        } else {
            return false;
        }
    }

    public function imageFlip()
    {
        //lib instance
        $upload = new Core();

        //set file
        $upload->setFile(['https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png']);

        //save file in C:\teste\p 
        $upload->setSaveDirectory(["C:\\teste"]);

        //save image as. Possible values: (jpg|quality - 0 to 100, png|quality - 0 to 100, gif, webp|quality - 0 to 100)
        $upload->setSaveImageAs(['jpg|100', 'png|100', 'gif', 'webp|100']);

        //image flip
        //int mode - Possible values: (IMG_FLIP_HORIZONTAL, IMG_FLIP_VERTICAL, IMG_FLIP_BOTH)
        $upload->imageFlip(IMG_FLIP_VERTICAL);

        //save file to local server
        if ($upload->saveLocal()) {
            return true;
        } else {
            return false;
        }
    }

    public function imageGammaCorrect()
    {
        //lib instance
        $upload = new Core();

        //set file
        $upload->setFile(['https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png']);

        //save file in C:\teste\p 
        $upload->setSaveDirectory(["C:\\teste"]);

        //save image as. Possible values: (jpg|quality - 0 to 100, png|quality - 0 to 100, gif, webp|quality - 0 to 100)
        $upload->setSaveImageAs(['jpg|100', 'png|100', 'gif', 'webp|100']);

        //image gamma correct
        //float $inputgamma, float $outputgamma
        $upload->imageGammaCorrect(1.0, 1.537);

        //save file to local server
        if ($upload->saveLocal()) {
            return true;
        } else {
            return false;
        }
    }

    public function imageRotate()
    {
        //lib instance
        $upload = new Core();

        //set file
        $upload->setFile(['https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png']);

        //save file in C:\teste\p 
        $upload->setSaveDirectory(["C:\\teste"]);

        //save image as. Possible values: (jpg|quality - 0 to 100, png|quality - 0 to 100, gif, webp|quality - 0 to 100)
        $upload->setSaveImageAs(['jpg|100', 'png|100', 'gif', 'webp|100']);

        //image rotate
        //int $rotate - Possible values: (0 to 360)
        $upload->imageRotate(80);

        //save file to local server
        if ($upload->saveLocal()) {
            return true;
        } else {
            return false;
        }
    }

    public function imageText()
    {
        //lib instance
        $upload = new Core();

        //set file
        $upload->setFile(['https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png']);

        //save file in C:\teste\p 
        $upload->setSaveDirectory(["C:\\teste"]);

        //save image as. Possible values: (jpg|quality - 0 to 100, png|quality - 0 to 100, gif, webp|quality - 0 to 100)
        $upload->setSaveImageAs(['jpg|100', 'png|100', 'gif', 'webp|100']);

        //image text
        //string $text, string $fontFile, int $size, array $rgbColor, int $angle - (0 to 90), int $x, int $y
        $upload->imageText('Test test', 'C:\Windows\Fonts\arial.ttf', 16, [255, 0, 0], 0, 30, 30);

        //save file to local server
        if ($upload->saveLocal()) {
            return true;
        } else {
            return false;
        }
    }

    public function imageWatermarks()
    {
        //lib instance
        $upload = new Core();

        //set file
        $upload->setFile(['https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png']);

        //save file in C:\teste\p 
        $upload->setSaveDirectory(["C:\\teste"]);

        //save image as. Possible values: (jpg|quality - 0 to 100, png|quality - 0 to 100, gif, webp|quality - 0 to 100)
        $upload->setSaveImageAs(['jpg|100', 'png|100', 'gif', 'webp|100']);

        //image watermarks
        //int $bottom, int $right, string $imageLogo
        $upload->imageWatermarks(10, 10, 'C:\teste\logo.png');

        //save file to local server
        if ($upload->saveLocal()) {
            return true;
        } else {
            return false;
        }
    }

    public function imageFilterNegative()
    {
        //lib instance
        $upload = new Core();

        //set file
        $upload->setFile(['https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png']);

        //save file in C:\teste\p 
        $upload->setSaveDirectory(["C:\\teste"]);

        //save image as. Possible values: (jpg|quality - 0 to 100, png|quality - 0 to 100, gif, webp|quality - 0 to 100)
        $upload->setSaveImageAs(['jpg|100', 'png|100', 'gif', 'webp|100']);

        //image filter
        $upload->imageFilter(IMG_FILTER_NEGATE);

        //save file to local server
        if ($upload->saveLocal()) {
            return true;
        } else {
            return false;
        }
    }

    public function imageFilterGrayScale()
    {
        //lib instance
        $upload = new Core();

        //set file
        $upload->setFile(['https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png']);

        //save file in C:\teste\p 
        $upload->setSaveDirectory(["C:\\teste"]);

        //save image as. Possible values: (jpg|quality - 0 to 100, png|quality - 0 to 100, gif, webp|quality - 0 to 100)
        $upload->setSaveImageAs(['jpg|100', 'png|100', 'gif', 'webp|100']);

        //image filter
        $upload->imageFilter(IMG_FILTER_GRAYSCALE);

        //save file to local server
        if ($upload->saveLocal()) {
            return true;
        } else {
            return false;
        }
    }

    public function imageFilterEdgedetect()
    {
        //lib instance
        $upload = new Core();

        //set file
        $upload->setFile(['https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png']);

        //save file in C:\teste\p 
        $upload->setSaveDirectory(["C:\\teste"]);

        //save image as. Possible values: (jpg|quality - 0 to 100, png|quality - 0 to 100, gif, webp|quality - 0 to 100)
        $upload->setSaveImageAs(['jpg|100', 'png|100', 'gif', 'webp|100']);

        //image filter
        $upload->imageFilter(IMG_FILTER_EDGEDETECT);

        //save file to local server
        if ($upload->saveLocal()) {
            return true;
        } else {
            return false;
        }
    }

    public function imageFilterEmboss()
    {
        //lib instance
        $upload = new Core();

        //set file
        $upload->setFile(['https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png']);

        //save file in C:\teste\p 
        $upload->setSaveDirectory(["C:\\teste"]);

        //save image as. Possible values: (jpg|quality - 0 to 100, png|quality - 0 to 100, gif, webp|quality - 0 to 100)
        $upload->setSaveImageAs(['jpg|100', 'png|100', 'gif', 'webp|100']);

        //image filter
        $upload->imageFilter(IMG_FILTER_EMBOSS);

        //save file to local server
        if ($upload->saveLocal()) {
            return true;
        } else {
            return false;
        }
    }

    public function imageFilterGaussianBlur()
    {
        //lib instance
        $upload = new Core();

        //set file
        $upload->setFile(['https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png']);

        //save file in C:\teste\p 
        $upload->setSaveDirectory(["C:\\teste"]);

        //save image as. Possible values: (jpg|quality - 0 to 100, png|quality - 0 to 100, gif, webp|quality - 0 to 100)
        $upload->setSaveImageAs(['jpg|100', 'png|100', 'gif', 'webp|100']);

        //image filter
        $upload->imageFilter(IMG_FILTER_GAUSSIAN_BLUR);

        //save file to local server
        if ($upload->saveLocal()) {
            return true;
        } else {
            return false;
        }
    }

    public function imageFilterSelectiveBlur()
    {
        //lib instance
        $upload = new Core();

        //set file
        $upload->setFile(['https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png']);

        //save file in C:\teste\p 
        $upload->setSaveDirectory(["C:\\teste"]);

        //save image as. Possible values: (jpg|quality - 0 to 100, png|quality - 0 to 100, gif, webp|quality - 0 to 100)
        $upload->setSaveImageAs(['jpg|100', 'png|100', 'gif', 'webp|100']);

        //image filter
        $upload->imageFilter(IMG_FILTER_SELECTIVE_BLUR);

        //save file to local server
        if ($upload->saveLocal()) {
            return true;
        } else {
            return false;
        }
    }

    public function imageFilterMeanRemoval()
    {
        //lib instance
        $upload = new Core();

        //set file
        $upload->setFile(['https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png']);

        //save file in C:\teste\p 
        $upload->setSaveDirectory(["C:\\teste"]);

        //save image as. Possible values: (jpg|quality - 0 to 100, png|quality - 0 to 100, gif, webp|quality - 0 to 100)
        $upload->setSaveImageAs(['jpg|100', 'png|100', 'gif', 'webp|100']);

        //image filter
        $upload->imageFilter(IMG_FILTER_MEAN_REMOVAL);

        //save file to local server
        if ($upload->saveLocal()) {
            return true;
        } else {
            return false;
        }
    }

    public function imageFilterSmooth()
    {
        //lib instance
        $upload = new Core();

        //set file
        $upload->setFile(['https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png']);

        //save file in C:\teste\p 
        $upload->setSaveDirectory(["C:\\teste"]);

        //save image as. Possible values: (jpg|quality - 0 to 100, png|quality - 0 to 100, gif, webp|quality - 0 to 100)
        $upload->setSaveImageAs(['jpg|100', 'png|100', 'gif', 'webp|100']);

        //image filter
        $upload->imageFilter(IMG_FILTER_SMOOTH);

        //save file to local server
        if ($upload->saveLocal()) {
            return true;
        } else {
            return false;
        }
    }

    public function imageFilterBrightness()
    {
        //lib instance
        $upload = new Core();

        //set file
        $upload->setFile(['https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png']);

        //save file in C:\teste\p 
        $upload->setSaveDirectory(["C:\\teste"]);

        //save image as. Possible values: (jpg|quality - 0 to 100, png|quality - 0 to 100, gif, webp|quality - 0 to 100)
        $upload->setSaveImageAs(['jpg|100', 'png|100', 'gif', 'webp|100']);

        //image filter - (-255 to 255)
        $upload->imageFilter(IMG_FILTER_BRIGHTNESS, 100);

        //save file to local server
        if ($upload->saveLocal()) {
            return true;
        } else {
            return false;
        }
    }

    public function imageFilterContrast()
    {
        //lib instance
        $upload = new Core();

        //set file
        $upload->setFile(['https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png']);

        //save file in C:\teste\p 
        $upload->setSaveDirectory(["C:\\teste"]);

        //save image as. Possible values: (jpg|quality - 0 to 100, png|quality - 0 to 100, gif, webp|quality - 0 to 100)
        $upload->setSaveImageAs(['jpg|100', 'png|100', 'gif', 'webp|100']);

        //image filter - (-100 to 100)
        $upload->imageFilter(IMG_FILTER_CONTRAST, -50);

        //save file to local server
        if ($upload->saveLocal()) {
            return true;
        } else {
            return false;
        }
    }

    public function imageFilterPixelate()
    {
        //lib instance
        $upload = new Core();

        //set file
        $upload->setFile(['https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png']);

        //save file in C:\teste\p 
        $upload->setSaveDirectory(["C:\\teste"]);

        //save image as. Possible values: (jpg|quality - 0 to 100, png|quality - 0 to 100, gif, webp|quality - 0 to 100)
        $upload->setSaveImageAs(['jpg|100', 'png|100', 'gif', 'webp|100']);

        //image filter 
        $upload->imageFilter(IMG_FILTER_PIXELATE, 3);

        //save file to local server
        if ($upload->saveLocal()) {
            return true;
        } else {
            return false;
        }
    }

    public function imageFilterColorize()
    {
        //lib instance
        $upload = new Core();

        //set file
        $upload->setFile(['https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png']);

        //save file in C:\teste\p 
        $upload->setSaveDirectory(["C:\\teste"]);

        //save image as. Possible values: (jpg|quality - 0 to 100, png|quality - 0 to 100, gif, webp|quality - 0 to 100)
        $upload->setSaveImageAs(['jpg|100', 'png|100', 'gif', 'webp|100']);

        //image filter 
        //arg1 (0 to 255), arg2 (0 to 255), arg3 (0 to 255), arg4 (0 to 127)
        $upload->imageFilter(IMG_FILTER_COLORIZE, 64, 193, 198, 50);

        //save file to local server
        if ($upload->saveLocal()) {
            return true;
        } else {
            return false;
        }
    }

}