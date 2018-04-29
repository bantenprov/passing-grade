<?php

namespace Bantenprov\PassingGrade\Http\Controllers;

/* Require */
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bantenprov\PassingGrade\Facades\PassingGradeFacade;

/* Models */
use Bantenprov\Sekolah\Models\Bantenprov\Sekolah\Sekolah;
use Bantenprov\Siswa\Models\Bantenprov\Siswa\Siswa;
use App\User;

/* Etc */
use Validator;
use Auth;

/**
 * The PassingGradeController class.
 *
 * @package Bantenprov\PassingGrade
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class PassingGradeController extends Controller
{
    protected $sekolah;
    protected $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->sekolah  = new Sekolah;
        $this->siswa    = new Siswa;
        $this->user     = new User;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->has('sort')) {
            list($sortCol, $sortDir) = explode('|', request()->sort);

            $query = $this->sekolah->orderBy($sortCol, $sortDir);
        } else {
            $query = $this->sekolah->orderBy('id', 'asc');
        }

        if ($request->exists('filter')) {
            $query->where(function($q) use($request) {
                $value = "%{$request->filter}%";

                $q->where('nama', 'like', $value)
                    ->orWhere('npsn', 'like', $value);
            });
        }

        $perPage = request()->has('per_page') ? (int) request()->per_page : null;

        $response = $query->with(['jenis_sekolah', 'province', 'city', 'district', 'village', 'master_zona', 'user'])->paginate($perPage);

        return response()->json($response)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sekolah  $sekolah
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        if (request()->has('sort')) {
            list($sortCol, $sortDir) = explode('|', request()->sort);
            $query = $this->siswa->orderBy($sortCol, $sortDir);
        } else {
            $query = $this->siswa->orderBy('id', 'asc');
        }

        if ($request->exists('filter')) {
            $query->where(function($q) use($request) {
                $value = "%{$request->filter}%";
                $q->where('nomor_un', 'like', $value)
                    ->orWhere('nik', 'like', $value)
                    ->orWhere('nama_siswa', 'like', $value)
                    ->orWhere('no_kk', 'like', $value)
                    ->orWhere('nisn', 'like', $value);
            });
        }

        $query->where('sekolah_id', '=', $id);

        $perPage    = request()->has('per_page') ? (int) request()->per_page : null;

        $response   = $query->with(['province', 'city', 'district', 'village', 'sekolah', 'prodi_sekolah', 'user'])->paginate($perPage);

        foreach($response as $siswa){
            if (isset($siswa->prodi_sekolah->program_keahlian)) {
                $siswa->prodi_sekolah->program_keahlian;
            }
        }

        return response()->json($response)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
    }
}
