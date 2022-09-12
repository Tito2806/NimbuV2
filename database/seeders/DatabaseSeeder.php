<?php

use Database\Seeders\UsersTableSeeder;
use Database\Seeders\PersonSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{

  public function run()
  {
      // $this->truncateTables([
      //     'statuses',
      //     'areas',
      //     'users',
      //     'roles',
      //     'role_users',
      //     'categories',
      //     'subcategories',
      //     'warehouses',
      //     'actives',
      //     'type_commodities',
      //     'unit_measures',
      //     //'quantities',
          
      //     'registers',
      //     'management_centers',
      //     'company_suppliers',
      //     'person_suppliers',
      //     'commodities',
      // ]); LLAVES FORANEAS
      
    $this->call([
      //PersonSeeder::class,
      // AreaSeeder::class,
      UsersTableSeeder::class,
      // RoleSeeder::class,
      // CategorySeeder::class,
      // SubcategorySeeder::class,
      // WarehouseSeeder::class,
      // ActiveSeeder::class,
      // TypeCommoditySeeder::class,
      // UnitMeasureSeeder::class,
      // //QuantitySeeder::class,
      
      // RegisterSeeder::class,
      // ManagementCenterSeeder::class,
      // CompanySupplierSeeder::class,
      // PersonSupplierSeeder::class,
      // CommoditySeeder::class,
    ]);
  }

  public function truncateTables(array $tables){
      DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
      foreach($tables as $table)
      {
          DB::table($table)->truncate();
      }
      DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
  }
}