<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_advertiser extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'advertiser_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'advertiser_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE,
            ),
            'advertiser_email' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE,
            ),
            'advertiser_password' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE,
                'default' => "e10adc3949ba59abbe56e057f20f883e",
            ),
            'advertiser_phone' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE,
            ),
            'advertiser_is_company' => array(
                'type' => 'TINYINT',
                'constraint' => '1',
                'null' => FALSE,
                'default' => 0,
            ),
            'advertiser_company_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE,
                'default' => NULL,
            ),
            'advertiser_company_location' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE,
                'default' => NULL,
            ),
            'advertiser_company_phone' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE,
                'default' => NULL,
            ),
            'advertiser_company_email' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE,
                'default' => NULL,
            ),
            'advertiser_company_kra_pin' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE,
                'default' => NULL,
            ),
            'advertiser_status' => array(
                'type' => 'BOOLEAN',
                'null' => FALSE,
                'default' => 0,
            ),
        ));
        $this->dbforge->add_field("`created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP");
        $this->dbforge->add_field("`modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP");
        $this->dbforge->add_key('advertiser_id', TRUE);
        $this->dbforge->create_table('advertiser');
    }

    public function down()
    {
            $this->dbforge->drop_table('advertiser');
    }
}