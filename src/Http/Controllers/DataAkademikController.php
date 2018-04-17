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
        $this->data_akademik = $data_akademik;
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
                $q->where('label', 'like', $value)
                    ->orWhere('keterangan', 'like', $value);
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

        $response['current_user'] = $current_user;
        $response['status'] = true;

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
            'label'             => 'required',
            'keterangan'        => 'required',
            'user_id'           => 'required|unique:sekolahs,user_id',
        ]);

        if($validator->fails()){
            $check = $data_akademik->where('user_id',$request->user_id)->whereNull('deleted_at')->count();

            if ($check > 0) {
                $response['message'] = 'Failed' . $request->user_id . ' already exists';

            } else {
                $data_akademik->label             = $request->input('label');
                $data_akademik->keterangan        = $request->input('keterangan');
                $data_akademik->user_id           = $request->input('user_id');
                $data_akademik->save();

                $response['message'] = 'success';
            }
        } else {
                $data_akademik->label             = $request->input('label');
                $data_akademik->keterangan        = $request->input('keterangan');
                $data_akademik->user_id           = $request->input('user_id');
                $data_akademik->save();

            $response['message'] = 'success';
        }

        $response['status'] = true;

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

        $response['data_akademik']   = $data_akademik;
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

        $response['data_akademik']   = $data_akademik;
        $response['user']               = $data_akademik->user;
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

        if ($request->input('old_user_id') == $request->input('user_id'))
        {
            $validator = Validator::make($request->all(), [
                'label'               => 'required',
                'user_id'             => 'required',
                'keterangan'          => 'required',

            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'label'             => 'required',
                'keterangan'        => 'required',
                'user_id'           => 'required|unique:data_akademiks,user_id',
            ]);
        }

        if ($validator->fails()) {
            $check = $data_akademik->where('user_id',$request->user_id)->whereNull('deleted_at')->count();

            if ($check > 0) {
                $response['message'] = 'Failed,Username ' . $request->user_id . ' already exists';
            } else {
                $data_akademik->label                 = $request->input('label');
                $data_akademik->user_id               = $request->input('user_id');
                $data_akademik->keterangan            = $request->input('keterangan');
                $data_akademik->save();

                $response['message'] = 'success';
            }
        } else {
                $data_akademik->label                 = $request->input('label');
                $data_akademik->user_id               = $request->input('user_id');
                $data_akademik->keterangan            = $request->input('keterangan');
                $data_akademik->save();

            $response['message'] = 'success';
        }

        $response['status'] = true;

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
