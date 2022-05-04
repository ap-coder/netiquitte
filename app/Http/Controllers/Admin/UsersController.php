<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = User::with(['roles', 'team'])->get();

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'user_show';
                $editGate = 'user_edit';
                $deleteGate = 'user_delete';
                $crudRoutePart = 'users';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : '';
            });
            $table->editColumn('email_verified_at', function ($row) {
                return $row->email_verified_at ? $row->email_verified_at : '';
            });
            $table->editColumn('roles', function ($row) {
                $labels = [];

                foreach ($row->roles as $role) {
                    $labels[] = sprintf('<span class="btn btn-outline-primary btn-xs">%s</span>', $role->title);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('status', function ($row) {
                if ($row->approved == 1) {
                    $labels = '<input class="chkToggle" checked type="checkbox" data-toggle="toggle" data-on="Approved" data-off="Pending" data-onstyle="success" data-offstyle="warning" userID="'.$row->id.'" data-size="mini">' ;
                } else {
                    $labels = '<input class="chkToggle" type="checkbox" data-toggle="toggle" data-on="Approved" data-off="Pending" data-onstyle="success" data-offstyle="warning" userID="'.$row->id.'" data-size="mini"> &nbsp; &nbsp; 
                    
                    <a href="'.route("userDeclined", $row->id).'" class="userDeclined  btn btn-dark btn-xs"><span class="fas fa-times"></span></a>
                ';
                }
            //     <form action="'.route("admin.users.destroy", $row->id).'" method="POST" onsubmit="return confirm('.trans('global.areYouSure').');" style="display: inline-block;">
            //     <input type="hidden" name="_method" value="DELETE">
            //     <input type="hidden" name="_token" value="'.csrf_token().'">
            //     <input type="submit"  value="X">
            // </form>
                // <a href=""><span class="fas fa-times"></span></a>
                return $labels;
            });

            $table->rawColumns(['actions', 'placeholder', 'roles', 'status']);

            return $table->make(true);
        }

        return view('admin.users.index');
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('title', 'id');

        $teams = Team::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.users.create', compact('roles', 'teams'));
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', []));

        if ($request->input('photo', false)) {
            $user->addMedia(storage_path('tmp/uploads/'.basename($request->input('photo'))))->toMediaCollection('photo');
        }

        return redirect()->route('admin.users.index');
    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('title', 'id');

        $teams = Team::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $user->load('roles', 'team');

        return view('admin.users.edit', compact('roles', 'teams', 'user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        $user->roles()->sync($request->input('roles', []));

        if ($request->input('photo', false)) {
            if (! $user->photo || $request->input('photo') !== $user->photo->file_name) {
                if ($user->photo) {
                    $user->photo->delete();
                }
                $user->addMedia(storage_path('tmp/uploads/'.basename($request->input('photo'))))->toMediaCollection('photo');
            }
        } elseif ($user->photo) {
            $user->photo->delete();
        }

        return redirect()->route('admin.users.index');
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->load('roles', 'team', 'userUserAlerts');

        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->team()->delete();
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Successfully deleted user!');
    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        User::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
