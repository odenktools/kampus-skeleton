<?php

namespace App\Libraries;

use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Contracts\Pagination\Paginator;

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
    public static $apiVersion = "1.0.1";

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
        $return['pageinfo'] = (object)[];
        $return['errors'] = array();
        $return['data']['message'] = $messages;
        $return['data']['item'] = (object)[];
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
     * @param array $items
     * @param string $messages
     * @param string $method
     * @return array
     */
    public static function okSingle($item, $messages, $method = 'POST')
    {
        $return = [];
        $return['meta']['code'] = JsonResponse::HTTP_OK;
        $return['meta']['api_version'] = self::$apiVersion;
        $return['meta']['method'] = $method;
        $return['meta']['message'] = trans('message.api.success');
        //$return['pageinfo'] = (object)[];
        $return['pageinfo'] = self::emptyPageInfo();
        $return['errors'] = array();
        $return['data']['message'] = $messages;
        $return['data']['item'] = $item;
        $return['data']['items'] = array();

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
    public static function paginate($items, Paginator $paged, $code = 200)
    {
        $return = [];
        $return['meta']['code'] = $code;
        $return['meta']['api_version'] = self::$apiVersion;
        $return['meta']['method'] = 'GET';
        $return['meta']['message'] = trans('message.api.success');
        $return['pageinfo'] = (object) [
            "total" => null,
            "per_page" => $paged->perPage(),
            "current_page" => $paged->currentPage(),
            "last_page" => $paged->lastPage(),
            "next_page_url" => $paged->nextPageUrl(),
            "prev_page_url" => $paged->previousPageUrl(),
            "from" => $paged->firstItem(),
            "to" => $paged->lastItem()
        ];
        $return['errors'] = array();
        $return['data']['message'] = 'Success';
        $return['data']['item'] = (object)[];
        if (is_array($items)) {
            $return['data']['items'] = $items;
        } else if (is_object($items)) {
            $return['data']['items'] = (object)($items);
        } else {
            $return['data']['items'] = $items;
        }
        return $return;
    }

    /**
     * Create empty response.
     *
     * @return object
     */
    private static function emptyPageInfo()
    {
        $pageInfo = (object) [
            "total" => null,
            "per_page" => null,
            "current_page" => null,
            "last_page" => null,
            "next_page_url" => null,
            "prev_page_url" => null,
            "from" => null,
            "to" => null
        ];

        return $pageInfo;
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
        $return['pageinfo'] = self::emptyPageInfo();
        if (is_array($errors)) {
            $return['meta']['errors'] = $errors;
        } else {
            $return['meta']['errors'] = array($errors);
        }
        $return['data']['message'] = 'errors';
        $return['data']['items'] = array();
        $return['data']['item'] = (object)[];

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
        $return['pageinfo'] = self::emptyPageInfo();
        $return['errors'] = array();
        if (is_array($errors)) {
            $return['errors'] = $errors;
        } else {
            $return['errors'] = array($errors);
        }
        $return['data']['message'] = 'errors';
        $return['data']['items'] = array();
        $return['data']['item'] = (object)[];

        return $return;
    }
}
