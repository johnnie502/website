<?php

use Illuminate\Database\Seeder;
use App\Models\Node;

class NodeTableSeeder extends Seeder 
{
    public function run()
    {
        $nodes = factory(Node::class)->times(50)->make()->each(function ($node, $index) {
            if ($index == 0) {
                // $node->field = 'value';
            }
        });

        Node::insert($nodes->toArray());
    }

}

