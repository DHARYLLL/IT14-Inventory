<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Package;
use App\Models\ServiceRequest;
use App\Models\packageInclusion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class PackageTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_create_a_package(): void
    {
        $package = Package::create([
            'pkg_name' => 'Premium Package',
        ]);

        $this->assertDatabaseHas('packages', [
            'pkg_name' => 'Premium Package',
        ]);

        $this->assertTrue($package->exists);
        $this->assertEquals('Premium Package', $package->pkg_name);
    }

    #[Test]
    public function it_has_many_service_requests(): void
    {
        $package = Package::create([
            'pkg_name' => 'Standard Package',
        ]);

        $service1 = ServiceRequest::create([
            'client_name' => 'John Doe',
            'client_contact_number' => '09123456789',
            'svc_startDate' => now(),
            'svc_endDate' => now()->addDays(2),
            'svc_wakeLoc' => 'Manila Chapel',
            'svc_churchLoc' => 'St. Peter Church',
            'svc_burialLoc' => 'Manila Memorial Park',
            'svc_equipment_status' => 'Ready',
            'svc_return_date' => now()->addDays(3),
            'package_id' => $package->id,
            'emp_id' => null,
        ]);

        $service2 = ServiceRequest::create([
            'client_name' => 'Jane Smith',
            'client_contact_number' => '09998887777',
            'svc_startDate' => now(),
            'svc_endDate' => now()->addDays(1),
            'svc_wakeLoc' => 'QC Chapel',
            'svc_churchLoc' => 'Sacred Heart Parish',
            'svc_burialLoc' => 'Loyola Memorial',
            'svc_equipment_status' => 'Pending',
            'svc_return_date' => now()->addDays(2),
            'package_id' => $package->id,
            'emp_id' => null,
        ]);

        $this->assertCount(2, $package->pacToSvcReq);
        $this->assertTrue($package->pacToSvcReq->contains($service1));
        $this->assertTrue($package->pacToSvcReq->contains($service2));
    }

    #[Test]
    public function it_has_many_package_inclusions(): void
    {
        $package = Package::create([
            'pkg_name' => 'Deluxe Package',
        ]);

        $inclusion1 = packageInclusion::create([
            'pkg_inclusion' => 'Casket',
            'package_id' => $package->id,
        ]);

        $inclusion2 = packageInclusion::create([
            'pkg_inclusion' => 'Hearse Service',
            'package_id' => $package->id,
        ]);

        $this->assertCount(2, $package->pkgToPkgInc);
        $this->assertTrue($package->pkgToPkgInc->contains($inclusion1));
        $this->assertTrue($package->pkgToPkgInc->contains($inclusion2));
    }
}
