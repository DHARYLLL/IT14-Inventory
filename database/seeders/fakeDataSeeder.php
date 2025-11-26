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
use App\Models\vehicle;
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
            'emp_fname' => 'admin',
            'emp_mname' => 'admin',
            'emp_lname' => 'admin',
            'emp_contact_number' => 'admin',
            'emp_address' => 'admin',
            'emp_email' => 'admin@alar.com',
            'emp_password' => Hash::make('superadmin'),
            'emp_role' => 'sadmin'
        ]);

        Employee::create([
            'emp_fname' => 'John',
            'emp_mname' => 'D',
            'emp_lname' => 'Doe',
            'emp_contact_number' => '12345678910',
            'emp_address' => 'Zone 3 Buhangin San Vicente Davao City',
            'emp_email' => 'j.doe@alar.com',
            'emp_password' => Hash::make('test'),
            'emp_role' => 'admin'
        ]);

        Employee::create([
            'emp_fname' => 'Maria',
            'emp_mname' => 'D',
            'emp_lname' => 'Doe',
            'emp_contact_number' => '12345678910',
            'emp_address' => 'Zone 1 Buhangin San Vicente Davao City',
            'emp_email' => 'm.doe@alar.com',
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
            ['item_name' => 'Tealight Candle',      'item_qty' => 100,  'item_size' => '8 oz',         'item_unit_price' => 5,    'item_qty_set' => 0, 'item_total_qty' => 100, 'item_type' => 'Consumable'],
            ['item_name' => 'Pillar Candle',        'item_qty' => 50,   'item_size' => '8 oz',         'item_unit_price' => 30,   'item_qty_set' => 0, 'item_total_qty' => 50, 'item_type' => 'Consumable'],
            ['item_name' => 'Incense Stick',        'item_qty' => 200,  'item_size' => '21 cm',        'item_unit_price' => 20,   'item_qty_set' => 0, 'item_total_qty' => 200, 'item_type' => 'Consumable'],
            ['item_name' => 'Flower Petals Bag',    'item_qty' => 40,   'item_size' => '200 g',        'item_unit_price' => 50,   'item_qty_set' => 0, 'item_total_qty' => 40, 'item_type' => 'Consumable'],
            ['item_name' => 'Disinfectant Spray',   'item_qty' => 60,   'item_size' => '155 ml',       'item_unit_price' => 80,   'item_qty_set' => 0, 'item_total_qty' => 60, 'item_type' => 'Consumable'],
            ['item_name' => 'Facial Tissue Box',    'item_qty' => 120,  'item_size' => '2 ply',        'item_unit_price' => 15,   'item_qty_set' => 0, 'item_total_qty' => 120, 'item_type' => 'Consumable'],
            ['item_name' => 'Latex Gloves',         'item_qty' => 500,  'item_size' => 'Small',        'item_unit_price' => 120,  'item_qty_set' => 0, 'item_total_qty' => 500, 'item_type' => 'Consumable'],
            ['item_name' => 'Cotton Rolls',         'item_qty' => 100,  'item_size' => 'Small',        'item_unit_price' => 35,   'item_qty_set' => 0, 'item_total_qty' => 100, 'item_type' => 'Consumable'],
            ['item_name' => 'Vigil Light',          'item_qty' => 15,   'item_size' => '16 cm x 6 cm', 'item_unit_price' => 35,   'item_qty_set' => 0, 'item_total_qty' => 15, 'item_type' => 'Consumable'],
            ['item_name' => 'Formalin',             'item_qty' => 15,   'item_size' => '1 Liter',      'item_unit_price' => 410,  'item_qty_set' => 0, 'item_total_qty' => 15, 'item_type' => 'Consumable'],
            ['item_name' => 'Genelyn Cavity Fluid', 'item_qty' => 15,   'item_size' => '1 Liter',      'item_unit_price' => 458,  'item_qty_set' => 0, 'item_total_qty' => 15, 'item_type' => 'Consumable']
        ];

        foreach ($consumables as $item) {
            Stock::create($item);
        }

        $equipments = [
            ['eq_name' => 'Casket Stand',            'eq_type' => 'Non-Consumable', 'eq_available' => 5,    'eq_size' => '84 x 28 x 23',    'eq_qty_set' => 0, 'eq_total_qty' => 5,     'eq_unit_price' => 2500, 'eq_in_use' => 0],
            ['eq_name' => 'Viewing Light Set',       'eq_type' => 'Non-Consumable', 'eq_available' => 3,    'eq_size' => '48 in',           'eq_qty_set' => 0, 'eq_total_qty' => 3,     'eq_unit_price' => 4000, 'eq_in_use' => 0],
            ['eq_name' => 'Flower Stand',            'eq_type' => 'Non-Consumable', 'eq_available' => 8,    'eq_size' => '36 in',           'eq_qty_set' => 0, 'eq_total_qty' => 8,     'eq_unit_price' => 900, 'eq_in_use' => 0],
            ['eq_name' => 'Viewing Tent',            'eq_type' => 'Non-Consumable', 'eq_available' => 4,    'eq_size' => '3m x 3m',         'eq_qty_set' => 0, 'eq_total_qty' => 4,     'eq_unit_price' => 5000, 'eq_in_use' => 0],
            ['eq_name' => 'Chapel Chairs',           'eq_type' => 'Non-Consumable', 'eq_available' => 100,  'eq_size' => '35 x 19 x 20',    'eq_qty_set' => 0, 'eq_total_qty' => 100,   'eq_unit_price' => 600, 'eq_in_use' => 0],
            ['eq_name' => 'Carpet',                  'eq_type' => 'Non-Consumable', 'eq_available' => 20,   'eq_size' => '80 x 150 cm',     'eq_qty_set' => 0, 'eq_total_qty' => 20,    'eq_unit_price' => 600, 'eq_in_use' => 0],
            ['eq_name' => 'Curtain',                 'eq_type' => 'Non-Consumable', 'eq_available' => 20,   'eq_size' => '63 in',           'eq_qty_set' => 0, 'eq_total_qty' => 20,    'eq_unit_price' => 600, 'eq_in_use' => 0],
            ['eq_name' => 'Crucifix',                'eq_type' => 'Non-Consumable', 'eq_available' => 10,   'eq_size' => '25 cm',           'eq_qty_set' => 0, 'eq_total_qty' => 10,    'eq_unit_price' => 600, 'eq_in_use' => 0],
            ['eq_name' => 'Artery fixation forecep', 'eq_type' => 'Non-Consumable', 'eq_available' => 5,    'eq_size' => '5.5 in',          'eq_qty_set' => 0, 'eq_total_qty' => 5,     'eq_unit_price' => 4721, 'eq_in_use' => 0],
            ['eq_name' => 'Scalpel',                 'eq_type' => 'Non-Consumable', 'eq_available' => 5,    'eq_size' => '22',              'eq_qty_set' => 0, 'eq_total_qty' => 5,     'eq_unit_price' => 4721, 'eq_in_use' => 0],
        ];

        foreach ($equipments as $eq) {
            Equipment::create($eq);
        }


        //new package
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
        //end

        // new package
        Package::create([
            'pkg_name' => 'Embalming',
            'pkg_price' => 4000
        ]);

        PkgStock::create([
            'pkg_id' => 2,
            'stock_id' => 10,
            'stock_used' => 2
        ]);

        PkgStock::create([
            'pkg_id' => 2,
            'stock_id' => 11,
            'stock_used' => 2
        ]);

        PkgEquipment::create([
            'pkg_id' => 2,
            'eq_id' => 9,
            'eq_used' => 1
        ]);

        PkgEquipment::create([
            'pkg_id' => 2,
            'eq_id' => 10,
            'eq_used' => 1
        ]);

        //end

        Chapel::create([
            'chap_name' => 'Chapel of Rest',
            'chap_room' => '101',
            'chap_price' => 2000,
            'chap_status' => 'Available'
        ]);

        vehicle::create([
            'driver_name' => 'Example driver',
            'driver_contact_number' => '09970647935',
            'veh_price' => 1500,
            'veh_brand' => 'Nissan',
            'veh_plate_no' => '123XXX'
        ]);

        vehicle::create([
            'driver_name' => 'Example driver 2',
            'driver_contact_number' => '09970647931',
            'veh_price' => 1500,
            'veh_brand' => 'Nissan',
            'veh_plate_no' => '123XXX'
        ]);



    }
}
