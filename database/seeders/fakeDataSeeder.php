<?php

namespace Database\Seeders;

use App\Models\Chapel;
use App\Models\ChapEquipment;
use App\Models\ChapStock;
use App\Models\Employee;
use App\Models\Equipment;
use App\Models\Package;
use App\Models\packageInclusion;
use App\Models\PkgEquipment;
use App\Models\PkgStock;
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
            'emp_email' => 'm.doe@staff.com',
            'emp_password' => Hash::make('test'),
            'emp_role' => 'staff'
        ]);

        Supplier::create([
            'fname' => 'Gar Christian',
            'mname' => 'P',
            'lname' => "Flores",
            'contact_number' => '12345678910',
            'company_name' => 'ABC Inc.',
            'company_address' => 'Buhangin'
        ]);

        $consumables = [
            ['item_name' => 'Tealight Candle', 'item_qty' => 100, 'item_size' => 'Small', 'item_unit' => '8 oz', 'item_unit_price' => 5, 'item_type' => 'Consumable'],
            ['item_name' => 'Pillar Candle', 'item_qty' => 50, 'item_size' => 'Small', 'item_unit' => '8 oz', 'item_unit_price' => 30, 'item_type' => 'Consumable'],
            ['item_name' => 'Incense Stick', 'item_qty' => 200, 'item_size' => '21 cm', 'item_unit' => '2 oz', 'item_unit_price' => 20, 'item_type' => 'Consumable'],
            ['item_name' => 'Flower Petals Bag', 'item_qty' => 40, 'item_size' => '', 'item_unit' => '200 g', 'item_unit_price' => 50, 'item_type' => 'Consumable'],
            ['item_name' => 'Disinfectant Spray', 'item_qty' => 60, 'item_size' => '', 'item_unit' => '155 ml', 'item_unit_price' => 80, 'item_type' => 'Consumable'],
            ['item_name' => 'Facial Tissue Box', 'item_qty' => 120, 'item_size' => '2 ply', 'item_unit' => '300 pcs', 'item_unit_price' => 15, 'item_type' => 'Consumable'],
            ['item_name' => 'Latex Gloves', 'item_qty' => 500, 'item_size' => 'Small', 'item_unit' => '100 pcs', 'item_unit_price' => 120, 'item_type' => 'Consumable'],
            ['item_name' => 'Cotton Rolls', 'item_qty' => 100, 'item_size' => '', 'item_unit' => '400 g', 'item_unit_price' => 35, 'item_type' => 'Consumable'],

            ['item_name' => 'Vigil Light', 'item_qty' => 13, 'item_size' => '16 cm x 6 cm', 'item_unit' => '6 per pack', 'item_unit_price' => 35, 'item_type' => 'Consumable']
        ];

        foreach ($consumables as $item) {
            Stock::create($item);
        }

        $equipments = [
            ['eq_name' => 'Casket Stand', 'eq_type' => 'Non-Consumable', 'eq_available' => 5, 'eq_size' => '84 x 28 x 23', 'eq_unit' => 'Set of 1', 'eq_unit_price' => 2500, 'eq_in_use' => 0],
            ['eq_name' => 'Viewing Light Set', 'eq_type' => 'Non-Consumable', 'eq_available' => 3, 'eq_size' => '48 in', 'eq_unit' => 'Set of 2', 'eq_unit_price' => 4000, 'eq_in_use' => 0],
            ['eq_name' => 'Flower Stand', 'eq_type' => 'Non-Consumable', 'eq_available' => 8, 'eq_size' => '36 in', 'eq_unit' => 'Set of 2', 'eq_unit_price' => 900, 'eq_in_use' => 0],
            ['eq_name' => 'Viewing Tent', 'eq_type' => 'Non-Consumable', 'eq_available' => 4, 'eq_size' => '3m x 3m', 'eq_unit' => 'Set of 2', 'eq_unit_price' => 5000, 'eq_in_use' => 0],
            ['eq_name' => 'Chapel Chairs', 'eq_type' => 'Non-Consumable', 'eq_available' => 100, 'eq_size' => '35 x 19 x 20', 'eq_unit' => 'Set of 6', 'eq_unit_price' => 600, 'eq_in_use' => 0],

            ['eq_name' => 'Carpet', 'eq_type' => 'Non-Consumable', 'eq_available' => 20, 'eq_size' => '80 x 150 cm', 'eq_unit' => 'Set of 1', 'eq_unit_price' => 600, 'eq_in_use' => 0],
            ['eq_name' => 'Curtain', 'eq_type' => 'Non-Consumable', 'eq_available' => 20, 'eq_size' => '63 in', 'eq_unit' => 'Set of 1', 'eq_unit_price' => 600, 'eq_in_use' => 0],
            ['eq_name' => 'Crucifix', 'eq_type' => 'Non-Consumable', 'eq_available' => 10, 'eq_size' => '25 cm', 'eq_unit' => 'Set of 1', 'eq_unit_price' => 600, 'eq_in_use' => 0]
        ];

        foreach ($equipments as $eq) {
            Equipment::create($eq);
        }

        Package::create([
            'pkg_name' => 'Ordinary',
            'pkg_price' => 15000
        ]);

        PkgStock::create([
            'pkg_id' => 1,
            'stock_id' => 2,
            'stock_used' => 2
        ]);
        PkgStock::create([
            'pkg_id' => 1,
            'stock_id' => 9,
            'stock_used' => 1
        ]);

        PkgEquipment::create([
            'pkg_id' => 1,
            'eq_id' => 1,
            'eq_used' => 1
        ]);
        PkgEquipment::create([
            'pkg_id' => 1,
            'eq_id' => 2,
            'eq_used' => 1
        ]);
        PkgEquipment::create([
            'pkg_id' => 1,
            'eq_id' => 5,
            'eq_used' => 25
        ]);

        Chapel::create([
            'chap_name' => 'Chapel of Rest',
            'chap_room' => '101',
            'chap_price' => 2000,
            'chap_status' => 'Available',
            'max_cap' => 20
        ]);



    }
}
