<?php

namespace BagistoPlus\VisualDebut\Sections;

use BagistoPlus\Visual\Sections\BladeSection;
use Diglactic\Breadcrumbs\Breadcrumbs as BreadcrumbsBreadcrumbs;
use Illuminate\Support\Facades\Route;

use function BagistoPlus\VisualDebut\_t;

class Breadcrumbs extends BladeSection
{
    protected static string $view = 'shop::sections.breadcrumbs';

    protected static array $disabledOn = ['index', 'category'];

    public static function name(): string
    {
        return _t('breadcrumbs.name');
    }

    public static function description(): string
    {
        return _t('breadcrumbs.description');
    }

    public static function previewImageUrl(): string
    {
        return bagisto_asset('images/sections/breadcrumbs.png', 'visual-debut');
    }

    public function getViewData(): array
    {
        $breadcrumbsData = match (Route::currentRouteName()) {
            'shop.product_or_category.index' => ['name' => 'product', 'entity' => $this->context['product']],
            'shop.checkout.cart.index' => ['name' => 'cart'],
            'shop.checkout.onepage.index' => ['name' => 'checkout'],
            'shop.compare.index' => ['name' => 'compare'],

            // Account pages
            'shop.customers.account.profile.index' => ['name' => 'profile'],
            'shop.customers.account.profile.edit' => ['name' => 'profile.edit'],

            'shop.customers.account.addresses.index' => ['name' => 'addresses'],
            'shop.customers.account.addresses.create' => ['name' => 'addresses.create'],
            'shop.customers.account.addresses.edit' => ['name' => 'addresses.edit', 'entity' => $this->context['address']],

            'shop.customers.account.orders.index' => ['name' => 'orders'],
            'shop.customers.account.orders.view' => ['name' => 'orders.view', 'entity' => $this->context['order']],

            'shop.customers.account.reviews.index' => ['name' => 'reviews'],
            'shop.customers.account.downloadable_products.index' => ['name' => 'downloadable-products'],
            default => []
        };

        $breadcrumbs = empty($breadcrumbsData)
            ? collect([])
            : BreadcrumbsBreadcrumbs::generate(...$breadcrumbsData);

        return ['breadcrumbs' => $breadcrumbs];
    }
}
