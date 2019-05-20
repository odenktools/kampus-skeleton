<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libraries\ResponseLibrary;
use App\Models\Berita;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

/**
 * BeritaController Controller API, dipergunakan untuk belajar mapping API Response yang sederhana.
 *
 * @author     Odenktools
 * @license    MIT
 * @package     \App\Models
 * @copyright  (c) 2019, Odenktools Technology
 */
class BeritaController extends Controller
{

    /**
     * Image Model.
     *
     * @return \App\Models\Image
     */
    private $imageModel;

    public function __construct()
    {
        $this->model = new Berita();
        $this->imageModel = new Image();
        $this->responseLib = new ResponseLibrary();
    }

    /**
     * Find data.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getIndex(Request $request)
    {
        try {
            $judul_berita = strtolower($request->input('judul_berita'));
            $tipe_berita = strtolower($request->input('tipe_berita'));
            $limit = $request->input('limit') ? $request->input('limit') : 10;
            $sortBy = $request->input('sort') ? $request->input('sort') : 'berita.post_date';
            $orderBy = $request->input('order') ? $request->input('order') : 'DESC';
            $conditions = '1 = 1';
            if ($limit >= 20) {
                $limit = 10;
            }
            if (!empty($judul_berita)) {
                $conditions .= " AND judul_berita LIKE '%$judul_berita%'";
            }
            if (!empty($tipe_berita)) {
                $conditions .= " AND tipe_berita = '$tipe_berita'";
            }
            $select = $this->model
                ->sql('*')
                ->whereRaw($conditions)
                ->limit($limit)
                ->orderBy($sortBy, $orderBy);
            $berita = array();
            if (!empty($select)) {
                foreach ($select->get() as $idx => $dt) {
                    $berita[$idx] = $dt;
                    $berita[$idx]['image_url'] = env('APP_URL') . Storage::url($berita[$idx]['image_url']);
                }
            }
            return response()->json(['berita'=>$berita], 200);
        } catch (QueryException $e) {
            $code = $e->getCode();
            $message = $e->getMessage();
            return response($this->responseLib->failResponse(400, array("Error kode $code", $message)), 400);
        } catch (\Exception $e) {
            $code = $e->getCode();
            $message = $e->getMessage();
            return response($this->responseLib->failResponse(400, array("Error kode $code", $message)), 400);
        }
    }

     /**
     * Insert data.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function postInsert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul_berita' => 'required|unique:berita|max:150',
            'tipe_berita' => 'required|max:50',
            'isi_berita' => 'required',
            'thumbnail' => 'mimes:jpeg,jpg,png|max:5000',
            'is_active' => 'required|boolean|between:0,1'
        ]);
        if ($validator->fails()) {
            return response($this->responseLib->validationFailResponse($validator->errors()->all()), 422);
        }
        DB::beginTransaction();
        try {
            $model = $this->model;
            $model->judul_berita = $request->input('judul_berita');
            $model->tipe_berita = $request->input('tipe_berita');
            $model->is_active = $request->input('is_active');
            $model->isi_berita = $request->input('isi_berita');
            foreach ($request->file() as $key => $file) {
                if ($request->hasFile($key)) {
                    if ($request->file($key)->isValid()) {
                        $path = $file->store('images/berita', 'public');
                        $key_id = $this->imageModel->create(['image_url' => $path])->id;
                        $model->thumbnail = $key_id;
                    }
                } else {
                    $key_id = !empty($request->$key.'_old') ? $request->$key.'_old' : null;
                    $model->thumbnail = $key_id;
                }
            }
            $model->post_date = date('Y-m-d');
            $model->save();
        } catch (QueryException $e) {
            DB::rollback();
            $code = $e->getCode();
            $message = $e->getMessage();
            return response()->json($this->responseLib->failResponse(400, array("Error kode $code", $message)), 400);
        } catch (\Exception $e) {
            DB::rollback();
            $code = $e->getCode();
            $message = $e->getMessage();
            return response()->json($this->responseLib->failResponse(400, array("Error kode $code", $message)), 400);
        }
        DB::commit();
        return response()->json($this->responseLib->createResponse(200, array('success')), 200);
    }

     /**
     * Update data.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function postUpdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'judul_berita' => 'required|unique:berita,judul_berita,' . $id . '|max:150',
            'tipe_berita' => 'required|max:50',
            'isi_berita' => 'required',
            'thumbnail' => 'mimes:jpeg,jpg,png|max:5000',
            'is_active' => 'required|boolean|between:0,1'
        ]);
        if ($validator->fails()) {
            return response($this->responseLib->validationFailResponse($validator->errors()->all()), 422);
        }
        DB::beginTransaction();
        try {
            $model = $this->model->findOrFail($id);
            $model->judul_berita = $request->input('judul_berita');
            $model->tipe_berita = $request->input('tipe_berita');
            $model->is_active = $request->input('is_active');
            $model->isi_berita = $request->input('isi_berita');
            foreach ($request->file() as $key => $file) {
                if ($request->hasFile($key)) {
                    if ($request->file($key)->isValid()) {
                        $path = $file->store('images/berita', 'public');
                        $key_id = $this->imageModel->create(['image_url' => $path])->id;
                        $model->thumbnail = $key_id;
                    }
                } else {
                    $key_id = !empty($request->$key.'_old') ? $request->$key.'_old' : null;
                    $model->thumbnail = $key_id;
                }
            }
            $model->update();
        } catch (QueryException $e) {
            DB::rollback();
            $code = $e->getCode();
            $message = $e->getMessage();
            return response()->json($this->responseLib->failResponse(400, array("Error kode $code", $message)), 400);
        } catch (\Exception $e) {
            DB::rollback();
            $code = $e->getCode();
            $message = $e->getMessage();
            return response()->json($this->responseLib->failResponse(400, array("Error kode $code", $message)), 400);
        }
        DB::commit();
        return response()->json($this->responseLib->createResponse(200, array('success')), 200);
    }
}
