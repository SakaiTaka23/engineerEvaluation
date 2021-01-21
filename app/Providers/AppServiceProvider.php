<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Service\CalculateRankInterface;
use App\Service\FetchGitHubAPIInterface;
use App\Service\OffsetDataInterface;
use App\Service\RankDataInterface;
use App\Service\Production\CalculateRank;
use App\Service\Production\FetchGitHubAPI;
use App\Service\Production\OffsetData;
use App\Service\Production\RankData;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CalculateRankInterface::class, CalculateRank::class);
        $this->app->singleton(FetchGitHubAPIInterface::class, FetchGitHubAPI::class);
        $this->app->singleton(OffsetDataInterface::class, OffsetData::class);
        $this->app->singleton(RankDataInterface::class, RankData::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
