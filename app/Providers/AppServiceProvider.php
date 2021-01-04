<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use App\Exports\Concerns\WithCustomCells;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Writer;

/**
 * Class AppServiceProvider.
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Excel::extend(WithCustomCells::class, function(WithCustomCells $exportable, Writer $writer) {
            $delegate = $writer->getDelegate();
            $cells = $exportable->customCells();
            foreach ($cells as $key => $value) {
                $delegate->getActiveSheet()->setCellValue($key, $value);
            }
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
    }
}
