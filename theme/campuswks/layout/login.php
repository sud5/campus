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
 * A login page layout for the campuswks theme.
 *
 * @package  theme_campuswks
 * @copyright 2016 Damyon Wiese
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$bodyattributes = $OUTPUT->body_attributes();

$extraclasses = [];
$settings = get_config('theme_campuswks');
$bodyattributes = $OUTPUT->body_attributes($extraclasses);
$logincontent = $settings->companyinfo;
$fs = get_file_storage();
$files = $fs->get_area_files(context_system::instance()->id, 'theme_campuswks', 'loginpageimg', 0, '', false);
foreach ($files as $file) {
    $loginimg = clean_param(\moodle_url::make_pluginfile_url(context_system::instance()->id, $file->get_component(), $file->get_filearea(), 0, '/', $file->get_filename())->out(false), PARAM_URL);
}

$templatecontext = [
    'sitename' => format_string($SITE->shortname, true, ['context' => context_course::instance(SITEID), "escape" => false]),
    'output' => $OUTPUT,
    'loginimg' => $loginimg,
    'logincontent' => $logincontent,
    'bodyattributes' => $bodyattributes
];

echo $OUTPUT->render_from_template('theme_campuswks/login', $templatecontext);

