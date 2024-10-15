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
 * Web service function declarations for the local_webservices plugin
 *
 * @package local_webservices
 * @copyright 2023 Irina Hoppe Uni Münster
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$functions = [
    'local_webservices_get_completion_for_courseid' => [
        'classname' => 'local_webservices\external\get_completion_for_courseid',
        'description' => 'Returns the course completionstatus of all users in the course matching this courseid.',
        'type' => 'read',
        'ajax' => true,
        'services' => [
            MOODLE_OFFICIAL_MOBILE_SERVICE
        ]
    ]
];
