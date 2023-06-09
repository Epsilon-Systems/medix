<?php

/**
 * @copyright     Copyright (c) 2009-2022 Ryan Demmer. All rights reserved
 * @license       GNU/GPL 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * JCE is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses
 */
defined('JPATH_PLATFORM') or die;

require_once WF_EDITOR_LIBRARIES . '/classes/manager.php';

class WFBrowserPlugin extends WFMediaManager
{
    /*
     * @var string
     */
    protected $_filetypes = 'doc,docx,dot,dotx,ppt,pps,pptx,ppsx,xls,xlsx,gif,jpeg,jpg,png,webp,apng,avif,pdf,zip,tar,gz,swf,rar,mov,mp4,m4a,flv,mkv,webm,ogg,ogv,qt,wmv,asx,asf,avi,wav,mp3,aiff,oga,odt,odg,odp,ods,odf,rtf,txt,csv';

    private function isMediaField()
    {
        $app = JFactory::getApplication();
        return $app->input->getInt('standalone') && $app->input->getString('mediatype') && $app->input->getCmd('fieldid');
    }

    /**
     * Get a parameter by key.
     *
     * @param string $key        Parameter key eg: editor.width
     * @param mixed  $fallback   Fallback value
     * @param mixed  $default    Default value
     * @param string $type       Variable type eg: string, boolean, integer, array
     *
     * @return mixed
     */
    public function getParam($key, $fallback = '', $default = '', $type = 'string')
    {
        $wf = WFApplication::getInstance();
        
        $value = parent::getParam($key, $fallback, $default, $type);

        // get all keys
        $keys = explode('.', $key);

        // get caller if any
        $caller = $this->get('caller');

        // create new namespaced key
        if ($caller && ($keys[0] === $caller || count($keys) == 1)) {
            // create new key
            $key = $caller . '.' . 'browser' . '.' . array_pop($keys);	
            // get namespaced value, fallback to base parameter
            $value = $wf->getParam($key, $value, $default, $type);
        }

        return $value;
    }
    
    protected function getFileBrowserConfig($config = array())
    {
        $app = JFactory::getApplication();
        
        $config = parent::getFileBrowserConfig($config);

        // update folder path if a value is passed from a mediafield url
        if ($this->isMediaField()) {
            $folder = $app->input->getString('mediafolder', '');

            if ($folder) {
                if (empty($config['dir'])) {
                    $config['dir'] = 'images';
                }
                
                $config['dir'] = WFUtility::makePath($config['dir'], trim(rawurldecode($folder)));
            }
        }

        return $config;
    }
    
    public function __construct($config = array())
    {
        $app = JFactory::getApplication();

        $config = array(
            'layout' => 'browser',
            'can_edit_images' => 1,
            'show_view_mode' => 1,
        );

        parent::__construct($config);

        // get mediatype from xml
        $mediatype = $app->input->getString('mediatype', $app->input->getString('filter', 'files'));

        if ($mediatype) {
            // clean and lowercase filter value
            $mediatype = (string) preg_replace('/[^\w_,]/i', '', strtolower($mediatype));

            // get filetypes from params
            $filetypes = $this->getParam('extensions', $this->get('_filetypes'));

            // get file browser reference
            $browser = $this->getFileBrowser();

            // add upload event
            $browser->addEvent('onUpload', array($this, 'onUpload'));

            // map to comma seperated list
            $filetypes = $browser->getFileTypes('list', $filetypes);

            $map = array(
                'images' => 'jpg,jpeg,png,apng,gif,webp,avif',
                'media' => 'avi,wmv,wm,asf,asx,wmx,wvx,mov,qt,mpg,mpeg,m4a,m4v,swf,dcr,rm,ra,ram,divx,mp4,ogv,ogg,webm,flv,f4v,mp3,ogg,wav,xap',
                'documents' => 'doc,docx,odg,odp,ods,odt,pdf,ppt,pptx,txt,xcf,xls,xlsx,csv',
                'html' => 'html,htm,txt,md',
                'files' => $filetypes,
            );

            // add svg support to images if it is allowed in filetypes
            if (in_array('svg', explode(',', $filetypes))) {
                $map['images'] .= ',svg';
            }

            $accept = explode(',', $filetypes);

            if (array_key_exists($mediatype, $map)) {
                // process the map to filter permitted extensions
                array_walk($map, function (&$item, $key) use ($accept) {
                    $items = explode(',', $item);

                    $values = array_intersect($items, $accept);
                    $item = empty($values) ? '' : implode(',', $values);
                });

                $filetypes = $map[$mediatype];
            } else {
                $filetypes = implode(',', array_intersect(explode(',', $mediatype), $accept));
            }

            // set updated filetypes
            $this->setFileTypes($filetypes);
        }
    }

    public function setFileTypes($filetypes = '')
    {
        // get file browser reference
        $browser = $this->getFileBrowser();
        
        // set updated filetypes
        $browser->setFileTypes($filetypes);
    }

    /**
     * Display the plugin.
     */
    public function display()
    {
        parent::display();

        $app = JFactory::getApplication();

        $document = WFDocument::getInstance();
        $slot = $app->input->getCmd('slot', 'plugin');

        // update some document variables
        $document->setName('browser');
        $document->setTitle(JText::_('WF_BROWSER_TITLE'));

        if ($document->get('standalone') == 1) {
            if ($slot === 'plugin') {
                $document->addScript(array('window.min'));

                $callback = $app->input->getCmd('callback', '');
                $element = $app->input->getCmd('fieldid', 'field-media-id');

                // Joomla 4 field variable not converted
                if ($element == 'field-media-id') {
                    $element = $app->input->getCmd('element', '');
                }

                $settings = array(
                    'site_url' => JURI::base(true) . '/',
                    'document_base_url' => JURI::root(),
                    'language' => WFLanguage::getCode(),
                    'element' => $element,
                    'token' => JSession::getFormToken(),
                );

                if ($callback) {
                    $settings['callback'] = $callback;
                }

                $document->addScriptDeclaration('tinymce.settings=' . json_encode($settings) . ';');
            }

            $document->addScript(array('popup.min'), 'plugins');
            $document->addStyleSheet(array('browser.min'), 'plugins');
        }

        if ($slot === 'plugin') {
            $document->addScript(array('browser'), 'plugins');
        }
    }

    public function onUpload($file, $relative = '')
    {
        parent::onUpload($file, $relative);

        $app = JFactory::getApplication();

        // inline upload
        if ($app->input->getInt('inline', 0) === 1) {
            $result = array(
                'file' => $relative,
                'name' => basename($file),
            );

            return $result;
        }

        return array();
    }
}
