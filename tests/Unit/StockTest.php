<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Stock;
use App\Models\SvsStock;
use App\Models\ServiceRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class StockTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_create_a_stock(): void
    {
        $stock = Stock::create([
            'item_name' => 'Coffin',
            'item_qty' => 10,
            'size_weight' => 'Large',
            'item_unit_price' => 5000.00,
            'item_type' => 'Funeral Supply',
        ]);

        $this->assertDatabaseHas('stocks', [
            'item_name' => 'Coffin',
            'item_qty' => 10,
            'item_unit_price' => 5000.00,
        ]);

        $this->assertTrue($stock->exists);
        $this->assertEquals('Coffin', $stock->item_name);
        $this->assertEquals('Funeral Supply', $stock->item_type);
    }

    #[Test]
    public function it_has_many_service_stocks(): void
    {
        // Create a stock item
        $stock = Stock::create([
            'item_name' => 'Candle Set',
            'item_qty' => 100,
            'size_weight' => 'Small',
            'item_unit_price' => 50.00,
            'item_type' => 'Consumable',
        ]);

        // Create a dummy Service Request (to satisfy foreign key)
        $serviceRequest = ServiceRequest::create([
            'client_name' => 'Juan Dela Cruz',
            'client_contact_number' => '09123456789',
            'svc_startDate' => now(),
            'svc_endDate' => now()->addDays(3),
            'svc_wakeLoc' => 'Home Chapel',
            'svc_churchLoc' => 'St. Peter Parish',
            'svc_burialLoc' => 'Manila Cemetery',
            'svc_equipment_status' => 'Pending',
            'svc_return_date' => now()->addDays(5),
            'package_id' => null,
            'emp_id' => null,
        ]);

        // Create service stock records linked to the stock
        $svsStock1 = SvsStock::create([
            'stock_id' => $stock->id,
            'service_id' => $serviceRequest->id,
            'stock_used' => 5,
        ]);

        $svsStock2 = SvsStock::create([
            'stock_id' => $stock->id,
            'service_id' => $serviceRequest->id,
            'stock_used' => 3,
        ]);

        // Assertions
        $this->assertCount(2, $stock->stoToSvcSto);
        $this->assertTrue($stock->stoToSvcSto->contains($svsStock1));
        $this->assertTrue($stock->stoToSvcSto->contains($svsStock2));

        $this->assertEquals($stock->id, $svsStock1->stock_id);
        $this->assertEquals($stock->id, $svsStock2->stock_id);
    }
}
