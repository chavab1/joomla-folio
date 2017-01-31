<?php
/**
 * @package     com_library
 * @copyright   Copyright (C) 2013 NCJFCJ. All rights reserved.
 * @author      NCJFCJ <zdraper@ncjfcj.org> - http://ncjfcj.org
 */

// no direct access
defined('_JEXEC') or die;

// Access check.
if(!JFactory::getUser()->authorise('core.manage', 'com_folio')){
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependancies
jimport('joomla.application.component.controller');

$controller	= JControllerLegacy::getInstance('Folio');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();