<?php

namespace Bantenprov\DataAkademik\Http\Controllers;

/* Require */
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bantenprov\DataAkademik\Facades\DataAkademikFacade;
use Bantenprov\Sekolah\Models\Bantenprov\Sekolah\AdminSekolah;
use App\User;

/* Models */
use Bantenprov\DataAkademik\Models\Bantenprov\DataAkademik\DataAkademik;

/* Etc */
use Validator;
use Auth;

/**
 * The DataAkademikController class.
 *
 * @package Bantenprov\DataAkademik
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class DataAkademikController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $user;
    public function __construct(DataAkademik $data_akademik, User $user)
    {
        $this->data_akademik    = $data_akademik;
        $this->user             = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('sort')) {
            list($sortCol, $sortDir) = explode('|', $request->sort);

            $query = $this->data_akademik->with('user')->orderBy($sortCol, $sortDir);
        } else {
            $query = $this->data_akademik->with('user')->orderBy('id', 'asc');
        }

        if ($request->exists('filter')) {
            $query->where(function($q) use($request) {
                $value = "%{$request->filter}%";
                $q->where('nama_siswa', 'like', $value)
                    ->orWhere('nomor_un', 'like', $value);
            });
        }


        $perPage = $request->has('per_page') ? (int) $request->per_page : null;

        if($this->checkRole(['superadministrator','administrator'])){
            $response = $query->paginate($perPage);
        }else{
            $response = [];
        }

        return response()->json($response)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $response = [];

        $users_special = $this->user->all();
        $users_standar = $this->user->find(\Auth::User()->id);
        $current_user = \Auth::User();

        $role_check = \Auth::User()->hasRole(['superadministrator']);

        if($role_check){
            $response['user_special'] = true;
            foreach($users_special as $user){
                array_set($user, 'label', $user->name);
            }
            $response['user'] = $users_special;
        }else{
            $response['user_special'] = false;
            array_set($users_standar, 'label', $users_standar->name);
            if($this->checkRole(['superadministrator','administrator'])){
                $response['user'] = $users_standar;
            }else{
                $response['user'] = null;
            }
        }

        array_set($current_user, 'label', $current_user->name);

        if($this->checkRole(['superadministrator','administrator'])){
            $response['current_user']   = $current_user;
            $response['status']         = true;
            $response['error']          = false;
        }else{
            $response['current_user']   = null;
            $response['status']         = null;
            $response['error']          = true;
            $response['message']        = 'Anda Tidak mempunyai hak akses';            
        }

        $response['status']         = true;

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DataAkademik  $data_akademik
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($this->checkRole(['superadministrator','administrator'])){
            
            $data_akademik = $this->data_akademik;

            $validator = Validator::make($request->all(), [
                'nomor_un'          => 'required|unique:data_akademiks,nomor_un',
                'nama_siswa'        => 'required',
                'nomor_kk'          => 'max:255',
                'tanggal_lahir'     => 'required|date',
                'bahasa_indonesia'  => 'required|numeric',
                'bahasa_inggris'    => 'required|numeric',
                'matematika'        => 'required|numeric',
                'ipa'               => 'required|numeric',
                'user_id'           => 'required',
            ]);

        if($validator->fails()){
            $check = $data_akademik->where('nomor_un',$request->nomor_un)->whereNull('deleted_at')->count();

            if ($check > 0) {
                $response['message'] = 'Failed Nomor UN : ' . $request->nomor_un . ' already exists';

            } else {
                $data_akademik->nomor_un          = $request->input('nomor_un');
                $data_akademik->nama_siswa        = $request->input('nama_siswa');
                $data_akademik->nomor_kk          = $request->input('nomor_kk');
                $data_akademik->tanggal_lahir     = $request->input('tanggal_lahir');
                $data_akademik->user_id           = $request->input('user_id');
                $data_akademik->bahasa_indonesia  = $request->input('bahasa_indonesia');
                $data_akademik->bahasa_inggris    = $request->input('bahasa_inggris');
                $data_akademik->matematika        = $request->input('matematika');
                $data_akademik->ipa               = $request->input('ipa');
                $data_akademik->save();
            }
        } else {
            $data_akademik->nomor_un          = $request->input('nomor_un');
            $data_akademik->nama_siswa        = $request->input('nama_siswa');
            $data_akademik->nomor_kk          = $request->input('nomor_kk');
            $data_akademik->tanggal_lahir     = $request->input('tanggal_lahir');
            $data_akademik->user_id           = $request->input('user_id');
            $data_akademik->bahasa_indonesia  = $request->input('bahasa_indonesia');
            $data_akademik->bahasa_inggris    = $request->input('bahasa_inggris');
            $data_akademik->matematika        = $request->input('matematika');
            $data_akademik->ipa               = $request->input('ipa');
            $data_akademik->save();

        }

        $response['status']         = true;
        $response['error']          = false;
        $response['message']        = 'Success';

        return response()->json($response);

        }else{
            $response['message'] = 'Tidak mempunyai hak ases untuk ini.';
            $response['status']  = true;

            return response()->json($response);

        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {


        $data_akademik = $this->data_akademik->findOrFail($id);

        array_set($data_akademik, 'user', $data_akademik->user->name);

        if($this->checkRole(['superadministrator','administrator'])){
            $response['data_akademik']      = $data_akademik;
            $response['status']             = true;
        }else{
            $response['data_akademik']      = [];
            $response['massege']            = 'Tidak mempunyai hak akses untuk ini.';
            $response['status']             = true;
        }


        return response()->json($response);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DataAkademik  $data_akademik
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data_akademik = $this->data_akademik->findOrFail($id);

        array_set($data_akademik->user, 'label', $data_akademik->user->name);

        if($this->checkRole(['superadministrator'])){
            $response['data_akademik']      = $data_akademik;
            $response['user']               = $data_akademik->user;
            $response['status']             = true;
        }else{
            $response['message']            = 'Tidak mempunyai hak akses untuk ini.';
            $response['data_akademik']      = null;
            $response['user']               = null;
            $response['status']             = true;
        }



        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DataAkademik  $data_akademik
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($this->checkRole(['superadministrator'])){

        $data_akademik = $this->data_akademik->findOrFail($id);

        if ($request->input('old_nomor_un') == $request->input('nomor_un'))
        {
            $validator = Validator::make($request->all(), [
                'nomor_un'          => 'required',
                'nama_siswa'        => 'required',
                'nomor_kk'          => 'required',
                'tanggal_lahir'     => 'required|date',
                'bahasa_indonesia'  => 'required|numeric',
                'bahasa_inggris'    => 'required|numeric',
                'matematika'        => 'required|numeric',
                'ipa'               => 'required|numeric',
                'user_id'           => 'required',

            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'nomor_un'          => 'required|unique:data_akademiks,nomor_un',
                'nama_siswa'        => 'required',
                'nomor_kk'          => 'max:255',
                'tanggal_lahir'     => 'required|date',
                'bahasa_indonesia'  => 'required|numeric',
                'bahasa_inggris'    => 'required|numeric',
                'matematika'        => 'required|numeric',
                'ipa'               => 'required|numeric',
                'user_id'           => 'required',
            ]);
        }

        if ($validator->fails()) {
            $check = $data_akademik->where('nomor_un',$request->nomor_un)->whereNull('deleted_at')->count();

            if ($check > 0) {
                $response['message'] = 'Failed Nomor UN : ' . $request->nomor_un . ' already exists';
                $response['status']         = true;
                $response['error']          = true;
            } else {
                $data_akademik->nomor_un          = $request->input('nomor_un');
                $data_akademik->nomor_kk          = $request->input('nomor_kk');
                $data_akademik->nama_siswa        = $request->input('nama_siswa');
                $data_akademik->tanggal_lahir     = $request->input('tanggal_lahir');
                $data_akademik->user_id           = $request->input('user_id');
                $data_akademik->bahasa_indonesia  = $request->input('bahasa_indonesia');
                $data_akademik->bahasa_inggris    = $request->input('bahasa_inggris');
                $data_akademik->matematika        = $request->input('matematika');
                $data_akademik->ipa               = $request->input('ipa');
                $data_akademik->save();

                $response['message']        = 'Success';
                $response['status']         = true;
                $response['error']          = false;
            }
        } else {
            $data_akademik->nomor_un          = $request->input('nomor_un');
            $data_akademik->nomor_kk          = $request->input('nomor_kk');
            $data_akademik->nama_siswa        = $request->input('nama_siswa');
            $data_akademik->tanggal_lahir     = $request->input('tanggal_lahir');
            $data_akademik->user_id           = $request->input('user_id');
            $data_akademik->bahasa_indonesia  = $request->input('bahasa_indonesia');
            $data_akademik->bahasa_inggris    = $request->input('bahasa_inggris');
            $data_akademik->matematika        = $request->input('matematika');
            $data_akademik->ipa               = $request->input('ipa');
            $data_akademik->save();

            $response['status']         = true;
            $response['error']          = false;
            $response['message']        = 'Success';

            
        }   
            

            return response()->json($response);
    }else{

            $response['status'] = true;
            $response['message'] = 'Tidak mempunyai akses untuk ini.';

            return response()->json($response);

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DataAkademik  $data_akademik
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        if($this->checkRole(['superadministrator'])){

        $data_akademik = $this->data_akademik->findOrFail($id);

        if ($data_akademik->delete()) {
            $response['status'] = true;
        } else {
            $response['status'] = false;
        }

        return json_encode($response);
    }else{

        $response['status']     = true;
            $response['message']    = 'Tidak mempunyai akses untuk ini.';

            return response()->json($response);
        }

    }

    /* Check Role */

    protected function checkRole($role = array())
    {
        return Auth::user()->hasRole($role);
    }
}
