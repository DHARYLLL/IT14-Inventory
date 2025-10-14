<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\PurchaseOrderItem;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Models\Employee;
use PHPUnit\Framework\Attributes\Test;

class PurchaseOrderItemTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_create_a_purchase_order_item(): void
    {
        $supplier = Supplier::create([
            'fname' => 'Mark',
            'mname' => 'L.',
            'lname' => 'Reyes',
            'contact_number' => '09998887777',
            'company_name' => 'Cebu Dental Supply',
            'company_address' => 'Banilad, Cebu City',
        ]);

        $employee = Employee::create([
            'emp_fname' => 'John',
            'emp_mname' => 'P.',
            'emp_lname' => 'Dela Cruz',
            'emp_contact_number' => '09123456789',
            'emp_address' => 'Mandaue City',
            'emp_email' => 'john@example.com',
            'emp_password' => bcrypt('password'),
            'emp_role' => 'Staff',
        ]);

        $purchaseOrder = PurchaseOrder::create([
            'status' => 'Pending',
            'total_amount' => 0,
            'submitted_date' => now(),
            'supplier_id' => $supplier->id,
            'emp_id' => $employee->id,
        ]);

        $poItem = PurchaseOrderItem::create([
            'item' => 'Dental Chair',
            'qty' => 2,
            'sizeWeight' => 'Large',
            'unit_price' => 15000,
            'total_amount' => 30000,
            'qty_arrived' => 0,
            'type' => 'Equipment',
            'po_id' => $purchaseOrder->id,
        ]);

        $this->assertDatabaseHas('purchase_order_items', [
            'item' => 'Dental Chair',
            'qty' => 2,
            'po_id' => $purchaseOrder->id,
        ]);
    }

    #[Test]
    public function it_belongs_to_a_purchase_order(): void
    {
        $supplier = Supplier::create([
            'fname' => 'Anna',
            'mname' => 'M.',
            'lname' => 'Torres',
            'contact_number' => '09876543210',
            'company_name' => 'SmilePro Dental',
            'company_address' => 'Cebu City',
        ]);

        $employee = Employee::create([
            'emp_fname' => 'Liza',
            'emp_mname' => 'Q.',
            'emp_lname' => 'Santos',
            'emp_contact_number' => '09112223333',
            'emp_address' => 'Talisay City',
            'emp_email' => 'liza@example.com',
            'emp_password' => bcrypt('password'),
            'emp_role' => 'Admin',
        ]);

        $purchaseOrder = PurchaseOrder::create([
            'status' => 'Approved',
            'total_amount' => 25000,
            'submitted_date' => now(),
            'supplier_id' => $supplier->id,
            'emp_id' => $employee->id,
        ]);

        $poItem = PurchaseOrderItem::create([
            'item' => 'Dental Mirror Set',
            'qty' => 10,
            'sizeWeight' => 'Small',
            'unit_price' => 250,
            'total_amount' => 2500,
            'qty_arrived' => 10,
            'type' => 'Supply',
            'po_id' => $purchaseOrder->id,
        ]);

        $this->assertInstanceOf(PurchaseOrder::class, $poItem->purchaseOrder);
        $this->assertEquals($purchaseOrder->id, $poItem->purchaseOrder->id);
    }
}
