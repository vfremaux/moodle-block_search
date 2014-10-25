<?php

/**
* Requires and includes
*/
include_once $CFG->dirroot."/local/search/lib.php";

$defaultfiletypes = "PDF,TXT,HTML,PPT,XML,DOC,HTM";

if (!defined('MOODLE_INTERNAL')) die ("You cannot use this script this way");

$settings->add(new admin_setting_configtext('block_search/text', get_string('configsearchtext', 'block_search'), get_string('configsearchtext_desc', 'block_search'), get_string('searchmoodle', 'block_search'), PARAM_TEXT));

$settings->add(new admin_setting_configtext('block_search/button', get_string('configbuttonlabel', 'block_search'), get_string('configbuttonlabel_desc', 'block_search'), get_string('go', 'block_search'), PARAM_TEXT));

$convertoptions = array(
    '-1' => get_string('fromutf8', 'block_search'),
    '0' => get_string('nochange', 'block_search'),
    '1' => get_string('toutf8', 'block_search'),
);
$settings->add(new admin_setting_configselect('block_search/utf8dir', get_string('configutf8transcoding', 'block_search'), get_string('configutf8transcoding_desc', 'block_search'), 0, $convertoptions));

$settings->add(new admin_setting_configcheckbox('block_search/softlock', get_string('configusingsoftlock', 'block_search'), get_string('configusingsoftlock_desc', 'block_search'), 0));

$settings->add(new admin_setting_configcheckbox('block_search/enable_file_indexing', get_string('configenablefileindexing', 'block_search'), get_string('configenablefileindexing', 'block_search'), get_string('configenablefileindexing_desc', 'block_search'), 0));

$settings->add(new admin_setting_configtext('block_search/filetypes', get_string('configfiletypes', 'block_search'), get_string('configfiletypes_desc', 'block_search'), $defaultfiletypes, PARAM_TEXT));

$settings->add(new admin_setting_configcheckbox('block_search/usemoodleroot', get_string('usemoodleroot', 'block_search'), get_string('usemoodleroot_desc', 'block_search'), 1));

$settings->add(new admin_setting_configtext('block_search/limit_index_body', get_string('configlimitindexbody', 'block_search'), get_string('configlimitindexbody_desc', 'block_search'), 0, PARAM_TEXT));

$settings->add(new admin_setting_heading('head1', get_string('pdfhandling', 'block_search'), ''));

if ($CFG->ostype == 'WINDOWS'){
    $default= "lib/xpdf/win32/pdftotext.exe -eol dos -enc UTF-8 -q";
} else {
    $default = "lib/xpdf/linux/pdftotext -enc UTF-8 -eol unix -q";
}

$settings->add(new admin_setting_configtext('block_search/pdf_to_text_cmd', get_string('configpdftotextcmd', 'block_search'), get_string('configpdftotextcmd_desc', 'block_search'), $default, PARAM_TEXT));

$settings->add(new admin_setting_heading('head2', get_string('wordhandling', 'block_search'), ''));

if ($CFG->ostype == 'WINDOWS') {
    $default = "lib/antiword/win32/antiword/antiword.exe";
} else {
    $default = "lib/antiword/linux/usr/bin/antiword";
}

$settings->add(new admin_setting_configtext('block_search/word_to_text_cmd', get_string('configwordtotextcmd', 'block_search'), get_string('configwordtotextcmd_desc', 'block_search'), $default, PARAM_TEXT));

if ($CFG->ostype == 'WINDOWS') {
    $default = "HOME={$CFG->dirroot}\\lib\\antiword\\win32";
} else {
    $default = "ANTIWORDHOME={$CFG->dirroot}/lib/antiword/linux/usr/share/antiword";
}

$settings->add(new admin_setting_configtext('block_search/word_to_text_env', get_string('configwordtotextenv', 'block_search'), get_string('configwordtotextenv_desc', 'block_search'), $default, PARAM_TEXT));

$types = explode(',', @$CFG->block_search_filetypes);
if (!empty($types)) {
    foreach($types as $type) {
        $utype = strtoupper($type);
        $type = strtolower($type);
        $type = trim($type);
        if (preg_match("/\\b$type\\b/i", $defaultfiletypes)) {
            continue;
        }

        $settings->add(new admin_setting_configcheckbox('block_search/'.$type.'_to_text_cmd', get_string('configtypetotxtcmd', 'block_search'), get_string('configtypetotxtcmd_desc', 'block_search'), 0));
        $settings->add(new admin_setting_configcheckbox('block_search/'.$type.'_to_text_env', get_string('configtypetotxtenv', 'block_search'), get_string('configtypetotxtenv_desc', 'block_search'), 0));
    }
}

$searchnames = search_collect_searchables(true);
$searchable_list = implode("','", $searchnames);

$settings->add(new admin_setting_heading('head3', get_string('searchdiscovery', 'block_search'), '<pre>'.$searchable_list.'</pre>'));

$settings->add(new admin_setting_heading('head4', get_string('coresearchswitches', 'block_search'), ''));

$settings->add(new admin_setting_configcheckbox('block_search/search_in_user', get_string('users'), get_string('users'), 1));

$settings->add(new admin_setting_heading('head5', get_string('modulessearchswitches', 'block_search'), ''));

$i = 0;
$found_searchable_modules = 0;
if ($modules = $DB->get_records_select('modules', " name IN ('{$searchable_list}') ", array(), 'name', 'id,name')) {
    foreach($modules as $module) {
        $i++;
        $keyname = "block_search/search_in_{$module->name}";
        $settings->add(new admin_setting_configcheckbox($keyname, get_string('pluginname', $module->name), get_string('pluginname', $module->name), 1));
        $found_searchable_modules = 1;
    }
}

$settings->add(new admin_setting_heading('head6', get_string('blockssearchswitches', 'block_search'), ''));

$i = 0;
$found_searchable_blocks = 0;
if ($blocks = $DB->get_records_select('block', " name IN ('{$searchable_list}') ", array(), 'name', 'id,name')) {
    foreach($blocks as $block) {
        $i++;
        $keyname = "block_search/search_in_{$block->name}";
        $settings->add(new admin_setting_configcheckbox($keyname, get_string('pluginname', $block->name), get_string('pluginname', $block->name), 1));
        $found_searchable_modules = 1;
    }
}

$settings->add(new admin_setting_heading('head6', get_string('configenableglobalsearch', 'block_search'), ''));

$settings->add(new admin_setting_configcheckbox('enableglobalsearch', get_string('configenableglobalsearch', 'block_search'), get_string('configenableglobalsearch_desc', 'block_search'), 0));
