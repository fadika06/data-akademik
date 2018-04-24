<?php

namespace Bantenprov\DataAkademik\Http\Controllers;

/* Require */
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bantenprov\DataAkademik\Facades\DataAkademikFacade;
use App\User;

/* Models */
use Bantenprov\DataAkademik\Models\Bantenprov\DataAkademik\DataAkademik;

/* Etc */
use Validator;

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
        $response = $query->paginate($perPage);

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

        $role_check = \Auth::User()->hasRole(['superadministrator','administrator']);

        if($role_check){
            $response['user_special'] = true;
            foreach($users_special as $user){
                array_set($user, 'label', $user->name);
            }
            $response['user'] = $users_special;
        }else{
            $response['user_special'] = false;
            array_set($users_standar, 'label', $users_standar->name);
            $response['user'] = $users_standar;
        }

        array_set($current_user, 'label', $current_user->name);

        $response['current_user']   = $current_user;
        //$response['status']         = true;
        $response['error']          = false;
        $response['message']        = 'Success';
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
        $data_akademik = $this->data_akademik;

        $validator = Validator::make($request->all(), [
            'nomor_un'      => "required|max:255|unique:{$this->data_akademik->getTable()},nomor_un,NULL,id,deleted_at,NULL",
            'nama_siswa'        => 'required',
            'nomor_kk'          => 'required',
            'bahasa_indonesia'  => 'required|numeric',
            'bahasa_inggris'    => 'required|numeric',
            'matematika'        => 'required|numeric',
            'ipa'               => 'required|numeric',
            'user_id'           => 'required',
        ]);

        if ($validator->fails()) {
            $error      = true;
            $message    = $validator->errors()->first();

            } else {
                $data_akademik->nomor_un          = $request->input('nomor_un');
                $data_akademik->nama_siswa        = $request->input('nama_siswa');
                $data_akademik->nomor_kk          = $request->input('nomor_kk');
                $data_akademik->user_id           = $request->input('user_id');
                $data_akademik->bahasa_indonesia  = $request->input('bahasa_indonesia');
                $data_akademik->bahasa_inggris    = $request->input('bahasa_inggris');
                $data_akademik->matematika        = $request->input('matematika');
                $data_akademik->ipa               = $request->input('ipa');
                $data_akademik->save();

                $error      = false;
                $message    = 'Success';
            }

            $response['error']      = $error;
            $response['message']    = $message;
            $response['status']     = true;

            return response()->json($response);
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

        $response['data_akademik']      = $data_akademik;
        $response['status']             = true;

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

        $response['data_akademik']      = $data_akademik;
        $response['user']               = $data_akademik->user;
        //$response['status']             = true;
        $response['error']              = false;
        $response['message']            = 'Success';
        $response['status']             = true;

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
        $data_akademik = $this->data_akademik->findOrFail($id);
        {
            $validator = Validator::make($request->all(), [
                'nomor_un'          => "required|max:255|unique:{$this->data_akademik->getTable()},nomor_un,{$id},id,deleted_at,NULL",
                'nama_siswa'        => 'required',
                'nomor_kk'          => 'required',
                'bahasa_indonesia'  => 'required|numeric',
                'bahasa_inggris'    => 'required|numeric',
                'matematika'        => 'required|numeric',
                'ipa'               => 'required|numeric',
                'user_id'           => 'required',

            ]);
        if ($validator->fails()) {
                $error      = true;
                $message    = $validator->errors()->first();
        } else {
                $data_akademik->nomor_un          = $request->input('nomor_un');
                $data_akademik->nomor_kk          = $request->input('nomor_kk');
                $data_akademik->nama_siswa        = $request->input('nama_siswa');
                $data_akademik->user_id           = $request->input('user_id');
                $data_akademik->bahasa_indonesia  = $request->input('bahasa_indonesia');
                $data_akademik->bahasa_inggris    = $request->input('bahasa_inggris');
                $data_akademik->matematika        = $request->input('matematika');
                $data_akademik->ipa               = $request->input('ipa');
                $data_akademik->save();

                $error      = false;
                $message    = 'Success';
            }
        }

        $response['error']      = $error;
        $response['message']    = $message;
        $response['status']     = true;
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DataAkademik  $data_akademik
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data_akademik = $this->data_akademik->findOrFail($id);

        if ($data_akademik->delete()) {
            $response['status'] = true;
        } else {
            $response['status'] = false;
        }

        return json_encode($response);
    }
}
