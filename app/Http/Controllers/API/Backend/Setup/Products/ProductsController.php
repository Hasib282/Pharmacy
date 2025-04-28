<?php

namespace App\Http\Controllers\API\Backend\Setup\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use App\Models\Transaction_Head;
use App\Models\Transaction_Groupe;

class ProductsController extends Controller
{
    // Show All Pharmacy Item/Products
    public function Show(Request $req){
        // Update Product Quantity
        // DB::connection('mysql')
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

        $type = GetTranType($req->segment(2));

        $data = filterByCompany(
                    Transaction_Head::on('mysql')
                    ->with('Groupe', 'Category', 'Manufecturer', 'Form', 'Unit', 'Store')
                    ->whereHas('Groupe', function ($query) use($type){
                        $query->where('tran_groupe_type', $type);
                    })
                )
                ->orderBy('added_at','asc')
                ->get();
        
        return response()->json([
            'status'=> true,
            'data' => $data,
        ], 200);
    } // End Method



    // Insert Pharmacy Item/Products
    public function Insert(Request $req){
        $req->validate([
            "productName" => 'required|unique:mysql.transaction__heads,tran_head_name',
            "groupe" => 'required|exists:mysql.transaction__groupes,id',
            "category" => 'nullable|exists:mysql.item__categories,id',
            "manufacturer" => 'nullable|exists:mysql.item__manufacturers,id',
            "form" => 'nullable|exists:mysql.item__forms,id',
            "unit" => 'nullable|exists:mysql.item__units,id',
        ]);

        $insert = Transaction_Head::on('mysql')->create([
            "tran_head_name" => $req->productName,
            "groupe_id" => $req->groupe,
            "category_id" => $req->category,
            "manufacturer_id" => $req->manufacturer,
            "form_id" => $req->form,
            "unit_id" => $req->unit?:1,
            'company_id' => $req->company,
        ]);

        $data = Transaction_Head::on('mysql')->with('Groupe', 'Category', 'Manufecturer', 'Form', 'Unit', 'Store')->findOrFail($insert->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Product Added Successfully',
            "data" => $data,
        ], 200);  
    } // End Method



    // Update Pharmacy Item/Products
    public function Update(Request $req){
        $data = Transaction_Head::findOrFail($req->id);
        
        $req->validate([
            "productName" => ['required',Rule::unique('mysql.transaction__heads', 'tran_head_name')->ignore($req->id)],
            "groupe" => 'required|exists:mysql.transaction__groupes,id',
            "category" => 'nullable|exists:mysql.item__categories,id',
            "manufacturer" => 'nullable|exists:mysql.item__manufacturers,id',
            "form" => 'nullable|exists:mysql.item__forms,id',
            "unit" => 'nullable|exists:mysql.item__units,id',
            "quantity" => 'required|numeric',
            "cp" => 'required|numeric',
            "mrp" => 'required|numeric',
        ]);

        $update = $data->update([
            "tran_head_name" => $req->productName,
            "groupe_id" => $req->groupe,
            "category_id" => $req->category,
            "manufacturer_id" => $req->manufacturer,
            "form_id" => $req->form,
            "unit_id" => $req->unit ?: 1,
            "quantity" => $req->quantity,
            "cp" => $req->cp,
            "mrp" => $req->mrp,
            "expiry_date" => $req->expiryDate,
            "updated_at" => now()
        ]);

        $updatedData = Transaction_Head::on('mysql')->with('Groupe', 'Category', 'Manufecturer', 'Form', 'Unit', 'Store')->findOrFail($req->id);

        if($update){
            return response()->json([
                'status'=>true,
                'message' => 'Product Updated Successfully',
                "updatedData" => $updatedData,
            ], 200); 
        }
    } // End Method



    // Delete Pharmacy Item/Products
    public function Delete(Request $req){
        Transaction_Head::on('mysql')->findOrFail($req->id)->delete();
        return response()->json([
            'status'=> true,
            'message' => 'Product Deleted Successfully',
        ], 200); 
    } // End Method



    // Get Pharmacy Product By Groupe
    public function Get(Request $req){
        // Update Product Quantity
        // DB::connection('mysql')
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

        $data = filterByCompany(
                    Transaction_Head::on('mysql')
                    ->with("Unit","Form","Manufecturer","Category")
                    ->where('tran_head_name', 'like', $req->product.'%')
                    ->whereIn('groupe_id', $req->groupe)
                )
                ->orderBy('tran_head_name','asc')
                ->take(10)
                ->get();

        if($data->count() > 0){
            $list = "";
            foreach($data as $index => $item) {
                $list .= '<tr tabindex="' . ($index + 1) . '" data-id="'.$item->id.'" data-groupe="'.$item->groupe_id.'" data-unit="'.optional($item->Unit)->unit_name.'" data-unit-id="'.$item->unit_id.'" data-cp="'.$item->cp.'" data-mrp="'.$item->mrp.'">
                            <td>'.$item->tran_head_name.'</td>
                            <td>'.($item->category_id == null ? '' : optional($item->Category)->category_name).'</td>
                            <td>'.($item->manufacturer_id == null ? '' : optional($item->Menufacturer)->manufacturer_name).'</td>
                            <td>'.($item->form_id == null ? '' : optional($item->Form)->form_name).'</td>
                            <td>'.$item->quantity.'</td>
                            <td>'.$item->mrp.'</td>
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




    // Get Pharmacy Product List
    public function GetProductList(Request $req){
        $heads = filterByCompany(
                    Transaction_Head::on('mysql')
                    ->with("Unit","Form","Manufecturer","Category")
                    ->where('tran_head_name', 'like', $req->product.'%')
                    ->whereIn('groupe_id', $req->groupe)
                )
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
