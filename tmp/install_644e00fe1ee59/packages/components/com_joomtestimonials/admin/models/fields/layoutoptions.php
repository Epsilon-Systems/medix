<?php

// No direct access.
defined('_JEXEC') or die;


use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

jimport('joomla.html.html');
jimport('joomla.form.formfield');

/**
 * Supports an HTML select list of Testimonials.
 *
 * @package        Joomla.Administrator
 * @subpakage    JoomBoost.Joomtestimonials
 */
class JFormFieldLayoutOptions extends JFormField
{

    /** @var string        The form field type. */
    protected $type = 'LayoutOptions';

    protected $appInput;

    public function __construct($form = null)
    {
        parent::__construct($form);
        $this->appInput = \Joomla\CMS\Factory::getApplication()->input->get('option');
    }

    /**
     * Method to get the field input markup.
     *
     * @return    string    The field input markup.
     */
    protected function getInput()
    {
        JHtml::_('jquery.framework');

        require_once(JPATH_ADMINISTRATOR . '/components/com_joomtestimonials/helpers/layout.php');
        $document = JFactory::getApplication()->getDocument();
        $InputId = ($this->appInput=='com_config')?'':'params_';
        $document->addScriptOptions('com_joomtestimonials.testimonialslayout',[
            'itemType' => $this->getItemType(),
            'itemId' => Uri::getInstance()->getVar('id'),
            'InputId'=> 'jform_'.$InputId.'testimonials_layout'
        ]);

        HTMLHelper::_('script', 'media/com_joomtestimonials/js/testimonialslayout.js');

        $options = '<a
                         id="iframe"
                         data-bs-target="#iframeHolder"
                         data-bs-toggle="modal"
                         class="btn btn-secondary modal_jform_contenthistory"
                         data-href="index.php?option=com_joomtestimonials&amp;task=testimonials.layoutModal&amp;view=modal&amp;tmpl=component">            
                         
                         <span class="icon-cog"></span>
                         <span>' . Text::_("COM_TESTIMONIALS_CUSTOMISE") . '</span>
                    </a>';

        $modalHTML = HTMLHelper::_('bootstrap.renderModal',
            'iframeHolder',
            array(
                'url' => '',
                'title' => '',
                'closeButton' => true,
                'height' => '100%',
                'width' => '100%',
                'modalWidth' => '60',
                'bodyHeight' => '60',
                'footer' => '<button type="button" id="ResetOptions" class="btn btn-primary"><span class="icon-redo"></span>' . Text::_("Reset") . '</button>'
                    . '<button type="button" id="saveModal" class="btn btn-success"><span class="icon-save"></span>' . Text::_('Save') . '</button>'
                    . '<button type="button" id="closeModal" class="btn btn-danger" data-bs-dismiss="modal"><span class="icon-cancel"></span>' . Text::_('JCANCEL') . '</button>',
            )
        );

        $html = '<div class="input-group">' . $this->getList() . $options . '</div>' . $modalHTML;

        return $html;
    }

    public function getItemType()
    {
        $itemTypes = ['com_menus' => 'menu', 'com_config' => 'global', 'com_modules' => 'module'];
        return $itemTypes[$this->appInput];
    }


    public function getList()
    {
        if ($this->appInput == 'com_config') {
            return HTMLHelper::_(
                'select.genericlist',
                LayoutHelper::getListLayouts(true),
                'jform[testimonials_layout]',
                'class ="form-select valid form-control-success ItemIdHolder"',
                $optKey = 'value',
                $optText = 'text',
                JComponentHelper::getParams('com_joomtestimonials')->get('testimonials_layout'), 'jform_testimonials_layout',
                $translate = true
            );
        }

        return HTMLHelper::_(
            'select.groupedlist',
            LayoutHelper::getLayoutParentTypes(),
            'jform[params][testimonials_layout]',
            array('group.items' => null,
                'id' => 'jform_params_testimonials_layout',
                'list.select' => LayoutHelper::getSelectedValue(),
                'list.translate' => true,
                'list.attr' => 'class ="form-select valid form-control-success ItemIdHolder"')
        );
    }
}