<?php
/**
 *  Description action plugin
 *
 *  @lastmodified 2012-07-02
 *  @license      GPL 2 (http://www.gnu.org/licenses/gpl.html)
 *  @author       Ikuo Obataya <I.Obataya@gmail.com>
 *  @author       Matthias Schulte <dokuwiki@lupo49.de>
 *  @version      2012-07-02
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
     * Add an abstract, global value or a specified string to meta header
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
            $a = $metadata['plugin_description']['keywords'];
            if(empty($a)) return;
        }
        
        $m = array("name" => "description", "content" => $a);
        $event->data['meta'][] = $m;
    }
}
