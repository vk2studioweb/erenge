<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            SeederConfiguration::class,
            SeederConfigurationMail::class,
            SeederCountries::class,
            SeederCountriesStates::class,
            SeederCountriesStatesCities::class,
            SeederListStyle::class,
            SeederLoginClasses::class,
            SeederLoginPermissions::class,
            SeederLoginUsers::class,
            SeederNavGroup::class,
            SeederNavGroupMenu::class,
            SeederNavGroupMenuChildren::class,
            SeederNavGroupMenuStyle::class,
            SeederNavGroupMenuStyleCollumns::class,
            SeederPermissions::class,
        ]);
    }
}
