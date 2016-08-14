<?php

/*
 * Copyright (C) 2016 Ryan Nutt - https://classcube.com
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

namespace filter\ccembed;

class functions {

    public static function get_client_keys( $course_id = 0 ) {
        global $CFG, $DB;
        require_once($CFG->dirroot . '/mod/lti/locallib.php');

        $ret = new \stdClass();

        /* Try and get the keys from settings first. If they're there, we'll
         * use them.
         */
        $key = get_config( 'filter_ccembed', 'client_key' );
        $secret = get_config( 'filter_ccembed', 'client_secret' );

        if ( !empty( $key ) && !empty( $secret ) ) {
            $ret->key = $key;
            $ret->secret = $secret;
        }
        else {
            $tool = lti_get_tool_by_url_match( 'https://app.classcube.com/p/', $course_id );
            if ( !$tool ) {
                return false;
            }

            $ret->key = '';
            $ret->secret = '';

            $results = $DB->get_records_sql( 'SELECT * FROM {lti_types_config} WHERE typeid = ? AND (name= ? OR name=?)', array( $tool->id, 'resourcekey', 'password' ) );

            if ( $results ) {
                foreach ( $results as $result ) {
                    if ( $result->name == 'resourcekey' ) {
                        $ret->key = $result->value;
                    }
                    else if ( $result->name == 'password' ) {
                        $ret->secret = $result->value;
                    }
                }
            }
        }

        return $ret;
    }

    /** @deprecated */
    public static function get_client_key() {
        global $CFG;
        require_once($CFG->dirroot . '/mod/lti/locallib.php');
        return get_config( 'filter_ccembed', 'client_key' );
    }

    /** @deprecated */
    public static function get_client_secret() {
        global $CFG;
        require_once($CFG->dirroot . '/mod/lti/locallib.php');
        return get_config( 'filter_ccembed', 'client_secret' );
    }

}
