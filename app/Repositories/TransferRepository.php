<?php

namespace App\Repositories;

use App\Models\Transfer;
// TODO: Create Exception

class TransferRepository
{
    /**
     * TransferRepository constructor.
     * @param Transfer $transfer
     */
    public function __construct(Transfer $transfer)
    {
        $this->model = $transfer;
    }

    /**
     * @param array $data
     * @return Transfer
     * @throws CreateTransferErrorException
     */
    public function createTransfer(array $data): Transfer
    {
        try {
            return $this->model->create($data);
        } catch (QueryException $e) {
            throw new CreateTransferErrorException($e);
        }
    }
}
