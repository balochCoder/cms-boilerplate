<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:users-add|users-edit|role-view|users-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:users-add', ['only' => ['create', 'store']]);
        $this->middleware('permission:users-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:users-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::select('*');
            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return Str::ucfirst($row->name);
                })
                ->addColumn('role', function ($row) {
                    if (!empty($row->getRoleNames())) {
                        foreach ($row->getRoleNames() as  $roleName) {
                            $roleNameUC = Str::ucfirst($roleName);
                            return $roleNameUC;
                        }
                    }
                })
                ->addColumn('created_at', function ($row) {
                    return date('d-M-Y', strtotime($row->created_at));
                })
                ->addColumn('action', function ($row) {
                    if (Auth::user()->id !== $row->id) {
                        $btn = '';
                        if (Auth::user()->hasPermissionTo('users-edit')) {
                            $btn .= '<a href="' . route('users.edit', $row->id) . '"><i title="Edit" class="fas fa-edit font-size-18"></i></a>';
                        }

                        if (Auth::user()->hasPermissionTo('users-delete')) {
                            $btn .= ' <a href="javascript:void(0);" class="text-danger remove" data-id="' . $row->id . '"><input type="hidden" value="' . $row->id . '"/><i title="Delete" class="fas fa-trash-alt font-size-18"></i></a>';
                        }

                        return $btn;
                    }
                })
                ->rawColumns(['name', 'role', 'created_at', 'action'])
                ->make(true);
        }

        return view('backend.admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('backend.admin.users.create')->with('roles', $roles);
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm_password',
            'role' => 'required'
        ]);

        try {
            $user =  User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);

            $user->assignRole($request->role);

            $data['type'] = "success";
            $data['message'] = "User Added Successfuly!.";
            $data['icon'] = 'mdi-check-all';

            return redirect()->route('users.index')->with($data);
        } catch (\Throwable $th) {
            $data['type'] = "danger";
            $data['message'] = "Failed to Add User, please try again.";
            $data['icon'] = 'mdi-block-helper';

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
    public function edit(User $user)
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('backend.admin.users.edit', compact(['roles', 'user']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        // dd($user->getRoleNames());

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required'
        ]);

        try {
            $input = $request->all();
            if (!empty($input['password'])) {
                $this->validate($request, [
                    'password' => 'required',
                    'confirm_password' => 'required|same:password',
                ]);

                $input['password'] = Hash::make($input['password']);
            } else {
                $input = Arr::except($input, array('password'));
            }

            $user->update($input);

            if ($user->hasExactRoles($request->role)) {
                // dd('if');

                $user->syncRoles($request->role);
            } else {
                // dd($request->role);
                // $user->removeRole($request->role);
                $user->syncRoles($request->role);
            }
            $data['type'] = "success";
            $data['message'] = "User Update Successfuly!.";
            $data['icon'] = 'mdi-check-all';

            return redirect()->route('users.index')->with($data);
        } catch (\Throwable $th) {
            $data['type'] = "danger";
            $data['message'] = "Failed to Update User, please try again.";
            $data['icon'] = 'mdi-block-helper';

            return redirect()->route('users.index')->withInput()->with($data);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            $data['type'] = "success";
            $data['message'] = "User Deleted Successfuly!.";
            $data['icon'] = 'mdi-check-all';

            echo json_encode($data);
        } catch (\Throwable $th) {
            //throw $th;
            $data['type'] = "danger";
            $data['message'] = "Failed to Remove User, please try again.";
            $data['icon'] = 'mdi-block-helper';

            echo json_encode($data);
        }
    }
}
