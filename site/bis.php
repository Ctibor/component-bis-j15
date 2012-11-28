<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

// Require the base controller
require_once (JPATH_COMPONENT . DS . 'controller.php');
//Require model
require_once (JPATH_COMPONENT . DS . 'models' . DS . 'bis.php'); 

// Create the controller
$controller = new bisController;

// Perform the Request task
$controller->execute(JRequest::getVar('task'));

// Redirect if set by the controller
$controller->redirect();



