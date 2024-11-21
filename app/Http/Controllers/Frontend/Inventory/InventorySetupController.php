<?php

namespace App\Http\Controllers\Frontend\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InventorySetupController extends Controller
{
    /////////////////////////// --------------- Manufacturer Methods Start Here ---------- //////////////////////////
    // Show Manufacturers
    public function ShowManufacturer(Request $req){
        $name = "Manufacturer";
        $js = 'inventory/inventory_setup/item_manufacturer';
        if ($req->ajax()) {
            return view('common_modals.single_input.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('common_modals.single_input.singleData', compact('name', 'js'));
        }
    } // End Method



    // Search Manufacturer
    public function SearchManufacturer(Request $req){
        $name = "Manufacturer";
        $js = 'inventory/inventory_setup/item_manufacturer';
        return view('common_modals.single_input.singleData', compact('name', 'js'));
    } // End Method





    /////////////////////////// --------------- Item/Product Category Methods Start Here ---------- //////////////////////////
    // Show Item/Product Categories
    public function ShowItemCategory(Request $req){
        $name = "Item Category";
        $js = 'inventory/inventory_setup/item_category';
        if ($req->ajax()) {
            return view('common_modals.single_input.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('common_modals.single_input.singleData', compact('name', 'js'));
        }
    } // End Method



    // Search Item/Product Category
    public function SearchItemCategory(Request $req){
        $name = "Item Category";
        $js = 'inventory/inventory_setup/item_category';
        return view('common_modals.single_input.singleData', compact('name', 'js'));
    } // End Method
    




    /////////////////////////// --------------- Item/Product Unit Methods Start Here ---------- //////////////////////////
    // Show Item/Product Unit
    public function ShowUnit(Request $req){
        $name = "Item Unit";
        $js = 'inventory/inventory_setup/item_unit';
        if ($req->ajax()) {
            return view('common_modals.single_input.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('common_modals.single_input.singleData', compact('name', 'js'));
        }
    } // End Method



    // Search Item/Product Unit
    public function SearchUnit(Request $req){
        $name = "Item Unit";
        $js = 'inventory/inventory_setup/item_unit';
        return view('common_modals.single_input.singleData', compact('name', 'js'));
    } // End Method
    




    //////////////////////////// --------------- Item/Product Form Methods Start Here ---------- //////////////////////////
    // Show Item/Product Form
    public function ShowForm(Request $req){
        $name = "Item Form";
        $js = 'inventory/inventory_setup/item_form';
        if ($req->ajax()) {
            return view('common_modals.single_input.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('common_modals.single_input.singleData', compact('name', 'js'));
        }
    } // End Method



    // Search Item/Product Form
    public function SearchForm(Request $req){
        $name = "Item Form";
        $js = 'inventory/inventory_setup/item_form';
        return view('common_modals.single_input.singleData', compact('name', 'js'));
    } // End Method





    /////////////////////////// --------------- Inventory Product Table Methods Start ---------- //////////////////////////
    // Show All Inventory Product
    public function ShowInventoryProduct(Request $req){
        $name = "Inventory Product";
        $js = 'inventory/inventory_setup/inventory_product';
        if ($req->ajax()) {
            return view('products.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('products.products', compact('name', 'js'));
        }
    } // End Method



    // Inventory Product Search
    public function SearchInventoryProduct(Request $req){
        $name = "Inventory Product";
        $js = 'inventory/inventory_setup/inventory_product';
        return view('products.products', compact('name', 'js'));
    } // End Method
}
