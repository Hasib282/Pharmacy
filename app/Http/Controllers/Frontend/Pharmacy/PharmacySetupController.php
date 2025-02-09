<?php

namespace App\Http\Controllers\Frontend\Pharmacy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PharmacySetupController extends Controller
{
    /////////////////////////// --------------- Manufacturer Methods Start Here ---------- //////////////////////////
    // Show Manufacturers
    public function ShowManufacturer(Request $req){
        $name = "Manufacturer";
        $js = 'pharmacy/pharmacy_setup/item_manufacturer';
        if ($req->ajax()) {
            return view('common_modals.single_input.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('common_modals.single_input.main', compact('name', 'js'));
        }
    } // End Method



    // Search Manufacturer
    public function SearchManufacturer(Request $req){
        $name = "Manufacturer";
        $js = 'pharmacy/pharmacy_setup/item_manufacturer';
        return view('common_modals.single_input.main', compact('name', 'js'));
    } // End Method





    /////////////////////////// --------------- Item/Product Category Methods Start Here ---------- //////////////////////////
    // Show Item/Product Categories
    public function ShowItemCategory(Request $req){
        $name = "Item Category";
        $js = 'pharmacy/pharmacy_setup/item_category';
        if ($req->ajax()) {
            return view('common_modals.single_input.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('common_modals.single_input.main', compact('name', 'js'));
        }
    } // End Method



    // Search Item/Product Category
    public function SearchItemCategory(Request $req){
        $name = "Item Category";
        $js = 'pharmacy/pharmacy_setup/item_category';
        return view('common_modals.single_input.main', compact('name', 'js'));
    } // End Method
    




    /////////////////////////// --------------- Item/Product Unit Methods Start Here ---------- //////////////////////////
    // Show Item/Product Unit
    public function ShowUnit(Request $req){
        $name = "Item Unit";
        $js = 'pharmacy/pharmacy_setup/item_unit';
        if ($req->ajax()) {
            return view('common_modals.single_input.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('common_modals.single_input.main', compact('name', 'js'));
        }
    } // End Method



    // Search Item/Product Uni
    public function SearchUnit(Request $req){
        $name = "Item Unit";
        $js = 'pharmacy/pharmacy_setup/item_unit';
        return view('common_modals.single_input.main', compact('name', 'js'));
    } // End Method
    




    //////////////////////////// --------------- Item/Product Form Methods Start Here ---------- //////////////////////////
    // Show Item/Product Form
    public function ShowForm(Request $req){
        $name = "Item Form";
        $js = 'pharmacy/pharmacy_setup/item_form';
        if ($req->ajax()) {
            return view('common_modals.single_input.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('common_modals.single_input.main', compact('name', 'js'));
        }
    } // End Method



    // Search Item/Product Form
    public function SearchForm(Request $req){
        $name = "Item Form";
        $js = 'pharmacy/pharmacy_setup/item_form';
        return view('common_modals.single_input.main', compact('name', 'js'));
    } // End Method





    /////////////////////////// --------------- Pharmacy Product Table Methods Start ---------- //////////////////////////
    // Show All Pharmacy Product
    public function ShowPharmacyProduct(Request $req){
        $name = "Pharmacy Product";
        $js = 'pharmacy/pharmacy_setup/pharmacy_product';
        if ($req->ajax()) {
            return view('admin_setup.products.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('admin_setup.products.main', compact('name', 'js'));
        }
    } // End Method



    // Pharmacy Product Search
    public function SearchPharmacyProduct(Request $req){
        $name = "Pharmacy Product";
        $js = 'pharmacy/pharmacy_setup/pharmacy_product';
        return view('admin_setup.products.main', compact('name', 'js'));
    } // End Method
}
