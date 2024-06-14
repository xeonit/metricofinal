<?php
namespace App\Console;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class DatabasePreparation
{
    public static function invoke()
    {
        echo "Preparing Database\n";
        $rawSql = \public_path("uploads/app/raw.sql");
        $rawContent = file_get_contents($rawSql);
        $insertedDBNAME = str_replace('{{DB_NAME}}', env('DB_DATABASE'), $rawContent);
        file_put_contents($rawSql, $insertedDBNAME);
        $command =  env('MYSQL_CLIENT')." -h ".env('DB_HOST')." -P ".env('DB_PORT')." --user=".env('DB_USERNAME')." --password=".env('DB_PASSWORD')." < $rawSql";
        shell_exec($command);
        file_put_contents($rawSql, $rawContent);
        echo "Database setup completed\n";
    }
}
