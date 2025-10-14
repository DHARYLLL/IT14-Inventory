<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Models\Employee;
use App\Models\Invoice;
use PHPUnit\Framework\Attributes\Test;

class PurchaseOrderTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_create_a_purchase_order(): void
    {
        $supplier = Supplier::create([
            'fname' => 'John',
            'mname' => 'B.',
            'lname' => 'Doe',
            'contact_number' => '09123456789',
            'company_name' => 'Smile Dental Supplies',
            'company_address' => '123 Main St, Cebu City',
        ]);

        $employee = Employee::create([
            'emp_fname' => 'Alice',
            'emp_mname' => 'C.',
            'emp_lname' => 'Reyes',
            'emp_contact_number' => '09998887777',
            'emp_address' => '456 Mango Ave, Cebu City',
            'emp_email' => 'alice@example.com',
            'emp_password' => bcrypt('password'),
            'emp_role' => 'Staff',
        ]);

        $purchaseOrder = PurchaseOrder::create([
            'status' => 'Pending',
            'total_amount' => 15000.00,
            'submitted_date' => now(),
            'supplier_id' => $supplier->id,
            'emp_id' => $employee->id,
        ]);

        $this->assertDatabaseHas('purchase_orders', [
            'status' => 'Pending',
            'supplier_id' => $supplier->id,
            'emp_id' => $employee->id,
        ]);
    }

    #[Test]
    public function it_belongs_to_a_supplier(): void
    {
        $supplier = Supplier::create([
            'fname' => 'Jane',
            'mname' => 'K.',
            'lname' => 'Smith',
            'contact_number' => '09997776666',
            'company_name' => 'DentalPro Supplies',
            'company_address' => '456 Elm St, Cebu City',
        ]);

        $purchaseOrder = PurchaseOrder::create([
            'status' => 'Approved',
            'total_amount' => 20000.00,
            'submitted_date' => now(),
            'supplier_id' => $supplier->id,
        ]);

        $this->assertInstanceOf(Supplier::class, $purchaseOrder->poToSup);
        $this->assertEquals($supplier->id, $purchaseOrder->poToSup->id);
    }

    #[Test]
    public function it_belongs_to_an_employee(): void
    {
        $employee = Employee::create([
            'emp_fname' => 'Mark',
            'emp_mname' => 'D.',
            'emp_lname' => 'Lopez',
            'emp_contact_number' => '09112223333',
            'emp_address' => '789 Banilad, Cebu City',
            'emp_email' => 'mark@example.com',
            'emp_password' => bcrypt('password'),
            'emp_role' => 'Admin',
        ]);

        $purchaseOrder = PurchaseOrder::create([
            'status' => 'Delivered',
            'total_amount' => 30000.00,
            'submitted_date' => now(),
            'emp_id' => $employee->id,
        ]);

        $this->assertInstanceOf(Employee::class, $purchaseOrder->poToEmp);
        $this->assertEquals($employee->id, $purchaseOrder->poToEmp->id);
    }

    #[Test]
    public function it_belongs_to_an_invoice(): void
    {
        $supplier = Supplier::create([
            'fname' => 'Luke',
            'mname' => 'G.',
            'lname' => 'Cruz',
            'contact_number' => '09123456789',
            'company_name' => 'Prime Dental',
            'company_address' => 'Mandaue City',
        ]);

        $purchaseOrder = PurchaseOrder::create([
            'status' => 'Delivered',
            'total_amount' => 50000.00,
            'submitted_date' => now(),
            'supplier_id' => $supplier->id,
        ]);

        $invoice = Invoice::create([
            'invoice_number' => 'INV-1001',
            'invoice_date' => now(),
            'total' => 50000.00,
            'po_id' => $purchaseOrder->id,
        ]);

        $this->assertInstanceOf(Invoice::class, $purchaseOrder->poToInv);
        $this->assertEquals($invoice->id, $purchaseOrder->poToInv->id);
    }
}
