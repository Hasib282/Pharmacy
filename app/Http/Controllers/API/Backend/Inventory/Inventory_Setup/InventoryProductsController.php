<?php

namespace App\Http\Controllers\API\Backend\Inventory\Inventory_Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use App\Models\Transaction_Head;
use App\Models\Transaction_Groupe;

class InventoryProductsController extends Controller
{
    // Show All Item/Product
    public function ShowAll(Request $req){
        // Update Product Quantity
        // DB::connection('mysql_second'
        // )->table('transaction__heads as h')
        // ->join(DB::raw("(SELECT tran_head_id, SUM(IF(tran_method = 'Purchase',quantity_actual,0)) 
        // -SUM(IF(tran_method = 'Issue',quantity_actual,0)) 
        // -SUM(IF(tran_method = 'Supplier Return',quantity_actual,0)) 
        // +SUM(IF(tran_method = 'Client Return',quantity_actual,0)) 
        // +SUM(IF(tran_method = 'Positive',quantity_actual,0)) 
        // -SUM(IF(tran_method = 'Negative',quantity_actual,0)) as balance
        //   FROM transaction__details
        //     GROUP BY tran_head_id
        // ) as x"),'h.id', '=', 'x.tran_head_id')
        // ->update(['h.quantity' => DB::raw('x.balance')]);

        $groupes = Transaction_Groupe::on('mysql_second')->where('tran_groupe_type', '5')->orderBy('added_at','asc')->get();
        $heads = Transaction_Head::on('mysql_second')->with('Groupe', 'Category', 'Manufecturer', 'Form', 'Unit', 'Store')
        ->whereHas('Groupe', function ($query){
            $query->where('tran_groupe_type', 5);
        })
        ->orderBy('added_at','asc')
        ->paginate(15);

        return response()->json([
            'status'=> true,
            'data' => $heads,
            'groupes' => $groupes,
        ], 200);
    } // End Method



    // Insert Item/Product
    public function Insert(Request $req){
        $req->validate([
            "productName" => 'required|unique:mysql_second.transaction__heads,tran_head_name',
            "groupe" => 'required|numeric',
            "category" => 'required|numeric',
            "manufacturer" => 'required|numeric',
            "form" => 'required|numeric',
            "unit" => 'required|numeric',
        ]);

        Transaction_Head::on('mysql_second')->insert([
            "tran_head_name" => $req->productName,
            "groupe_id" => $req->groupe,
            "category_id" => $req->category,
            "manufacturer_id" => $req->manufacturer,
            "form_id" => $req->form,
            "unit_id" => $req->unit,

        ]);
        
        return response()->json([
            'status'=> true,
            'message' => 'Product Added Successfully'
        ], 200);  
    } // End Method



    // Edit Item/Product
    public function Edit(Request $req){
        $groupes = Transaction_Groupe::on('mysql_second')->where('tran_groupe_type', '5')->orderBy('added_at','asc')->get();
        $heads = Transaction_Head::on('mysql_second')->with('Groupe', 'Category', 'Manufecturer', 'Form', 'Unit', 'Store')->findOrFail($req->id);
        return response()->json([
            'status'=> true,
            'heads'=>$heads,
            'groupes' => $groupes,
        ], 200);
    } // End Method



    // Update Item/Product
    public function Update(Request $req){
        $heads = Transaction_Head::on('mysql_second')->findOrFail($req->id);

        $req->validate([
            "productName" => ['required',Rule::unique('mysql_second.transaction__heads', 'tran_head_name')->ignore($heads->id)],
            "groupe" => 'required|numeric',
            "category" => 'numeric',
            "manufacturer" => 'numeric',
            "form" => 'numeric',
            "unit" => 'required|numeric',
            "store" => 'required|numeric',
            "quantity" => 'required|numeric',
            "cp" => 'required|numeric',
            "mrp" => 'required|numeric',
        ]);

        $update = Transaction_Head::on('mysql_second')->findOrFail($req->id)->update([
            "tran_head_name" => $req->productName,
            "groupe_id" => $req->groupe,
            "category_id" => $req->category,
            "manufacturer_id" => $req->manufacturer,
            "form_id" => $req->form,
            "unit_id" => $req->unit,
            "store_id" => $req->store,
            "quantity" => $req->quantity,
            "cp" => $req->cp,
            "mrp" => $req->mrp,
            "expiry_date" => $req->expiryDate,
            "updated_at" => now()
        ]);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Product Updated Successfully',
            ], 200); 
        }
    } // End Method



    // Delete Item/Product
    public function Delete(Request $req){
        Transaction_Head::on('mysql_second')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Product Deleted Successfully',
        ], 200); 
    } // End Method



    // Search Item/Product
    public function Search(Request $req){
        $query = Transaction_Head::on('mysql_second')->with('Groupe', 'Category', 'Manufecturer', 'Form', 'Unit', 'Store')->whereHas('Groupe', function ($q) {$q->where('tran_groupe_type', 5);} ); // Base query

        if($req->searchOption == 1){
            $query->where('tran_head_name', 'like', '%'.$req->search.'%')
            ->orderBy('tran_head_name','asc');
        }
        else if($req->searchOption == 2){
            $query->whereHas('Groupe', function ($q) use ($req){
                $q->where('tran_groupe_name', 'like', '%' . $req->search . '%');
                $q->orderBy('tran_groupe_name','asc');
            });
        }
        else if($req->searchOption == 3){
            $query->whereHas('Category', function ($q) use ($req) {
                $q->where('category_name', 'like', '%' . $req->search . '%');
                $q->orderBy('category_name','asc');
            });
        }
        else if($req->searchOption == 4){
            $query->whereHas('Manufecturer', function ($q) use ($req) {
                $q->where('manufacturer_name', 'like', '%' . $req->search . '%');
                $q->orderBy('manufacturer_name','asc');
            });
        }
        else if($req->searchOption == 5){
            $query->whereHas('Form', function ($q) use ($req) {
                $q->where('form_name', 'like', '%' . $req->search . '%');
                $q->orderBy('form_name','asc');
            });
        }
        else if($req->searchOption == 6){
            $query->whereHas('Unit', function ($q) use ($req) {
                $q->where('unit_name', 'like', '%' . $req->search . '%');
                $q->orderBy('unit_name','asc');
            });
        }
        else if($req->searchOption == 7){
            $query->whereHas('Store', function ($q) use ($req) {
                $q->where('store_name', 'like', '%' . $req->search . '%');
                $q->orderBy('store_name','asc');
            });
        }
        else if($req->searchOption == 8){
            $query->where('expired_date', 'like', '%' . $req->search . '%')
            ->orderBy('expired_date','asc');
        }

        $heads = $query->paginate(15);
        
        return response()->json([
            'status' => true,
            'data' => $heads,
        ], 200);
    } // End Method



    // Get Inventory Product By Groupe
    public function Get(Request $req){
        // Update Product Quantity
        // DB::connection('mysql_second')
        // ->table('transaction__heads as h')
        // ->join(DB::raw("(SELECT tran_head_id, SUM(IF(tran_method = 'Purchase',quantity_actual,0)) 
        // -SUM(IF(tran_method = 'Issue',quantity_actual,0)) 
        // -SUM(IF(tran_method = 'Supplier Return',quantity_actual,0)) 
        // +SUM(IF(tran_method = 'Client Return',quantity_actual,0)) 
        // +SUM(IF(tran_method = 'Positive',quantity_actual,0)) 
        // -SUM(IF(tran_method = 'Negative',quantity_actual,0)) as balance
        //   FROM transaction__details
        //     GROUP BY tran_head_id
        // ) as x"),'h.id', '=', 'x.tran_head_id')
        // ->update(['h.quantity' => DB::raw('x.balance')]);

        $heads = Transaction_Head::on('mysql_second')->with("Unit","Form","Manufecturer","Category")
        ->where('tran_head_name', 'like', '%'.$req->product.'%')
        ->whereIn('groupe_id', $req->groupe)
        ->orderBy('tran_head_name','asc')
        ->take(10)
        ->get();

        if($heads->count() > 0){
            $list = "";
            foreach($heads as $index => $head) {
                $list .= '<tr tabindex="' . ($index + 1) . '" data-id="'.$head->id.'" data-groupe="'.$head->groupe_id.'" data-unit="'.optional($head->Unit)->unit_name.'" data-unit-id="'.$head->unit_id.'" data-cp="'.$head->cp.'" data-mrp="'.$head->mrp.'" data-qty="'.$head->quantity.'">
                            <td>'.$head->tran_head_name.'</td>
                            <td>'.($head->category_id == null ? '' : optional($head->Category)->category_name).'</td>
                            <td>'.($head->manufacturer_id == null ? '' : optional($head->Manufecturer)->manufacturer_name).'</td>
                            <td>'.($head->form_id == null ? '' : optional($head->Form)->form_name).'</td>
                            <td>'.$head->quantity.'</td>
                            <td>'.$head->cp.'</td>
                            <td>'.$head->mrp.'</td>
                        </tr>';
            }
        }
        else{
            $list = '<tr> 
                        <td> No Data Found </td> 
                    </tr>';
        }
        return $list;
    } // End Method




    // Get Inventory Product List
    public function GetProductList(Request $req){
        $heads = Transaction_Head::on('mysql_second')->with("Unit","Form","Manufecturer","Category")
        ->where('tran_head_name', 'like', '%'.$req->product.'%')
        ->whereIn('groupe_id', $req->groupe)
        ->orderBy('tran_head_name','asc')
        ->take(10)
        ->get();

        if($heads->count() > 0){
            $list = "";
            foreach($heads as $index => $head) {
                $list .= '<li tabindex="' . ($index + 1) . '" data-id="' .$head->id. '">'.$head->tran_head_name.'</li>';
            }
        }
        else{
            $list = '<li> No Data Found </li>';
        }
        return $list;
    } // End Method
}
