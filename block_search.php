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
 * @package   block_search
 * @category  blocks
 * @author    Michael Champanis (mchampan)
 * @author    Valery Fremaux (valery.fremaux@gmail.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

class block_search extends block_base {

    protected $siteconfig;

    public function init() {
        $this->title = get_string('pluginname', 'block_search');
        $this->siteconfig = get_config('block_search');
    }

    // Only one instance of this block is required.
    public function instance_allow_multiple() {
        return false;
    }

    // Label and button values can be set in admin.
    public function has_config() {
        return true;
    }

    public function get_content() {
        global $config;

        $config = get_config('local_search');

        // Cache block contents.
        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new Stdclass;

        if (empty($config->enable)) {
            $this->content->text = get_string('disabledsearch', 'local_search');
            return $this->content;
        }

        $this->content = new stdClass;

        // Fetch values if defined in admin, otherwise use defaults.
        $label = (!empty($this->siteconfig->text)) ? $this->siteconfig->text : get_string('searchmoodle', 'block_search');
        $button = (!empty($this->siteconfig->button)) ? $this->siteconfig->button : get_string('go', 'block_search');

        // Basic search form.
        $searchurl = new moodle_url('/local/search/query.php');

        $this->content->text = '<form id="searchquery" method="get" action="'.$searchurl.'"><div>';
        $this->content->text .= '<label for="block_search_q">'. $label .'</label>';
        $this->content->text .= '<input id="block_search_q" type="text" name="query_string" />';
        $this->content->text .= '<input type="submit" value="'.$button.'" />';
        $this->content->text .= '</div></form>';

        // No footer, thanks.
        $this->content->footer = '';

        return $this->content;
    }

    public function specialisation() {
    }

    /**
     * Wraps up to search engine cron.
     *
     */
    public function cron(){
        global $CFG;
    }

    /**
     * Default behavior: save all variables as $CFG properties
     * You don't need to override this if you 're satisfied with the above
     *
     * @param array $data
     * @return boolean
     */
    public function config_save($data) {
        foreach ($data as $name => $value) {
            set_config($name, $value, 'block_search');
        }
        return true;
    }
}

