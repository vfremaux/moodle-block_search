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

defined('MOODLE_INTERNAL') || die();

/**
 * @package   block_search
 * @category  blocks
 * @author   Michael Champanis (mchampan)
 * @author    Valery Fremaux (valery.fremaux@gmail.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$settings->add(new admin_setting_configtext('block_search/text', get_string('configsearchtext', 'block_search'), get_string('configsearchtext_desc', 'block_search'), get_string('searchmoodle', 'block_search'), PARAM_TEXT));

$settings->add(new admin_setting_configtext('block_search/button', get_string('configbuttonlabel', 'block_search'), get_string('configbuttonlabel_desc', 'block_search'), get_string('go', 'block_search'), PARAM_TEXT));
