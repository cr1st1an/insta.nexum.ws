<?php

class Validator {

    public function getGetParams($KEYS) {
        $response = array();
        $get = array();

        foreach ($KEYS as $key) {
            if (empty($response)) {
                if (isset($_GET[$key])) {
                    $get[$key] = $_GET[$key];
                } else {
                    $response['success'] = false;
                    $response['message'] = t('There is a missing parameter: ') . $key;
                }
            }
        }

        if (empty($response)) {
            $response['success'] = true;
            $response['message'] = t('All the requested GET parameters are present.');
            $response['get'] = $get;
        }

        return $response;
    }

    public function getPostParams($KEYS) {
        $response = array();
        $post = array();

        foreach ($KEYS as $key) {
            if (empty($response)) {
                if (isset($_POST[$key])) {
                    $post[$key] = $_POST[$key];
                } else {
                    $response['success'] = false;
                    $response['message'] = t('There is a missing parameter: ') . $key;
                }
            }
        }

        if (empty($response)) {
            $response['success'] = true;
            $response['message'] = t('All the requested POST parameters are present.');
            $response['post'] = $post;
        }

        return $response;
    }

    public function getPutParams($KEYS) {
        $response = array();
        $put = array();

        parse_str(file_get_contents("php://input"), $_PUT);

        foreach ($KEYS as $key) {
            if (empty($response)) {
                if (isset($_PUT[$key])) {
                    $put[$key] = $_PUT[$key];
                } else {
                    $response['success'] = false;
                    $response['message'] = t('There is a missing parameter: ') . $key;
                }
            }
        }

        if (empty($response)) {
            $response['success'] = true;
            $response['message'] = t('All the requested PUT parameters are present.');
            $response['put'] = $put;
        }

        return $response;
    }

}