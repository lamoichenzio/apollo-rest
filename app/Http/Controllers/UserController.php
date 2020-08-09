<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Role;
use App\User;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['store']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        //If request is paginated
        if ($pagSize = request('pagSize')) {
            request()->validate([
                'pagSize' => 'numeric'
            ]);
            if ($username = \request('username')) {
                return UserResource::collection(User::where('username', $username)->paginate($pagSize))->response();
            }
            return UserResource::collection(User::paginate($pagSize))->response();
        }

        if ($name = request('username')) {
            $users = User::where('username', $name)->get();
            return UserResource::collection($users)->response();
        }

        $links = User::all()->map(function ($user) {
            return $user->path();
        });
        return response()->json(['data' => $links]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|min:4',
            'password' => 'required|min:5',
            'email' => 'required|email|unique:users'
        ]);

        $user = new User([
            'username' => $request['username'],
            'password' => Hash::make($request['password']),
            'email' => $request['email'],
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
            'pic' => $request['pic']
        ]);
        $user->role_id = Role::getStandardRole()->id;
        $user->save();

        return response()->json(['self' => $user->path()], 201, ["Location" => $user->path()]);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function show(User $user)
    {
        return response()->json(new UserResource($user));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $request->validate([
            'username' => 'sometimes|required|min:4',
            'password' => 'sometimes|required|min:5',
            'old_password' => 'required_with:password|password',
            'email' => 'sometimes|required|email|unique:users',
        ]);

        if($password = $request['password']){
            $request['password']=Hash::make($password);
        }

        $user->update($request->all());
        return response()->json("",204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $user->delete();
        return response()->json("",204);
    }
}
