<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreationRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\ImageFile;
use App\Services\UserService;
use App\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->middleware('auth:api', ['except' => ['store']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {

        request()->validate([
            'pagSize' => 'numeric',
            'username' => 'string|alpha_dash'
        ]);

        //If request is paginated
        if ($pagSize = request('pagSize')) {
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
     * @param UserCreationRequest $request
     * @return JsonResponse
     */
    public function store(UserCreationRequest $request)
    {
        $user = new User([
            'username' => $request['username'],
            'password' => Hash::make($request['password']),
            'email' => $request['email'],
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
        ]);

        if ($fileData = $request['pic']) {
            $file = new ImageFile(['name' => $fileData['name'], 'data' => $fileData['data']]);
            $this->userService->createStandardUserWithIcon($user, $file);
        } else {
            $this->userService->createStandardUser($user);
        }

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
     * @param UserUpdateRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        if ($password = $request['password']) {
            $request['password'] = Hash::make($password);
        }
        if ($request['file'] == 'delete' && $user->pic) {
            ImageFile::destroy($user->pic);
            $user->pic = null;
        }
        $user->update($request->all());
        return response()->json("", 204);
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
        $this->userService->deleteUser($user);
        return response()->json("", 204);
    }
}
