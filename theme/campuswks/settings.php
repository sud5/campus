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
 * @package   theme_campuswks
 * @copyright 2016 Ryan Wyllie
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {
    $settings = new theme_boost_admin_settingspage_tabs('themesettingcampuswks', get_string('configtitle', 'theme_campuswks'));
    $page = new admin_settingpage('theme_campuswks_general', get_string('generalsettings', 'theme_campuswks'));

    // Unaddable blocks.
    // Blocks to be excluded when this theme is enabled in the "Add a block" list: Administration, Navigation, Courses and
    // Section links.
    $default = 'navigation,settings,course_list,section_links';
    $setting = new admin_setting_configtext('theme_campuswks/unaddableblocks',
        get_string('unaddableblocks', 'theme_campuswks'), get_string('unaddableblocks_desc', 'theme_campuswks'), $default, PARAM_TEXT);
    $page->add($setting);

    // Preset.
    $name = 'theme_campuswks/preset';
    $title = get_string('preset', 'theme_campuswks');
    $description = get_string('preset_desc', 'theme_campuswks');
    $default = 'default.scss';

    $context = context_system::instance();
    $fs = get_file_storage();
    $files = $fs->get_area_files($context->id, 'theme_campuswks', 'preset', 0, 'itemid, filepath, filename', false);

    $choices = [];
    foreach ($files as $file) {
        $choices[$file->get_filename()] = $file->get_filename();
    }
    // These are the built in presets.
    $choices['default.scss'] = 'default.scss';
    $choices['plain.scss'] = 'plain.scss';
    $choices['custom.scss'] = 'custom.scss';

    $setting = new admin_setting_configthemepreset($name, $title, $description, $default, $choices, 'campuswks');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Preset files setting.
    $name = 'theme_campuswks/presetfiles';
    $title = get_string('presetfiles','theme_campuswks');
    $description = get_string('presetfiles_desc', 'theme_campuswks');

    $setting = new admin_setting_configstoredfile($name, $title, $description, 'preset', 0,
        array('maxfiles' => 20, 'accepted_types' => array('.scss')));
    $page->add($setting);

    // Background image setting.
    $name = 'theme_campuswks/backgroundimage';
    $title = get_string('backgroundimage', 'theme_campuswks');
    $description = get_string('backgroundimage_desc', 'theme_campuswks');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'backgroundimage');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Login Background image setting.
    $name = 'theme_boost/loginbackgroundimage';
    $title = get_string('loginbackgroundimage', 'theme_campuswks');
    $description = get_string('loginbackgroundimage_desc', 'theme_campuswks');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'loginbackgroundimage');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
   
    // Variable $body-color.
    // We use an empty default value because the default colour should come from the preset.
    $name = 'theme_campuswks/brandcolor';
    $title = get_string('brandcolor', 'theme_campuswks');
    $description = get_string('brandcolor_desc', 'theme_campuswks');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Must add the page after definiting all the settings!
//    $settings->add($page);
    
    // Login Page settings.
    $page = new admin_settingpage('theme_campuswks_loginpage', get_string('loginpagesettings', 'theme_campuswks'));
    
    //login page Company info
    $setting = new admin_setting_confightmleditor('theme_campuswks/companyinfo', get_string('companyinfo', 'theme_campuswks'),
    get_string('companyinfo_desc', 'theme_campuswks'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Login page background setting.
    $name = 'theme_campuswks/loginpageimg';
    $title = get_string('loginpageimg', 'theme_campuswks');
    $description = get_string('loginpageimg_desc', 'theme_campuswks');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'loginpageimg');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    // Variable $body-color.
    // We use an empty default value because the default colour should come from the preset.
    $name = 'theme_campuswks/themecolor';
    $title = get_string('themecolor', 'theme_campuswks');
    $description = get_string('themecolor_desc', 'theme_campuswks');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $settings->add($page);

    // Advanced settings.
    $page = new admin_settingpage('theme_campuswks_advanced', get_string('advancedsettings', 'theme_campuswks'));

    // Raw SCSS to include before the content.
    $setting = new admin_setting_scsscode('theme_campuswks/scsspre',
        get_string('rawscsspre', 'theme_campuswks'), get_string('rawscsspre_desc', 'theme_campuswks'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Raw SCSS to include after the content.
    $setting = new admin_setting_scsscode('theme_campuswks/scss', get_string('rawscss', 'theme_campuswks'),
        get_string('rawscss_desc', 'theme_campuswks'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $settings->add($page);   
}
