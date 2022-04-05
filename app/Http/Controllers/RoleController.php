<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:roles-add|roles-edit|role-view|roles-delete', ['only' => ['index','store']]);
         $this->middleware('permission:roles-add', ['only' => ['create','store']]);
         $this->middleware('permission:roles-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:roles-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $roles = Role::select('*');
            return DataTables::of($roles)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return Str::ucfirst($row->name);
                })
                ->addColumn('created_at', function ($row) {
                    return date('d-M-Y', strtotime($row->created_at));
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('roles.edit', $row->id) . '"><i title="Edit" class="fas fa-edit font-size-18"></i></a>';
                    $btn .= ' <a href="javascript:void(0);" class="text-danger remove" data-id="' . $row->id . '"><input type="hidden" value="'.$row->id.'"/><i title="Delete" class="fas fa-trash-alt font-size-18"></i></a>';
                    return $btn;
                })
                ->rawColumns(['name', 'action', 'created_at'])
                ->make(true);
        }

        return view('backend.admin.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();

        return view('backend.admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        try {
            $role = Role::create(['name' => $request->input('name')]);
            $role->syncPermissions($request->input('permission'));

            $data['type'] = "success";
            $data['message'] = "Role Added Successfuly!.";
            $data['icon'] = 'mdi mdi-check-all';

            return redirect()->route('roles.index')->with($data);
        } catch (Exception $e) {

            if (!($e instanceof QueryException)) {
                app()->make(\App\Exceptions\Handler::class)->report($e); // Report the exception if you don't know what actually caused it
            }
            $data['type'] = "danger";
            $data['message'] = "Failed to Add Role, please try again.";
            $data['icon'] = 'mdi mdi-block-helper';
            return redirect()->back()->withInput()->with($data);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('backend.admin.roles.edit', compact(['permissions','role']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {

       
        $this->validate($request, [
            'name' => 'required|unique:roles,name,'.$role->id,
            'permission' => 'required',
        ]);
       
        try {
           $role->update([
               'name'=>$request->name
           ]);

           $role->syncPermissions($request->input('permission'));
           $data['type'] = "success";
           $data['message'] = "Role Updated Successfuly!.";
           $data['icon'] = 'mdi mdi-check-all';

           return redirect()->route('roles.index')->with($data);
        } catch (Exception $e) {
            if (!($e instanceof QueryException)) {
                app()->make(\App\Exceptions\Handler::class)->report($e); // Report the exception if you don't know what actually caused it
            }
            $data['type'] = "danger";
            $data['message'] = "Failed to update Role, please try again.";
            $data['icon'] = 'mdi mdi-block-helper';
            return redirect()->back()->withInput()->with($data);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        
        try {
            $role->delete();
            $data['type'] = "success";
            $data['message'] = "Role Deleted Successfuly!.";
            $data['icon'] = 'mdi-check-all';

            echo json_encode($data);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
