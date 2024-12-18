<?php

namespace App\Providers;
use Illuminate\Support\Facades\Http;
use View;

use App\Models\CompanyInfo;
use Session;
use Illuminate\Support\ServiceProvider;

class ContentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
{
    // Fetch the company information
    $companyInfo = CompanyInfo::first(); // Assuming there is only one entry for company info

    // Prepare the content array
    $content = [];

    // Check if company info exists and add the logo
    if ($companyInfo) {
        $content['logo'] = $companyInfo->logo; // Assuming the logo field exists in the CompanyInfo model
    } else {
        $content['logo'] = null; // Fallback in case no data is available
    }

    // dd($companyInfo);

    // Share the data across all views
    View::share('commonContent', $content);
}
}
