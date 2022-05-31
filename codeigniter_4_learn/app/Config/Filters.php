<?php

namespace Config;

use App\Filters\UserExistsFilter;
use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseConfig {

    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     *
     * @var array
     */
    public $aliases = [
        'csrf' => CSRF::class,
        'toolbar' => DebugToolbar::class,
        'honeypot' => Honeypot::class,
        'invalidchars' => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        // filtros customizados
        'isLogged' => \App\Filters\Employee\IsLoggedFilter::class,
        'isNotLogged' => \App\Filters\Employee\IsNotLoggedFilter::class,
        'hasClient' => \App\Filters\Client\HasClientFilter::class,
        'hasProvider' => \App\Filters\Provider\HasProviderFilter::class,
        'hasProductType' => \App\Filters\Product\HasProductTypeFilter::class,
        'hasProduct' => \App\Filters\Product\HasProductFilter::class,
        'hasStorage' => \App\Filters\Storage\HasStorageFilter::class,
        'hasAcquisition' => \App\Filters\Acquisition\HasAcquisitionFilter::class,
        'hasSale' => \App\Filters\Sale\HasSaleFilter::class,
        'hasProductType' => \App\Filters\Product\HasProductTypeFilter::class,
        'hasBrand' => \App\Filters\Brand\HasBrandFilter::class,
        'hasUserType' => \App\Filters\HasUserTypeFilter::class,
        'hasTelephoneType' => \App\Filters\HasTelephoneTypeFilter::class,
        'isNotFirstLogin' => \App\Filters\Employee\IsNotFirstLoginFilter::class,
        'toAddBrand' => \App\Filters\Product\ToAddBrandFilter::class,
        'toAddDescription' => \App\Filters\Product\ToAddDescriptionFilter::class,
        'toAddProduct' => \App\Filters\Product\ToAddProductFilter::class,
        'toAddAcquisitionProduct' => \App\Filters\Acquisition\AddAcquisitionProductFilter::class,
        'toAddAcquisitionAdditionalData' => \App\Filters\Acquisition\AddAcquisitionAdditionalDataFilter::class,
        'toAddAcquisitionResume' => \App\Filters\Acquisition\AddAcquisitionResumeFilter::class,
        'toAddSaleProduct' => \App\Filters\Sale\AddSaleProductFilter::class,
        'toAddSaleAdditionalData' => \App\Filters\Sale\AddSaleAdditionalDataFilter::class,
        'toAddSaleResume' => \App\Filters\Sale\AddSaleResumeFilter::class,
        'isActive' => \App\Filters\Employee\IsActiveFilter::class
    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     *
     * @var array
     */
    public $globals = [
        'before' => [
            // 'honeypot',
            'csrf',
        // 'invalidchars',
        ],
        'after' => [
            'toolbar',
        // 'honeypot',
        // 'secureheaders',
        ],
    ];

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['csrf', 'throttle']
     *
     * @var array
     */
    public $methods = [];

    /**
     * List of filter aliases that should run on any
     * before or after URI patterns.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     *
     * @var array
     */
    public $filters = [];

}
