<?php

namespace Test\App\Models;

use App\Repositories\TransferRepository;

use Tests\TestCase;

class TransferUnitTest extends TestCase
{
    /** @test */
    public function it_can_create_a_transaction()
    {
        $data = [
            'payer_id' => $this->faker->integer,
            'payee_id' => $this->faker->integer,
            'balance' => $this->faker->randomFloat(2, 0, 1000),
        ];

        $transferRepository = new TransferRepository();
        $transfer = $transferRepository->create($data);

        $this->assertInstanceOf(Transfer::class, $transfer);
        $this->assertEquals($data['payer_id'], $transfer->title);
        $this->assertEquals($data['payee_id'], $transfer->link);
        $this->assertEquals($data['balance'], $transfer->src);
    }
}
