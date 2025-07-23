<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;

use Illuminate\Support\Facades\Hash;

use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateUserRequest;


class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::all();

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<div class="d-flex">';
                        if (auth()->user()->can('show-user')) {
                            $btn .= '<a href="'.route("users.show", $row['id']).'" class="btn btn-warning btn-sm mr-2"><i class="bi bi-eye"></i> Show</a>';
                        }
                        if (in_array('Super Admin', $row->getRoleNames()->toArray() ?? [])) {
                            if (auth()->user()->hasRole('Super Admin')) {
                                $btn .= '<a href="'.route("users.edit", $row['id']).'" class="btn btn-primary btn-sm mr-2"><i class="bi bi-pencil-square"></i> Edit</a>';
                            }
                        } else {
                            if (auth()->user()->can('edit-user')) {
                                $btn .= '<a href="'.route("users.edit", $row['id']).'" class="btn btn-primary btn-sm mr-2"><i class="bi bi-pencil-square"></i> Edit</a>';
                            }
                            if (auth()->user()->can('destroy-user') && auth()->user()->id != $row['id']) {
                                $btn .= '<form action="'.route("users.destroy", $row['id']).'" method="POST" style="display:inline;">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger btn-sm mr-2" onclick="return confirm(\'Do you want to delete this user?\');"><i class="bi bi-trash"></i> Delete</button>
                                </form>';
                            }
                        }
                        $btn .= '</div>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('users.create', [
            'roles' => Role::pluck('name')->all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $input = $request->all();
        $input['password'] = Hash::make($request->password);

        $user = User::create($input);
        $user->assignRole($request->roles);

        return redirect()->route('users.index')
                ->withSuccess('New user is added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {
        return view('users.show', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        // Check Only Super Admin can update his own Profile
        if ($user->hasRole('Super Admin')){
            if($user->id != auth()->user()->id){
                abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
            }
        }

        return view('users.edit', [
            'user' => $user,
            'roles' => Role::pluck('name')->all(),
            'userRoles' => $user->roles->pluck('name')->all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
{
    $input = $request->all();
    $path = 'images';

    if ($request->hasFile('image')) {
        $old_image = $user->image;
        if ($old_image && file_exists(public_path('storage/' . $old_image))) {
            unlink(public_path('storage/' . $old_image));
        }
        $image_name = auth()->user()->id . time() . '.' . $request->image->extension();
        $request->image->move(public_path('storage/' . $path), $image_name);
        $input['image'] = $path . '/' . $image_name;
    } else {
        $input['image'] = $user->image;
    }

    if (!empty($request->password)) {
        $input['password'] = Hash::make($request->password);
    } else {
        unset($input['password']);
    }

    $user->update($input);
    $user->syncRoles($request->roles);

    if (empty($request->from)) {
        return redirect()->route('users.index')
            ->withSuccess('User is updated successfully.');
    } else {
        return redirect()->route('users.profile')
            ->withSuccess('Profile is updated successfully.');
    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        // About if user is Super Admin or User ID belongs to Auth User
        if ($user->hasRole('Super Admin') || $user->id == auth()->user()->id)
        {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
        }

        $user->syncRoles([]);
        $user->delete();
        return redirect()->route('users.index')->withSuccess('User is deleted successfully.');
    }
}
