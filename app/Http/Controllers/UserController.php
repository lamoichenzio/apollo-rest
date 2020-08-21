<?php

namespace App\Http\Controllers;

use App\Helpers\DataHelper;
use App\Http\Requests\UserCreationRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Services\ImageFileService;
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
        $params = request()->validate([
            'pag_size' => 'numeric',
            'username' => 'string|alpha_dash'
        ]);

        if (count($params) > 0) {
            //If request is paginated
            if ($pagSize = request('pag_size')) {
                unset($params['pag_size']);
                return UserResource::collection(User::where($params)->paginate($pagSize))->response();
            }
            $users = User::where($params)->get();
            return UserResource::collection($users)->response();
        }

        $links = User::all()->map(function ($user) {
            return $user->path();
        });
        return response()->json(DataHelper::listDataResponse($links));
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

        if ($fileData = $request['pic']) {
            $file = ImageFileService::createImageFile($fileData);
            $this->userService->createStandardUserWithIcon($user, $file);
        } else {
            $this->userService->createStandardUser($user);
        }

        return response()->json(
            DataHelper::creationDataResponse($user), 201, ["Location" => $user->path()]);
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
        return response()->json(new UserResource($user));
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
        if ($request['pic'] && $request['pic'] != 'delete') {
            $image = ImageFileService::updateImageFile($user->avatar, $request['pic']);
            $user->avatar = $image->id;
        }

        $this->userService->updateUser($request, $user, $request['pic'] == 'delete');
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
