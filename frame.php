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

/* This file is the iframe target that actually does the LTI launch */

require_once('../../config.php');
require_once(__DIR__ . '/OAuth.php');
require_once(__DIR__ . '/functions.php');

global $USER;
$PAGE->set_url( '/filter/ccembed/frame.php', $_GET );
$PAGE->set_pagelayout( 'embedded' );

$contextmodule = context_module::instance( $_GET[ 'cid' ] );
$PAGE->set_context( $contextmodule );
require_login();

$oauth_keys = \filter\ccembed\functions::get_client_keys($_GET['course']); 

if (empty($oauth_keys)) {
    die(get_string('err_nokeys', 'filter_ccembed'));
}
else if (empty($oauth_keys->key) || empty($oauth_keys->secret)) {
    die(get_string('err_nokeys', 'filter_ccembed')); 
}

/* Build the LTI form data */
$domain = parse_url( $CFG->wwwroot, PHP_URL_HOST );
$domain = preg_replace( '/^www\./', '', $domain );
$lti_data = [
    'oauth_version' => '1.0',
    'oauth_timestamp' => date( 'U' ),
    'oauth_nonce' => md5( microtime() . mt_rand() ),
    'oauth_consumer_key' => $oauth_keys->key,
    'oauth_signature_method' => 'HMAC-SHA1',
    'oauth_callback' => 'about:blank',
    'lti_message_type' => 'basic-lti-launch-request',
    'lti_version' => 'LTI-1p0',
    'user_id' => $USER->id,
    'lis_person_sourcedid' => $USER->idnumber,
    'resource_link_id' => base64_encode(json_encode( ['guid' => $domain, 'cid' => $_GET[ 'cid' ], 'cmid' => $contextmodule->id, 'uid' => $USER->id ] ) ),
    'custom_problem' => $_GET[ 'p' ],
    'custom_assignment' => $_GET[ 'u' ],
    'tool_consumer_instance_guid' => $domain
];
//echo '<pre>'.print_r($lti_data, true).'</pre>'; die(); 
/* Additional fields that are dependent on settings */
if (isset($_REQUEST['nolink']) || get_config('filter_ccembed', 'hidelink')) {
    $lti_data['custom_nolink'] = 1; 
}
if (isset($_GET['hide_instructions'])) {
    $lti_data['custom_hide_instructions'] = 1; 
}

$privacy = get_config('filter_ccembed', 'privacy');
switch ($privacy) {
    case 'name':
        $lti_data['lis_person_name_given'] = $USER->firstname;
        $lti_data['lis_person_name_family'] = $USER->lastname;
        $lti_data['lis_person_name_full'] = $USER->firstname . ' ' . $USER->lastname; 
        /* Intentionally not breaking. name includes email as well */
    case 'email':
        $lti_data['lis_person_contact_email_primary'] = $USER->email;
        break;
}

/* Generat OAuth Signature */
$request = new \filter\ccembed\OAuthRequest('POST', 'https://app.classcube.com/p/', $lti_data);
$consumer = new \filter\ccembed\OAuthConsumer($oauth_keys->key, $oauth_keys->secret); 
$signature = (new \filter\ccembed\OAuthSignatureMethod_HMAC_SHA1())->build_signature($request, $consumer, false);
$lti_data['oauth_signature'] = $signature; 
?>
<!DOCTYPE html>
<html><body>
<form id="frm-launch" action="https://app.classcube.com/p/" method="POST" enctype="application/x-www-form-urlencoded">
    <?php
    foreach ($lti_data as $k => $v) {
        echo '<input type="hidden" name="' . $k . '" value="' . $v . '">';
    }
    ?>
    <noscript>
    <button type="submit">Launch</button>
    </noscript>
</form>
        <script type="text/javascript">document.getElementById('frm-launch').submit();</script>
    </body>
</html>