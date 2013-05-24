<?php

class DB_Sessions {

    protected $_name = 'sessions';

    public function insert($DATA) {
        $response = array();
        
        $id_subscriber = (int) $DATA['id_subscriber'];
        if (empty($response) && empty($id_subscriber)) {
            $response['success'] = false;
            $response['message'] = t('Missing value: ') . "ID_SUBSCRIBER; DB_Sessions->insert()";
        }

        $id_ig_user = (int) $DATA['id_ig_user'];
        if (empty($response) && empty($id_ig_user)) {
            $response['success'] = false;
            $response['message'] = t('Missing value: ') . "ID_IG_USER; DB_Sessions->insert()";
        }

        $id_install = $DATA['id_install'];
        if (empty($response) && empty($id_install)) {
            $response['success'] = false;
            $response['message'] = t('Missing value: ') . "ID_INSTALL; DB_Sessions->insert()";
        }

        $code = $DATA['code'];
        if (empty($response) && empty($code)) {
            $response['success'] = false;
            $response['message'] = t('Missing value: ') . "CODE; DB_Sessions->insert()";
        }

        $client = $DATA['client'];
        if (empty($response) && empty($client)) {
            $response['success'] = false;
            $response['message'] = t('Missing value: ') . "CLIENT; DB_Sessions->insert()";
        }

        $version = $DATA['version'];
        if (empty($response) && empty($version)) {
            $response['success'] = false;
            $response['message'] = t('Missing value: ') . "VERSION; DB_Sessions->insert()";
        }

        $created = date("Y-m-d H:i:s");
        if(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else
            $ip = $_SERVER['REMOTE_ADDR'];

        if (empty($response)) {
            $insert_data = array(
                'id_subscriber' => $id_subscriber,
                'id_ig_user' => $id_ig_user,
                'id_install' => $id_install,
                'created' => $created,
                'code' => $code,
                'client' => $client,
                'version' => $version,
                'ip' => $ip
            );
            $id_session = getDatabase()->execute(
                    'INSERT INTO ' . $this->_name . '(id_subscriber, id_ig_user, id_install, created, code, client, version, ip) VALUES(:id_subscriber, :id_ig_user, :id_install, :created, :code, :client, :version, :ip)', $insert_data
            );

            $response['success'] = true;
            $response['message'] = t('A new session has been saved, with id: ') . $id_session;
            $response['id_session'] = $id_session;
        }

        return $response;
    }

//    public function select($ID_SESSION) {
//        $response = array();
//
//        $id_session = (int) $ID_SESSION;
//        if (empty($response) && empty($id_session)) {
//            $response['success'] = false;
//            $response['message'] = t('error003') . "ID_SESSION " . t('txt003') . "DB_Sessions->select()";
//        }
//
//        if (empty($response)) {
//            $select_data = array(
//                'id_session' => $id_session
//            );
//            $session_data = getDatabase()->one(
//                    'SELECT * FROM ' . $this->_name . ' WHERE id_session=:id_session', $select_data
//            );
//
//            $response['success'] = true;
//            $response['message'] = t('ok034') . $id_session;
//            $response['session_data'] = $session_data;
//        }
//
//        return $response;
//    }

}