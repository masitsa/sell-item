<?php
class Migration_Laikipia_Schools extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field(
           array(
              'id' => array(
                 'type' => 'INT',
                //  'constraint' => 5,
                //  'unsigned' => true,
                 'auto_increment' => true
              ),
              'school_name' => array(
                 'type' => 'TEXT',
                 'constraint' => '400',
              ),
              'boys' => array(
                 'type' => 'TEXT',
                 'null' => true,
              ),
              'girls' => array(
                'type' => 'TEXT',
                'null' => true,
             ),
             'about' => array(
                'type' => 'TEXT',
                'null' => true,
             ),
             'logo' => array(
                'type' => 'TEXT',
                'null' => true,
             ),
             'latitude' => array(
                'type' => 'FLOAT',
                'null' => true,
             ),
             'longitude' => array(
                'type' => 'FLOAT',
                'null' => true,
             ),
            'photos' => array(
               'type' => 'TEXT',
               'null' => true,
            )
           )
        );

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('laikipia_schools');
    }

    public function down()
    {
        $this->dbforge->drop_table('laikipia_schools');
    }
}
