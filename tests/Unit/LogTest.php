<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Log;
use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class LogTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_create_a_log(): void
    {
        $employee = Employee::create([
            'emp_fname' => 'Juan',
            'emp_mname' => 'Santos',
            'emp_lname' => 'Dela Cruz',
            'emp_contact_number' => '09123456789',
            'emp_address' => 'Quezon City',
            'emp_email' => 'juan@example.com',
            'emp_password' => bcrypt('password'),
            'emp_role' => 'Staff',
        ]);

        $log = Log::create([
            'action' => 'Created Purchase Order',
            'from' => 'Purchase Order Module',
            'action_date' => now(),
            'emp_id' => $employee->id,
        ]);

        $this->assertDatabaseHas('logs', [
            'action' => 'Created Purchase Order',
            'emp_id' => $employee->id,
        ]);

        $this->assertTrue($log->exists);
        $this->assertEquals('Created Purchase Order', $log->action);
        $this->assertEquals($employee->id, $log->emp_id);
    }

    #[Test]
    public function it_belongs_to_an_employee(): void
    {
        $employee = Employee::create([
            'emp_fname' => 'Maria',
            'emp_mname' => 'Reyes',
            'emp_lname' => 'Santos',
            'emp_contact_number' => '09998887777',
            'emp_address' => 'Makati City',
            'emp_email' => 'maria@example.com',
            'emp_password' => bcrypt('secret'),
            'emp_role' => 'Admin',
        ]);

        $log = Log::create([
            'action' => 'Updated Inventory',
            'from' => 'Stock Management Module',
            'action_date' => now(),
            'emp_id' => $employee->id,
        ]);

        // Relationship check
        $this->assertInstanceOf(Employee::class, $log->logToEmp);
        $this->assertEquals($employee->id, $log->logToEmp->id);
        $this->assertEquals('Maria', $log->logToEmp->emp_fname);
    }
}
