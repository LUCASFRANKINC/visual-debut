<?php

namespace BagistoPlus\VisualDebut\Sections;

use BagistoPlus\Visual\Actions\Cart\MoveWishlistToCart;
use BagistoPlus\Visual\Actions\ClearWishlist;
use BagistoPlus\Visual\Actions\GetWishlistItems;
use BagistoPlus\Visual\Actions\RemoveItemFromWishlist;
use BagistoPlus\Visual\Sections\LivewireSection;
use BagistoPlus\VisualDebut\Enums\Events;

class Wishlist extends LivewireSection
{
    protected static array $enabledOn = ['account/wishlist'];

    protected static string $view = 'shop::sections.wishlist';

    public function loader($id) {}

    public function removeAll()
    {
        $response = app(ClearWishlist::class)->execute();

        session()->flash('info', $response['message']);
    }

    public function removeItem($id)
    {
        $response = app(RemoveItemFromWishlist::class)->execute($id);

        session()->flash('info', $response['message']);
    }

    public function moveToCart($id, $productId, $quantity)
    {
        $response = app(MoveWishlistToCart::class)->execute($id, $productId, $quantity);

        if (isset($response['redirect'])) {
            session()->flash('warning', $response['message']);

            return $this->redirect($response['data']);
        }

        $this->dispatch(Events::CART_UPDATED);
        session()->flash('success', $response['message']);
    }

    public function getViewData(): array
    {
        return [
            'wishlistItems' => app(GetWishlistItems::class)->execute(),
        ];
    }
}
