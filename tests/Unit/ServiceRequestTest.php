<?php

namespace Tests\Unit;

use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\ServiceRequest;
use App\Models\Package;
use App\Models\Employee;

class ServiceRequestTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_create_a_service_request()
    {
        // Create a package first (foreign key requirement)
        $package = Package::create([
            'pkg_name' => 'Premium Funeral Package'
        ]);

        // Create an employee since ServiceRequest also has emp_id
        $employee = Employee::create([
            'emp_fname' => 'Jane',
            'emp_mname' => 'B.',
            'emp_lname' => 'Smith',
            'emp_contact_number' => '09998887777',
            'emp_address' => '456 Elm Street',
            'emp_email' => 'jane@example.com',
            'emp_password' => 'password',
            'emp_role' => 'Service Coordinator',
        ]);

        // Create the service request
        $serviceRequest = ServiceRequest::create([
            'client_name' => 'John Doe',
            'client_contact_number' => '09123456789',
            'svc_startDate' => now(),
            'svc_endDate' => now()->addDays(3),
            'svc_wakeLoc' => 'St. Peter Chapel, Cebu City',
            'svc_churchLoc' => 'Sacred Heart Church',
            'svc_burialLoc' => 'Cebu Memorial Park',
            'svc_equipment_status' => 'Ready',
            'svc_return_date' => now()->addDays(4),
            'package_id' => $package->id,
            'emp_id' => $employee->id,
        ]);

        // Assert the record exists in DB
        $this->assertDatabaseHas('services_requests', [
            'client_name' => 'John Doe',
            'svc_wakeLoc' => 'St. Peter Chapel, Cebu City',
        ]);
    }

    #[Test]
    public function it_belongs_to_a_package()
    {
        // Create a package
        $package = Package::create([
            'pkg_name' => 'Standard Package'
        ]);

        // Create an employee
        $employee = Employee::create([
            'emp_fname' => 'Mark',
            'emp_mname' => 'C.',
            'emp_lname' => 'Reyes',
            'emp_contact_number' => '09170000000',
            'emp_address' => '123 Main St',
            'emp_email' => 'mark@example.com',
            'emp_password' => 'password',
            'emp_role' => 'Staff',
        ]);

        // Create a service request linked to the package
        $serviceRequest = ServiceRequest::create([
            'client_name' => 'Mary Johnson',
            'client_contact_number' => '09876543210',
            'svc_startDate' => now(),
            'svc_endDate' => now()->addDays(2),
            'svc_wakeLoc' => 'Peace Memorial Chapel',
            'svc_churchLoc' => 'St. John Parish',
            'svc_burialLoc' => 'Heaven’s Gate Cemetery',
            'svc_equipment_status' => 'In Use',
            'svc_return_date' => now()->addDays(3),
            'package_id' => $package->id,
            'emp_id' => $employee->id,
        ]);

        // Assert relationship
        $this->assertInstanceOf(Package::class, $serviceRequest->svcReqToPac);
        $this->assertEquals($package->id, $serviceRequest->svcReqToPac->id);
    }
}
