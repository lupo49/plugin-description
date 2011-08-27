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

class action_plugin_description extends DokuWiki_Action_Plugin {
  function getInfo(){
      return array( 'author' => "Ikuo Obataya"
                   ,'email'  => 'ikuo.obataya@gmail.com'
                   ,'date'   => '2007-07-21'
                   ,'name'   => "Description action plugin"
                   ,'desc'   => "Add an abstract to a description meta header"
                   ,'url'    => 'http://symplus.edu-wiki.org/en/description_plugin'
                  );
  }
  function register(&$controller) {
      $controller->register_hook('TPL_METAHEADER_OUTPUT','BEFORE',$this,'description',array());
  }
 /**
  * Add a metadata['description']['abstract'] to meta header
  */
  function description(&$event, $param) {
      if(empty($event->data)||empty($event->data['meta'])) return;

      global $ID;
      $d = p_get_metadata($ID,'description');
      if(empty($d)) return;

      $a = str_replace("\n"," ",$d['abstract']);
      if(empty($a)) return;

      $m = array("name"=>"description","content"=>$a);
      $event->data['meta'][] = $m;
  }
}
