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

defined( 'MOODLE_INTERNAL' ) || die();

require_once(__DIR__ . '/functions.php');

class filter_ccembed extends moodle_text_filter {

    /**
     * Regex to use to determine whether there is a link to a 
     * ClassCube problem. 
     */
    const URL_REGEX = '/(https?:\/\/)?(app\.classcube\.com\/p\/[0-9a-zA-Z\?\&\=;_]*)/';

    /**
     * Used to keep track of the current frame
     * @var int
     */
    var $current_frame = 1;

    public function setup( $page, $context ) {
        parent::setup( $page, $context );
        $this->current_frame = 1;
    }

    /**
     * Apply the filter to the text
     *
     * @see filter_manager::apply_filter_chain()
     * @param string $text to be processed by the text
     * @param array $options filter options
     * @return string text after processing
     */
    public function filter( $text, array $options = array() ) {
        $text = preg_replace_callback( self::URL_REGEX, function($matches) {
            return $this->build_frame( $matches[ 2 ] );
        }
                , $text );

        return $text;
    }

    /**
     * Builds the iframe code for replacement into the page
     * 
     * This needs to pass the problem, assignment if it exists, and any 
     * information from Moodle to specify what the context is for the
     * page the iframe is inserted on to. The frame contents will not
     * have direct access, so it's getting passed as part of the query
     * string. 
     * 
     * @global type $CFG
     * @global type $PAGE
     * @param type $link
     * @return type
     */
    private function build_frame( $link ) {
        global $CFG, $PAGE, $COURSE;

        $context = $PAGE->context;
        $coursecontext = $context->get_course_context();
        $courseid = $coursecontext->instanceid;
        $mod_info = $PAGE->cm->get_modinfo();

        $url_info = parse_url( $link );
        parse_str( html_entity_decode( $url_info[ 'query' ] ), $qs );
        
        if ( empty( $qs[ 'p' ] ) ) {
            return get_string( 'err_querystring', 'filter_ccembed' );
        }

        $querystring = 'p=' . $qs[ 'p' ];
        if ( !empty( $qs[ 'u' ] ) ) {
            $querystring .= '&u=' . $qs[ 'u' ];
        }
        if ( isset( $qs[ 'hide_instructions' ] ) ) {
            $querystring .= '&hide_instructions';
        }
        if ( isset( $qs[ 'nolink' ] ) ) {
            $querystring .= '&nolink';
        }
        $querystring .= '&cid=' . $context->instanceid;
        $querystring .= '&course=' . $courseid;

        $src = $CFG->wwwroot . '/filter/ccembed/frame.php?' . $querystring;

        $iframe = '<iframe ';
        if ( $this->current_frame == 1 ) {
            $iframe .= 'id="cc-embed-first" src=';
        }
        else {
            $iframe .= 'data-cc-src=';
        }
        $iframe .= '"' . $src . '" style="' . get_config( 'filter_ccembed', 'iframestyle' ) . '" class="' . get_config( 'filter_ccembed', 'iframecss' ) . '"' . (!empty( get_config( 'filter_ccembed', 'allowfullscreen' ) ) ? ' allowfullscreen' : '');

        $iframe .= '></iframe>';

        /* On the second frame we're going to add in the JavaScript to go 
         * through and swap the data attribute with the src after the first
         * frame is loaded. 
         */
        if ( $this->current_frame == 2 ) {
            ?>
            <script type="text/javascript">
                document.addEventListener('DOMContentLoaded', function () {
                    require(['jquery'], function ($) {
                        $('iframe#cc-embed-first').on('load', function () {
                            $.each($('iframe[data-cc-src]'), function (idx, val) {
                                $(this).attr('src', $(this).data('cc-src'));
                            });
                        });
                    });
                }, false);
            </script>
            <?php

        }

        $this->current_frame++;

        return $iframe;
    }

}
