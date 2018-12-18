<?php
class Migration_Register_Business extends CI_Migration
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
              'business_name' => array(
                 'type' => 'TEXT',
                 'constraint' => '400',
              ),
              'category' => array(
                 'type' => 'TEXT',
                 'null' => true,
              ),
              'phone_number' => array(
                'type' => 'TEXT',
                'null' => true,
             ),
             'logo' => array(
                'type' => 'TEXT',
                'null' => true,
             ),
             'location' => array(
                'type' => 'TEXT',
                'null' => true,
             ),
           )
        );

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('register_businesses');
    }

    public function down()
    {
        $this->dbforge->drop_table('register_businesses');
    }
}
