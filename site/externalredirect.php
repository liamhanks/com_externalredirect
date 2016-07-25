<?php
//defined('_JEXEC') or die;

$current = JURI::getInstance();
$current = end(explode('/',$current));

//We need to make sure this redirection is coming from our website. Otherwise anyone could redirect to anywhere from our website (which is really bad).
//Connect to db
$db = JFactory::getDbo();
//Create query object
$query = $db->getQuery(true);

$query->select($db->quoteName(array('cpt','oldurl','newurl')));
$query->from($db->quoteName('#__sh404sef_urls'));
$query->where($db->quoteName('oldurl') . ' = ' . $db->quote($current));
//Set the query
$db->setQuery($query);
//load the results
$results = $db->loadAssoc();

if($results){
	$newurl = parse_url($results['newurl']);
	parse_str($newurl['query'],$redirect);

	$redirect = $redirect['redirect'];

	$app = JFactory::getApplication();
	$app->redirect($redirect);
}else{
	$app = JFactory::getApplication();
	$app->enqueueMessage('Address does not exist!', 'error');
}
?>