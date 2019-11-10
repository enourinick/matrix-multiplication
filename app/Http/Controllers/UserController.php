<?php

namespace App\Http\Controllers;

use App\Exceptions\RepositoryException;
use App\Http\Requests\UserRequest;
use App\Services\UserService;
use App\Tools\ResponseWrapper;
use App\User;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * UserController constructor.
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return ResponseWrapper::successObject($this->userService->index());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return JsonResponse
     * @throws RepositoryException
     * @throws BindingResolutionException
     */
    public function store(UserRequest $request): JsonResponse
    {
        return ResponseWrapper::successObject($this->userService->store($request->all()), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @return JsonResponse
     */
    public function show(): JsonResponse
    {
        return ResponseWrapper::successObject($this->userService->show(request()->user()));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @return JsonResponse
     */
    public function update(UserRequest $request): JsonResponse
    {
        return ResponseWrapper::successObject($this->userService->update($request->all(), request()->user()));
    }
}
