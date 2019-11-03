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
 * Kampus Controller API, dipergunakan untuk belajar mapping API Response yang sederhana.
 *
 * @author     Odenktools
 * @license    MIT
 * @package     \App\Http\Controllers\Api
 * @copyright  (c) 2019, Odenktools
 * @link       https://odenktools.com
 */
class BeritaController extends Controller
{
    /**
     * Image Model.
     *
     * @return \App\Models\Image
     */
    private $imageModel;

    /**
     * BeritaController constructor.
     */
    public function __construct()
    {
        $this->model = new Berita();
        $this->imageModel = new Image();
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
            $arrayLog = array('IP' => $request->getClientIp());
            \Illuminate\Support\Facades\Log::info('REQUEST_DATA_BERITA' . json_encode($arrayLog));
            $judul_berita = strtolower($request->input('judul_berita'));
            $tipe_berita = strtolower($request->input('tipe_berita'));
            $limit = $request->input('limit') ? $request->input('limit') : 10;
            $sortBy = $request->input('sort') ? $request->input('sort') : 'berita.created_at';
            $orderBy = $request->input('order') ? $request->input('order') : 'DESC';
            $conditions = '1 = 1';
            if ($limit >= 20) {
                $limit = 10;
            }
            $conditions .= " AND is_active=1";
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
            return response()->json(['message'=>"Success", 'results' => $berita], 200);
        } catch (QueryException $e) {
            $code = $e->getCode();
            $message = $e->getMessage();
            $errors = array("Error kode $code", $message);
            \Illuminate\Support\Facades\Log::info('ERROR_REQUEST_DATA_BERITA' . json_encode($errors));
            return response()->json(['message' => "Error", 'results' => $errors], 400);
        } catch (\Exception $e) {
            $code = $e->getCode();
            $message = $e->getMessage();
            $errors = array("Error kode $code", $message);
            \Illuminate\Support\Facades\Log::info('ERROR_REQUEST_DATA_BERITA' . json_encode($errors));
            return response()->json(['message' => "Error", 'results' => $errors], 400);
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
            return response()->json(['message' => "Error", 'results' => $validator->errors()->all()], 400);
        }
        DB::beginTransaction();
        try {
            $model = $this->model;
            $model->judul_berita = $request->input('judul_berita');
            $model->tipe_berita = $request->input('tipe_berita');
            $model->is_active = $request->input('is_active');
            $model->post_date = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
            $model->isi_berita = $request->input('isi_berita');
            if (!$request->hasFile('thumbnail')) {
                $model->thumbnail = 0;
            }
            foreach ($request->file() as $key => $file) {
                if ($request->hasFile($key)) {
                    if ($request->file($key)->isValid()) {
                        $path = $file->store('images/berita', 'public');
                        $key_id = $this->imageModel->create(['image_url' => $path])->id;
                        $model->thumbnail = $key_id;
                    }
                } else {
                    $key_id = !empty($request->$key . '_old') ? $request->$key . '_old' : null;
                    $model->thumbnail = $key_id;
                }
            }
            $model->post_date = date('Y-m-d');
            $model->save();
        } catch (QueryException $e) {
            DB::rollback();
            $code = $e->getCode();
            $message = $e->getMessage();
            $errors = array("Error kode $code", $message);
            return response()->json(['message' => "Error", 'results' => $errors], 400);
        } catch (\Exception $e) {
            DB::rollback();
            $code = $e->getCode();
            $message = $e->getMessage();
            $errors = array("Error kode $code", $message);
            return response()->json(['message' => "Error", 'results' => $errors], 400);
        }
        DB::commit();
        return response()->json(['message' => "Success", 'results' => [$model]], 200);
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
            return response()->json(['message' => "Error", 'results' => $validator->errors()->all()], 400);
        }
        DB::beginTransaction();
        try {
          if($id === "1" || $id === "2"){
              DB::rollback();
              return response()->json(['message' => "Error", 'results' => array('maaf, data default tidak bisa diupdate')], 400);
          }
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
                    $key_id = !empty($request->$key . '_old') ? $request->$key . '_old' : null;
                    $model->thumbnail = $key_id;
                }
            }
            $model->update();
        } catch (QueryException $e) {
            DB::rollback();
            $code = $e->getCode();
            $message = $e->getMessage();
            $errors = array("Error kode $code", $message);
            return response()->json(['message' => "Error", 'results' => $errors], 400);
        } catch (\Exception $e) {
            DB::rollback();
            $code = $e->getCode();
            $message = $e->getMessage();
            $errors = array("Error kode $code", $message);
            return response()->json(['message' => "Error", 'results' => $errors], 400);
        }
        DB::commit();
        return response()->json(['message' => "Success", 'results' => [$model]], 200);
    }

    /**
     * Hapus data.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function postDelete($id)
    {
        DB::beginTransaction();
        try {
          if($id === "1" || $id === "2"){
              DB::rollback();
              return response()->json(['message' => "Error", 'results' => array('maaf, data default tidak bisa dihapus')], 400);
          }
          $model = $this->model->findOrFail($id);
          $model->delete();
        } catch (QueryException $e) {
            DB::rollback();
            $code = $e->getCode();
            $message = $e->getMessage();
            $errors = array("Error kode $code", $message);
            return response()->json(['message' => "Error", 'results' => $errors], 400);
        } catch (\Exception $e) {
            DB::rollback();
            $code = $e->getCode();
            $message = $e->getMessage();
            $errors = array("Error kode $code", $message);
            return response()->json(['message' => "Error", 'results' => $errors], 400);
        }
        DB::commit();
        return response()->json(['message' => "Success", 'results' => [$model]], 200);
    }
}
