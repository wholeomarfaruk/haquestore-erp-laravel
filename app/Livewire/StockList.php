<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Support\Str;
use Livewire\Component;

class StockList extends Component
{
    public $products;
    public $search = "";
    public $editProductName, $editProductSalePrice, $editKgPerUnit, $editProductQuantity, $editProductUnit, $editProductStockStatus, $editProductDescription, $editProductId, $editViewProductImage;
    public $viewProduct;
    public $editProductModal = false;
    public function editProduct($id)
    {
        // dd($id);

        $this->viewProduct = Product::find($id);
        $this->editProductId = $this->viewProduct->id;
        $this->editProductName = $this->viewProduct->name;
        // $this->editProductPurchasePrice = $this->viewProduct->purchase_price;
        $this->editProductSalePrice = $this->viewProduct->price;
        // $this->editProductDiscountPrice = $this->viewProduct->discount_price;
        $this->editProductQuantity = $this->viewProduct->unit_value;
        $this->editProductUnit = $this->viewProduct->unit_name;
        $this->editProductStockStatus = $this->viewProduct->stock_status;
        $this->editProductDescription = $this->viewProduct->description;
        $this->editKgPerUnit = $this->viewProduct->value_per_unit;
        $this->editViewProductImage = $this->viewProduct->image;

        $this->editProductModal = true;
    }

    public function updateNewProduct()
    {
        //  dd($this->editProductImage);
        try {
            if (!$this->editProductId) {
                return abort(404);
            }
            $this->validate([
                // 'editProductName' => 'required|min:3',
                'editProductSalePrice' => 'required',
                'editProductQuantity' => 'required',
                'editProductUnit' => 'required',
                'editKgPerUnit' => 'required',
            ]);



            //code...

            $product = Product::find($this->editProductId);
            // $product->name = $this->editProductName;
            // $product->purchase_price = $this->editProductPurchasePrice;
            $product->price = $this->editProductSalePrice;
            $product->unit_value = $this->editProductQuantity;
            $product->unit_name = $this->editProductUnit;
            $product->stock_status = $this->editProductStockStatus;
            $product->description = $this->editProductDescription;
            $product->value_per_unit = $this->editKgPerUnit;
            $product->stock=floatval($product->unit_value) * floatval($product->value_per_unit);


            $product->save();
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
        $this->editProductModal = false;
    }
    public function render()
    {
        if (!empty($this->search)) {
            // dd($this->search);
            $this->products = Product::where('name', 'LIKE', '%' . $this->search . '%')
                ->orderByDesc('id')
                ->get();
        } else {

            $this->products = Product::orderByDesc('id')->get();

        }
        return view('livewire.stock-list')->layout('layouts.company');
    }
}
