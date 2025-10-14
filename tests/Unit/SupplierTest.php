<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Supplier;
use App\Models\PurchaseOrder;
use PHPUnit\Framework\Attributes\Test;

class SupplierTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    #[Test]
    public function it_can_create_a_supplier()
    {
        $supplier = Supplier::create([
            'fname' => 'John',
            'mname' => 'A.',
            'lname' => 'Doe',
            'contact_number' => '09123456789',
            'company_name' => 'Smile Dental Supplies',
            'company_address' => '123 Main St, Cebu City',
        ]);

        $this->assertDatabaseHas('suppliers', [
            'fname' => 'John',
            'lname' => 'Doe',
            'company_name' => 'Smile Dental Supplies'
        ]);
    }

    /** @test */
    #[Test]
    public function it_has_many_purchase_orders()
    {
        // create a supplier manually
        $supplier = Supplier::create([
            'fname' => 'Jane',
            'mname' => 'B.',
            'lname' => 'Smith',
            'contact_number' => '09998887777',
            'company_name' => 'DentalPro Supplies',
            'company_address' => '456 Elm Street',
        ]);

        // create related purchase orders manually
        $purchaseOrder1 = PurchaseOrder::create([
            'supplier_id' => $supplier->id,
            'submitted_date' => now(),
            'status'          => 'Pending',
            // include other required fields for your purchase_orders table
        ]);

        $purchaseOrder2 = PurchaseOrder::create([
            'supplier_id' => $supplier->id,
            'submitted_date' => now(),
            'status'          => 'Approved',
            // include other required fields for your purchase_orders table
        ]);

        // verify relationship
        $this->assertCount(2, $supplier->supToPo);
        $this->assertTrue($supplier->supToPo->contains($purchaseOrder1));
        $this->assertTrue($supplier->supToPo->contains($purchaseOrder2));
    }
}
