<?php

use Illuminate\Database\Seeder;
use App\Model\SeedInformation;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->startSeed('SeedInformationSeeder');
        $this->startSeed('AdminUserSeeder');
        $this->startSeed('LanguageSeeder');
        $this->startSeed('PageSeeder');
        $this->startSeed('RolesSeeder');
    }

    public function startSeed($seedClass) {
        $seedCount = SeedInformation::where('name', $seedClass)->count();

        if ($seedCount == 0) {
            \DB::beginTransaction();
            try {
                $this->call($seedClass);
                SeedInformation::create([
                    'name' => $seedClass,
                ]);
                \DB::commit();
            } catch (\Exception $e) {
                \DB::rollback();
                \Log::error($e);
                echo "\033[31m" . $e->getMessage() . "\n";
            }
        } else {
            echo ( "\033[32m" . $seedClass . ": \033[37mAlready Seeded\n");
        }
        
    }
}
