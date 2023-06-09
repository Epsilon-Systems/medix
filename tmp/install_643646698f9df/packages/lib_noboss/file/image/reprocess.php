<?php
/**
 * @package			No Boss Extensions
 * @subpackage  	No Boss Library
 * @author			No Boss Technology <contact@nobosstechnology.com>
 * @copyright		Copyright (C) 2018 No Boss Technology. All rights reserved.
 * @license			GNU Lesser General Public License version 3 or later; see <https://www.gnu.org/licenses/lgpl-3.0.en.html>
 */
defined('_JEXEC') or die('Restricted access');
class NoBossImageReprocess
{
	protected $_file;
	protected $_newdir;
	protected $_adapter;
	protected $_newname;

	/**
	 * Class constructor. 
	 * @param string $file The image which was uploaded by the user
	 * @param string $newdir Directory path of the fresh reprocessed image ex. '/etc/www/'.  
	 * @param string $newname Name of the new file like 'abc'. The class will set the extension automatically.
	 */
	
	public function __construct($file, $newdir = null, $newname = null)
	{
		$this->_file 	= $file;
		$this->_newdir  = $newdir;
		$this->_newname = $newname;
	}
	
	/**
	 * Sets adapter, default is 'GD'. So it will use the GD library by default.
	 * @param string
	 * @return NoBossImageReprocess object 
	 */
	public function setAdapter($adapter)
	{
		if ($adapter == 'GD') {
			$this->_adapter = new Adapter_GD($this->_file, $this->_newdir, $this->_newname);
		}
		elseif ($adapter == 'Imagick')
			//no need mimeType here
			$this->_adapter = new Adapter_Imagick($this->_file, $this->_newdir, $this->_newname);
		return $this;
	}
	
	/**
	 * Reprocess the image - based on the adapter. This will remove exif data as well
	 * The new image will be safe after reprocess.
	 * @return bool This value will be false if something went wrong
	 */
	public function reprocess()
	{
		$mime = $this->checkMime();	
		if ($mime == null) {
			return false;
		}
		return $this->_adapter->reprocess($mime);
	}
	
	/**
	 * Check MIME-type. We will use the fileinfo extension for this.
	 * We call the proper reprocess function based on the returned value of this. 
	 * ! Remember you cannot trust in MIME-type of uploaded images !
	 * @return string The  calculated MIMEType like 'image/jpeg'
	 */
	public function checkMime()
	{
		$mime = null;
		$file = $this->_file;
		
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		if(is_resource($finfo) == false)
			return false;
		
		$mime = finfo_file($finfo, $file);
		finfo_close($finfo);
		
		return $mime;
	}
}

/**
 * Abstract class for the adapter
 */
abstract class Adapter_Abstract 
{
	protected $_file;
	protected $_newdir;
	protected $_newname;

	public function __construct($file, $newdir = null, $newname = null)
	{
		$this->_file 	= $file;
		$this->_newdir  = $newdir;
		$this->_newname = $newname;
	}
	
	/**
	 * @param string The actual MIME Type
	 * @return bool False on fail
	 */
	abstract public function reprocess($mime = null);	
}

/**
 * GD Adapter
 */
class Adapter_GD extends Adapter_Abstract
{
	public function reprocess($mime = null)
	{
		switch ($mime):
			case 'image/jpeg':
				return $this->_reprocessJpeg();
				break;
				
			case 'image/png':
				return $this->_reprocessPng();
				break;
				
			case 'image/gif':
				return $this->_reprocessGif();
				break;
				
			default:
				//handle error
				return false;		
		endswitch;
	}
	
	protected function _reprocessJpeg() 
	{
		$file  = $this->_file;
		$image = @imagecreatefromjpeg($file);
		if (!$image) {
			return false;
		} else {
			$filepath = $this->_newdir.$this->_newname.'.jpg'; 
			imagejpeg($image, $filepath, 80);
		}
		
		//free up memory
		imagedestroy($image);
		return true;
	}
	
	protected function _reprocessPng() 
	{
		$file  = $this->_file;
		$image = @imagecreatefrompng($file);
		if (!$image) {
			return false;
		} else {
			$filepath = $this->_newdir.$this->_newname.'.png'; 
			imagepng($image, $filepath, 8);
		}
		
		imagedestroy($image);
		return true;
	}
	
	protected function _reprocessGif() 
	{
		$file  = $this->_file;
		$image = @imagecreatefromgif($file);
		if (!$image) {
			return false;
		} else {
			$filepath = $this->_newdir.$this->_newname.'.gif'; 
			imagegif($image, $filepath);
		}
		
		imagedestroy($image);
		return true;	
	}	
}

/**
 * Imagick Adapter
 */
class Adapter_Imagick extends Adapter_Abstract
{
	public function reprocess($mime = null)
	{
		try 
		{
	        $img = new Imagick($this->_file);
	        $img->stripImage();
			
			$newname = $this->_createNewFilename($mime);
	        $img->writeImage($newname);
	        $img->clear();
	        $img->destroy();
			return true;
		} catch (Exception $e){
			error_log('Imagick exception caught: '.$e->getMessage());
			return false;
		}
	}
	
	/**
	 * Creates new filename based on the NoBossImageReprocess::checkMime() function
	 */
	protected function _createNewFilename($mime)
	{
		switch ($mime):
			case 'image/jpeg':
				return $this->_newdir.$this->_newname.'.jpg';
				break;
				
			case 'image/png':
				return $this->_newdir.$this->_newname.'.png';
				break;
				
			case 'image/gif':
				return $this->_newdir.$this->_newname.'.gif';
				break;
				
			default:
				//handle error
				return false;		
		endswitch;
	}
}
?>
