<?php

class Route_Sessions {

    public function postRoot() {
        include_once Epi::getPath('data') . 'db_sessions.php';
        include_once Epi::getPath('data') . 'db_subscribers.php';
        include_once Epi::getPath('lib') . 'instagram.php';
        include_once Epi::getPath('lib') . 'validator.php';

        $DB_Sessions = new DB_Sessions();
        $DB_Subscribers = new DB_Subscribers();

        $Instagram = new Instagram();
        $Validator = new Validator();

        $response = array();
        $post = array();
        $access_token = '';
        $instagram_user = array();
        $id_subscriber = '';
        $subscriber_data = array();

        if (empty($response)) {
            $r_getPostParams = $Validator->getPostParams(array('id_install', 'client', 'version', 'code'));

            if ($r_getPostParams['success']) {
                $post = $r_getPostParams['post'];
            } else {
                $response = $r_getPostParams;
            }
        }

        if (empty($response)) {
            $r_auth_1 = $Instagram->auth($post['code']);

            if (empty($r_auth_1['error_message'])) {
                $access_token = $r_auth_1['access_token'];
                $instagram_user = $r_auth_1['user'];
            } else {
                $response['success'] = false;
                $response['message'] = t('There was an error with Instagram. Details: ') . $r_auth_1['error_message'];
            }
        }

        if (empty($response)) {
            $r_insert = $DB_Subscribers->insert(
                    array(
                        'id_ig_user' => $instagram_user['id'],
                        'access_token' => $access_token
                    )
            );
            if ($r_insert['success']) {
                $id_subscriber = $r_insert['id_subscriber'];
            } else {
                $response['success'] = false;
                $response['message'] = t('We could not insert the subscriber with id: ') . $instagram_user['id'];
            }
        }

        if (empty($response)) {
            $r_select = $DB_Subscribers->select($id_subscriber);
            if ($r_select['success']) {
                $subscriber_data = $r_select['subscriber_data'];
            } else {
                $response = $r_select;
            }
        }
        
        if (empty($response)){
            $r_updateAccessToken = $DB_Subscribers->updateAccessToken($id_subscriber, $access_token);
            if (!$r_updateAccessToken['success']) {
                $response = $r_updateAccessToken;
            }
        }
        
        if (empty($response)) {
            $session_data = array(
                'id_subscriber' => $id_subscriber,
                'id_ig_user' => $instagram_user['id'],
                'id_install' => $post['id_install'],
                'code' => $post['code'],
                'client' => $post['client'],
                'version' => $post['version']
            );
            $r_insert_1 = $DB_Sessions->insert($session_data);

            if (!$r_insert_1['success']) {
                $response = $r_insert_1;
            }
        }

        if (empty($response)) {
            $response['success'] = true;
            $response['message'] = t('A new session has been saved, with id: ') . $r_insert_1['id_session'];
            $response['user_data'] = $instagram_user;
            $response['access_token'] = $access_token;
            if (empty($subscriber_data['email']))
                $response['trigger'] = 'no_email';
            else if (!$subscriber_data['verified'])
                $response['trigger'] = 'no_code';
        }
        
        return $response;
    }

}