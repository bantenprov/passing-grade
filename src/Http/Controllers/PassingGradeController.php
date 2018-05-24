<?php

namespace Bantenprov\PassingGrade\Http\Controllers;

/* Require */
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Bantenprov\PassingGrade\Facades\PassingGradeFacade;

/* Models */
use Bantenprov\Sekolah\Models\Bantenprov\Sekolah\Sekolah;
use Bantenprov\Siswa\Models\Bantenprov\Siswa\Siswa;
use App\User;
use Bantenprov\Sekolah\Models\Bantenprov\Sekolah\AdminSekolah;

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
    protected $admin_sekolah;
    protected $user_id;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->sekolah          = new Sekolah;
        $this->siswa            = new Siswa;
        $this->user             = new User;
        $this->user_id          = isset(Auth::User()->id) ?? null;
        $this->admin_sekolah    = AdminSekolah::where('admin_sekolah_id', $this->user_id)->first();
        $this->admin_sekolah_id = isset($this->admin_sekolah->sekolah_id) ?? null;
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

            $query = $this->sekolah
                ->orderBy($sortCol, $sortDir);
        } else {
            $query = $this->sekolah
                ->orderBy('npsn', 'asc');
        }

        if ($request->exists('filter')) {
            $query->where(function($q) use($request) {
                $value = "%{$request->filter}%";

                if (Auth::User()->hasRole(['superadministrator'])) {
                    $q->where('nama', 'like', $value)
                        ->orWhere('npsn', 'like', $value);
                } else {
                    $q->where('nama', 'like', $value)
                        ->orWhere('npsn', 'like', $value);
                }
            });
        }

        if (Auth::User()->hasRole(['superadministrator'])) {
            //
        } else {
            $query->where('id', $this->admin_sekolah_id);
        }

        $perPage = request()->has('per_page') ? (int) request()->per_page : null;
        $response = $query->with(['jenis_sekolah', 'province', 'city', 'district', 'village', 'master_zona', 'user'])->paginate($perPage);

        if (is_null($this->admin_sekolah) && !Auth::User()->hasRole(['superadministrator'])) {
            // $response = (object) [];
        } else {
            //
        }

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
    public function show($id, $track = null, Request $request)
    {
        if (request()->has('sort')) {
            list($sortCol, $sortDir) = explode('|', request()->sort);

            $query = $this->siswa->orderBy($sortCol, $sortDir);
        } else {
            $query = $this->siswa
                ->orderBy('nomor_un', 'asc');
        }

        if ($request->exists('filter')) {
            $query->where(function($q) use($request) {
                $value = "%{$request->filter}%";

                if (Auth::User()->hasRole(['superadministrator'])) {
                    $q->where('nomor_un', 'like', $value)
                        ->orWhere('nik', 'like', $value)
                        ->orWhere('nama_siswa', 'like', $value)
                        ->orWhere('no_kk', 'like', $value)
                        ->orWhere('nisn', 'like', $value);
                } else {
                    $q->where('nomor_un', 'like', $value)
                        ->orWhere('nik', 'like', $value)
                        ->orWhere('nama_siswa', 'like', $value)
                        ->orWhere('no_kk', 'like', $value)
                        ->orWhere('nisn', 'like', $value);
                }
            });
        }

        if (Auth::User()->hasRole(['superadministrator'])) {
            $query->where('sekolah_id', '=', $id);
        } else if (!is_null($this->admin_sekolah)) {
            $query->where('sekolah_id', '=', $this->admin_sekolah->sekolah_id);
        }

        if ($track == 'umum') {
            $query->whereIn('kegiatan_id', ['12', '22']);
        } else if ($track == 'prestasi') {
            $query->whereIn('kegiatan_id', ['11', '21']);
        }

        $perPage    = request()->has('per_page') ? (int) request()->per_page : null;

        if (is_null($this->admin_sekolah) && !Auth::User()->hasRole(['superadministrator'])) {
            $response   = $query->with(['province', 'city', 'district', 'village', 'sekolah', 'prodi_sekolah', 'user', 'akademik', 'nilai'])->paginate($perPage);
        } else {
            $response   = $query->with(['province', 'city', 'district', 'village', 'sekolah', 'prodi_sekolah', 'user', 'akademik', 'nilai'])->paginate($perPage);
        }

        foreach ($response as $siswa) {
            if (isset($siswa->prodi_sekolah->program_keahlian)) {
                $siswa->prodi_sekolah->program_keahlian;
            }
        }

        return response()->json($response)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
    }
}
