<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Equipment;
use App\Models\Package;
use App\Models\packageInclusion;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Stock;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class fakeDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        Employee::create([
            'emp_fname' => 'John',
            'emp_mname' => 'D',
            'emp_lname' => 'Doe',
            'emp_contact_number' => '12345678910',
            'emp_address' => 'Zone 3 Buhangin San Vicente Davao City',
            'emp_email' => 'j.doe@admin.com',
            'emp_password' => Hash::make('test'),
            'emp_role' => 'admin'
        ]);

        Employee::create([
            'emp_fname' => 'Maria',
            'emp_mname' => 'D',
            'emp_lname' => 'Doe',
            'emp_contact_number' => '12345678910',
            'emp_address' => 'Zone 1 Buhangin San Vicente Davao City',
            'emp_email' => 'm.doe@admin.com',
            'emp_password' => Hash::make('test'),
            'emp_role' => 'admin'
        ]);

        Supplier::create([
            'fname' => 'Gar Christian',
            'mname' => 'P',
            'lname' => "Flores",
            'contact_number' => '12345678910',
            'company_name' => 'ABC Inc.',
            'company_address' => 'Buhangin'
        ]);

        PurchaseOrder::create([
            'status' => 'Pending',
            'submitted_date' => Carbon::now()->format('Y-m-d'),
            'supplier_id' => 1,
            'emp_id' => 1
        ]);

        Stock::create([
            'item_name' => 'Candle',
            'item_qty' => 0,
            'size_weight' => 'Large',
            'item_unit_price' => 10
        ]);
        Stock::create([
            'item_name' => 'Candle',
            'item_qty' => 0,
            'size_weight' => 'Medium',
            'item_unit_price' => 10
        ]);
        Stock::create([
            'item_name' => 'Candle',
            'item_qty' => 0,
            'size_weight' => 'Small',
            'item_unit_price' => 10
        ]);

        PurchaseOrderItem::create([
            'item' => 'Candle',
            'qty' => 3,
            'sizeWeight' => 'Large',
            'unit_price' => 10,
            'total_amount' => 30,
            'po_id' => 1,
            'stock_id' => 1
        ]);
        PurchaseOrderItem::create([
            'item' => 'Candle',
            'qty' => 3,
            'sizeWeight' => 'Medium',
            'unit_price' => 10,
            'total_amount' => 30,
            'po_id' => 1,
            'stock_id' => 2
        ]);
        PurchaseOrderItem::create([
            'item' => 'Candle',
            'qty' => 3,
            'sizeWeight' => 'Small',
            'unit_price' => 10,
            'total_amount' => 30,
            'po_id' => 1,
            'stock_id' => 3
        ]);

        Package::create([
            'pkg_name' => 'MOA'
        ]);
        packageInclusion::create([
            'pkg_inclusion' => '15K inclusion',
            'package_id' => 1
        ]);
        packageInclusion::create([
            'pkg_inclusion' => 'Free 1/2 sack rice',
            'package_id' => 1
        ]);
        packageInclusion::create([
            'pkg_inclusion' => 'Tarpauline',
            'package_id' => 1
        ]);
        packageInclusion::create([
            'pkg_inclusion' => 'Flower stand',
            'package_id' => 1
        ]);
        packageInclusion::create([
            'pkg_inclusion' => 'Coffee',
            'package_id' => 1
        ]);
        packageInclusion::create([
            'pkg_inclusion' => 'Sugar',
            'package_id' => 1
        ]);
        packageInclusion::create([
            'pkg_inclusion' => 'Biscuit',
            'package_id' => 1
        ]);
        packageInclusion::create([
            'pkg_inclusion' => 'Tombstone',
            'package_id' => 1
        ]);


        Equipment::create([
            'eq_name' => 'Candelabra (gold)',
            'eq_available' => 10,
            'eq_in_use' => 0
        ]);
        Equipment::create([
            'eq_name' => 'Candelabra (silver)',
            'eq_available' => 10,
            'eq_in_use' => 0
        ]);
        Equipment::create([
            'eq_name' => 'Casket stand',
            'eq_available' => 10,
            'eq_in_use' => 0
        ]);
        Equipment::create([
            'eq_name' => 'Flower stand',
            'eq_available' => 10,
            'eq_in_use' => 0
        ]);
        Equipment::create([
            'eq_name' => 'Tarpauline',
            'eq_available' => 10,
            'eq_in_use' => 0
        ]);
    }
}
