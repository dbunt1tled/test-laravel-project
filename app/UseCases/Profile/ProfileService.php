<?php
/**
 * Created by PhpStorm.
 * User: sid
 * Date: 10.07.18
 * Time: 17:55
 */

namespace App\UseCases\Profile;

use App\Entity\User;
use App\Http\Requests\Cabinet\UpdateRequest;
class ProfileService
{
    public function edit($id, UpdateRequest $request): void
    {
        /** @var User $user */
        $user = User::findOrFail($id);
        $oldPhone = $user->phone;
        $user->update($request->only('name', 'last_name', 'phone'));
        if ($user->phone !== $oldPhone) {
            $user->unverifyPhone();
        }
    }
}