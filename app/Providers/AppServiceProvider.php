<?php

namespace App\Providers;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Validator::extend('unique_local_ingredients', function ($attribute, $value, $parameters, $validator) {
            // ローカル上での材料が一意であることを確認するロジックをここに実装
            // 例: ローカル上での材料がすでに存在しているかどうかをデータベースや配列などで確認する
            return !in_array($value, $parameters);
        });
    }
}
