<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Category;
use App\Merk;
use App\Models;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {	

    	$data = array(
                "name"=>"thomas",
                "email"=>"thomas.wangsa@gmail.com",
                "password"=>bcrypt(12345678),
            );
    	User::firstOrCreate($data);

        $this->populate_category();
        $this->populate_merk();
        $this->populate_models();
        // $this->call(UsersTableSeeder::class);
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
