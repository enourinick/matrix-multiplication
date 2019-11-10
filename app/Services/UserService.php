<?php

namespace App\Services;

use App\Exceptions\RepositoryException;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return LengthAwarePaginator
     */
    public function index()
    {
        return $this->userRepository->paginate();
    }

    /**
     * @param $data
     * @return mixed
     * @throws RepositoryException
     * @throws BindingResolutionException
     */
    public function store($data)
    {
        return $this->userRepository->create($data);
    }

    /**
     * @param $data
     * @param User $user
     * @return mixed
     */
    public function update($data, User $user)
    {
        return $this->userRepository->update($data, $user);
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function show(User $user)
    {
        return $this->userRepository->load($user);
    }
}
