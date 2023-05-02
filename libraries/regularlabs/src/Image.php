<?php
/**
 * @package         Regular Labs Library
 * @version         23.4.18579
 * 
 * @author          Peter van Westen <info@regularlabs.com>
 * @link            http://regularlabs.com
 * @copyright       Copyright © 2023 Regular Labs All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

namespace RegularLabs\Library;

defined('_JEXEC') or die;

require_once dirname(__FILE__, 2) . '/vendor/autoload.php';

use Intervention\Image\Exception\NotReadableException as NotReadableException;
use Intervention\Image\ImageManagerStatic as ImageManager;
use Joomla\CMS\Uri\Uri as JUri;

class Image
{
    static  $data_files = [];
    private $attributes;
    private $description;
    private $input;
    private $is_resized;
    private $output;
    private $settings;

    /**
     * @param string $file
     * @param object $attributes @deprecated use SET methods instead
     */
    public function __construct($file = null, $attributes = null)
    {
        $this->settings = (object) [
            'resize'       => (object) [
                'enabled'              => true,
                'quality'              => 70,
                'method'               => 'crop',
                'folder'               => 'resized',
                'max_age'              => 0,
                'use_retina'           => true,
                'retina_pixel_density' => 1.5,
            ],
            'title'        => (object) [
                'enabled'         => true,
                'format'          => 'uppercase_first',
                'lowercase_words' => 'a,the,to,at,in,with,and,but,or',
            ],
            'lazy_loading' => false,
        ];

        if ($file)
        {
            $this->setFile($file);
        }

        if ($attributes)
        {
            $this->setFromOldAttributes($attributes);
        }
    }

    public static function cleanPath($path)
    {
        $path      = str_replace('\\', '/', $path);
        $path_site = str_replace('\\', '/', JPATH_SITE) . '/';

        if (strpos($path, $path_site) === 0)
        {
            $path = substr($path, strlen($path_site));
        }

        $path = ltrim(str_replace(JUri::root(), '', $path), '/');
        $path = strtok($path, '?');
        $path = strtok($path, '#');

        return $path;
    }

    public function createResizeFolder()
    {
        $path = $this->getResizeFolder();

        if (is_dir($path))
        {
            return $this;
        }

        if ( ! @mkdir($path, 0755, true))
        {
            $this->settings->resize->folder = '';
        }

        return $this;
    }

    public function exists($file = null)
    {
        $file = urldecode($file ?: $this->input->file_path);

        return file_exists($file) && is_file($file);
    }

    public function getAlt()
    {
        if (isset($this->attributes->alt))
        {
            return $this->attributes->alt;
        }

        $alt = $this->getDataFileDataByType('alt');

        if ( ! is_null($alt))
        {
            return htmlentities($alt);
        }

        return $this->getTitle(true);
    }

    public function getDataFileData()
    {
        $image_data = $this->getFolderFileData();

        return $image_data[$this->getFileStem()] ?? null;
    }

    public function getDataFileDataByType($type = 'title')
    {
        $image_data = $this->getDataFileData();

        if (isset($image_data[$type]))
        {
            return $image_data[$type];
        }

        $default_data = $this->getDefaultDataFileData();

        return $default_data[$type] ?? null;
    }

    public function getDefaultDataFileData()
    {
        $image_data = $this->getFolderFileData();

        return $image_data['*'] ?? null;
    }

    public function getDescription()
    {
        if ( ! is_null($this->description))
        {
            return $this->description;
        }

        return $this->getDataFileDataByType('description');
    }

    public function setDescription($description)
    {
        return $this->description = $description;
    }

    public function getFile()
    {
        return $this->input->file;
    }

    public function getFileExtension()
    {
        return $this->input->file_extension;
    }

    public function getFileInfo($file, $file_path)
    {
        $file_path = urldecode($file_path);

        $file_exists = $this->exists($file_path);

        $path_info = $file_exists ? pathinfo($file_path) : null;
        $size_info = $file_exists ? getimagesize($file_path) : null;

        return (object) [
            'folder'         => File::getDirName($file),
            'folder_path'    => $path_info['dirname'] ?? null,
            'file'           => $file,
            'file_path'      => $file_path,
            'file_name'      => $path_info['basename'] ?? null,
            'file_stem'      => $path_info['filename'] ?? null,
            'file_extension' => $path_info['extension'] ?? null,
            'mime'           => $size_info['mime'] ?? null,
            'width'          => $size_info[0] ?? null,
            'height'         => $size_info[1] ?? null,
        ];
    }

    public function getFileName()
    {
        return $this->input->file_name;
    }

    public function getFilePath()
    {
        return $this->input->file_path;
    }

    public function getFileStem()
    {
        return $this->input->file_stem;
    }

    public function getFolder()
    {
        return $this->input->folder;
    }

    public function getFolderPath()
    {
        return $this->input->folder_path;
    }

    public function getHeight()
    {
        return $this->output->height;
    }

    public function getOriginalHeight()
    {
        return $this->input->height;
    }

    public function getOriginalWidth()
    {
        return $this->input->width;
    }

    public function getOutputFile()
    {
        if (File::isExternal($this->input->file) || ! $this->exists())
        {
            return $this->input->file;
        }

        return $this->output->file;
    }

    /**
     * @depecated Use getOutputFile() instead
     */
    public function getPath()
    {
        return $this->getOutputFile();
    }

    public function getSrcSet($pixel_density = null)
    {
        if (File::isExternal($this->input->file))
        {
            return null;
        }

        if ( ! $this->settings->resize->use_retina)
        {
            return null;
        }

        if ($this->input->file_path == $this->output->file_path)
        {
            return null;
        }

        $pixel_density = $pixel_density ?: $this->settings->resize->retina_pixel_density;
        $single        = $this->getOutputFile();
        $double        = $this->getOutputFile2x();

        if ($double == $single)
        {
            return null;
        }

        return $double . ' ' . ((float) $pixel_density) . 'x, ' . $single . ' 1x';
    }

    public function getTagAttributes()
    {
        $ordered_keys = [
            'src',
            'srcset',
            'alt',
            'title',
            'width',
            'height',
            'class',
            'lazy_loading',
        ];

        krsort($ordered_keys);

        $this->attributes         = $this->attributes ?: (object) [];
        $this->attributes->src    = $this->getOutputFile();
        $this->attributes->srcset = $this->getSrcset();
        $this->attributes->alt    = $this->getAlt();
        $this->attributes->title  = $this->getTitle(true);
        $this->attributes->width  = $this->output->width;
        $this->attributes->height = $this->output->height;

        if ($this->settings->lazy_loading)
        {
            $this->attributes->loading = 'lazy';
        }

        $attributes = (array) $this->attributes;

        foreach ($ordered_keys as $key)
        {
            if ( ! key_exists($key, $attributes))
            {
                continue;
            }

            $value = $attributes[$key];
            unset($attributes[$key]);

            $attributes = array_merge([$key => $value], $attributes);
        }

        return (object) $attributes;
    }

    public function getTitle($force = false)
    {
        if (isset($this->attributes->title))
        {
            return $this->attributes->title;
        }

        $title = $this->getDataFileDataByType('title');

        if ( ! is_null($title))
        {
            // Remove HTML tags
            $title = strip_tags($title);

            return htmlentities($title);
        }

        return $this->getTitleFromName($force);
    }

    public function getWidth()
    {
        return $this->output->width;
    }

    public function isResized()
    {
        if ( ! is_null($this->is_resized))
        {
            return $this->is_resized;
        }

        $this->is_resized = false;

        $parent_folder_name = File::getBaseName($this->input->folder_path);
        $resize_folder_name = $this->settings->resize->folder;

        // Image is not inside the resize folder
        if ($parent_folder_name != $resize_folder_name)
        {
            return false;
        }

        $parent_folder = File::getDirName($this->input->folder_path);
        $file_name     = $this->input->file_name;

        // Check if image with same name exists in parent folder
        if ($this->exists($parent_folder . '/' . StringHelper::utf8_decode($file_name)))
        {
            $this->is_resized = true;

            return true;
        }

        // Remove any dimensions from the file
        // image_300x200.jpg => image.jpg
        $file_name = RegEx::replace(
            '_[0-9]+x[0-9]*(\.[^.]+)$',
            '\1',
            $file_name
        );

        // Check again if image with same name (but without dimensions) exists in parent folder
        if ($this->exists($parent_folder . '/' . StringHelper::utf8_decode($file_name)))
        {
            $this->is_resized = true;

            return true;
        }

        return false;
    }

    public function render($outer_class = '')
    {
        $attributes = (array) $this->getTagAttributes();

        $image_tag = '<img ' . HtmlTag::flattenAttributes($attributes) . ' />';

        if ( ! $outer_class)
        {
            return $image_tag;
        }

        return '<div class="' . htmlspecialchars($outer_class) . '">'
            . $image_tag
            . '</div>';
    }

    /**
     * @depecated Use render() instead
     */
    public function renderTag()
    {
        return $this->render($this->attributes->{'outer-class'} ?? '');
    }

    public function setAlt($alt)
    {
        return $this->setTagAttribute('alt', $alt);
    }

    public function setAutoTitles($enabled, $title_format = 'titlecase', $lowercase_words = 'a,the,to,at,in,with,and,but,or')
    {
        $this->settings->title->enabled         = $enabled;
        $this->settings->title->format          = $title_format;
        $this->settings->title->lowercase_words = $lowercase_words;

        return $this;
    }

    public function setDimensions($width, $height)
    {
        $this->setResizeMethod(empty($width) || empty($height) ? 'scale' : 'crop');

        return $this->handleDimensions($width, $height);
    }

    public function setEnableResize($enabled)
    {
        $this->settings->resize->enabled = $enabled;

        return $this;
    }

    public function setFile($file)
    {
        $this->input = File::isExternal($file)
            ? $this->getFileInfo($file, $file)
            : $this->getFileInfo(self::cleanPath($file), JPATH_ROOT . '/' . ltrim(self::cleanPath($file), '/'));

        $this->output = clone $this->input;

        return $this;
    }

    public function setHeight($height)
    {
        $this->handleDimensions(0, $height);

        return $this;
    }

    public function setItemProp($itemprop)
    {
        $itemprop = $itemprop ? 'image' : null;
        $this->setTagAttribute('itemprop', $itemprop);

        return $this;
    }

    public function setLazyLoading($enabled)
    {
        $this->settings->lazy_loading = $enabled;

        return $this;
    }

    public function setLowerCaseWords($words)
    {
        $this->settings->title->lowercase_words = $words;

        return $this;
    }

    public function setResizeFolder(string $folder = 'resized')
    {
        $this->settings->resize->folder = $folder;

        return $this;
    }

    /**
     * @param int $age Age in days
     *
     * @return $this
     */
    public function setResizeMaxAge(int $age)
    {
        $this->settings->resize->max_age = $age;

        return $this;
    }

    public function setResizeMethod($method)
    {
        $this->settings->resize->method = $method;

        return $this;
    }

    public function setResizeQuality($quality)
    {
        $this->settings->resize->quality = $this->parseQuality($quality);

        return $this;
    }

    public function setRetinaPixelDensity($pixel_density)
    {
        $this->settings->resize->retina_pixel_density = $pixel_density;

        return $this;
    }

    public function setTagAttribute($key, $value)
    {
        if (is_null($this->attributes))
        {
            $this->attributes = (object) [];
        }

        $this->attributes->{$key} = $value;

        return $this;
    }

    public function setTagAttributes(object $attributes)
    {
        foreach ($attributes as $key => $value)
        {
            $this->setTagAttribute($key, $value);
        }

        return $this;
    }

    public function setTitle($title)
    {
        return $this->setTagAttribute('title', $title);
    }

    public function setUseRetina($use_retina)
    {
        $this->settings->resize->use_retina = $use_retina;

        return $this;
    }

    public function setWidth($width)
    {
        $this->handleDimensions($width, 0);

        return $this;
    }

    private function getFolderFileData()
    {
        $folder = $this->getFolderPath();

        if (isset(self::$data_files[$folder]))
        {
            return self::$data_files[$folder];
        }

        self::$data_files[$folder] = [];

        if ( ! $this->exists($folder . '/data.txt'))
        {
            return self::$data_files[$folder];
        }

        $data = file_get_contents($folder . '/data.txt');

        $data = str_replace("\r", '', $data);
        $data = explode("\n", $data);

        foreach ($data as $data_line)
        {
            if (empty($data_line)
                || $data_line[0] == '#'
                || strpos($data_line, '=') === false
            )
            {
                continue;
            }

            [$key, $val] = explode('=', $data_line, 2);
            if ( ! RegEx::match('^(?<file>.*?)\[(?<type>.*)\]$', $key, $match))
            {
                continue;
            }

            $file = $match['file'];
            $type = $match['type'];

            if ( ! isset(self::$data_files[$folder][$file]))
            {
                self::$data_files[$folder][$file] = [];
            }

            self::$data_files[$folder][$file][$type] = $val;
        }

        return self::$data_files[$folder];
    }

    private function getLowercaseWords()
    {
        $words = $this->settings->title->lowercase_words;
        $words = ArrayHelper::implode($words, ',');
        $words = StringHelper::strtolower($words);

        return explode(',', ' ' . str_replace(',', ' , ', $words . ' '));
    }

    private function getOutputFile2x()
    {
        if (File::isExternal($this->input->file))
        {
            return $this->getOutputFile();
        }

        $double_width  = $this->output->width * 2;
        $double_height = $this->output->height * 2;

        if ($double_width == $this->input->width && $double_height == $this->input->height)
        {
            return $this->getOutputFile();
        }

        $double_size = ObjectHelper::clone($this);
        $double_size->setDimensions($double_width, $double_height);

        return $double_size->getOutputFile();
    }

    private function getResizeBoundry()
    {
        if (($this->input->width / $this->output->width) > ($this->input->height / $this->output->height))
        {
            return 'width';
        }

        return 'height';
    }

    private function getResizeDimensions()
    {
        if ( ! $this->output->width)
        {
            return [null, $this->output->height];
        }

        if ( ! $this->output->height)
        {
            return [$this->output->width, null];
        }

        if (($this->input->width / $this->output->width) > ($this->input->height / $this->output->height))
        {
            return [null, $this->output->height];
        }

        return [$this->output->width, null];
    }

    private function getResizeFolder()
    {
        if ( ! $this->settings->resize->folder)
        {
            $this->setResizeFolder();
        }

        return $this->getFolder() . '/' . $this->settings->resize->folder;
    }

    private function getResizeFolderPath()
    {
        if ( ! $this->settings->resize->folder)
        {
            $this->setResizeFolder();
        }

        return $this->getFolderPath() . '/' . $this->settings->resize->folder;
    }

    private function getResizedFileName()
    {
        return $this->input->file_stem . '_' . $this->output->width . 'x' . $this->output->height . '.' . $this->input->file_extension;
    }

    private function getTitleFromName($force = false)
    {
        if ( ! $force && ! $this->settings->title->enabled)
        {
            return '';
        }

        $title = StringHelper::toSpaceSeparated($this->input->file_stem);

        switch ($this->settings->title->format)
        {
            case 'lowercase':
                return StringHelper::strtolower($title);

            case 'uppercase':
                return StringHelper::strtoupper($title);

            case 'uppercase_first':
                return StringHelper::strtoupper(StringHelper::substr($title, 0, 1))
                    . StringHelper::strtolower(StringHelper::substr($title, 1));

            case 'titlecase':
                return function_exists('mb_convert_case')
                    ? mb_convert_case(StringHelper::strtolower($title), MB_CASE_TITLE)
                    : ucwords(strtolower($title));

            case 'titlecase_smart':
                $title           = function_exists('mb_convert_case')
                    ? mb_convert_case(StringHelper::strtolower($title), MB_CASE_TITLE)
                    : ucwords(strtolower($title));
                $lowercase_words = $this->getLowercaseWords();

                return str_ireplace($lowercase_words, $lowercase_words, $title);

            default:
                return $title;
        }
    }

    private function handleDimensions($width = 0, $height = 0)
    {
        if ( ! $this->exists($this->output->file_path))
        {
            return $this;
        }

        $this->output->width  = (int) $width;
        $this->output->height = (int) $height;

        // Width and height are both not set, so revert to original dimensions
        if ( ! $this->output->height && ! $this->output->width)
        {
            $this->output->width  = $this->input->width;
            $this->output->height = $this->input->height;

            return $this;
        }

        if ($this->settings->resize->method == 'crop')
        {
            $this->output->width  = $this->output->width ?: $this->output->height;
            $this->output->height = $this->output->height ?: $this->output->width;

            return $this->resize();
        }

        // Width and height are both set
        if ($this->output->width && $this->output->height)
        {
            $boundry = $this->getResizeBoundry();

            $this->output->width  = $boundry == 'width' ? $this->output->width : round($this->output->height / $this->input->height * $this->input->width);
            $this->output->height = $boundry == 'height' ? $this->output->height : round($this->output->width / $this->input->width * $this->input->height);

            return $this->resize();
        }

        $this->output->width  = $this->output->width ?: round($this->output->height / $this->input->height * $this->input->width);
        $this->output->height = $this->output->height ?: round($this->output->width / $this->input->width * $this->input->height);

        return $this->resize();
    }

    private function limitDimensions()
    {
        if ($this->output->width <= $this->input->width && $this->output->height <= $this->input->height)
        {
            return;
        }

        if ($this->output->width > $this->input->width)
        {
            $this->output->height = $this->output->height / $this->output->width * $this->input->width;
            $this->output->width  = $this->input->width;
        }

        if ($this->output->height > $this->input->height)
        {
            $this->output->width  = $this->output->width / $this->output->height * $this->input->height;
            $this->output->height = $this->input->height;
        }

        $this->output->width  = round($this->output->width);
        $this->output->height = round($this->output->height);
    }

    private function parseQuality($quality = 90)
    {
        if (is_int($quality))
        {
            return $quality;
        }

        switch ($quality)
        {
            case 'low':
                return 30;

            case 'medium':
                return 60;

            case 'high':
            default:
                return 90;
        }
    }

    /**
     * Method to create a resized version of the current image and save them to disk
     *
     * @return  Image
     */
    private function resize(string $width = null, string $height = null, int $quality = null)
    {
        if ( ! $this->settings->resize->enabled)
        {
            return $this;
        }

        if ($this->isResized())
        {
            return $this;
        }

        if (File::isExternal($this->input->file))
        {
            return $this;
        }

        if ( ! is_null($width) || ! is_null($height))
        {
            $this->setDimensions($width, $height);
        }

        if ( ! is_null($quality))
        {
            $this->setResizeQuality($quality);
        }

        if ($this->output->width == $this->input->width
            && $this->output->height == $this->input->height
        )
        {
            $this->output = $this->input;

            return $this;
        }

        $this->limitDimensions();

        $file                    = $this->getResizedFileName();
        $this->output->file      = $this->getResizeFolder() . '/' . $file;
        $this->output->file_path = $this->getResizeFolderPath() . '/' . $file;

        $file_exists      = $this->exists($this->output->file_path);
        $file_is_outdated = false;

        if ($file_exists && $this->settings->resize->max_age > 0)
        {
            $max_age_in_seconds = $this->settings->resize->max_age * 60 * 60 * 24;
            $min_time           = time() - $max_age_in_seconds;

            $file_is_outdated = filemtime($this->output->file_path) < $min_time;
        }

        if ($file_exists && ! $file_is_outdated)
        {
            $this->output = $this->getFileInfo($this->output->file, $this->output->file_path);

            return $this;
        }

        [$resize_width, $resize_height] = $this->getResizeDimensions();

        try
        {
            $resized = ImageManager::make($this->getFilePath())
                ->orientate()
                ->resize($resize_width, $resize_height, function ($constraint) {
                    $constraint->aspectRatio();
                });

            if ($this->settings->resize->method == 'crop'
                || ($this->output->width && $this->output->height)
            )
            {
                $resized->crop($this->output->width, $this->output->height);
            }

            $this->createResizeFolder();
            $resized->save($this->output->file, $this->settings->resize->quality);
        }
        catch (NotReadableException $exception)
        {
            $resized = null;
        }

        if ( ! $resized)
        {
            $this->output     = $this->input;
            $this->is_resized = false;
        }

        $this->output = $this->getFileInfo($this->output->file, $this->output->file_path);

        return $this;
    }

    private function setFromOldAttributes($attributes)
    {
        if (isset($attributes->alt))
        {
            $this->setAlt($attributes->alt);
        }
        if (isset($attributes->title))
        {
            $this->setTitle($attributes->title);
        }
        if (isset($attributes->class))
        {
            $this->setTagAttribute('class', $attributes->class);
        }
        if (isset($attributes->{'outer-class'}))
        {
            $this->setTagAttribute('outer-class', $attributes->{'outer-class'});
        }
        if (isset($attributes->{'resize-folder'}))
        {
            $folder = File::getBaseName($attributes->{'resize-folder'});
            $this->setResizeFolder($folder);
        }
        if (isset($attributes->quality))
        {
            $this->setResizeQuality($attributes->quality);
        }

        $this->setDimensions($attributes->width ?? 0, $attributes->height ?? 0);
    }
}
