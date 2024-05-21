<?php

namespace App\Livewire;

use App\Helpers\CartMangement;
use App\Livewire\Partials\Navbar;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Productos - PieroMG')]
class ProductPage extends Component
{
    use WithPagination;
    #[Url]
    public $selected_categories = [];
    #[Url]
    public $selected_brands = [];
    #[Url]
    public $featured = [];
    #[Url]
    public $on_sale = [];
    #[Url]
    public $price_range = 10000;
    #[Url]
    public $sort = 'latest';

    // add product to cart method
    public function addToCart($product_id)
    {
        $total_count = CartMangement::addItemToCart($product_id);
        $this->dispatch('update-cart-count', total_count: $total_count)->to(Navbar::class);
        toastr()->addSuccess('Product added!');
    }

    public function render()
    {
        $productQuery = Product::query()->where('is_active', 1);

        if (!empty($this->selected_categories))
        {
            $productQuery->whereIn('category_id', $this->selected_categories);
        }
        if (!empty($this->selected_brands))
        {
            $productQuery->whereIn('brand_id', $this->selected_brands);
        }
        if (!empty($this->featured))
        {
            $productQuery->where('is_featured', 1);
        }
        if (!empty($this->on_sale))
        {
            $productQuery->where('on_sale', 1);
        }
        if (!empty($this->price_range))
        {
            $productQuery->whereBetween('price', [0, $this->price_range]);
        }
        if ($this->sort == 'latest')
        {
            $productQuery->latest();
        }
        if ($this->sort == 'price')
        {
            $productQuery->orderBy('price');
        }
        return view('livewire.product-page', [
            'products' => $productQuery->paginate(3),
            'brands' => Brand::where('is_active', 1)->get(['id', 'name', 'slug']),
            'categories' => Category::where('is_active', 1)->get(['id', 'name', 'slug'])
        ]);
    }
}
