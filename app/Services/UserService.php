<?php


namespace App\Services;


use App\ImageFile;
use App\Role;
use App\User;
use Illuminate\Http\Request;

class UserService
{
    public function createStandardUserWithIcon(User $user, ImageFile $imageFile)
    {
        $imageFile->save();
        $user->avatar = $imageFile->id;
        $this->createStandardUser($user);
    }

    public function createStandardUser(User $user)
    {
        $user->role()->associate(Role::getStandardRole());
        $user->save();
    }

    public function updateUser(Request $request, User $user, bool $deleteFile)
    {
        if ($deleteFile && $user->avatar) {
            ImageFile::destroy($user->avatar);
            $user->avatar = null;
        }
        $user->update($request->all());
    }

    public function deleteUser(User $user)
    {
        if ($user->avatar) {
            ImageFile::destroy($user->avatar);
        }
        $user->delete();
    }

}