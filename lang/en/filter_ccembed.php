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

$string[ 'ccembed' ] = 'Embed ClassCube Problems';
$string[ 'ccembed_desc' ] = 'Insert ClassCube problems directly into pages by pasting the link';

$string[ 'iframe_classes' ] = 'IFrame CSS Classes';
$string[ 'iframe_classes_desc' ] = 'Anything here will be appended to the class attribute on the IFrames that are created to embed problems.';

$string[ 'allow_fullscreen' ] = 'Allow full screen';
$string[ 'allow_fullscreen_desc' ] = 'If enabled, the filter will attempt to allow the iframe to show full screen. Not all browsers will allow this.';

$string[ 'client_heading' ] = 'Client key settings';
$string[ 'client_notes' ] = 'These settings may be optional depending on how your class or server is setup. If blank, this filter will look in the course and then the server settings for a client key and secret that is tied to ClassCube. If you are already using ClassCube problems as an external tool, it is likely that you can leave these fields blank.';

$string[ 'client_secret' ] = 'Client secret';
$string[ 'client_secret_desc' ] = 'The client secret code from the key that you created in ClassCube';

$string[ 'client_key' ] = 'Client key';
$string[ 'client_key_desc' ] = 'The client key from the key that you created in ClassCube';
