<?php

include_once Epi::getPath('controller') . 'route_sessions.php';
getApi()->post('/v1/sessions', array('Route_Sessions', 'postRoot'), EpiApi::external);

include_once Epi::getPath('controller') . 'route_subscribers.php';
getApi()->post('/v1/subscribers/email', array('Route_Subscribers', 'postEmail'), EpiApi::external);
getApi()->post('/v1/subscribers/invite', array('Route_Subscribers', 'postInvite'), EpiApi::external);
//getApi()->post('/v1/subscribers/device_token', array('Route_Subscribers', 'postDeviceToken'), EpiApi::external);

include_once Epi::getPath('controller') . 'route_workers.php';
getApi()->get('/v1/workers/invite_subscriber', array('Route_Workers', 'getW1'), EpiApi::external);

function block() {
    return array(
        'success' => false,
        'message' => t('These are not the endpoints you are looking for. inbox [at] insta [dot] mx')
    );
}
getApi()->get('(.*)', 'block', EpiApi::external);


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");