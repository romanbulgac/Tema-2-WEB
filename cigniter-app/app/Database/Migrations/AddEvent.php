<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddEvent extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'=>[
                'type'=>'INT',
                'constraint'=>5,
                'unsigned'=>true,
                'auto_increment'=>true
            ],
            'title'=>[
                'type'=>'VARCHAR',
                'constraint'=>'100'
            ],
            'description'=>[
                'type'=>'VARCHAR',
                'constraint'=>'1500'
            ],
            'image'=>[
                'type'=>'VARCHAR',
                'constraint'=>'200'
            ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('events');
    }

    public function down()
    {
        $this->forge->dropTable('events');
    }
}
