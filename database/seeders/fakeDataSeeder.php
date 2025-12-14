<?php

namespace Database\Seeders;

use App\Models\Chapel;
use App\Models\ChapEquipment;
use App\Models\ChapStock;
use App\Models\embalming;
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

        Employee::create([
            'emp_fname' => 'Aureliano',
            'emp_mname' => 'Espina',
            'emp_lname' => 'Garcia',
            'emp_contact_number' => '09198337182',
            'emp_address' => 'Compostela Davao de oro',
            'emp_email' => 'alarmemorial@alar.com',
            'emp_password' => Hash::make('alar'),
            'emp_role' => 'admin'
        ]);

        /*
        Employee::create([
            'emp_fname' => 'Michael',
            'emp_mname' => '',
            'emp_lname' => 'Baliad',
            'emp_contact_number' => '09198337182',
            'emp_address' => 'Compostela Davao de oro',
            'emp_email' => 'm.baliad.d@alar.com',
            'emp_password' => Hash::make('alar'),
            'emp_role' => 'driver'
        ]);

        Employee::create([
            'emp_fname' => 'Fredrick',
            'emp_mname' => 'Patrick',
            'emp_lname' => 'Facon',
            'emp_contact_number' => '09198337182',
            'emp_address' => 'Compostela Davao de oro',
            'emp_email' => 'f.facon.d@alar.com',
            'emp_password' => Hash::make('alar'),
            'emp_role' => 'driver'
        ]);

        Employee::create([
            'emp_fname' => 'James',
            'emp_mname' => '',
            'emp_lname' => 'Fabroa',
            'emp_contact_number' => '09198337182',
            'emp_address' => 'Compostela Davao de oro',
            'emp_email' => 'j.fabroa.d@alar.com',
            'emp_password' => Hash::make('alar'),
            'emp_role' => 'driver'
        ]);

        Employee::create([
            'emp_fname' => 'Fredrick',
            'emp_mname' => 'Patrick',
            'emp_lname' => 'Facon',
            'emp_contact_number' => '09198337182',
            'emp_address' => 'Compostela Davao de oro',
            'emp_email' => 'f.facon.e@alar.com',
            'emp_password' => Hash::make('alar'),
            'emp_role' => 'embalmer'
        ]);
        */

        Supplier::create([
            'fname' => 'Gar Christian',
            'mname' => 'P',
            'lname' => "Flores",
            'contact_number' => '12345678910',
            'company_name' => 'ABC Inc.',
            'company_address' => 'Buhangin'
        ]);

        $consumables = [
            ['item_name' => 'Tealight Candle',      'item_qty' => 100,  'item_size' => '8 oz',         'item_type' => 'Consumable', 'item_low_limit' => 40],
            ['item_name' => 'Pillar Candle',        'item_qty' => 50,   'item_size' => '8 oz',         'item_type' => 'Consumable', 'item_low_limit' => 10],
            ['item_name' => 'Incense Stick',        'item_qty' => 200,  'item_size' => '21 cm',        'item_type' => 'Consumable', 'item_low_limit' => 100],
            ['item_name' => 'Flower Petals Bag',    'item_qty' => 40,   'item_size' => '200 g',        'item_type' => 'Consumable', 'item_low_limit' => 10],
            ['item_name' => 'Disinfectant Spray',   'item_qty' => 60,   'item_size' => '155 ml',       'item_type' => 'Consumable', 'item_low_limit' => 10],
            ['item_name' => 'Facial Tissue Box',    'item_qty' => 4200, 'item_size' => '3 ply',        'item_type' => 'Consumable', 'item_low_limit' => 2100],
            ['item_name' => 'Latex Gloves',         'item_qty' => 500,  'item_size' => 'Small',        'item_type' => 'Consumable', 'item_low_limit' => 200],
            ['item_name' => 'Cotton Rolls',         'item_qty' => 50,   'item_size' => '300g',         'item_type' => 'Consumable', 'item_low_limit' => 10],
            ['item_name' => 'Vigil Light',          'item_qty' => 15,   'item_size' => '16 cm x 6 cm', 'item_type' => 'Consumable', 'item_low_limit' => 10],
            ['item_name' => 'Formalin',             'item_qty' => 15,   'item_size' => '1 Liter',      'item_type' => 'Consumable', 'item_low_limit' => 10],
            ['item_name' => 'Genelyn Cavity Fluid', 'item_qty' => 15,   'item_size' => '1 Liter',      'item_type' => 'Consumable', 'item_low_limit' => 10]
        ];

        foreach ($consumables as $item) {
            Stock::create($item);
        }

        $equipments = [
            ['eq_name' => 'Casket Stand',            'eq_type' => 'Non-Consumable', 'eq_available' => 40,    'eq_size' => '84 x 28 x 23',  'eq_in_use' => 0, 'eq_low_limit' => 2],
            ['eq_name' => 'Viewing Light Set',       'eq_type' => 'Non-Consumable', 'eq_available' => 50,    'eq_size' => '48 in',         'eq_in_use' => 0, 'eq_low_limit' => 2],
            ['eq_name' => 'Flower Stand',            'eq_type' => 'Non-Consumable', 'eq_available' => 80,    'eq_size' => '36 in',         'eq_in_use' => 0, 'eq_low_limit' => 2],
            ['eq_name' => 'Viewing Tent',            'eq_type' => 'Non-Consumable', 'eq_available' => 10,    'eq_size' => '3m x 3m',       'eq_in_use' => 0, 'eq_low_limit' => 2],
            ['eq_name' => 'Chapel Chairs',           'eq_type' => 'Non-Consumable', 'eq_available' => 100,  'eq_size' => '35 x 19 x 20',   'eq_in_use' => 0, 'eq_low_limit' => 20],
            ['eq_name' => 'Carpet',                  'eq_type' => 'Non-Consumable', 'eq_available' => 20,   'eq_size' => '80 x 150 cm',    'eq_in_use' => 0, 'eq_low_limit' => 2],
            ['eq_name' => 'Curtain',                 'eq_type' => 'Non-Consumable', 'eq_available' => 20,   'eq_size' => '63 in',          'eq_in_use' => 0, 'eq_low_limit' => 2],
            ['eq_name' => 'Crucifix',                'eq_type' => 'Non-Consumable', 'eq_available' => 10,   'eq_size' => '25 cm',          'eq_in_use' => 0, 'eq_low_limit' => 2],
            ['eq_name' => 'Artery fixation forecep', 'eq_type' => 'Non-Consumable', 'eq_available' => 5,    'eq_size' => '5.5 in',         'eq_in_use' => 0, 'eq_low_limit' => 2],
            ['eq_name' => 'Scalpel',                 'eq_type' => 'Non-Consumable', 'eq_available' => 5,    'eq_size' => '22',             'eq_in_use' => 0, 'eq_low_limit' => 2],
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
            'stock_used' => 2,
            'stock_used_set' => 1,
        ]);
        PkgStock::create([
            'pkg_id' => 1,
            'stock_id' => 9,
            'stock_used' => 1,
            'stock_used_set' => 1,
        ]);

        PkgEquipment::create([
            'pkg_id' => 1,
            'eq_id' => 1,
            'eq_used' => 1,
            'eq_used_set' => 1
        ]);
        PkgEquipment::create([
            'pkg_id' => 1,
            'eq_id' => 2,
            'eq_used' => 4,
            'eq_used_set' => 1
        ]);
        PkgEquipment::create([
            'pkg_id' => 1,
            'eq_id' => 5,
            'eq_used' => 25,
            'eq_used_set' => 1
        ]);
        //end

        // new package
        Package::create([
            'pkg_name' => 'Uggoy',
            'pkg_price' => 17000
        ]);

        PkgStock::create([
            'pkg_id' => 2,
            'stock_id' => 10,
            'stock_used' => 2,
            'stock_used_set' => 1,
        ]);

        PkgStock::create([
            'pkg_id' => 2,
            'stock_id' => 11,
            'stock_used' => 2,
            'stock_used_set' => 1,
        ]);

        PkgEquipment::create([
            'pkg_id' => 2,
            'eq_id' => 9,
            'eq_used' => 1,
            'eq_used_set' => 1
        ]);

        PkgEquipment::create([
            'pkg_id' => 2,
            'eq_id' => 10,
            'eq_used' => 1,
            'eq_used_set' => 1
        ]);

        //end

        //new emabler
        embalming::create([
            'embalmer_name' => 'Test embalmer',
            'prep_price' => 4000
        ]);

        PkgStock::create([
            'prep_id' => 1,
            'stock_id' => 7,
            'stock_used' => 1,
            'stock_used_set' => 20,
        ]);

        PkgStock::create([
            'prep_id' => 1,
            'stock_id' => 8,
            'stock_used' => 1,
            'stock_used_set' => 20,
        ]);

        PkgEquipment::create([
            'prep_id' => 1,
            'eq_id' => 9,
            'eq_used' => 1,
            'eq_used_set' => 1
        ]);

        PkgEquipment::create([
            'prep_id' => 1,
            'eq_id' => 10,
            'eq_used' => 1,
            'eq_used_set' => 1
        ]);

        //end

        Chapel::create([
            'chap_name' => 'Chapel of Rest',
            'chap_room' => '101',
            'chap_price' => 2000
        ]);

        Chapel::create([
            'chap_name' => 'Chapel of Rest',
            'chap_room' => '102',
            'chap_price' => 2000
        ]);

        vehicle::create([
            'driver_name' => 'Example driver',
            'driver_contact_number' => '09970647935',
            'veh_price' => 1500
        ]);

        vehicle::create([
            'driver_name' => 'Example driver 2',
            'driver_contact_number' => '09970647931',
            'veh_price' => 1500
        ]);



    }
}
