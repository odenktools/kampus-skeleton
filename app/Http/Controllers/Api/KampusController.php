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

/**
 * Kampus Controller API.
 *
 * @author     Odenktools
 * @license    MIT
 * @package     \App\Http\Controllers\Api
 * @copyright  (c) 2019, Odenktools
 * @link       https://odenktools.com
 */
class KampusController extends Controller
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
        try {

            $nama_kampus = strtolower($request->input('nama_kampus'));
            $kode_kampus = strtolower($request->input('kode_kampus'));
            $alamat = strtolower($request->input('alamat'));
            $kota = strtolower($request->input('kota'));
            $limit = $request->input('limit') ? $request->input('limit') : 10;
            $sortBy = $request->input('sort') ? $request->input('sort') : 'kampus.updated_at';
            $orderBy = $request->input('order') ? $request->input('order') : 'DESC';
            $conditions = '1 = 1';

            if ($limit >= 20) {
                $limit = 10;
            }

            if (!empty($nama_kampus)) {
                $conditions .= " AND kampus.nama_kampus LIKE '%$nama_kampus%'";
            }

            if (!empty($kode_kampus)) {
                $conditions .= " AND kampus.kode_kampus = '$kode_kampus'";
            }

            if (!empty($alamat)) {
                $conditions .= " AND kampus.alamat LIKE '%$alamat%'";
            }

            if (!empty($kota)) {
                $conditions .= " AND kampus.kota LIKE '%$kota%'";
            }

            $select = $this->model
                ->sql('*')
                ->whereRaw($conditions)
                ->limit($limit)
                ->orderBy($sortBy, $orderBy);

            $paging = array();
            if (!empty($select)) {
                $paginate = $select->paginate($limit);
                $paging['total'] = $paginate->total();
                $paging['per_page'] = $paginate->perPage();
                $paging['current_page'] = $paginate->currentPage();
                $paging['last_page'] = $paginate->lastPage();
                $paging['next_page_url'] = $paginate->nextPageUrl();
                $paging['prev_page_url'] = $paginate->previousPageUrl();
                $paging['from'] = $paginate->firstItem();
                $paging['to'] = $paginate->lastItem();
                $kampusList = array();
                foreach ($select->get() as $idx => $dt) {
                    $kampusList[$idx] = $dt;
                    $kampusList[$idx]['image_url'] = env('APP_URL') . Storage::url($kampusList[$idx]['image_url']);
                }
                return response()->json(ResponseLibrary::paginate($kampusList, $paging), 200);
            }
        } catch (QueryException $e) {
            $code = $e->getCode();
            $message = $e->getMessage();
            $errors = array("Error kode $code", $message);
            //return response()->json(ResponseLibrary::paginate(array(), null), 200);
            return response()->json(ResponseLibrary::fail($errors, "GET"), 400);
        } catch (\Exception $e) {
            $code = $e->getCode();
            $message = $e->getMessage();
            $errors = array("Error kode $code", $message);
            return response()->json(ResponseLibrary::fail($errors, "GET"), 400);
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
            'nama_kampus' => 'required|unique:kampus|max:255',
            'no_telephone' => 'required|unique:kampus|max:150',
            'nama_admin' => 'required|unique:users,name|max:150',
            'handphone_admin' => 'required|phone:ID,mobile|unique:users,phone|max:15',
            'email_admin' => 'required|max:255|email_trust|unique:users,email',
            'kota' => 'required|max:255',
            'alamat' => 'required',
            'deskripsi' => 'required|string|max:255'
        ]);
        if ($validator->fails()) {
            return response(ResponseLibrary::validation($validator->errors()->all(), 'POST'), 422);
        }
        DB::beginTransaction();
        try {
            $vKampus = $this->model;
            $vKampus->nama_kampus = $request->input('nama_kampus');
            $vKampus->kode_kampus = Str::slug($request->input('nama_kampus'));
            $vKampus->no_telephone = $request->input('handphone_admin');
            $vKampus->kota = $request->input('kota');
            $vKampus->alamat = $request->input('alamat');
            $vKampus->deskripsi = $request->input('deskripsi');
            $vKampus->save();

            $apikey = \App\Libraries\StringHelpers::random();
            $user = new User();

            $user->kampus_id = $vKampus->id;
            $user->name = $request->nama_admin;
            $user->email = $request->email_admin;
            $user->phone = $request->handphone_admin;
            $user->password = bcrypt($request->password);
            $user->is_active = 1;
            $user->api_token = $apikey;
            $user->avatar = null;
            $user->save();


            $user->user_role()->attach(['role_id' => 1]);

        } catch (QueryException $e) {
            DB::rollback();
            $code = $e->getCode();
            $message = $e->getMessage();
            $errors = array("Error kode $code", $message);
            return response()->json(ResponseLibrary::fail($errors, "POST"), 400);

        } catch (\Exception $e) {
            DB::rollback();
            $code = $e->getCode();
            $message = $e->getMessage();
            $errors = array("Error kode $code", $message);
            return response()->json(ResponseLibrary::fail($errors, "POST"), 400);
        }

        DB::commit();

        $insertedData = array(
            'id' => $vKampus->id,
            'nama_kampus' => $vKampus->nama_kampus,
            'api_token' => $user->api_token,
            'email' => $user->email,
            'phone' => $user->phone
        );

        if ($this->configuration['email_sender']) {
            event(new \App\Events\KampusSaved($vKampus, $insertedData));
        }

        return response()->json(ResponseLibrary::ok($vKampus, "your apikey is $apikey"), 200);
    }

     /**
     * Insert data.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function getDetail($id)
    {
        $data = Kampus::find($id);
        if (!$data) {
            return response(ResponseLibrary::fail(array('Data not found'), "GET"), 400);
        }
        return response()->json(ResponseLibrary::okSingle($data, "success", 'GET'), 200);
    }

    /**
     * Update data.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function putUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|int',
            'nama_kampus' => 'required|unique:kampus,nama_kampus,' . $request->input('id') . '|max:255',
            'alamat' => 'required',
            'no_telephone' => 'required',
            'deskripsi' => 'required|string|max:255'
        ]);
        if ($validator->fails()) {
            return response(ResponseLibrary::validation($validator->errors()->all(), 'PUT'), 422);
        }
        DB::beginTransaction();
        try {
            $model = $this->model->findOrFail($request->input('id'));
            $model->nama_kampus = $request->input('nama_kampus');
            $model->kode_kampus = Str::slug($request->input('nama_kampus'));
            $model->no_telephone = $request->input('no_telephone');
            $model->alamat = $request->input('alamat');
            $model->deskripsi = $request->input('deskripsi');
            $model->update();
        } catch (QueryException $e) {
            DB::rollback();
            $code = $e->getCode();
            $message = $e->getMessage();
            $errors = array("Error kode $code", $message);
            return response(ResponseLibrary::fail($errors, "PUT"), 400);
        } catch (\Exception $e) {
            DB::rollback();
            $code = $e->getCode();
            $message = $e->getMessage();
            $errors = array("Error kode $code", $message);
            return response(ResponseLibrary::fail($errors, "PUT"), 400);
        }
        DB::commit();

        return response()->json(ResponseLibrary::ok($model, "success", 'PUT'), 200);
    }

    /**
     * Upload Image (multipart/form-data).
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function postImageKampus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|string|max:255',
            'foto_utama' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:6048',
            'foto_1' => 'image|mimes:jpeg,png,jpg,gif,svg|max:6048',
            'foto_2' => 'image|mimes:jpeg,png,jpg,gif,svg|max:6048',
            'foto_3' => 'image|mimes:jpeg,png,jpg,gif,svg|max:6048',
        ]);
        if ($validator->fails()) {
            return response(ResponseLibrary::validation($validator->errors()->all(), 'POST'), 422);
        }
        $data = Kampus::find($request->input('id'));
        if (!$data) {
            return response(ResponseLibrary::fail(array('Data not found'), "POST"), 400);
        }
        $imageData = array();
        DB::beginTransaction();
        try {
            if (!empty($request->file('foto_utama'))) {
                if ($request->file('foto_utama')->isValid()) {
                    $imageModel = new Image();
                    $path = $request->file('foto_utama')->store('images/kampus', 'public');
                    $key_id = $imageModel->create(['image_url' => $path])->id;
                    $imageData[$key_id] = array();
                }
            }
            if (!empty($request->file('foto_1'))) {
                if ($request->file('foto_1')->isValid()) {
                    $imageModel = new Image();
                    $path = $request->file('foto_1')->store('images/kampus', 'public');
                    $key_id = $imageModel->create(['image_url' => $path])->id;
                    $imageData[$key_id] = array();
                }
            }
            if (!empty($request->file('foto_2'))) {
                if ($request->file('foto_2')->isValid()) {
                    $imageModel = new Image();
                    $path = $request->file('foto_2')->store('images/kampus', 'public');
                    $key_id = $imageModel->create(['image_url' => $path])->id;
                    $imageData[$key_id] = array();
                }
            }
            if (!empty($request->file('foto_3'))) {
                if ($request->file('foto_3')->isValid()) {
                    $imageModel = new Image();
                    $path = $request->file('foto_3')->store('images/kampus', 'public');
                    $key_id = $imageModel->create(['image_url' => $path])->id;
                    $imageData[$key_id] = array();
                }
            }
            $data->kampus_images()->sync($imageData);
        } catch (QueryException $e) {
            DB::rollback();
            $code = $e->getCode();
            $message = $e->getMessage();
            $errors = array("Error kode $code", $message);
            return response(ResponseLibrary::fail($errors, "POST"), 400);
        } catch (\Exception $e) {
            DB::rollback();
            $code = $e->getCode();
            $message = $e->getMessage();
            $errors = array("Error kode $code", $message);
            return response(ResponseLibrary::fail($errors, "POST"), 400);
        }
        DB::commit();

        return response()->json(ResponseLibrary::ok($data, "success"), 200);
    }

    /**
     * Hapus records.
     *
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function deleteHapus($id)
    {
        DB::beginTransaction();
        try {
            $kampus = Kampus::find($id);
            if (!$kampus) {
                return response(ResponseLibrary::fail(array('Data not found'), "DELETE"), 400);
            }
            foreach ($kampus->users as $user) {
                $user->user_role()->detach();
                $user->delete();
            }
            $kampus->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            $code = $e->getCode();
            $message = $e->getMessage();
            $errors = array("Error kode $code", $message);
            return response(ResponseLibrary::fail($errors, "DELETE"), 400);
        } catch (\Exception $e) {
            DB::rollback();
            return response(ResponseLibrary::fail(array($e->getMessage()), "DELETE"), 400);
        }
        DB::commit();
        return response()->json(ResponseLibrary::ok($kampus, "success", 'DELETE'), 200);
    }
}
