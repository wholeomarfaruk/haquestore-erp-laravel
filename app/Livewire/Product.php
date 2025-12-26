<?php

namespace App\Livewire;

use App\Models\Product as ModelsProduct;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Product extends Component
{
    public $products;
    public $search='';
    public $addProductModal = false;
    public $editProductModal = false;
    public $viewModal = false;
    public $viewProduct;
    public $newPName,$newPPurchasePrice,$newPSalePrice,$newPDiscountPrice,$newPQuantity,$newPunit,$newPStockStatus='in_stock',$newPDescription;
    public $editProductName,$editProductPurchasePrice,$editProductSalePrice,$editProductDiscountPrice,$editProductQuantity,$editProductUnit,$editProductStockStatus,$editProductDescription,$editProductImage,$editProductId,$editViewProductImage;
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
            'newPImage' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'newPPurchasePrice' => 'required',
            'newPSalePrice' => 'required',
            'newPQuantity' => 'required|integer|min:1',
            'newPunit' => 'required',
        ]);
        try {
            //code...

        $product = new ModelsProduct();
        $product->name = $this->newPName;
        if($this->newPPurchasePrice){

            $product->purchase_price = $this->newPPurchasePrice;
        }
        $product->price = $this->newPSalePrice;
        if($this->newPDiscountPrice){

            $product->discount_price = $this->newPDiscountPrice;
        }

        $product->unit_value = $this->newPQuantity;
        $product->unit_name = $this->newPunit;
        // $product->stock_status = $this->newPStockStatus;
        if($this->newPDescription){

            $product->description = $this->newPDescription;
        }
        $product->image = $this->newPImage->storeAs('products', Str::uuid() . '.' . $this->newPImage->extension(), 'public');
        $product->save();
           } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }

        $this->reset('newPName', 'newPPurchasePrice', 'newPSalePrice', 'newPDiscountPrice', 'newPQuantity', 'newPunit', 'newPStockStatus', 'newPDescription', 'newPImage');
        $this->addProductModal = false;
    }
    public function deleteProduct($id)
    {
       $product = ModelsProduct::find($id);
       if(!$product){
           return abort(404);
       }
       if(file_exists('storage/'.$product->image)){
           unlink('storage/'.$product->image);
       }
       $product->delete();
    }
    public function editProduct($id){
        // dd($id);

        $this->viewProduct = ModelsProduct::find($id);
        $this->editProductId = $this->viewProduct->id;
        $this->editProductName = $this->viewProduct->name;
        $this->editProductPurchasePrice = $this->viewProduct->purchase_price;
        $this->editProductSalePrice = $this->viewProduct->price;
        $this->editProductDiscountPrice = $this->viewProduct->discount_price;
        $this->editProductQuantity = $this->viewProduct->unit_value;
        $this->editProductUnit = $this->viewProduct->unit_name;
        $this->editProductStockStatus = $this->viewProduct->stock_status;
        $this->editProductDescription = $this->viewProduct->description;
        $this->editViewProductImage = $this->viewProduct->image;

        $this->editProductModal = true;
    }

    public function updateNewProduct(){
        try {
        if(!$this->editProductId){
            return abort(404);
        }
        $this->validate([
            'editProductName' => 'required|min:3',
            'editProductPurchasePrice' => 'required',
            'editProductSalePrice' => 'required',
            'editProductQuantity' => 'required',
            'editProductUnit' => 'required',
        ]);



        if($this->editProductImage){
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
        $product->unit_value = $this->editProductQuantity;
        $product->unit_name = $this->editProductUnit;
        $product->stock_status = $this->editProductStockStatus;
        $product->description = $this->editProductDescription;
        if($this->editProductImage){
            if(file_exists('storage/'.$product->image)){
                unlink('storage/'.$product->image);
            }
            $product->image = $this->editProductImage->storeAs('products', Str::uuid() . '.' . $this->editProductImage->extension(), 'public');
        }
        $product->save();
         } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
        $this->editProductModal = false;
    }
}
