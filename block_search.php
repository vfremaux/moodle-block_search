<?php 
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * This is the global search shortcut block - a single query can be entered, and
 * the user will be redirected to the query page where they can enter more
 * advanced queries, and view the results of their search. When searching from
 * this block, the broadest possible selection of documents is searched.
 *
 * Todo: make strings -> get_string()
 *
 * @package block_search
 * @author: Michael Champanis (mchampan), reengineered by Valery Fremaux 
 */

class block_search extends block_base {
    
    var $siteconfig;

    function init() {
        $this->title = get_string('pluginname', 'block_search');
        $this->siteconfig = get_config('block_search');
    }

    // only one instance of this block is required
    function instance_allow_multiple() {
        return false;
    }

    // label and button values can be set in admin
    function has_config() {
        return true;
    }

    function get_content() {
        global $CFG;

        if (empty($CFG->enableglobalsearch)) {
            return get_string('disabledsearch', 'local_search');
        }

        // Cache block contents.
        if ($this->content !== NULL) {
            return $this->content;
        }
      
        $this->content = new stdClass;

        // Fetch values if defined in admin, otherwise use defaults.
        $label  = (!empty($this->siteconfig->text)) ? $this->siteconfig->text : get_string('searchmoodle', 'block_search');
        $button = (!empty($this->siteconfig->button)) ? $this->siteconfig->button : get_string('go', 'block_search');

        // Basic search form.
        $searchurl = new moodle_url('/local/search/query.php');

        $this->content->text =
            '<form id="searchquery" method="get" action="'.$searchurl.'"><div>'
          . '<label for="block_search_q">'. $label .'</label>'
          . '<input id="block_search_q" type="text" name="query_string" />'
          . '<input type="submit" value="'.$button.'" />'
          . '</div></form>';

        // No footer, thanks.
        $this->content->footer = '';

        return $this->content;
    }

    function specialisation() {
    }

    /**
     * Wraps up to search engine cron.
     *
     */
    function cron(){
        global $CFG;
    }

    /**
     * Default behavior: save all variables as $CFG properties
     * You don't need to override this if you 're satisfied with the above
     *
     * @param array $data
     * @return boolean
     */
    function config_save($data) {
        print_object($data);
        foreach ($data as $name => $value) {
            set_config($name, $value, 'block_search');
        }
        die;
        return true;
    }
}
