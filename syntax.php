<?php
/**
 * Description plugin
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Matthias Schulte <dokuwiki@lupo49.de>
 */

// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

if (!defined('DOKU_LF')) define('DOKU_LF', "\n");
if (!defined('DOKU_TAB')) define('DOKU_TAB', "\t");
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');

require_once(DOKU_PLUGIN.'syntax.php');

class syntax_plugin_description extends DokuWiki_Syntax_Plugin {

    function getType() { return 'substition'; }
    function getPType() { return 'block'; }
    function getSort() { return 98; }

    function connectTo($mode) {
        $this->Lexer->addSpecialPattern('\{\{description>.+?\}\}', $mode, 'plugin_description');
    }

    function handle($match, $state, $pos, Doku_Handler $handler) {
        $match = substr($match, 14, -2); // strip markup
        $match = hsc($match);
        
        return array($match);
    }            

    function render($mode, Doku_Renderer $renderer, $data) {
        global $conf;
        global $ID;       
        $description = $data[0];
        if(empty($description)) return false;

        if ($mode == 'metadata') {
            $renderer->meta['plugin_description']['keywords'] = $description;
            return true;
        }
        return false;
    }
}

// vim:ts=4:sw=4:et: 
