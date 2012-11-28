<?php

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');

class bisViewDetail extends JView {

    function display($tpl = null) {
        global $mainframe;

        $pparams = &$mainframe->getParams('com_contact');

        $model = new bisModelBis;
        $query = $model->buildQuery($pparams);
        $result = $model->getResult($query['query']);
        $formatted_result_text = $model->getFormattedResult($result, $pparams);

        $this->assignRef('params', $pparams);
        $this->assignRef('formatted_result_text', $formatted_result_text);

        parent::display($tpl);
    }

}
