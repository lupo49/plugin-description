<?php
/**
 *  Description action plugin
 *
 *  @lastmodified 2008-07-21
 *  @license      GPL 2 (http://www.gnu.org/licenses/gpl.html)
 *  @author       Ikuo Obataya <I.Obataya@gmail.com>
 *  @version      2010-11-09
 */

if(!defined('DOKU_INC')) die();
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');

require_once(DOKU_PLUGIN.'action.php');

define('KEYWORD_SOURCE_ABSTRACT', 'abstract');
define('KEYWORD_SOURCE_GLOBAL', 'global');
define('KEYWORD_SOURCE_SYNTAX', 'syntax');

class action_plugin_description extends DokuWiki_Action_Plugin {

    function register(&$controller) {
        $controller->register_hook('TPL_METAHEADER_OUTPUT','BEFORE',$this,'description',array());
    }

    /**
     * Add a metadata['description']['abstract'] to meta header
     */
    function description(&$event, $param) {
        if(empty($event->data) || empty($event->data['meta'])) return;
        
        global $ID;
        $source = $this->getConf('keyword_source');
        if(empty($source)) $source = 'abstract';
        
        if($source == KEYWORD_SOURCE_ABSTRACT) {
            $d = p_get_metadata($ID, 'description');
            if(empty($d)) return;
    
            $a = str_replace("\n", " ", $d['abstract']);
            if(empty($a)) return;
        }
        
        if($source == KEYWORD_SOURCE_GLOBAL) {
            $a = $this->getConf('global_description');
            if(empty($a)) return;
        }

        if($source == KEYWORD_SOURCE_SYNTAX) {
            $metadata = p_get_metadata($ID);
            $a = $metadata['plugin_description']['description'];
        }
        
        $m = array("name" => "description", "content" => $a);
        $event->data['meta'][] = $m;
    }
}
