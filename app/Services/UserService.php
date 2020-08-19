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
        $user->pic = $imageFile->id;
        $this->createStandardUser($user);
    }

    public function createStandardUser(User $user)
    {
        $user->role_id = Role::getStandardRole()->id;
        $user->save();
    }

    public function updateUser(Request $request, User $user, bool $deleteFile)
    {
        if ($deleteFile && $user->pic) {
            ImageFile::destroy($user->pic);
            $user->pic = null;
        }
        $user->update($request->all());
    }

    public function deleteUser(User $user)
    {
        if ($user->pic) {
            ImageFile::destroy($user->pic);
        }
        $user->delete();
    }

}