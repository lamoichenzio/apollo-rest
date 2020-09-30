<?php


namespace App\Services;


use App\Helpers\DataHelper;
use App\Role;
use App\User;
use Illuminate\Http\Request;

class UserService
{

    public function createStandardUser(User $user)
    {
        $user->role()->associate(Role::getStandardRole());
        $user->save();
        return DataHelper::creationDataResponse($user);
    }

    public function updateUser(Request $request, User $user, bool $deleteFile)
    {
        if ($deleteFile && $user->avatar) {
            ImageFileService::deleteFile($user->avatar);
            $user->avatar = null;
        }
        $user->update($request->all());
    }

    public function deleteUser(User $user)
    {
        if ($user->avatar) {
            ImageFileService::deleteFile($user->avatar);
        }
        $user->delete();
    }

    public function getUsers(int $pag_size = null, string $username = null,
                             string $order = null, string $orderDir = null)
    {
        $params = [];
        if ($username) {
            array_push($params, ['username', 'like', '%' . $username . '%']);
        }
        $query = User::where($params);
        if ($order != null && $orderDir != null) {
            $query = $query->orderBy($order, $orderDir);
        }
        if ($pag_size) {
            return $query->paginate($pag_size)->withQueryString();
        }
        return $query->get();
    }

    public function getUserLinks()
    {
        $data = User::all()->map(function ($user) {
            return $user->path();
        });
        return DataHelper::listDataResponse($data);
    }

}