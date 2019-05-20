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
    public function __construct()
    {
        $this->model = new Berita();
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
}
