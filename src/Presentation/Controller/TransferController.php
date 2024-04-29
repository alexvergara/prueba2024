<?php

namespace App\Presentation\Controller;

use App\Application\Service\TransferService;
use App\Presentation\Request\TransferRequest;
use App\Presentation\Response\ApiResponse;

class TransferController
{
    private $transferService;

    public function __construct(TransferService $transferService)
    {
        $this->transferService = $transferService;
    }

    public function transfer(TransferRequest $request): ApiResponse
    {
        try {
            $this->transferService->transfer(
                $request->getPayerId(),
                $request->getPayeeId(),
                $request->getAmount()
            );

            return new ApiResponse(200, 'Transfer successful.');
        } catch (\Exception $e) {
            return new ApiResponse(500, $e->getMessage());
        }
    }
}

// Presentation/Controller/TransferController.php
