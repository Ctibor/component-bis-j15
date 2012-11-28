<?php

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');

class bisViewList extends JView {

    function display($tpl = null) {
        global $mainframe;

        $session = JFactory::getSession();

        $pparams = &$mainframe->getParams('com_contact');

        $bis_id = JRequest::getVar('bis_id');

        $pparams->set('bis_id', $bis_id);

        $model = new bisModelBis;
        $query = $model->buildQuery($pparams);
        $result = $model->getResult($query['query']);

        if (strlen($bis_id > 0)) {
            $this->assignRef('backlink', $session->get('plg_bis_backlink'));
            $formatted_result_text = $model->getFormattedResult($result, $pparams, true);
        } else {
            $session->set('plg_bis_backlink', JURI::getInstance()->toString());
            $formatted_result_text = $model->getFormattedResult($result, $pparams);
        }
        $this->assignRef('bis_id', $bis_id);
        $this->assignRef('params', $pparams);
        $this->assignRef('formatted_result_text', $formatted_result_text);

        parent::display($tpl);
    }

}
