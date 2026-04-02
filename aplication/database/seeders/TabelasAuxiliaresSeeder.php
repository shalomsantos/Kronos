<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SubitemFornecedor;
use App\Models\ItemSubitem;

class TabelasAuxiliaresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // subitem fornecedor
        $subitemFornecedor = [
            [
                'subitem_id' => 1,
                'fornecedor_id' => 1
            ],
            [
                'subitem_id' => 2,
                'fornecedor_id' => 1
            ],
            [
                'subitem_id' => 3,
                'fornecedor_id' => 1
            ],
            [
                'subitem_id' => 4,
                'fornecedor_id' => 1
            ],
            [
                'subitem_id' => 5,
                'fornecedor_id' => 1
            ],
            [
                'subitem_id' => 6,
                'fornecedor_id' => 1
            ],
            [
                'subitem_id' => 7,
                'fornecedor_id' => 1
            ],
            [
                'subitem_id' => 8,
                'fornecedor_id' => 1
            ],
            [
                'subitem_id' => 9,
                'fornecedor_id' => 1
            ],
            [
                'subitem_id' => 10,
                'fornecedor_id' => 1
            ],
        ];
        SubitemFornecedor::insert($subitemFornecedor);
        // Subitem item
        $itemSubitem = [
            [
                'item_id' => 1,
                'subitem_id' => 1,
            ],
            [
                'item_id' => 1,
                'subitem_id' => 2,
            ],
            [
                'item_id' => 1,
                'subitem_id' => 3,
            ],
            [
                'item_id' => 2,
                'subitem_id' => 4,
            ],
            [
                'item_id' => 2,
                'subitem_id' => 5,
            ],
            [
                'item_id' => 2,
                'subitem_id' => 6,
            ],
            [
                'item_id' => 2,
                'subitem_id' => 7,
            ],
            [
                'item_id' => 2,
                'subitem_id' => 8,
            ],
            [
                'item_id' => 3,
                'subitem_id' => 9,
            ],
            [
                'item_id' => 3,
                'subitem_id' => 10,
            ]
        ];
        ItemSubitem::insert($itemSubitem);
    }
}
