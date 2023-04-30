<?php

/**
 * @author          Tassos.gr
 * @link            http://www.tassos.gr
 * @copyright       Copyright © 2022 Tassos Marinos All Rights Reserved
 * @license         GNU GPLv3 <http://www.gnu.org/licenses/gpl.html> or later
*/

namespace NRFramework\SmartTags;

use NRFramework\Conditions\Conditions\Component\ContentBase;
use Joomla\CMS\Factory;
use NRFramework\Cache;
use Joomla\Registry\Registry;

defined('_JEXEC') or die('Restricted access');

class Article extends SmartTag
{
    /**
     * The data object of the article loaded
     *
     * @var mixed
     */
    protected $article;

    /**
     * Class constructor
     *
     * @param [type] $factory
     * @param [type] $options
     */
    public function __construct($factory = null, $options = null)
    {
        parent::__construct($factory, $options);

        $article_id = $this->parsedOptions->get('id', null);

        $contentAssignment = new ContentBase();
        
        $this->article = $contentAssignment->getItem($article_id);
    }

    /**
     * Fetch a property from the User object
     *
     * @param   string  $key   The name of the property to return
     *
     * @return  mixed   Null if property is not found, mixed if property is found
     */
    public function fetchValue($key)
    {
        if (!$this->article)
        {
            return;
        }

        // Case SEF URL: {article.link}
        if ($key == 'link')
        {
            return \JRoute::_(\Joomla\Component\Content\Site\Helper\RouteHelper::getArticleRoute($this->article->id, $this->article->catid, $this->article->language));
        }

        // Case custom fields: {article.field.age}
        if (strpos($key, 'field.') !== false)
        {
            $fieldname = str_replace('field.', '', $key);

            if ($fields = $this->fetchCustomFields())
            {
                if (array_key_exists($fieldname, $fields))
                {
                    return $fields[$fieldname]->value;
                }
            }

            return;
        }

        $articleRegistry = new Registry($this->article);

        return $articleRegistry->get($key);
    }

    /**
     * Return an assosiative array with user custoom fields
     *
     * @return mixed    Array on success, null on failure
     */
    private function fetchCustomFields()
    {
        if (!$this->article)
        {
            return;
        }

        $callback = function()
        { 
            \JLoader::register('FieldsHelper', JPATH_ADMINISTRATOR . '/components/com_fields/helpers/fields.php');
    
            if (!$fields = \FieldsHelper::getFields('com_content.article', $this->article, true))
            {
                return;
            }

            $fieldsAssoc = [];

            foreach ($fields as $field)
            {
                $fieldsAssoc[$field->name] = $field;
            }

            return $fieldsAssoc;
        };

        return Cache::memo('fetchCustomFields' . $this->article->id, $callback);
    }
}