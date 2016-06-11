<?php

/*
 * Copyright (C) 2016 Ryan Nutt https://classcube.com
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
if ( $ADMIN->fulltree ) {

    $settings->add( new admin_setting_heading( 'filter_ccembed/general_heading', new lang_string( 'general_settings', 'filter_ccembed' ), '' ) );

    $settings->add( new admin_setting_configcheckbox( 'filter_ccembed/allowfullscreen', get_string( 'allow_fullscreen', 'filter_ccembed' ), get_string( 'allow_fullscreen_desc', 'filter_ccembed' ), true ) );

    $settings->add( new admin_setting_configcheckbox( 'filter_ccembed/hidelink', get_string( 'hidelink', 'filter_ccembed' ), get_string( 'hidelink_desc', 'filter_ccembed' ), false ) );

    $settings->add( new admin_setting_configtext( 'filter_ccembed/iframecss', new lang_string( 'iframe_classes', 'filter_ccembed' ), new lang_string( 'iframe_classes_desc', 'filter_ccembed' ), 'classcube-frame', PARAM_RAW ) );

    $settings->add( new admin_setting_configtext( 'filter_ccembed/iframestyle', new lang_string( 'iframe_styles', 'filter_ccembed' ), new lang_string( 'iframe_styles_desc', 'filter_ccembed' ), 'width:100%;height:300px;display:block;border:none;' ) );

    $settings->add( new admin_setting_configselect( 'filter_ccembed/privacy', get_string( 'user_info', 'filter_ccembed' ), get_string( 'user_info_desc', 'filter_ccembed' ), 'name', ['name' => get_string( 'user_info_full_name', 'filter_ccembed' ), 'email' => get_string( 'user_info_email_only', 'filter_ccembed' ), 'none' => get_string( 'user_info_anonymous', 'filter_ccembed' ) ] ) );

    $settings->add( new admin_setting_heading( 'filter_ccembed/keys_heading', new lang_string( 'key_settings', 'filter_ccembed' ), new lang_string( 'key_settings_help', 'filter_ccembed' ) ) );

    $settings->add( new admin_setting_configtext( 'filter_ccembed/client_key', new lang_string( 'client_key', 'filter_ccembed' ), new lang_string( 'client_key_desc', 'filter_ccembed' ), '', PARAM_RAW ) );

    $settings->add( new admin_setting_configtext( 'filter_ccembed/client_secret', new lang_string( 'client_secret', 'filter_ccembed' ), new lang_string( 'client_secret_desc', 'filter_ccembed' ), '', PARAM_RAW ) );
}