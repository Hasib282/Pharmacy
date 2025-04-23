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
    public function ShowAll(Request $req){
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
            "unit_id" => $req->unit,
            'company_id' => $req->company,
        ]);

        $data = Transaction_Head::on('mysql')->with('Groupe', 'Category', 'Manufecturer', 'Form', 'Unit', 'Store')->findOrFail($insert->id);
        
        return response()->json([
            'status'=> true,
            'message' => 'Product Added Successfully',
            "data" => $data,
        ], 200);  
    } // End Method



    // Edit Pharmacy Item/Products
    public function Edit(Request $req){
        $type = GetTranType($req->segment(2));
        $groupes = Transaction_Groupe::on('mysql')->where('tran_groupe_type', $type)->orderBy('added_at','asc')->get();
        $data = Transaction_Head::on('mysql')->with('Groupe', 'Category', 'Manufecturer', 'Form', 'Unit', 'Store')->findOrFail($req->id);
        return response()->json([
            'status'=> true,
            'data'=>$data,
            'groupes' => $groupes,
        ], 200);
    } // End Method



    // Update Pharmacy Item/Products
    public function Update(Request $req){
        $data = Transaction_Head::findOrFail($req->id);
        
        $req->validate([
            "productName" => ['required',Rule::unique('mysql.transaction__heads', 'tran_head_name')->ignore($data->id)],
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
            "unit_id" => $req->unit,
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



    // Search Pharmacy Item/Products
    public function Search(Request $req){
        $type = GetTranType($req->segment(2));
        $query = filterByCompany(Transaction_Head::on('mysql')
                    ->with('Groupe', 'Category', 'Manufecturer', 'Form', 'Unit', 'Store')
                    ->whereHas('Groupe', function ($q) use($type){
                        $q->where('tran_groupe_type', $type);
                    }) // Base query
                );

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
            $query->where('expiry_date', 'like', '%' . $req->search . '%')
            ->orderBy('expiry_date','asc');
        }

        $data = $query->paginate(15);


        
        return response()->json([
            'status' => true,
            'data' => $data,
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
