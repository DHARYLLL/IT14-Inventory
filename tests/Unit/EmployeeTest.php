<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Employee;
use App\Models\Log;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_create_an_employee(): void
    {
        $employee = Employee::create([
            'emp_fname' => 'Juan',
            'emp_mname' => 'Dela',
            'emp_lname' => 'Cruz',
            'emp_contact_number' => '09123456789',
            'emp_address' => 'Quezon City',
            'emp_email' => 'juan.cruz@example.com',
            'emp_password' => bcrypt('password123'),
            'emp_role' => 'Admin',
        ]);

        $this->assertDatabaseHas('employees', [
            'emp_fname' => 'Juan',
            'emp_lname' => 'Cruz',
            'emp_email' => 'juan.cruz@example.com',
        ]);

        $this->assertTrue($employee->exists);
        $this->assertEquals('Juan', $employee->emp_fname);
        $this->assertEquals('Admin', $employee->emp_role);
    }

    #[Test]
    public function it_has_many_logs(): void
    {
        // Create an employee
        $employee = Employee::create([
            'emp_fname' => 'Maria',
            'emp_mname' => 'Lopez',
            'emp_lname' => 'Santos',
            'emp_contact_number' => '09998887777',
            'emp_address' => 'Makati City',
            'emp_email' => 'maria.santos@example.com',
            'emp_password' => bcrypt('securepass'),
            'emp_role' => 'Staff',
        ]);

        // Create related logs
        $log1 = Log::create([
            'action' => 'Created Purchase Order',
            'from' => 'Purchase Order Module',
            'action_date' => now(),
            'emp_id' => $employee->id,
        ]);

        $log2 = Log::create([
            'action' => 'Approved Invoice',
            'from' => 'Invoice Module',
            'action_date' => now(),
            'emp_id' => $employee->id,
        ]);

        // Assertions
        $this->assertCount(2, $employee->empToLog);
        $this->assertTrue($employee->empToLog->contains($log1));
        $this->assertTrue($employee->empToLog->contains($log2));

        $this->assertEquals($employee->id, $log1->emp_id);
        $this->assertEquals($employee->id, $log2->emp_id);
    }
}
