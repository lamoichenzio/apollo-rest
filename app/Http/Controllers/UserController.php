<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreationRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Services\ImageFileService;
use App\Services\UserService;
use App\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

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
        $params = request()->validate([
            'pag_size' => 'numeric',
            'username' => 'string',
            'order' => Rule::in(Schema::getColumnListing((new User)->getTable())),
            'order_dir' => Rule::in(['asc', 'desc'])
        ]);

        if (count($params) > 0) {
            return UserResource::collection(
                $this->userService->getUsers(request('pag_size'), request('username'),
                    request('order'), request('order_dir'))
            )->response();
        }

        return response()->json($this->userService->getUserLinks());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserCreationRequest $request
     * @return JsonResponse
     */
    public
    function store(UserCreationRequest $request)
    {
        $request['password'] = Hash::make($request['password']);
        $user = new User($request->all());
        if ($fileData = $request['avatar']) {
            $file = ImageFileService::createImageFile($fileData);
            $user->avatar = $file->id;
        }
        $data = $this->userService->createStandardUser($user);
        return response()->json(
            $data, 201, ["Location" => $user->path()]);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return JsonResponse
     */
    public
    function show(User $user)
    {
        return UserResource::make($user)->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserUpdateRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public
    function update(UserUpdateRequest $request, User $user)
    {
        if ($password = $request['password']) {
            $request['password'] = Hash::make($password);
        }

        //File update
        if ($request['avatar'] && $request['avatar'] != 'delete') {
            $image = ImageFileService::updateImageFile($user->avatar, $request['avatar']);
            $user->avatar = $image->id;
        }

        $this->userService->updateUser($request, $user, $request['avatar'] == 'delete');
        return response()->json("", 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return JsonResponse
     * @throws Exception
     */
    public
    function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $this->userService->deleteUser($user);
        return response()->json("", 204);
    }
}
