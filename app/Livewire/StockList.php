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
    public int $updateUnit=0;
    public int $updateKg=0;
    public int $updateGram=0;
    public $filterLowStock = false;
    public $filterStockOut = false;
    public $filterStockAvailable = false;

    public $stock_input='in';


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

        $this->updateUnit=0;
        $this->editProductModal = true;


    }

    public function updateNewProduct()
    {
        //  dd($this->editProductImage);

        try {

            if (!$this->editProductId) {
                return abort(404);
            }

            // $this->validate([
                // 'editProductName' => 'required|min:3',
                // 'editProductSalePrice' => 'required',
                // 'editProductQuantity' => 'required',
                // 'editProductUnit' => 'required',
                // 'editKgPerUnit' => 'required',
            // ]);



            //code...

            $product = Product::find($this->editProductId);
            // $product->name = $this->editProductName;
            // $product->purchase_price = $this->editProductPurchasePrice;
            // $product->price = $this->editProductSalePrice;
            // $product->unit_name = $this->editProductUnit;
            $product->stock_status = $this->editProductStockStatus;
            // $product->description = $this->editProductDescription;
            // $product->value_per_unit = $this->editKgPerUnit;
            if (($this->updateUnit > 0 || $this->updateKg >0 || $this->updateGram>0) && $this->stock_input == 'in') {

                $unitinkg = $this->updateUnit * $product->value_per_unit;
                $kg=$this->updateKg;
                $graminkg= $this->updateGram>0 ? ($this->updateGram/1000) : 0;
                $totalkg=$kg+$graminkg+$unitinkg;
                $newUnit=$totalkg/$product->value_per_unit;


                $product->unit_value += $newUnit;
                $product->stock += $totalkg;

            }elseif(($this->updateUnit > 0 || $this->updateKg >0 || $this->updateGram>0) && $this->stock_input == 'out' ){
                $unitinkg = $this->updateUnit * $product->value_per_unit;
                $kg=$this->updateKg;
                $graminkg= $this->updateGram>0 ? ($this->updateGram/1000) : 0;
                $totalkg=$kg+$graminkg+$unitinkg;
                $newUnit=$totalkg/$product->value_per_unit;


                if($this->viewProduct->stock<$totalkg){
                    $this->dispatch('toast', [
                        'type' => 'error',
                        'message' => 'Stock not enough'
                    ]);
                    return false;
                }

                $product->unit_value -= $newUnit;
                $product->stock -= $totalkg;
            }


            $product->save();
            $this->reset(['updateUnit','updateKg','updateGram']);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
        $this->editProductModal = false;

    }
    public function render()
    {
        $products = Product::query()
        ->when($this->filterLowStock, function ($query) {
            return $query->where('stock', '<=', 10);
        })
        ->when($this->search, function ($query) {
            return $query->where('name', 'LIKE', '%' . $this->search . '%');
        })
        ->when($this->filterStockOut, function ($query) {
            return $query->where('stock', '<=', 0);
        })
        ->when($this->filterStockAvailable, function ($query) {
            return $query->where('stock', '>', 0);
        })
        ->orderBy('id', 'desc')
        ->get();

        $this->products = $products;
        return view('livewire.stock-list')->layout('layouts.company');
    }
    public function resetFilter()
    {
        $this->reset(['filterLowStock', 'filterStockOut', 'filterStockAvailable']);
    }
}
