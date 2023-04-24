<?php
global $smartSliderCustomGenerators;

if(empty($smartSliderCustomGenerators)){
    $smartSliderCustomGenerators = array();
}

$options = array();

$smartSliderCustomGenerators[] = array(
    'name'    => 'example_generator',
    'label'   => 'Example',
    'options' => $options,
    'records' => 'getRecords'
);

function getRecords($data) {
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);
    $query->select($db->quoteName(array('id')));
    $query->from($db->quoteName('jj19p_categories'));
    
    $db->setQuery($query);
    
    $results = $db->loadObjectList();

    
}