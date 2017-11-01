<?php

namespace Tests\Unit;

use App\Alert;
use App\Facades\EtherPrice;
use App\Price;
use App\Services\EtherPriceService;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Mockery;
use Tests\TestCase;

class EtherPriceServiceTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function test_users_get_notified_when_price_surpasses_alert_price()
    {
        Price::insert([
            ['price' => 95],
            ['price' => 105]
        ]);

        $serviceMock = Mockery::mock(EtherPriceService::class)->makePartial();
        $serviceMock
            ->shouldReceive('getCurrentPrice')
            ->once()
            ->andReturn(Price::all()->last());


        $user = factory(User::class)->create();
        $alert = Alert::make([
            'direction' => 'above',
            'price' => 100,
        ]);
        $user->alerts()->save($alert);

    }
}
