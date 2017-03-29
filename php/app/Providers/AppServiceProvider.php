<?php

namespace App\Providers;

use DB;
use App;
use Illuminate\Support\ServiceProvider;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 监听 db 执行
        DB::listen(function($sql, $bindings, $time) {
            if (App::environment() == 'production' || !isset($_GET['sql'])) return true;

            static $number;
            $number = ($number === null ? 1 : $number + 1);

            print '<pre>';
            print sprintf("%d, ExecTime: %f, SQL: %s, GiveData: %s",$number, $time, $sql, print_R($bindings, true));
            print "</pre>\n";

            //Log::info(sprintf("%d, ExecTime: %f, SQL: %s, GiveData: %s",$number, $time, $sql, print_R($bindings, true)));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
