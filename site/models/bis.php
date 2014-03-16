<?php

// No direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

//We need content plugin BIS to be installed !!!
require_once (JPATH_BASE . DS . 'plugins' . DS . 'content' . DS . 'myr' . DS . 'myr.php');

class bisModelBis extends JModel {

    public function buildQuery($params) {
        //Get parameters
        $show_type = $params->get('show-type');
        $bis_id = $params->get('bis_id');
        $custom_query = $params->get('custom-query');
        $paging = $params->get('limit-count');
        //$sort_by = $params->get('sort-by');
        $only_year = $params->get('only-year');
        $only_program = $params->get('only-program');

        //Ret value
        $ret = array('query' => '', 'result_modify' => '');


        //Custom query
        if ($show_type == 'custom') {
            if (strlen($custom_query) > 0) {
                $ret['query'] = $custom_query;
                if (strlen($bis_id) > 0) {
		            $ret['query'].="&id=$bis_id";
                }
                return $ret;
            } else {
                $ret['query'] = 'query=akce';
                if (strlen($bis_id) > 0) {
		            $ret['query'].="&id=$bis_id";
                }
                return $ret;
            }
        }

        //Base query
        switch ($show_type) {
            case 'all':
                $ret['query'] = 'query=akce';
                break;
            /* case 'all-tab':
              $ret['query'] = 'query=akce';
              break; */
            case 'vik':
                $ret['query'] = 'query=akce&filter=vik';
                break;
            case 'tabor':
                $ret['query'] = 'query=akce&filter=tabor';
                break;
            case 'klub':
                $ret['query'] = 'query=akce&filter=klub';
                break;
        }

        if (strlen($bis_id) > 0) {
            $ret['query'].="&id=$bis_id";
        }

        //Additional params
        //Paging
        if (strlen($paging) > 0 && intval($paging) > 0) {
            $ret['query'].='&limit_from=0&limit_count=' . $paging;
        }

        //Sort by
        /* if (strlen($sort_by) > 0) {
          //TODO - not yet implemented by MYR/BIS
          $ret['query'].='&order=' . $sort_by;
          } */

        //Only year
        if (strlen($only_year) > 0 && intval($only_year) > 1970) {
            $ret['query'].='&rok=' . $only_year;
        }

        //Only program
        if (strlen($only_program) > 0) {
            $ret['query'].='&program=' . $only_program;
        }

        return $ret;
    }

    //Get result
    public function getResult($query) {
        $myr = new myr;
        $result = $myr->doQuery($query);
        return $result;
    }

    public function getFormattedResult($result, $params, $detail = false) {
        $template = new myrTemplateData;

        if ($detail == false) {
            $template->head = $params->get('tpl-head');
            $template->item = $params->get('tpl-item');
            $template->foot = $params->get('tpl-foot');
        } else {
            $template->head = $params->get('tpl-detail-head');
            $template->item = $params->get('tpl-detail-item');
            $template->foot = $params->get('tpl-detail-foot');
        }
        $split_url = preg_split('/\?/', JURI::getInstance()->toString());

        //Set up links
        $links['detail-url'] = $split_url[0];
        $links['detail-url-vik'] = '';
        $links['detail-url-tabor'] = '';
        $links['detail-url-klub'] = '';

        $template->link_detail = $links;

        $myr = new myr;
        return $myr->displayFormattedResult($result, $template);
    }

}
