<?php

namespace Tests\Unit;

use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Invoice;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Models\Employee;

class InvoiceTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_create_an_invoice()
    {
        // create required related models
        $supplier = Supplier::create([
            'fname' => 'John',
            'mname' => 'A.',
            'lname' => 'Doe',
            'contact_number' => '09123456789',
            'company_name' => 'Smile Dental Supplies',
            'company_address' => '123 Main St',
        ]);

        $employee = Employee::create([
            'emp_fname' => 'Jane',
            'emp_mname' => 'B.',
            'emp_lname' => 'Smith',
            'emp_contact_number' => '09998887777',
            'emp_address' => '456 Elm St',
            'emp_email' => 'jane@example.com',
            'emp_password' => 'password',
            'emp_role' => 'Admin',
        ]);

        // now safe to create purchase order
        $purchaseOrder = PurchaseOrder::create([
            'status' => 'Pending',
            'total_amount' => 15000.00,
            'submitted_date' => now(),
            'supplier_id' => $supplier->id,
            'emp_id' => $employee->id,
        ]);

        // create invoice
        $invoice = Invoice::create([
            'invoice_number' => 'INV-1001',
            'invoice_date' => now(),
            'total' => 15000.00,
            'po_id' => $purchaseOrder->id,
        ]);

        $this->assertDatabaseHas('invoices', [
            'invoice_number' => 'INV-1001',
            'total' => 15000.00,
        ]);
    }

    #[Test]
    public function it_belongs_to_a_purchase_order()
    {
        $supplier = Supplier::create([
            'fname' => 'John',
            'mname' => 'A.',
            'lname' => 'Doe',
            'contact_number' => '09123456789',
            'company_name' => 'Smile Dental Supplies',
            'company_address' => '123 Main St',
        ]);

        $employee = Employee::create([
            'emp_fname' => 'Jane',
            'emp_mname' => 'B.',
            'emp_lname' => 'Smith',
            'emp_contact_number' => '09998887777',
            'emp_address' => '456 Elm St',
            'emp_email' => 'jane@example.com',
            'emp_password' => 'password',
            'emp_role' => 'Admin',
        ]);

        $purchaseOrder = PurchaseOrder::create([
            'status' => 'Approved',
            'total_amount' => 25000.00,
            'submitted_date' => now(),
            'approved_date' => now(),
            'supplier_id' => $supplier->id,
            'emp_id' => $employee->id,
        ]);

        $invoice = Invoice::create([
            'invoice_number' => 'INV-2002',
            'invoice_date' => now(),
            'total' => 25000.00,
            'po_id' => $purchaseOrder->id,
        ]);

        $this->assertInstanceOf(PurchaseOrder::class, $invoice->invToPo);
        $this->assertEquals($purchaseOrder->id, $invoice->invToPo->id);
    }
}
