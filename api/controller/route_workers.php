<?php

class Route_Workers {

    public function getW1() {
        include_once Epi::getPath('data') . 'db_subscribers.php';
        include_once Epi::getPath('lib') . 'mandrill.php';
        include_once Epi::getPath('lib') . 'validator.php';

        $DB_Subscribers = new DB_Subscribers();

        $Mandrill = new Mandrill();
        $Validator = new Validator();

        $response = array();
        $get = array();
        $subscriber_data = array();

        if (empty($response)) {
            $r_getGetParams = $Validator->getGetParams(array('id_subscriber'));

            if ($r_getGetParams['success']) {
                $get = $r_getGetParams['get'];
            } else {
                $response = $r_getGetParams;
            }
        }

        if (empty($response)) {
            $r_select = $DB_Subscribers->select($get['id_subscriber']);
            if ($r_select['success']) {
                $subscriber_data = $r_select['subscriber_data'];
            } else {
                $response = $r_select;
            }
        }

        // VALIDATE IF MAIL IS THERE
        // VALIDATE IF VERIFIED

        if (empty($response)) {
            $invite = rand(1000, 9999);
            $r_updateInvite = $DB_Subscribers->updateInvite($subscriber_data['id_subscriber'], md5($invite));
            if (!$r_updateInvite['success']) {
                $response = $r_updateInvite;
            }
        }

        if (empty($response)) {
            $payload = array(
                'message' => array(
                    'html' =>
                    "Hi!<br/>
<br/>
Thank you for downloading Insta, the best Instagram viewer for the iPad. Please let us know what you think through our Facebook page: http://facebook.com/appinsta<br/>
<br/>
Your access code is: $invite <br/>
<br/>
Insta<br/>
&nbsp; by Cristian and Roman Castillo",
                    'text' =>
                    "Hi!

Thank you for downloading Insta, the best Instagram viewer for the iPad. Please let us know what you think through our Facebook page: http://facebook.com/appinsta

Your access code is: $invite

Insta
 by Cristian and Roman Castillo",
                    'subject' => 'Thanks for downloading Insta',
                    'from_email' => 'welcome@insta.mx',
                    'from_name' => 'Insta',
                    'to' => array(
                        array(
                            'email' => $subscriber_data['email']
                        ),
                    ),
                ),
                'async' => true
            );

            $response = $Mandrill->call('/messages/send', $payload);
        }

        return $response;
    }

}