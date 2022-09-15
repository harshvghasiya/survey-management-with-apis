<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigrateInOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate_in_order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute the migrations in the order specified in the file app/Console/Comands/MigrateInOrder.php \n Drop all the table in db before execute the command.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $migrations = [
            '2014_10_12_100000_create_password_resets_table.php',
            '2019_08_19_000000_create_failed_jobs_table.php',
            '2019_12_14_000001_create_personal_access_tokens_table.php',
            '2022_02_12_193405_create__project_category_table.php',
            '2022_02_12_193229_create__project_table.php',
            '2022_02_12_193445_create_pages_table.php',
            '2022_02_12_192742_create_userrole_table.php',
            '2022_02_12_192829_create_userrolepages_table.php',
            '2022_02_12_192531_create_user_table.php',
            '2022_02_12_193529_create_location_table.php',
            '2022_02_12_193312_create__project_location_table.php',
            '2022_02_12_193147_create__project_user_table.php',
            '2022_02_12_192928_create__survey_type_table.php',
            '2022_02_12_193104_create__survey_table.php',
            '2022_02_12_193027_create__survey_form_table.php'
        ];

        foreach ($migrations as $migration) {
            $basePath = 'database/migrations/';
            $migrationName = trim($migration);
            $path = $basePath . $migrationName;
            $this->call('migrate:refresh', [
                '--path' => $path,
            ]);
        }
    }
}
