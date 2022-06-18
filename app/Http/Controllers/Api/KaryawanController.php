<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libraries\ResponseLibrary;
use App\Models\Kampus;
use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Propaganistas\LaravelPhone\PhoneNumber;

/**
 * Kampus Controller API.
 *
 * @author     Odenktools
 * @license    MIT
 * @package     \App\Http\Controllers\Api
 * @copyright  (c) 2019, Odenktools
 * @link       https://odenktools.com
 */
class KaryawanController extends Controller
{
    protected $configuration = [];

    /**
     * KampusController constructor.
     */
    public function __construct()
    {
        $this->model = new Kampus();
        $this->configuration['email_sender'] = env('APP_EMAIL_SENDER') ? env('APP_EMAIL_SENDER') : false;
    }

    /**
     * Find data.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getIndex(Request $request)
    {
        $data = \App\Models\Berita::all();
        return response()->json(array('data'=>$data), 200);
    }

    /**
     * Find data.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function postCreateData(Request $request)
    {
            $validator = Validator::make($request->all(), [
                'nama' => 'required|max:255'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }
        $data = array('nama'=>$request->input('nama'), 'kelas'=>$request->input('kelas'));
        return response()->json($data, 200);
    }


    /**
     * Find data.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function deleteHapus($id, Request $request)
    {
        $data = array('id'=>$id);
        return response()->json($data, 200);
    }
}
