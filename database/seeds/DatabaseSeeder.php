<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Category;
use App\Merk;
use App\Models;
use App\Rule;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {	
        if(env('ENV_STATUS', 'development') == 'development') {
        	$data = array(
                    "name"=>"admin",
                    "email"=>"admin@gmail.com",
                    "password"=>bcrypt(12345678),
                    "role"=>2
                );
        	User::firstOrCreate($data);

            $this->populate_category();
            $this->populate_merk();
            $this->populate_models();
        }
        $this->populate_rule();
        // $this->call(UsersTableSeeder::class);
    }


    public function populate_rule() {

        $data =array(
            "view_admin_data",
            "add_setting_parameter",
            "edit_admin_data",
            "view_barang_masuk",
            "tambah_barang_masuk",
            "view_barang_keluar",
            "tambah_barang_keluar",
            "print_invoice",
            "print_barcode",
            "set_stock_retur",
            "delete_stock",
        );


        $full_data = array();
        foreach($data as $val) {
            $each_data = array(
                'name'=>$val,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );

            array_push($full_data,$each_data);
        }

        Rule::insert($full_data);
    }


    public function populate_category() {
        $data = array(
                "name"=>"AC",
                "created_by"=>1,
                "updated_by"=>1,
        );
        Category::firstOrCreate($data);

        $data = array(
                "name"=>"TV",
                "created_by"=>1,
                "updated_by"=>1,
        );
        Category::firstOrCreate($data);

        $data = array(
                "name"=>"CAR",
                "created_by"=>1,
                "updated_by"=>1,
        );
        Category::firstOrCreate($data);
    }


    public function populate_merk() {
        $data = array(
                "category_id"=>1,
                "name"=>"PANASONIC",
                "created_by"=>1,
                "updated_by"=>1,
        );
        Merk::firstOrCreate($data);

        $data = array(
                "category_id"=>1,
                "name"=>"DAIKIN",
                "created_by"=>1,
                "updated_by"=>1,
        );
        Merk::firstOrCreate($data);

        $data = array(
                "category_id"=>2,
                "name"=>"SHARP",
                "created_by"=>1,
                "updated_by"=>1,
        );
        Merk::firstOrCreate($data);

        $data = array(
                "category_id"=>2,
                "name"=>"XIAOMI",
                "created_by"=>1,
                "updated_by"=>1,
        );
        Merk::firstOrCreate($data);
    }


    public function populate_models() {
        $data = array(
                "merk_id"=>1,
                "name"=>"R310",
                "created_by"=>1,
                "updated_by"=>1,
        );
        Models::firstOrCreate($data);

        $data = array(
                "merk_id"=>1,
                "name"=>"R420",
                "created_by"=>1,
                "updated_by"=>1,
        );
        Models::firstOrCreate($data);


        $data = array(
                "merk_id"=>3,
                "name"=>"smarttv_2jt",
                "created_by"=>1,
                "updated_by"=>1,
        );
        Models::firstOrCreate($data);

        $data = array(
                "merk_id"=>3,
                "name"=>"SMARTTV4k",
                "created_by"=>1,
                "updated_by"=>1,
        );
        Models::firstOrCreate($data);

      
    }
}
