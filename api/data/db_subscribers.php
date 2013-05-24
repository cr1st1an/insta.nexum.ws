<?php

class DB_Subscribers {

    protected $_name = 'subscribers';

    public function insert($DATA) {
        $response = array();
        $id_subscriber = null;

        $id_ig_user = (int) $DATA['id_ig_user'];
        if (empty($response) && empty($id_ig_user)) {
            $response['success'] = false;
            $response['message'] = t('Missing value: ') . "ID_IG_USER; DB_Subscribers->insert()";
        }
        
        if (empty($response)) {
            $select_data = array(
                'id_ig_user' => $id_ig_user
            );
            $subscriber_data = getDatabase()->one('SELECT * FROM ' . $this->_name . ' WHERE id_ig_user=:id_ig_user', $select_data);

            if (empty($subscriber_data)) {
                $insert_data = array(
                    'id_ig_user' => $id_ig_user,
                    'created' => date("Y-m-d H:i:s")
                );
                $id_subscriber = getDatabase()->execute(
                        'INSERT INTO ' . $this->_name . '(id_ig_user, created) VALUES(:id_ig_user, :created)', $insert_data
                );
            } else {
                $id_subscriber = $subscriber_data['id_subscriber'];
            }

            $response['success'] = true;
            $response['message'] = t('A new subscriber has been saved, with id: ') . $id_subscriber;
            $response['id_subscriber'] = $id_subscriber;
        }

        return $response;
    }

    public function select($ID_SUBSCRIBER) {
        $response = array();

        $id_subscriber = (int) $ID_SUBSCRIBER;
        if (empty($response) && empty($id_subscriber)) {
            $response['success'] = false;
            $response['message'] = t('Missing value: ') . "ID_SUBSCRIBER; DB_Subscribers->select()";
        }

        if (empty($response)) {
            $select_data = array(
                'id_subscriber' => $id_subscriber
            );
            $subscriber_data = getDatabase()->one(
                    'SELECT * FROM ' . $this->_name . ' WHERE id_subscriber=:id_subscriber', $select_data
            );
            
            if(!$subscriber_data){
                $response['success'] = false;
                $response['message'] = t('There is no subscriber with id: ') . $id_subscriber;
            }
        }
        
        if(empty($response)){
            $response['success'] = true;
            $response['message'] = t('Here is the subscriber with id: ') . $id_subscriber;
            $response['subscriber_data'] = $subscriber_data;
        }

        return $response;
    }
    
    public function selectFromAccessToken($ACCESS_TOKEN) {
        $response = array();

        $access_token = $ACCESS_TOKEN;
        if (empty($response) && empty($access_token)) {
            $response['success'] = false;
            $response['message'] = t('Missing value: ') . "ACCESS_TOKEN; DB_Subscribers->selectFromAccessToken()";
        }

        if (empty($response)) {
            $select_data = array(
                'access_token' => $access_token
            );
            $subscriber_data = getDatabase()->one(
                    'SELECT * FROM ' . $this->_name . ' WHERE access_token=:access_token', $select_data
            );
            
            if(!$subscriber_data){
                $response['success'] = false;
                $response['message'] = t('There is no subscriber with id: ') . $id_subscriber;
            }
        }
        
        if(empty($response)){
            $response['success'] = true;
            $response['message'] = t('Here is the subscriber with id: ') . $id_subscriber;
            $response['subscriber_data'] = $subscriber_data;
        }


        return $response;
    }
    
    public function updateAccessToken($ID_SUBSCRIBER, $ACCESS_TOKEN){
        $response = array();
        
        $id_subscriber = (int) $ID_SUBSCRIBER;
        if (empty($response) && empty($id_subscriber)) {
            $response['success'] = false;
            $response['message'] = t('Missing value: ') . "ID_SUBSCRIBER; DB_Subscribers->updateDeviceToken()";
        }
        
        $access_token = $ACCESS_TOKEN;
        if (empty($response) && empty($access_token)) {
            $response['success'] = false;
            $response['message'] = t('Missing value: ') . "ACCESS_TOKEN; DB_Subscribers->updateDeviceToken()";
        }
        
        if (empty($response)) {
            $update_data = array(
                'id_subscriber' => $id_subscriber,
                'updated' => date("Y-m-d H:i:s"),
                'access_token' => $access_token
            );
            getDatabase()->execute('UPDATE ' . $this->_name . ' SET updated=:updated, access_token=:access_token WHERE id_subscriber=:id_subscriber', $update_data);
            
            $response['success'] = true;
            $response['message'] = t('Successfully updated the subscriber with id: ') . $id_subscriber;
        }
        
        return $response;
    }
    
    public function updateEmail($ID_SUBSCRIBER, $EMAIL){
        $response = array();
        
        $id_subscriber = (int) $ID_SUBSCRIBER;
        if (empty($response) && empty($id_subscriber)) {
            $response['success'] = false;
            $response['message'] = t('Missing value: ') . "ID_SUBSCRIBER; DB_Subscribers->updateEmail()";
        }
        
        $email = $EMAIL;
        if (empty($response) && empty($email)) {
            $response['success'] = false;
            $response['message'] = t('Missing value: ') . "EMAIL; DB_Subscribers->updateEmail()";
        }
        
        if (empty($response)) {
            $update_data = array(
                'id_subscriber' => $id_subscriber,
                'updated' => date("Y-m-d H:i:s"),
                'email' => $email,
                'md5_invite' => null,
                'verified' => false
            );
            getDatabase()->execute('UPDATE ' . $this->_name . ' SET updated=:updated, email=:email, md5_invite=:md5_invite, verified=:verified WHERE id_subscriber=:id_subscriber', $update_data);
            
            $response['success'] = true;
            $response['message'] = t('Successfully updated the subscriber with id: ') . $id_subscriber;
        }
        
        return $response;
    }
    
    public function updateInvite($ID_SUBSCRIBER, $MD5_INVITE){
        $response = array();
        
        $id_subscriber = (int) $ID_SUBSCRIBER;
        if (empty($response) && empty($id_subscriber)) {
            $response['success'] = false;
            $response['message'] = t('Missing value: ') . "ID_SUBSCRIBER; DB_Subscribers->updateInvite()";
        }
        
        $md5_invite = $MD5_INVITE;
        if (empty($response) && empty($md5_invite)) {
            $response['success'] = false;
            $response['message'] = t('Missing value: ') . "MD5_INVITE; DB_Subscribers->updateInvite()";
        }
        
        if (empty($response)) {
            $update_data = array(
                'id_subscriber' => $id_subscriber,
                'updated' => date("Y-m-d H:i:s"),
                'md5_invite' => $md5_invite,
                'verified' => false
            );
            getDatabase()->execute('UPDATE ' . $this->_name . ' SET updated=:updated, md5_invite=:md5_invite, verified=:verified WHERE id_subscriber=:id_subscriber', $update_data);
            
            $response['success'] = true;
            $response['message'] = t('Successfully updated the subscriber with id: ') . $id_subscriber;
        }
        
        return $response;
    }
    
    public function updateVerified($ID_SUBSCRIBER, $VERIFIED){
        $response = array();
        
        $id_subscriber = (int) $ID_SUBSCRIBER;
        if (empty($response) && empty($id_subscriber)) {
            $response['success'] = false;
            $response['message'] = t('Missing value: ') . "ID_SUBSCRIBER; DB_Subscribers->updateVerified()";
        }
        
        $verified = $VERIFIED;
        if (empty($response) && !isset($verified)) {
            $response['success'] = false;
            $response['message'] = t('Missing value: ') . "MD5_INVITE; DB_Subscribers->updateVerified()";
        }
        
        if (empty($response)) {
            $update_data = array(
                'id_subscriber' => $id_subscriber,
                'updated' => date("Y-m-d H:i:s"),
                'md5_invite' => null,
                'verified' => $verified
            );
            getDatabase()->execute('UPDATE ' . $this->_name . ' SET updated=:updated, md5_invite=:md5_invite, verified=:verified WHERE id_subscriber=:id_subscriber', $update_data);
            
            $response['success'] = true;
            $response['message'] = t('Successfully updated the subscriber with id: ') . $id_subscriber;
        }
        
        return $response;
    }
    
//    
//    public function updateDeviceToken($ID_SUBSCRIBER, $DEVICE_TOKEN){
//        $response = array();
//        
//        $id_subscriber = (int) $ID_SUBSCRIBER;
//        if (empty($response) && empty($id_subscriber)) {
//            $response['success'] = false;
//            $response['message'] = t('error003') . "ID_SUBSCRIBER " . t('txt003') . "DB_Subscribers->updateDeviceToken()";
//        }
//        
//        $device_token = $DEVICE_TOKEN;
//        if (empty($response) && empty($device_token)) {
//            $response['success'] = false;
//            $response['message'] = t('error003') . "DEVICE_TOKEN " . t('txt003') . "DB_Subscribers->updateDeviceToken()";
//        }
//        
//        if (empty($response)) {
//            $update_data = array(
//                'id_subscriber' => $id_subscriber,
//                'updated' => date("Y-m-d H:i:s"),
//                'device_token' => $device_token
//            );
//            getDatabase()->execute('UPDATE ' . $this->_name . ' SET updated=:updated, device_token=:device_token WHERE id_subscriber=:id_subscriber', $update_data);
//            
//            $response['success'] = true;
//            $response['message'] = t('ok036') . $id_subscriber;
//        }
//        
//        return $response;
//    }
//    
}