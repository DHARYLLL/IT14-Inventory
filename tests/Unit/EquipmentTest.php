<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Equipment;
use App\Models\SvsEquipment;
use App\Models\ServiceRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class EquipmentTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_create_equipment(): void
    {
        $equipment = Equipment::create([
            'eq_name' => 'Tent',
            'eq_type' => 'Event Equipment',
            'eq_available' => 5,
            'eq_size_weight' => 'Large',
            'eq_unit_price' => 1500.00,
            'eq_in_use' => 1,
        ]);

        $this->assertDatabaseHas('equipments', [
            'eq_name' => 'Tent',
            'eq_type' => 'Event Equipment',
        ]);

        $this->assertEquals('Tent', $equipment->eq_name);
        $this->assertEquals('Event Equipment', $equipment->eq_type);
        $this->assertTrue($equipment->exists);
    }

    #[Test]
    public function it_has_many_service_equipments(): void
    {
        // Create equipment
        $equipment = Equipment::create([
            'eq_name' => 'Casket Stand',
            'eq_type' => 'Funeral Accessory',
            'eq_available' => 3,
            'eq_size_weight' => 'Medium',
            'eq_unit_price' => 1000.00,
            'eq_in_use' => 0,
        ]);

        // Create a related service request to satisfy FK
        $service = ServiceRequest::create([
            'client_name' => 'John Doe',
            'client_contact_number' => '09123456789',
            'svc_startDate' => now(),
            'svc_endDate' => now()->addDays(2),
            'svc_wakeLoc' => 'Manila',
            'svc_churchLoc' => 'St. Peter Parish',
            'svc_burialLoc' => 'Manila Memorial Park',
            'svc_equipment_status' => 'In Use',
            'svc_return_date' => now()->addDays(3),
            'package_id' => null,
            'emp_id' => null,
        ]);

        // Link service + equipment
        $svcEquipment = SvsEquipment::create([
            'service_id' => $service->id,
            'equipment_id' => $equipment->id,
            'eq_used' => 2,
        ]);

        // Assertions
        $this->assertInstanceOf(SvsEquipment::class, $svcEquipment);
        $this->assertTrue($equipment->eqToSvcEq->contains($svcEquipment));
        $this->assertEquals($equipment->id, $svcEquipment->equipment_id);
        $this->assertEquals($service->id, $svcEquipment->service_id);
    }
}
