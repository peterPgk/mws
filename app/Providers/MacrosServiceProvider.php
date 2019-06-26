<?php

namespace App\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class MacrosServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Collection::macro('pluckMulti', function ($field) {
            $arr = explode('.', $field);
            $toGet = array_pop($arr);

            $res = $this;
            foreach ($arr as $relation) {
                $res = $res->pluck($relation)->flatten();
            }

            return $res->pluck($toGet);
        });
    }
}
