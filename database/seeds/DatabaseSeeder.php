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
                "name"=>"ac",
                "created_by"=>1,
                "updated_by"=>1,
        );
        Category::firstOrCreate($data);

        $data = array(
                "name"=>"tv",
                "created_by"=>1,
                "updated_by"=>1,
        );
        Category::firstOrCreate($data);

        $data = array(
                "name"=>"car",
                "created_by"=>1,
                "updated_by"=>1,
        );
        Category::firstOrCreate($data);
    }


    public function populate_merk() {
        $data = array(
                "category_id"=>1,
                "name"=>"panasonic",
                "created_by"=>1,
                "updated_by"=>1,
        );
        Merk::firstOrCreate($data);

        $data = array(
                "category_id"=>1,
                "name"=>"daikin",
                "created_by"=>1,
                "updated_by"=>1,
        );
        Merk::firstOrCreate($data);

        $data = array(
                "category_id"=>2,
                "name"=>"sharp",
                "created_by"=>1,
                "updated_by"=>1,
        );
        Merk::firstOrCreate($data);

        $data = array(
                "category_id"=>2,
                "name"=>"xiaomi",
                "created_by"=>1,
                "updated_by"=>1,
        );
        Merk::firstOrCreate($data);
    }


    public function populate_models() {
        $data = array(
                "merk_id"=>1,
                "name"=>"panasonic_r310",
                "created_by"=>1,
                "updated_by"=>1,
        );
        Models::firstOrCreate($data);

        $data = array(
                "merk_id"=>1,
                "name"=>"panasonic_r420",
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
                "name"=>"smarttv_4jt",
                "created_by"=>1,
                "updated_by"=>1,
        );
        Models::firstOrCreate($data);

      
    }
}
