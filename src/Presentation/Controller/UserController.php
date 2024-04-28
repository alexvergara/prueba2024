<?php

namespace App\Presentation\Controller;

use App\Application\Service\UserService;
use App\Presentation\Request\UserRegistrationRequest;
use App\Presentation\Response\ApiResponse;

class UserController
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(UserRegistrationRequest $request): ApiResponse
    {
        try {
            $user = $this->userService->registerUser(
                $request->getFullName(),
                $request->getDocumentId(),
                $request->getEmail(),
                $request->getPassword()
            );

            return new ApiResponse(201, ['user_id' => $user->getId()]);
        } catch (\Exception $e) {
            return new ApiResponse(400, $e->getMessage());
        }
    }
}

// Presentation/Controller/UserController.php
