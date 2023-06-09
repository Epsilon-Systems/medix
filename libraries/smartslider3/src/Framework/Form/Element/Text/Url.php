<?php


namespace Nextend\Framework\Form\Element\Text;


use Nextend\Framework\Asset\Js\Js;
use Nextend\Framework\Form\Element\AbstractChooserText;
use Nextend\Framework\Pattern\MVCHelperTrait;
use Nextend\Framework\Platform\Platform;

class Url extends AbstractChooserText {

    protected function addScript() {
        Js::addInline("new _N2.FormElementUrl('" . $this->fieldID . "', " . $this->getElementUrlParameters($this->getForm()) . " );");
    }

    /**
     * @param MVCHelperTrait $MVCHelper
     *
     * @return string
     */
    private function getElementUrlParameters($MVCHelper) {
        $params = array(
            'hasPosts' => Platform::hasPosts()
        );

        $params['url'] = $MVCHelper->createAjaxUrl("content/searchlink");
        $params['labelButton']      = 'Joomla';
        $params['labelDescription'] = n2_(/** @lang text */ 'Select article or menu item from your site.');
    

        return json_encode($params);
    }

    protected function post() {

        return parent::post();
    }

    /**
     * @param int $width
     */
    public function setWidth($width) {
        $this->width = $width;
    }

}