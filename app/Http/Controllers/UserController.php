<?php

namespace App\Http\Controllers;

use App\Http\PagedIndexes\UserPagedIndex;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function index(): Response
    {
        return new Response(UserPagedIndex::all());
    }

    public function show(User $user): Response
    {
        return new Response($user);
    }

    public function store(StoreUserRequest $request): Response
    {
        $user = User::create($request->validated());
        return new Response($user, Response::HTTP_CREATED);
    }

    public function update(UserRequest $request, User $user): Response
    {
        $user->update($request->validated());
        return new Response($user);
    }

    public function destroy(User $user): Response
    {
        $user->delete();
        return new Response($user);
    }
}
