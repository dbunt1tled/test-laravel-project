<?php

namespace App\Http\Controllers\Admin;

use App\Entity\User;
use App\Http\Requests\Admin\Users\CreateRequest;
use App\Http\Requests\Admin\Users\UpdateRequest;
use App\UseCases\Auth\RegisterService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gate;

class UsersController extends Controller
{
    private $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    public function index(Request $request)
    {
        $serchQuery = User::orderByDesc('id');
        if(!empty($value = $request->get('id'))){
           $serchQuery->where('id',$value);
        }
        if(!empty($value = $request->get('name'))){
            $serchQuery->where('name','like','%'.$value.'%');
        }
        if(!empty($value = $request->get('email'))){
            $serchQuery->where('email','like','%'.$value.'%');
        }
        if(is_numeric($value = $request->get('status'))){
            $serchQuery->where('status',$value);
        }
        if(!empty($value = $request->get('role'))){
            $serchQuery->where('role',$value);
        }
        $users = $serchQuery->paginate(20);
        $statuses = User::getStatuses();
        $roles = User::rolesList();
        return view('admin.users.index', compact('users','statuses','roles'));
    }

    public function create()
    {
        $statuses = User::getStatuses();
        $roles = User::rolesList();
        return view('admin.users.create', compact('statuses','roles'));
    }

    public function store(CreateRequest $request)
    {
        $user = User::new($request['name'],$request['email'],$request['status'],$request['password'],$request['role']);
        $user->save();
        return redirect()->route('admin.users.show',$user);
    }

    public function show(User $user)
    {
        $statuses = User::getStatuses();
        $roles = User::rolesList();
        return view('admin.users.show',[
            'user' => $user,
            'statuses' => $statuses,
            'roles' => $roles,
        ]);
    }

    public function edit(User $user)
    {
        $statuses = User::getStatuses();
        $roles = User::rolesList();
        return view('admin.users.edit', compact('user','statuses','roles'));
    }

    public function update(UpdateRequest $request, User $user)
    {
        $user->edit($request['name'],$request['email'],$request['status'],$request['password'],$request['role']);
        $user->save();
        return redirect()->route('admin.users.show',$user);
    }

    public function verify(User $user)
    {
        $this->registerService->verify($user->id);
        return redirect()->route('admin.users.show',$user);
    }

    public function destroy(User $user)
    {
        if(Gate::denies('users.manage')){
            abort(403,'В доступе отказано.');
        }
        $user->delete();
        return redirect()->route('admin.users.index');
    }
}
