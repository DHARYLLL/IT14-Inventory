<?php

namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\Stock;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ===============================
        // 1️⃣ CONSUMABLE ITEMS (stocks)
        // ===============================
        $consumables = [
            ['item_name' => 'Tealight Candle Pack', 'item_qty' => 100, 'size_weight' => 'Small', 'item_unit_price' => 5, 'item_type' => 'Consumable'],
            ['item_name' => 'Pillar Candle', 'item_qty' => 50, 'size_weight' => 'Medium', 'item_unit_price' => 30, 'item_type' => 'Consumable'],
            ['item_name' => 'Incense Sticks (Box)', 'item_qty' => 200, 'size_weight' => 'Box of 50', 'item_unit_price' => 20, 'item_type' => 'Consumable'],
            ['item_name' => 'Flower Petals Bag', 'item_qty' => 40, 'size_weight' => '2kg', 'item_unit_price' => 50, 'item_type' => 'Consumable'],
            ['item_name' => 'Disinfectant Spray', 'item_qty' => 60, 'size_weight' => '500ml', 'item_unit_price' => 80, 'item_type' => 'Consumable'],
            ['item_name' => 'Facial Tissue Box', 'item_qty' => 120, 'size_weight' => 'Standard', 'item_unit_price' => 15, 'item_type' => 'Consumable'],
            ['item_name' => 'Latex Gloves', 'item_qty' => 500, 'size_weight' => 'Box of 100', 'item_unit_price' => 120, 'item_type' => 'Consumable'],
            ['item_name' => 'Cotton Rolls', 'item_qty' => 100, 'size_weight' => '250g', 'item_unit_price' => 35, 'item_type' => 'Consumable'],
            // ['item_name' => 'Paper Cups', 'item_qty' => 500, 'size_weight' => '8oz', 'item_unit_price' => 2, 'item_type' => 'Consumable'],
            // ['item_name' => 'Bottled Water', 'item_qty' => 300, 'size_weight' => '500ml', 'item_unit_price' => 15, 'item_type' => 'Consumable'],
            // ['item_name' => 'Coffee Pack', 'item_qty' => 40, 'size_weight' => '1kg', 'item_unit_price' => 300, 'item_type' => 'Consumable'],
            ['item_name' => 'Embalming Fluid', 'item_qty' => 30, 'size_weight' => '1L', 'item_unit_price' => 250, 'item_type' => 'Consumable'],
            ['item_name' => 'Cosmetic Kit', 'item_qty' => 15, 'size_weight' => 'Complete Set', 'item_unit_price' => 600, 'item_type' => 'Consumable'],
            // ['item_name' => 'Paper Plates', 'item_qty' => 400, 'size_weight' => '10pcs/pack', 'item_unit_price' => 10, 'item_type' => 'Consumable'],
        ];

        foreach ($consumables as $item) {
            Stock::create($item);
        }

        // ===============================
        // 2️⃣ NON-CONSUMABLE ITEMS (equipment)
        // ===============================
        $equipments = [
            ['eq_name' => 'Casket Stand', 'eq_type' => 'Non-Consumable', 'eq_available' => 5, 'eq_size_weight' => 'Standard', 'eq_unit_price' => 2500, 'eq_in_use' => 0],
            ['eq_name' => 'Viewing Light Set', 'eq_type' => 'Non-Consumable', 'eq_available' => 3, 'eq_size_weight' => 'Set', 'eq_unit_price' => 4000, 'eq_in_use' => 0],
            ['eq_name' => 'Flower Stand', 'eq_type' => 'Non-Consumable', 'eq_available' => 8, 'eq_size_weight' => 'Medium', 'eq_unit_price' => 900, 'eq_in_use' => 0],
            // ['eq_name' => 'Sound System', 'eq_type' => 'Non-Consumable', 'eq_available' => 2, 'eq_size_weight' => 'Full Set', 'eq_unit_price' => 8500, 'eq_in_use' => 0],
            ['eq_name' => 'Viewing Tent', 'eq_type' => 'Non-Consumable', 'eq_available' => 4, 'eq_size_weight' => 'Large', 'eq_unit_price' => 5000, 'eq_in_use' => 0],
            ['eq_name' => 'Chapel Chairs', 'eq_type' => 'Non-Consumable', 'eq_available' => 100, 'eq_size_weight' => 'Standard', 'eq_unit_price' => 600, 'eq_in_use' => 0],
            // ['eq_name' => 'Projector', 'eq_type' => 'Non-Consumable', 'eq_available' => 2, 'eq_size_weight' => 'Medium', 'eq_unit_price' => 7000, 'eq_in_use' => 0],
            // ['eq_name' => 'Microphone Stand', 'eq_type' => 'Non-Consumable', 'eq_available' => 6, 'eq_size_weight' => 'Standard', 'eq_unit_price' => 750, 'eq_in_use' => 0],
            ['eq_name' => 'Funeral Van', 'eq_type' => 'Non-Consumable', 'eq_available' => 1, 'eq_size_weight' => 'Full-size', 'eq_unit_price' => 250000, 'eq_in_use' => 0],
            // ['eq_name' => 'Cooling Unit', 'eq_type' => 'Non-Consumable', 'eq_available' => 2, 'eq_size_weight' => 'Large', 'eq_unit_price' => 15000, 'eq_in_use' => 0],
        ];

        foreach ($equipments as $eq) {
            Equipment::create($eq);
        }
    }
}
