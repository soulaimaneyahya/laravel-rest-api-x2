<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\ApiController;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends ApiController
{
    public function index(): JsonResponse
    {
        $users = User::all();

        return $this->showAll($users, 200);
    }

    public function store(CreateUserRequest $request)
    {
        $data = $request->validated();

        $data['api_token'] = User::generateToken();
        $data['verification_token'] = User::generateToken();
        $data['password'] = Hash::make($data['password']);
        $data['verified'] = User::UNVERIFIED_USER;
        $data['is_admin'] = User::REGULAR_USER;

        $user = User::create($data);

        return $this->showOne($user, 201);
    }

    public function show(User $user): JsonResponse
    {
        return $this->showOne($user, 200);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();

        if (isset($data['name'])) {
            $user->name = $data['name'];
        }

        if (isset($data['email']) && $data['email'] != $user->email) {
            $user->verified = USER::UNVERIFIED_USER;
            $user->verification_token = User::generateToken();
            $user->email = $data['email'];
        }

        if (isset($data['is_admin'])) {
            if (!$user->isVerified()) {
                // 422 // Unprocessable Entity // 409 // conflict
                return $this->infoResponse('Only verified users can change admin field', 409);
            }

            $user->is_admin = $data['is_admin'];
        }

        if (isset($data['password'])) {
            $user->password = bcrypt($data['password']);
        }

        if (isset($data['verified']) && !$user->isVerified()) {
            $user->verified = USER::VERIFIED_USER;
            $user->verification_token = null;
        }

        if (!$user->isDirty()) {
            return $this->infoResponse('You need to specify diff value to change', 422);
        }

        $user->save();

        return $this->showOne($user, 200);
    }

    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return $this->infoResponse('user deleted', 200);
    }

    public function restore(string $id): JsonResponse
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();

        return $this->infoResponse('user restored', 200);
    }
}
