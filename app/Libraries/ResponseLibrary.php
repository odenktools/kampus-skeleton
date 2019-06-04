<?php

namespace App\Libraries;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * ResponseLibrary untuk mempermudah response API.
 *
 * @author     Odenktools
 * @license    MIT
 * @package     \App\Models
 * @copyright  (c) 2019, Odenktools Technology
 */
class ResponseLibrary
{
    public static $apiVersion = "1.0";

    /**
     * @param array $items
     * @param string $messages
     * @param string $method
     * @return array
     */
    public static function ok($items, $messages, $method = 'POST')
    {
        $return = [];
        $return['meta']['code'] = JsonResponse::HTTP_OK;
        $return['meta']['api_version'] = self::$apiVersion;
        $return['meta']['method'] = $method;
        $return['meta']['message'] = trans('message.api.success');
        $return['errors'] = array();
        $return['pageinfo'] = (object)[];
        $return['data']['message'] = $messages;

        if ($items instanceof \Illuminate\Database\Eloquent\Model) {
            $return['data']['items'] = array(new \Illuminate\Database\Eloquent\Collection($items));
        } else if (is_array($items)) {
            $return['data']['items'] = $items;
        } else {
            $return['data']['items'] = array($items);
        }
        return $return;
    }

    /**
     *
     * return response()->json(ResponseLibrary::paginate(array(), null,400), 400);
     *
     * @param array $items
     * @param object $pageInfo
     * @param int $code
     * @return array
     */
    public static function paginate(array $items, array $pageInfo, $code = 200)
    {
        $return = [];
        $return['meta']['code'] = $code;
        $return['meta']['api_version'] = self::$apiVersion;
        $return['meta']['method'] = 'GET';
        $return['meta']['message'] = trans('message.api.success');
        $return['errors'] = array();
        if (is_array($pageInfo)) {
            $return['pageinfo'] = $pageInfo;
        } else if ($pageInfo === null) {
            $return['pageinfo'] = (object)[];
        }
        $return['data']['message'] = 'Success';
        if (is_array($items)) {
            $return['data']['items'] = $items;
        } else {
            $return['data']['items'] = array($items);
        }
        return $return;
    }

    /**
     * @param array $errors
     * @param string $method
     * @param int $code
     * @return array
     */
    public static function fail(array $errors, $method, $code = 400)
    {
        $return = [];
        $return['meta']['code'] = $code;
        $return['meta']['api_version'] = self::$apiVersion;
        $return['meta']['method'] = $method;
        $return['meta']['message'] = trans('message.api.error.global');
        if (is_array($errors)) {
            $return['meta']['errors'] = $errors;
        } else {
            $return['meta']['errors'] = array($errors);
        }
        $return['data']['message'] = 'errors';
        $return['data']['items'] = array();

        return $return;
    }

    /**
     * @param array $errors
     * @param string $method
     * @return array
     */
    public static function validation(array $errors, $method)
    {
        $return = [];
        $return['meta']['code'] = 422;
        $return['meta']['api_version'] = self::$apiVersion;
        $return['meta']['method'] = $method;
        $return['meta']['message'] = trans('message.api.error.validation');
        if (is_array($errors)) {
            $return['meta']['errors'] = $errors;
        } else {
            $return['meta']['errors'] = array($errors);
        }
        $return['data']['message'] = 'errors';
        $return['data']['items'] = array();

        return $return;
    }
}
