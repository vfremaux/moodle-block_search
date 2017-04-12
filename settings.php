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
 * @package   block_search
 * @category  blocks
 * @author    Michael Champanis (mchampan)
 * @author    Valery Fremaux (valery.fremaux@gmail.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

$key = 'block_search/text';
$label = get_string('configsearchtext', 'block_search');
$desc = get_string('configsearchtext_desc', 'block_search');
$settings->add(new admin_setting_configtext($key, $label, $desc, get_string('searchmoodle', 'block_search'), PARAM_TEXT));

$key = 'block_search/button';
$label = get_string('configbuttonlabel', 'block_search');
$desc = get_string('configbuttonlabel_desc', 'block_search');
$settings->add(new admin_setting_configtext($key, $label, $desc, get_string('go', 'block_search'), PARAM_TEXT));
