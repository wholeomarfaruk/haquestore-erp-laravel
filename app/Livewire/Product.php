<?php

namespace App\Livewire;

use App\Models\Product as ModelsProduct;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Product extends Component
{
    public $products;
    public $search = '';
    public $addProductModal = false;
    public $editProductModal = false;
    public $viewModal = false;
    public $viewProduct;
    public $newPName, $newPPurchasePrice, $newPSalePrice, $newPDiscountPrice, $newPQuantity,$newKgPerUnit, $newPunit='kg', $newPStockStatus = 'in_stock', $newPDescription;
    public $editProductName, $editProductPurchasePrice, $editProductSalePrice, $editProductDiscountPrice,$editKgPerUnit, $editProductQuantity, $editProductUnit, $editProductStockStatus, $editProductDescription, $editProductImage, $editProductId, $editViewProductImage;
    public $newPImage;
    use WithFileUploads;
    public function render()
    {
        if (!empty($this->search)) {
            // dd($this->search);
            $this->products = ModelsProduct::where('name', 'LIKE', '%' . $this->search . '%')
                ->orderByDesc('id')
                ->get();
        } else {

            $this->products = ModelsProduct::orderByDesc('id')->get();

        }
        return view('livewire.product')->layout('layouts.company');
    }
    public function addNewProduct()
    {
        // dd($this->newPunit);


        $this->validate([
            'newPName' => 'required|min:3',

            'newPSalePrice' => 'required',

            'newKgPerUnit' => 'required|integer|min:1',
        ]);
        if($this->newPImage){
            $this->validate([
                'newPImage' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);
        }
        try {
            //code...

            $product = new ModelsProduct();
            $product->name = $this->newPName;
            $product->price = $this->newPSalePrice;
            // if ($this->newPPurchasePrice) {

            //     $product->purchase_price = $this->newPPurchasePrice;
            // }
            // if ($this->newPDiscountPrice) {

            //     $product->discount_price = $this->newPDiscountPrice;
            // }


            $product->value_per_unit = $this->newKgPerUnit;
            $product->unit_name = $this->newPunit;
            $product->stock_status = $this->newPStockStatus;

            if ($this->newPDescription) {

                $product->description = $this->newPDescription;
            }
            if ($this->newPImage) {

                $path = public_path('storage/products');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $filename = Str::uuid() . '.' . $this->newPImage->getClientOriginalExtension();
                copy($this->newPImage->getRealPath(), $path . '/' . $filename);
                $product->image = "products/$filename";
            }
            $product->save();
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }

        $this->reset('newPName', 'newPPurchasePrice', 'newPSalePrice', 'newPDiscountPrice', 'newPQuantity', 'newKgPerUnit', 'newPunit', 'newPStockStatus', 'newPDescription', 'newPImage');
        $this->addProductModal = false;
    }
    public function deleteProduct($id)
    {
        $product = ModelsProduct::find($id);
        if (!$product) {
            return abort(404);
        }
        if (file_exists('storage/' . $product->image)) {
            unlink('storage/' . $product->image);
        }
        $product->delete();
    }
    public function editProduct($id)
    {
        // dd($id);

        $this->viewProduct = ModelsProduct::find($id);
        $this->editProductId = $this->viewProduct->id;
        $this->editProductName = $this->viewProduct->name;
        $this->editProductPurchasePrice = $this->viewProduct->purchase_price;
        $this->editProductSalePrice = $this->viewProduct->price;
        $this->editProductDiscountPrice = $this->viewProduct->discount_price;
        $this->editProductUnit = $this->viewProduct->unit_name;
        $this->editProductStockStatus = $this->viewProduct->stock_status;
        $this->editProductDescription = $this->viewProduct->description;
        $this->editKgPerUnit = $this->viewProduct->value_per_unit;
        $this->editViewProductImage = $this->viewProduct->image;
        $this->editProductQuantity = $this->viewProduct->unit_value;
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
                'editProductName' => 'required|min:3',
                'editProductSalePrice' => 'required',
                'editKgPerUnit' => 'required',
            ]);



            if ($this->editProductImage) {
                $this->validate([
                    'editProductImage' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                ]);
            }

            //code...

            $product = ModelsProduct::find($this->editProductId);
            $product->name = $this->editProductName;
            $product->purchase_price = $this->editProductPurchasePrice;
            $product->price = $this->editProductSalePrice;
            $product->discount_price = $this->editProductDiscountPrice;

            // $product->unit_name = $this->editProductUnit;
            $product->stock_status = $this->editProductStockStatus;
            $product->description = $this->editProductDescription;
            $product->value_per_unit = $this->editKgPerUnit;
            if ($this->editProductImage) {
                if ($product->image && is_file('storage/' . $product->image )) {

                    unlink('storage/' . $product->image);
                }
                $path = public_path('storage/products');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $filename = Str::uuid() . '.' . $this->editProductImage->getClientOriginalExtension();
                copy($this->editProductImage->getRealPath(), $path . '/' . $filename);
                $product->image = "products/$filename";

            }

            $product->save();
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
        $this->editProductModal = false;
    }
}
