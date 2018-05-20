<?php

namespace App\Http\Controllers\Admin;

use App\Entity\User;
use App\Http\Requests\Admin\Users\CreateRequest;
use App\Http\Requests\Admin\Users\UpdateRequest;
use App\UseCases\Auth\RegisterService;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    private $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    public function index()
    {
       $users = User::orderBy('id','desc')->paginate(20);
       $statuses = User::getStatuses();
       return view('admin.users.index', compact('users','statuses'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(CreateRequest $request)
    {
        $user = User::new($request['name'],$request['email'],User::STATUS_ACTIVE,$request['password']);
        $user->save();
        return redirect()->route('admin.users.show',$user);
    }

    public function show(User $user)
    {
        $statuses = User::getStatuses();
        return view('admin.users.show',[
            'user' => $user,
            'statuses' => $statuses,
        ]);
    }

    public function edit(User $user)
    {
        $statuses = User::getStatuses();
        return view('admin.users.edit', compact('user','statuses'));
    }

    public function update(UpdateRequest $request, User $user)
    {
        $user->edit($request['name'],$request['email'],$request['status'],$request['password']);
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
        $user->delete();
        return redirect()->route('admin.users.index');
    }
}
