<?php

namespace local_webservices\external;

use context_course;
use core\oauth2\access_token;
use core_course\analytics\target\course_completion;
use external_function_parameters;
use external_multiple_structure;
use external_single_structure;
use external_value;

use core\plugininfo\webservice;

class get_completion_for_courseid extends \core_external\external_api {

    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */

    public static function execute_parameters() {
        return new external_function_parameters([
            'courseid' => new external_value(PARAM_INT, 'id of course')
        ]);
    }

    public static function execute($courseid) {

        global $CFG, $DB, $USER;

        $params = self::validate_parameters(self::execute_parameters(), ['courseid' => $courseid]);

        $transaction = $DB->start_delegated_transaction();

        $coursecontext = context_course::instance($courseid);

        require_capability('report/completion:view', $coursecontext);

        $users = get_enrolled_users($coursecontext, '', 0, 'u.id, u.username');

        //Fetch completionstates for all users in this course.
        $sql = "SELECT DISTINCT u.username as username, cc.timecompleted as completiondate,
                case
                    when cc.timecompleted IS NULL then 0
                    when cc.timecompleted IS NOT NULL then 1
                end as completionstatus FROM {user} u
                INNER JOIN {course_completions} cc ON u.id = cc.userid AND cc.course= :courseid
                WHERE u.id IN :userids";

        $results = $DB->get_records_sql($sql, [
            'courseid' => $courseid,
            'userids' => implode(", ", array_map(function($user) {
                            return $user->id;
                         },$users))
        ]);

        $transaction->allow_commit();

        return $results;
    }

    public static function execute_returns() {
        return new external_multiple_structure(
            new external_single_structure(
                array(
                    'username' => new external_value(PARAM_TEXT, 'username'),
                    'completiondate' => new external_value(PARAM_TEXT, 'date of completion'),
                    'completionstatus' => new external_value(PARAM_BOOL, 'completionstatus')
                )
            )
        );
    }

}

