<?php

use Illuminate\Support\Facades\Route;
// Middlewares
use Illuminate\Support\Facades\Artisan;
use App\Http\Middleware\ValidUser;
use App\Http\Middleware\CheckPermission;
// use App\Http\Middleware\SuperAdminAccess;
use App\Http\Controllers\ProfileController;



// Admin Setup Related Controllers
use App\Http\Controllers\Frontend\Admin_Setup\AdminSetupController;
use App\Http\Controllers\Frontend\Admin_Setup\UsersController;
use App\Http\Controllers\Frontend\Admin_Setup\PermissionController;


// Auth Controllers
use App\Http\Controllers\Frontend\Auth\AuthController;
use App\Http\Controllers\Frontend\Auth\ForgetPasswordController;



// Transaction Controllers
use App\Http\Controllers\Frontend\Transaction\GeneralTransactionController;
use App\Http\Controllers\Frontend\Transaction\BankTransactionController;
use App\Http\Controllers\Frontend\Transaction\PartyTransactionController;


// HR Controllers
use App\Http\Controllers\Frontend\HR\HRSetupController;
use App\Http\Controllers\Frontend\HR\EmployeeInfoController;
use App\Http\Controllers\Frontend\HR\PayRollController;
use App\Http\Controllers\Frontend\HR\HrReportController;



// Inventory Controllers
use App\Http\Controllers\Frontend\Inventory\InventorySetupController;
use App\Http\Controllers\Frontend\Inventory\InventoryTransactionsController;
use App\Http\Controllers\Frontend\Inventory\InventoryReturnController;
use App\Http\Controllers\Frontend\Inventory\InventoryAdjustmentController;
use App\Http\Controllers\Frontend\Inventory\InventoryReportController;


//Pharmacy Controllers
use App\Http\Controllers\Frontend\Pharmacy\PharmacySetupController;
use App\Http\Controllers\Frontend\Pharmacy\PharmacyTransactionsController;
use App\Http\Controllers\Frontend\Pharmacy\PharmacyReturnController;
use App\Http\Controllers\Frontend\Pharmacy\PharmacyAdjustmentController;
use App\Http\Controllers\Frontend\Pharmacy\PharmacyReportController;


//Hospital Controllers
use App\Http\Controllers\Frontend\Hospital\HospitalSetupConrtoller;
use App\Http\Controllers\Frontend\Hospital\HospitalReportConrtoller;
use App\Http\Controllers\Frontend\Hospital\HospitalTransactionController;


//Hotel Controllers
use App\Http\Controllers\Frontend\Hotel\HotelSetupController;
use App\Http\Controllers\Frontend\Hotel\HotelTransactionController;
use App\Http\Controllers\Frontend\Hotel\HotelReportController;


// Report Controllers
use App\Http\Controllers\Frontend\Report\AccountStatementController;
use App\Http\Controllers\Frontend\Report\PartyStatementController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*---------------------------------- Admin Login -----------------------------------------------*/

Route::get('/datatable', function () {
    return view('datatable.datatable');
});
Route::get('/link', function(){
    Artisan::call('storage:link');
});


// Don't Give Access to this routes if user is not valid
Route::middleware([ValidUser::class, CheckPermission::class])->group(function () {
    // *************************************** Login Controller Routes Start *************************************** //
    Route::controller(AuthController::class)->group(function () {
        Route::get('/login', 'Login')->name('login')->withoutMiddleware(CheckPermission::class);
        Route::get('/dashboard', 'Dashboard')->name('dashboard')->withoutMiddleware(CheckPermission::class);
    });


    // *************************************** Forget Password Controller Routes Start *************************************** //
    Route::controller(ForgetPasswordController::class)->group(function () {
        Route::get('/forgotpassword', 'ForgotPassord')->name('forgotPassword')->withoutMiddleware(CheckPermission::class);;
        Route::get('/resetpassword', 'ResetPassword')->name('resetPassword')->withoutMiddleware(CheckPermission::class);;
    });


    // *************************************** Profile Controller Routes Start *************************************** //
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile/{id}', 'ShowProfile')->name('show.profile');
        Route::post('/edit/profile', 'EditProfile')->name('edit.profile');
        Route::get('/update/profile', 'UpdateProfile')->name('update.profile');
    });


    


    /////-----/////-----/////-----/////-----/////-----///// Admin Setup Routes Start /////-----/////-----/////-----/////-----/////-----/////

    Route::prefix('/admin')->group(function () {
        // *************************************** User Routes Start *************************************** //
        Route::prefix('/users')->group(function () {
            Route::controller(UsersController::class)->group(function () {
                ///////////// --------------- Role routes ----------- ///////////////////
                Route::get('/roles', 'ShowRoles')->name('show.roles');
                

                ///////////// --------------- Admin Routes ----------- ///////////////////
                Route::get('/admins', 'ShowAdmins')->name('show.admins');



                ///////////// --------------- Super Admin Routes ----------- ///////////////////
                Route::get('/superadmins', 'ShowSuperAdmins')->name('show.superAdmins');
            }); // End Users Controller
        }); // End User Route



        // *************************************** Permission Routes Start *************************************** //
        Route::prefix('/permission')->group(function () {
            Route::controller(PermissionController::class)->group(function () {
                ///////////// --------------- Permission Main Heads routes ----------- ///////////////////
                Route::get('/mainhead', 'ShowPermissionMainheads')->name('show.permissionMainheads');
                
                
                
                ///////////// --------------- Permission Heads routes ----------- ///////////////////
                Route::get('/heads', 'ShowPermissions')->name('show.permissions');



                ///////////// --------------- Company Type Permission routes ----------- ///////////////////
                Route::get('/company_type_permissions', 'ShowCompanyTypePermissions')->name('show.companyTypePermissions');
                
                
                
                ///////////// --------------- Company Permission routes ----------- ///////////////////
                Route::get('/company_permissions', 'ShowCompanyPermissions')->name('show.companyPermissions');
                
                
                
                ///////////// --------------- User Permission routes ----------- ///////////////////
                Route::get('/userpermissions', 'ShowUserPermissions')->name('show.userPermissions');
            }); // End Permission Controller
        }); // End Permission Routes



        


        Route::controller(AdminSetupController::class)->group(function () {
            // *************************************** Main Heads Routes Start *************************************** //
            Route::get('/companytype', 'ShowCompanyType')->name('show.companytype');



            // *************************************** Company Routes Start *************************************** //
            Route::get('/companies', 'ShowCompanies')->name('show.companies');



            // *************************************** Bank Routes Start *************************************** //
            Route::get('/banks', 'ShowBanks')->name('show.banks');
            


            // *************************************** Location Routes Start *************************************** //
            Route::get('/locations', 'ShowLocations')->name('show.locations');
            


            // *************************************** Store Routes Start *************************************** //
            Route::get('/stores', 'ShowStores')->name('show.stores');


            
            // *************************************** Paymentmethod Routes Start *************************************** //
            Route::get('/payment_method', 'ShowPaymentMethod')->name('show.paymentMethod');



            // *************************************** Main Heads Routes Start *************************************** //
            Route::get('/mainheads', 'ShowTransactionMainHead')->name('show.mainhead');



            // *************************************** Corporate Routes Start *************************************** //
            Route::get('/corporate', 'ShowCorporate')->name('show.corporate');
            


            // *************************************** TranWith(User Type) Routes Start *************************************** //
            Route::get('/tranwith', 'ShowTranWith')->name('show.usertype');


            /// *************************************** TranGroupe Routes Start *************************************** //
            Route::get('/trangroupes', 'ShowTransactionGroupes')->name('show.groupes');



            // *************************************** TranHead Routes Start *************************************** //
            Route::get('/tranheads', 'ShowTransactionHeads')->name('show.heads');
        }); // End Admin Setup Controller
    }); // End Admin Routes

    /////-----/////-----/////-----/////-----/////-----///// Admin Setup Routes /////-----/////-----/////-----/////-----/////-----/////





    /////-----/////-----/////-----/////-----/////-----///// Transaction Routes Start /////-----/////-----/////-----/////-----/////-----/////

    Route::prefix('/transaction')->group(function () {
        Route::prefix('/setup')->group(function () {
            Route::controller(AdminSetupController::class)->group(function () {
                // *************************************** TranGroupe Routes Start *************************************** //
                Route::get('/groupes', 'ShowTransactionGroupes')->name('show.tranGroupes');



                // *************************************** TranHead Routes Start *************************************** //
                Route::get('/heads', 'ShowTransactionHeads')->name('show.tranHeads');
            }); // End Admin Setup Controller
        });



        Route::prefix('/users')->group(function () {
            Route::controller(AdminSetupController::class)->group(function () {
                // *************************************** Transaction User Type Routes Start *************************************** //
                Route::get('/usertype', 'ShowTranWith')->name('show.tranUserType');
            });


            Route::controller(UsersController::class)->group(function () {
                ///////////// --------------- Client Routes ----------- ///////////////////
                Route::get('/clients', 'ShowClients')->name('show.clients');



                ///////////// --------------- Supplire Routes ----------- ///////////////////
                Route::get('/suppliers', 'ShowSuppliers')->name('show.suppliers');
            });
        });



        // *************************************** General Transaction Routes Start *************************************** //
        Route::controller(GeneralTransactionController::class)->group(function () {
            Route::get('/receive', 'ShowTransactionReceive')->name('show.transactionReceive');
            Route::get('/receive/search', 'SearchTransaction')->name('search.transactionReceive');

            Route::get('/payment', 'ShowTransactionPayment')->name('show.transactionPayment');
            Route::get('/payment/search', 'SearchTransaction')->name('search.transactionPayment');
        }); // End GeneralTransactionController  



        // *************************************** Party Transaction Routes Start *************************************** //
        Route::controller(PartyTransactionController::class)->group(function () {
            Route::prefix('/party')->group(function () {
                Route::get('/receive', 'ShowPartyReceive')->name('show.partyReceive');
                Route::get('/receive/search', 'SearchParty')->name('search.partyReceive');

                Route::get('/payment', 'ShowPartyPayment')->name('show.partyPayment');
                Route::get('/payment/search', 'SearchParty')->name('search.partyPayment');
            }); // End Party Transaction Routres
        }); // End PartyTransactionController



        // *************************************** Bank Transaction Routes Start *************************************** //
        Route::controller(BankTransactionController::class)->group(function () {
            Route::prefix('/bank')->group(function () {
                Route::get('/withdraw', 'ShowBankWithdraws')->name('show.withdraws');
                Route::get('/withdraw/search', 'SearchBankTransactions')->name('search.withdraws');

                Route::get('/deposit', 'ShowBankDeposits')->name('show.deposits');
                Route::get('/deposit/search', 'SearchBankTransactions')->name('search.deposits');
            }); // End Bank Transaction Route
        }); // End BankTransactionController
    }); // End Transaction Routes

    /////-----/////-----/////-----/////-----/////-----///// Transaction Controllers End /////-----/////-----/////-----/////-----/////-----/////





    /////-----/////-----/////-----/////-----/////-----///// HR Controllers Start /////-----/////-----/////-----/////-----/////-----/////

    Route::prefix('/hr')->group(function () {
        Route::prefix('/setup')->group(function () {
            // *************************************** HR Setup Routes Start *************************************** //
            Route::controller(HRSetupController::class)->group(function () {
                // *************************************** Department Routes Start *************************************** //
                Route::get('/departments', 'ShowDepartments')->name('show.departments');



                // *************************************** Designations Routes Start *************************************** //
                Route::get('/designations', 'ShowDesignations')->name('show.designations');
            });
        }); // End HR Setup Routes
        





        // *************************************** Hr Employee Routes Start *************************************** //
        Route::prefix('/employee')->group(function () {
            Route::controller(AdminSetupController::class)->group(function () {
                // *************************************** Employee Type Routes Start *************************************** //
                Route::get('/usertype', 'ShowTranWith')->name('show.hrUserType');
            });



            Route::controller(EmployeeInfoController::class)->group(function () {
                ///////////// --------------- Employee Routes ----------- ///////////////////
                Route::get('/all', 'ShowEmployees')->name('show.employees');



                ///////////// --------------- Employee Personal Details Routes ----------- ///////////////////
                Route::get('/personal',  'PersonalDetails')->name('show.employeePersonal');



                ///////////// --------------- Employee Education Details Routes ----------- ///////////////////
                Route::get('/education',  'EducationDetails')->name('show.employeeEducation');
                
                

                ///////////// --------------- Employee Training Details Routes ----------- ///////////////////
                Route::get('/training',  'TrainingDetails')->name('show.employeeTraining');



                ///////////// --------------- Employee Experience Details Routes ----------- ///////////////////
                Route::get('/experience',  'ExperienceDetails')->name('show.employeeExperience');
                


                ///////////// --------------- Employee Organization Routes ----------- ///////////////////
                Route::get('/organization',  'OrganizationDetails')->name('show.employeeOrganization');
                


                ///////////// --------------- Attendence Routes ----------- ///////////////////
                Route::get('/attendence','ShowEmployeeAttendence')->name('show.employeeAttendence');
            });
        }); // End Hr Employee Routes





        // *************************************** HR Payroll Routes Start *************************************** //
        Route::prefix('/payroll')->group(function () {
            Route::controller(AdminSetupController::class)->group(function () {
                // *************************************** TranHead Routes Start *************************************** //
                Route::get('/heads', 'ShowTransactionHeads')->name('show.hrHeads');
            }); // End Admin Setup Controller



            Route::controller(PayRollController::class)->group(function(){
                ///////////// --------------- Payroll Setup Routes ----------- ///////////////////
                Route::get('/setup','ShowPayrollSetup')->name('show.payrollSetup');



                ///////////// --------------- Payroll Middlewire Routes ----------- ///////////////////
                Route::get('/middlewire','ShowPayrollMiddlewire')->name('show.payrollMiddlewire');
                
                
                
                ///////////// --------------- Payroll Installment(Salary Payment) Routes ----------- ///////////////////
                Route::get('/process','ShowPayroll')->name('show.payroll');
                Route::get('/process/search', 'SearchPayroll')->name('search.payroll');

            });
        }); // End Hr Payroll Routes




        // *************************************** Hr Report Routes Start *************************************** //
        Route::prefix('/report')->group(function () {
            Route::controller(HrReportController::class)->group(function () {            
                ///////////// --------------- Salary Summary Routes ----------- ///////////////////
                Route::get('/salary/summary','SalarySummaryReport')->name('show.salarySummaryReport'); 
                Route::get('/salary/summary/search', 'SearchSalarySummaryReport')->name('search.salarySummaryReport');


                
                ///////////// --------------- Salary Detail Routes ----------- ///////////////////
                Route::get('/salary/details','SalaryDetailsReport')->name('show.salaryDetailsReport'); 
                Route::get('/salary/details/search', 'SearchSalaryDetailsReport')->name('search.salaryDetailsReport');
            });
        }); // End Hr Report Routes
    }); // End HR Routes 

    /////-----/////-----/////-----/////-----/////-----///// HR Controllers End /////-----/////-----/////-----/////-----/////-----/////
    
    
    
    

    /////-----/////-----/////-----/////-----/////-----///// Inventory Routes Start /////-----/////-----/////-----/////-----/////-----/////

    Route::prefix('/inventory')->group(function () {
        // *************************************** Inventory Setup Routes Start *************************************** //
        Route::prefix('/setup')->group(function () {
            Route::controller(InventorySetupController::class)->group(function(){
                ///////////////////// ------------------ Item/Product Manufacturer Routes Start ------------------ /////////////////////
                // Crude Routes Start
                Route::get('/manufacturer',  'ShowManufacturer')->name('show.invManufacturer');



                ///////////////////// ------------------ Item/Product Category Routes Start ------------------ /////////////////////
                // Crude Routes Start
                Route::get('/category', 'ShowItemCategory')->name('show.invCategory');



                //////////////// ------------------ Item/Product Form Routes Start ------------------- //////////////////
                // Crude Routes Start
                Route::get('/form', 'ShowForm')->name('show.invForm');



                //////////////// ------------------ Item/Product Unit Routes Start ------------------- //////////////////
                // Crude Routes Start
                Route::get('/unit', 'ShowUnit')->name('show.invUnit');



                //////////////// ------------------ Inventory Product Routes Start ------------------- //////////////////
                // Crud Routes Start
                Route::get('/product', 'ShowInventoryProduct')->name('show.invProduct');
            });


            Route::controller(AdminSetupController::class)->group(function () {
                /// *************************************** Item Groupe Routes Start *************************************** //
                Route::get('/groupes', 'ShowTransactionGroupes')->name('show.invGroupes');
            }); // End Admin Setup Controller
        }); // End Inventory Setup Routes



        Route::prefix('/users')->group(function () {
            Route::controller(AdminSetupController::class)->group(function () {
                // *************************************** Inventory User Type Routes Start *************************************** //
                Route::get('/usertype', 'ShowTranWith')->name('show.invUserType');
            });


            Route::controller(UsersController::class)->group(function () {
                ///////////// --------------- Client Routes ----------- ///////////////////
                Route::get('/clients', 'ShowClients')->name('show.invClients');



                ///////////// --------------- Supplire Routes ----------- ///////////////////
                Route::get('/suppliers', 'ShowSuppliers')->name('show.invSuppliers');
            });
        });



        // *************************************** Inventory Transaction Routes Start *************************************** //
        Route::prefix('/transaction')->group(function () {
            Route::controller(InventoryTransactionsController::class)->group(function(){
                ///////////// --------------- Inventory Purchase Routes ----------- ///////////////////
                // Crude Routes Start
                Route::get('/purchase', 'ShowInventoryPurchase')->name('show.invPurchase');
                Route::get('/purchase/search', 'SearchInventoryPurchase')->name('search.invPurchase');
                
                
                
                ///////////// --------------- Inventory Issue Routes ----------- ///////////////////
                // Inventory Issue Crude Routes
                Route::get('/issue', 'ShowInventoryIssue')->name('show.invIssue');
                Route::get('/issue/search', 'SearchInventoryIssue')->name('search.invIssue');
            }); // End InventoryTransactionController 



            ///////////// --------------- Inventory Return Routes ----------- ///////////////////
            Route::prefix('/return')->group(function () {
                Route::controller(InventoryReturnController::class)->group(function () {
                    // *************** Inventory Client Return Routes *************** //
                    Route::get('/client', 'ShowClientReturn')->name('show.invClientReturn');
                    Route::get('/client/search', 'SearchClientReturn')->name('search.invClientReturn');



                    // *************** Inventory Supplier Return Routes *************** //
                    Route::get('/supplier', 'ShowSupplierReturn')->name('show.invSupplierReturn');
                    Route::get('/supplier/search', 'SearchSupplierReturn')->name('search.invSupplierReturn');
                }); // End Inventory Return Controller 
            }); // End Inventory Return Routes
        }); // End Inventory Transaction Routes 



        // *************************************** Inventory Adjustment Routes Start *************************************** //
        Route::prefix('/adjustment')->group(function () {
            Route::controller(InventoryAdjustmentController::class)->group(function () {
                ///////////// --------------- Inventory Positive Adjustment Routes ----------- ///////////////////
                Route::get('/positive', 'ShowPositiveAdjustment')->name('show.invPosAdjustment');
                Route::get('/positive/search', 'SearchPositiveAdjustment')->name('search.invPosAdjustment');



                ///////////// --------------- Inventory Negative Adjustment Routes ----------- ///////////////////
                Route::get('/negative', 'ShowNegativeAdjustment')->name('show.invNegAdjustment');
                Route::get('/negative/search', 'SearchNegativeAdjustment')->name('search.invNegAdjustment');
            }); // End Inventory Adjustment Controller 
        }); // End Inventory Adjustment Routes


        // *************************************** Inventory Party Transaction Routes Start *************************************** //
        Route::controller(PartyTransactionController::class)->group(function () {
            Route::prefix('/party')->group(function () {
                Route::get('/receive', 'ShowPartyReceive')->name('show.invPartyReceive');
                Route::get('/receive/search', 'SearchParty')->name('search.invPartyReceive');

                Route::get('/payment', 'ShowPartyPayment')->name('show.invPartyPayment');
                Route::get('/payment/search', 'SearchParty')->name('search.invPartyPayment');
            }); // End Party Transaction Routres
        }); // End PartyTransactionController



        // *************************************** Inventory Report Routes Start *************************************** //
        Route::prefix('/report')->group(function () {
            Route::controller(InventoryReportController::class)->group(function () {
                ///////////// --------------- Inventory Item Flow Statement Routes ----------- ///////////////////
                Route::get('/item/flow','ShowItemFlowStatement')->name('show.invItemFlow'); 
                Route::get('/item/flow/search', 'SearchItemFlowStatement')->name('search.invItemFlow');
                
                

                ///////////// --------------- Inventory Purchase Statement Routes ----------- ///////////////////
                Route::prefix('/purchase')->group(function () {
                    // *************** Inventory Purchase Summary Statement Routes *************** //
                    Route::get('/summary','ShowPurchaseSummaryStatement')->name('show.invPurchaseSummary'); 
                    Route::get('/summary/search', 'SearchPurchaseSummaryStatement')->name('search.invPurchaseSummary');
                    


                    // *************** Inventory Purchase Detail Statement Routes *************** //
                    Route::get('/details','ShowPurchaseDetailsStatement')->name('show.invPurchaseDetails'); 
                    Route::get('/details/search', 'SearchPurchaseDetailsStatement')->name('search.invPurchaseDetails');
                });



                ///////////// --------------- Inventory Issue Statement Routes ----------- ///////////////////
                Route::prefix('/issue')->group(function () {
                    // *************** Inventory Issue Summary Statement Routes *************** //
                    Route::get('/summary','ShowIssueSummaryStatement')->name('show.invIssueSummary'); 
                    Route::get('/summary/search', 'SearchIssueSummaryStatement')->name('search.invIssueSummary');


                    // *************** Inventory Issue Detail Statement Routes *************** //
                    Route::get('/details','ShowIssueDetailsStatement')->name('show.invIssueDetails'); 
                    Route::get('/details/search', 'SearchIssueDetailsStatement')->name('search.invIssueDetails');
                });



                ///////////// --------------- Inventory Return Statement Routes ----------- ///////////////////
                Route::prefix('/return')->group(function () {
                    // *************** Inventory Supplier Return Summary Statement Routes *************** //
                    Route::get('/supplier/summary','ShowSupplierReturnSummaryStatement')->name('show.invSupplierReturnSummary'); 
                    Route::get('/supplier/summary/search', 'SearchSupplierReturnSummaryStatement')->name('search.invSupplierReturnSummary');



                    // *************** Inventory Supplier Return Detail Statement Routes *************** //
                    Route::get('/supplier/details','ShowSupplierReturnDetailsStatement')->name('show.invSupplierReturnDetails'); 
                    Route::get('/supplier/details/search', 'SearchSupplierReturnDetailsStatement')->name('search.invSupplierReturnDetails');



                    // *************** Inventory Client Return Summary Statement Routes *************** //
                    Route::get('/client/summary','ShowClientReturnSummaryStatement')->name('show.invClientReturnSummary'); 
                    Route::get('/client/summary/search', 'SearchClientReturnSummaryStatement')->name('search.invClientReturnSummary');



                    // *************** Inventory Client Return Detail Statement Routes *************** //
                    Route::get('/client/details','ShowClientReturnDetailsStatement')->name('show.invClientReturnDetails'); 
                    Route::get('/client/details/search', 'SearchClientReturnDetailsStatement')->name('search.invClientReturnDetails');
                });


                
                ///////////// --------------- Inventory Stock Statement Routes ----------- ///////////////////
                Route::prefix('/stock')->group(function () {
                    // *************** Inventory Stock Summary Statement Routes *************** //
                    Route::get('/summary','ShowStockSummaryStatement')->name('show.invStockSummary'); 
                    Route::get('/summary/search', 'SearchStockSummaryStatement')->name('search.invStockSummary');
                    


                    // *************** Inventory Stock Detail Statement Routes *************** //
                    Route::get('/details','ShowStockDetailsStatement')->name('show.invStockDetails');
                    Route::get('/details/search', 'SearchStockDetailsStatement')->name('search.invStockDetails');
                });



                ///////////// --------------- Inventory Profitability Statement Routes ----------- ///////////////////
                Route::get('/profitability/statement','ShowProfitabilityStatement')->name('show.invProfit');
                Route::get('/profitability/statement/search', 'SearchProfitabilityStatement')->name('search.invProfit');
                


                ///////////// --------------- Inventory Expiry Statement Routes ----------- ///////////////////
                Route::get('/expiry/statement','ShowExpiryStatement')->name('show.invExpiry');
                Route::get('/expiry/statement/search', 'SearchExpiryStatement')->name('search.invExpiry');
            }); // End InventoryReportController
        }); // End Inventory Report Routes
    }); // End Inventory Routes 

    /////-----/////-----/////-----/////-----/////-----///// Inventory Routes End /////-----/////-----/////-----/////-----/////-----/////
    
    
    
    

    /////-----/////-----/////-----/////-----/////-----///// Pharmacy Routes Start /////-----/////-----/////-----/////-----/////-----/////

    Route::prefix('/pharmacy')->group(function () {
        // *************************************** Pharmacy Setup Routes Start *************************************** //
        Route::prefix('/setup')->group(function () {
            Route::controller(PharmacySetupController::class)->group(function(){
                ///////////// --------------- Pharmacy Manufacturer Routes ----------- ///////////////////
                Route::get('/manufacturer',  'ShowManufacturer')->name('show.pharmacyManufacturer');



                ///////////// --------------- Pharmacy Category Routes ----------- ///////////////////
                Route::get('/category', 'ShowItemCategory')->name('show.pharmacyCategory');



                ///////////// --------------- Pharmacy Form Routes ----------- ///////////////////
                Route::get('/form', 'ShowForm')->name('show.pharmacyForm');



                ///////////// --------------- Pharmacy Unit Routes ----------- ///////////////////
                Route::get('/unit', 'ShowUnit')->name('show.pharmacyUnit');



                ///////////// --------------- Pharmacy Products Routes ----------- ///////////////////
                Route::get('/product', 'ShowPharmacyProduct')->name('show.pharmacyProduct');
            }); // End Pharmacy Setup Controller


            Route::controller(AdminSetupController::class)->group(function () {
                /// *************************************** Item Groupe Routes Start *************************************** //
                Route::get('/groupes', 'ShowTransactionGroupes')->name('show.pharmacyGroupes');
            }); // End Admin Setup Controller
        }); // End Pharmacy Setup Routes



        Route::prefix('/users')->group(function () {
            Route::controller(AdminSetupController::class)->group(function () {
                // *************************************** Inventory User Type Routes Start *************************************** //
                Route::get('/usertype', 'ShowTranWith')->name('show.pharmacyUserType');
            });


            Route::controller(UsersController::class)->group(function () {
                ///////////// --------------- Client Routes ----------- ///////////////////
                Route::get('/clients', 'ShowClients')->name('show.pharmacyClients');



                ///////////// --------------- Supplire Routes ----------- ///////////////////
                Route::get('/suppliers', 'ShowSuppliers')->name('show.pharmacySuppliers');
            });
        });



        // *************************************** Pharmacy Transaction Routes Start *************************************** //
        Route::prefix('/transaction')->group(function () {
            Route::controller(PharmacyTransactionsController::class)->group(function(){
                ///////////// --------------- Pharmacy Purchase Routes ----------- ///////////////////
                Route::get('/purchase', 'ShowPharmacyPurchase')->name('show.pharmacyPurchase');
                Route::get('/purchase/search', 'SearchPharmacyPurchase')->name('search.pharmacyPurchase');
                
                

                ///////////// --------------- Pharmacy Issue Routes ----------- ///////////////////
                Route::get('/issue', 'ShowPharmacyIssue')->name('show.pharmacyIssue');
                Route::get('/issue/search', 'SearchPharmacyIssue')->name('search.pharmacyIssue');
            }); // End PharmacyTransactionController 



            ///////////// --------------- Pharmacy Return Routes ----------- ///////////////////
            Route::prefix('/return')->group(function () {
                Route::controller(PharmacyReturnController::class)->group(function () {
                    // *************** Pharmacy Client Return Routes *************** //
                    Route::get('/client', 'ShowClientReturn')->name('show.pharmacyClientReturn');
                    Route::get('/client/search', 'SearchClientReturn')->name('search.pharmacyClientReturn');



                    // *************** Pharmacy Supplier Return Routes *************** //
                    Route::get('/supplier', 'ShowSupplierReturn')->name('show.pharmacySupplierReturn');
                    Route::get('/supplier/search', 'SearchSupplierReturn')->name('search.pharmacySupplierReturn');
                }); // End Pharmacy Return Controller 
            }); // End Pharmacy Return Routes
        }); // End Pharmacy Transaction Routes 



        // *************************************** Pharmacy Adjustment Routes Start *************************************** //
        Route::prefix('/adjustment')->group(function () {
            Route::controller(PharmacyAdjustmentController::class)->group(function () {
                ///////////// --------------- Pharmacy Positive Adjustment Routes ----------- ///////////////////
                Route::get('/positive', 'ShowPositiveAdjustment')->name('show.pharmacyPosAdjustment');
                Route::get('/positive/search', 'SearchPositiveAdjustment')->name('search.pharmacyPosAdjustment');



                ///////////// --------------- Pharmacy Negative Adjustment Routes ----------- ///////////////////
                Route::get('/negative', 'ShowNegativeAdjustment')->name('show.pharmacyNegAdjustment');
                Route::get('/negative/search', 'SearchNegativeAdjustment')->name('search.pharmacyNegAdjustment');
            }); // End Pharmacy Adjustment Controller 
        }); // End Pharmacy Adjustment Routes



        // *************************************** Party Transaction Routes Start *************************************** //
        Route::controller(PartyTransactionController::class)->group(function () {
            Route::prefix('/party')->group(function () {
                Route::get('/receive', 'ShowPartyReceive')->name('show.pharmacyPartyReceive');
                Route::get('/receive/search', 'SearchParty')->name('search.pharmacyPartyReceive');

                Route::get('/payment', 'ShowPartyPayment')->name('show.pharmacyPartyPayment');
                Route::get('/payment/search', 'SearchParty')->name('search.pharmacyPartyPayment');
            }); // End Party Transaction Routres
        }); // End PartyTransactionController



        // *************************************** Pharmacy Report Routes Start *************************************** //
        Route::prefix('/report')->group(function () {
            Route::controller(PharmacyReportController::class)->group(function () {
                ///////////// --------------- Pharmacy Item Flow Statement Routes ----------- ///////////////////
                Route::get('/item/flow','ShowItemFlowStatement')->name('show.pharmacyItemFlow'); 
                Route::get('/item/flow/search', 'SearchItemFlowStatement')->name('search.pharmacyItemFlow');
                
                

                ///////////// --------------- Pharmacy Purchase Statement Routes ----------- ///////////////////
                Route::prefix('/purchase')->group(function () {
                    // *************** Pharmacy Purchase Summary Statement Routes *************** //
                    Route::get('/summary','ShowPurchaseSummaryStatement')->name('show.pharmacyPurchaseSummary'); 
                    Route::get('/summary/search', 'SearchPurchaseSummaryStatement')->name('search.pharmacyPurchaseSummary');


                    // *************** Pharmacy Purchase Detail Statement Routes *************** //
                    Route::get('/details','ShowPurchaseDetailsStatement')->name('show.pharmacyPurchaseDetails'); 
                    Route::get('/details/search', 'SearchPurchaseDetailsStatement')->name('search.pharmacyPurchaseDetails');
                });



                ///////////// --------------- Pharmacy Issue Statement Routes ----------- ///////////////////
                Route::prefix('/issue')->group(function () {
                    // *************** Pharmacy Issue Summary Statement Routes *************** //
                    Route::get('/summary','ShowIssueSummaryStatement')->name('show.pharmacyIssueSummary'); 
                    Route::get('/summary/search', 'SearchIssueSummaryStatement')->name('search.pharmacyIssueSummary');


                    // *************** Pharmacy Issue Detail Statement Routes *************** //
                    Route::get('/details','ShowIssueDetailsStatement')->name('show.pharmacyIssueDetails'); 
                    Route::get('/details/search', 'SearchIssueDetailsStatement')->name('search.pharmacyIssueDetails');
                });



                ///////////// --------------- Pharmacy Return Statement Routes ----------- ///////////////////
                Route::prefix('/return')->group(function () {
                    // *************** Pharmacy Supplier Return Summary Statement Routes *************** //
                    Route::get('/supplier/summary','ShowSupplierReturnSummaryStatement')->name('show.pharmacySupplierReturnSummary'); 
                    Route::get('/supplier/summary/search', 'SearchSupplierReturnSummaryStatement')->name('search.pharmacySupplierReturnSummary');



                    // *************** Pharmacy Supplier Return Detail Statement Routes *************** //
                    Route::get('/supplier/details','ShowSupplierReturnDetailsStatement')->name('show.pharmacySupplierReturnDetails'); 
                    Route::get('/supplier/details/search', 'SearchSupplierReturnDetailsStatement')->name('search.pharmacySupplierReturnDetails');



                    // *************** Pharmacy Client Return Summary Statement Routes *************** //
                    Route::get('/client/summary','ShowClientReturnSummaryStatement')->name('show.pharmacyClientReturnSummary'); 
                    Route::get('/client/summary/search', 'SearchClientReturnSummaryStatement')->name('search.pharmacyClientReturnSummary');



                    // *************** Pharmacy Client Return Detail Statement Routes *************** //
                    Route::get('/client/details','ShowClientReturnDetailsStatement')->name('show.pharmacyClientReturnDetails'); 
                    Route::get('/client/details/search', 'SearchClientReturnDetailsStatement')->name('search.pharmacyClientReturnDetails');
                });


                
                ///////////// --------------- Pharmacy Stock Statement Routes ----------- ///////////////////
                Route::prefix('/stock')->group(function () {
                    // *************** Pharmacy Stock Summary Statement Routes *************** //
                    Route::get('/summary','ShowStockSummaryStatement')->name('show.pharmacyStockSummary'); 
                    Route::get('/summary/search', 'SearchStockSummaryStatement')->name('search.pharmacyStockSummary');



                    // *************** Pharmacy Stock Detail Statement Routes *************** //
                    Route::get('/details','ShowStockDetailsStatement')->name('show.pharmacyStockDetails');
                    Route::get('/details/search', 'SearchStockDetailsStatement')->name('search.pharmacyStockDetails');
                });



                ///////////// --------------- Pharmacy Profitability Statement Routes ----------- ///////////////////
                Route::get('/profitability/statement','ShowProfitabilityStatement')->name('show.pharmacyProfit');
                Route::get('/profitability/statement/search', 'SearchProfitabilityStatement')->name('search.pharmacyProfit');
                


                ///////////// --------------- Pharmacy Expiry Statement Routes ----------- ///////////////////
                Route::get('/expiry/statement','ShowExpiryStatement')->name('show.pharmacyExpiry');
                Route::get('/expiry/statement/search', 'SearchExpiryStatement')->name('search.pharmacyExpiry');
            }); // End PharmacyReportController
        }); // End Pharmacy Report Routes
    }); // End Pharmacy Routes 

    /////-----/////-----/////-----/////-----/////-----///// Pharmacy Routes End /////-----/////-----/////-----/////-----/////-----/////





    /////-----/////-----/////-----/////-----/////-----///// Hospital Routes Start /////-----/////-----/////-----/////-----/////-----/////
    
    Route::prefix('/hospital')->group(function () {
        
        Route::controller(HospitalSetupConrtoller::class)->group(function(){
            // *************************************** Hospital Setup Routes Start *************************************** //
            Route::prefix('/setup')->group(function () {
                ///////////// --------------- Doctor Specialization Routes Start ----------- ///////////////////
                Route::get('/specialization',  'ShowSpecialization')->name('show.specialization');
                
                
                
                ///////////// --------------- Hospital Floors Routes Start ----------- ///////////////////
                Route::get('/floor',  'ShowFloor')->name('show.hospitalFloors');



                ///////////// --------------- Bed Catagoary Routes  ----------- ///////////////////
                Route::get('/bedcategory',  'ShowBedCategory')->name('show.bedcategory');


                
                ///////////// --------------- Bed list Routes Start ----------- ///////////////////
                Route::get('/bedlist',  'ShowBedList')->name('show.bedlist');


                ///////////////////// ------------------ Hospital Group Routes Start ------------------ /////////////////////
                Route::get('/groupe',  'ShowHospitalGroupe')->name('show.hospitalGroupe');
                
                
                ///////////////////// ------------------ Hospital Services Routes Start ------------------ /////////////////////
                Route::get('/services',  'ShowHospitalServices')->name('show.hospitalServices');
                
                
                ///////////////////// ------------------ Nursing Station Routes Start ------------------ /////////////////////
                Route::get('/nursingstation',  'ShowNursingStation')->name('show.nursingStation');
            }); // End Hospital Setup Routes


            ///////////////////// ------------------ Patient Registration Routes Start ------------------ /////////////////////
            Route::get('/ptnregistration',  'ShowPatientRegistrations')->name('show.patientRegistration');


            ///////////////////// ------------------ Patient Appoinment Routes Start ------------------ /////////////////////
            Route::get('/ptnappointment',  'ShowPatientAppointment')->name('show.patientAppointment');


            ///////////////////// ------------------ Patient Bed Transfer Routes Start ------------------ /////////////////////
            Route::get('/bedtransfer',  'ShowBedTransfer')->name('show.bedTransfer');

            
            ///////////////////// ------------------ Patient Bed Status Routes Start ------------------ /////////////////////
            Route::get('/bedstatus',  'ShowBedStatus')->name('show.bedStatus');
        });
        
        
        
        
        // *************************************** Hospital Users Routes Start *************************************** //
        Route::prefix('/users')->group(function () {
            Route::controller(UsersController::class)->group(function(){
                ///////////////////// ------------------ Doctors Information Routes Start ------------------ /////////////////////
                Route::get('/doctors',  'ShowDoctors')->name('show.doctors');



                ///////////////////// ------------------ Patient Registration Routes Start ------------------ /////////////////////
                Route::get('/patients',  'ShowPatients')->name('show.patients');
            });
        }); // End Hospital Users Routes
        
        
        
        // *************************************** Hospital Transaction Routes Start *************************************** //
        Route::prefix('/transaction')->group(function () {
            Route::controller(HospitalTransactionController::class)->group(function(){
                ///////////// --------------- Admission Fee Routes Start ----------- ///////////////////
                Route::get('/admission',  'showadmission')->name('show.admission');
                Route::get('/admission/search',  'SearchAdmission')->name('search.admission');
                
                
                
                ///////////// --------------- Deposit Routes Start ----------- ///////////////////
                Route::get('/deposit',  'ShowDeposit')->name('show.deposit');
                Route::get('/deposit/search',  'SearchDeposit')->name('search.deposit');
                
                
                
                ///////////// --------------- Deposit Refunds Routes Start ----------- ///////////////////
                Route::get('/depositrefund',  'ShowDepositRefund')->name('show.depositrefund');
                Route::get('/depositrefund/search',  'SearchDepositRefund')->name('search.depositrefund');
                
                
                
                ///////////// --------------- Services Fee Routes Start ----------- ///////////////////
                Route::get('/services',  'ShowServices')->name('show.services');
                Route::get('/services/search',  'SearchServices')->name('search.services');

            });
        }); // End Hospital Transaction Routes
        
        
        
        // *************************************** Hospital Paty Payment Routes Start *************************************** //
        Route::prefix('/party')->group(function () {
            
        }); // End Hospital Paty Payment Routes
        
        
        
        // *************************************** Hospital Report Routes Start *************************************** //
        Route::prefix('/report')->group(function () {
            
        }); // End Hospital Report Routes
    }); // End Hospital Routes 

    /////-----/////-----/////-----/////-----/////-----///// Hospital Routes Start /////-----/////-----/////-----/////-----/////-----/////





    /////-----/////-----/////-----/////-----/////-----///// Hotel Routes Start /////-----/////-----/////-----/////-----/////-----/////
    
    Route::prefix('/hotel')->group(function () {
        Route::controller(HotelSetupController::class)->group(function(){
            // *************************************** Hotel Setup Routes Start *************************************** //
            Route::prefix('/setup')->group(function () {
                Route::get('/floor',  'ShowFloor')->name('show.floor');
                
                Route::get('/roomcatagory',  'ShowRoomCatagory')->name('show.roomcatagory');
                
                Route::get('/roomlist',  'ShowRoomList')->name('show.roomlist');
                
                Route::get('/groupe',  'ShowGroupe')->name('show.groupe');

                Route::get('/service',  'ShowService')->name('show.service');
            }); // End Hotel Setup Routes


            // Hotel booking routes
            Route::get('/booking',  'ShowBooking')->name('show.booking');

            // Room Transfer routes
            Route::get('/roomtransfer',  'ShowRoomTransfer')->name('show.roomTransfer');

            // Hotel Room Status routes
            Route::get('/roomstatus',  'ShowRoomStatus')->name('show.roomStatus');

            // Hotel Bill Clearence
            Route::get('/billclearence',  'ShowBillClearence')->name('show.billClearence');
        }); // End Hotel Setup Controller



        // *************************************** Hotel Users Routes Start *************************************** //
        Route::prefix('/users')->group(function () {
            Route::controller(UsersController::class)->group(function(){
                // Hotel Guests routes
                Route::get('/guests',  'ShowGuests')->name('show.hotelGuests');
            });
        }); // End Hotel Users Routes
        
        
        
        // *************************************** Hotel Transaction Routes Start *************************************** //
        Route::prefix('/transaction')->group(function () {
            Route::controller(HotelTransactionController::class)->group(function(){
                ///////////// --------------- Services Fee Routes Start ----------- ///////////////////
                Route::get('/services',  'ShowServices')->name('show.hotelServices');
                Route::get('/services/search',  'SearchServices')->name('search.hotelServices');
            });
        }); // End Hotel Transaction Routes
        
        
        
        // *************************************** Hotel Paty Payment Routes Start *************************************** //
        Route::prefix('/party')->group(function () {
            
        }); // End Hotel Paty Payment Routes
        
        
        
        // *************************************** Hotel Report Routes Start *************************************** //
        Route::prefix('/report')->group(function () {
            
        }); // End Hotel Report Routes
    }); // End Hotel Routes 

    /////-----/////-----/////-----/////-----/////-----///// Hotel Routes Start /////-----/////-----/////-----/////-----/////-----/////
    
    
    
    
    
    /////-----/////-----/////-----/////-----/////-----///// Restaurants Routes Start /////-----/////-----/////-----/////-----/////-----/////
    
    Route::prefix('/restaurant')->group(function () {
        // *************************************** Restaurants Setup Routes Start *************************************** //
        Route::prefix('/setup')->group(function () {
            // Route::controller(AccountStatementController::class)->group(function () {
            //     ///////////// --------------- Account Summary Statement Routes ----------- ///////////////////
            //     Route::get('/summary', 'ShowAccountSummaryStatement')->name('show.accountSummary');
            //     Route::get('/summary/search', 'SearchAccountSummaryStatement')->name('search.accountSummary');
            // });
        }); // End Restaurants Setup Routes
        
        
        
        // *************************************** Restaurants Users Routes Start *************************************** //
        Route::prefix('/users')->group(function () {
            
        }); // End Restaurants Users Routes
        
        
        
        // *************************************** Restaurants Transaction Routes Start *************************************** //
        Route::prefix('/transaction')->group(function () {
            
        }); // End Restaurants Transaction Routes
        
        
        
        // *************************************** Restaurants Paty Payment Routes Start *************************************** //
        Route::prefix('/party')->group(function () {
            
        }); // End Restaurants Paty Payment Routes
        
        
        
        // *************************************** Restaurants Report Routes Start *************************************** //
        Route::prefix('/report')->group(function () {
            
        }); // End Restaurants Report Routes
    }); // End Restaurants Routes 

    /////-----/////-----/////-----/////-----/////-----///// Restaurants Routes Start /////-----/////-----/////-----/////-----/////-----/////
    
    
    
    
    
    /////-----/////-----/////-----/////-----/////-----///// Diagnosis Routes Start /////-----/////-----/////-----/////-----/////-----/////
    
    Route::prefix('/diagnosis')->group(function () {
        // *************************************** Diagnosis Setup Routes Start *************************************** //
        Route::prefix('/setup')->group(function () {
            // Route::controller(AccountStatementController::class)->group(function () {
            //     ///////////// --------------- Account Summary Statement Routes ----------- ///////////////////
            //     Route::get('/summary', 'ShowAccountSummaryStatement')->name('show.accountSummary');
            //     Route::get('/summary/search', 'SearchAccountSummaryStatement')->name('search.accountSummary');
            // });
        }); // End Diagnosis Setup Routes
        
        
        
        // *************************************** Diagnosis Users Routes Start *************************************** //
        Route::prefix('/users')->group(function () {
            
        }); // End Diagnosis Users Routes
        
        
        
        // *************************************** Diagnosis Transaction Routes Start *************************************** //
        Route::prefix('/transaction')->group(function () {
            
        }); // End Diagnosis Transaction Routes
        
        
        
        // *************************************** Diagnosis Paty Payment Routes Start *************************************** //
        Route::prefix('/party')->group(function () {
            
        }); // End Diagnosis Paty Payment Routes
        
        
        
        // *************************************** Diagnosis Report Routes Start *************************************** //
        Route::prefix('/report')->group(function () {
            
        }); // End Diagnosis Report Routes
    }); // End Diagnosis Routes 

    /////-----/////-----/////-----/////-----/////-----///// Diagnosis Routes Start /////-----/////-----/////-----/////-----/////-----/////
    
    
    
    
    
    /////-----/////-----/////-----/////-----/////-----///// School Routes Start /////-----/////-----/////-----/////-----/////-----/////
    
    Route::prefix('/school')->group(function () {
        // *************************************** School Setup Routes Start *************************************** //
        Route::prefix('/setup')->group(function () {
            // Route::controller(AccountStatementController::class)->group(function () {
            //     ///////////// --------------- Account Summary Statement Routes ----------- ///////////////////
            //     Route::get('/summary', 'ShowAccountSummaryStatement')->name('show.accountSummary');
            //     Route::get('/summary/search', 'SearchAccountSummaryStatement')->name('search.accountSummary');
            // });
        }); // End School Setup Routes
        
        
        
        // *************************************** School Users Routes Start *************************************** //
        Route::prefix('/users')->group(function () {
            
        }); // End School Users Routes
        
        
        
        // *************************************** School Transaction Routes Start *************************************** //
        Route::prefix('/transaction')->group(function () {
            
        }); // End School Transaction Routes
        
        
        
        // *************************************** School Paty Payment Routes Start *************************************** //
        Route::prefix('/party')->group(function () {
            
        }); // End School Paty Payment Routes
        
        
        
        // *************************************** School Report Routes Start *************************************** //
        Route::prefix('/report')->group(function () {
            
        }); // End School Report Routes
    }); // End School Routes 

    /////-----/////-----/////-----/////-----/////-----///// School Routes Start /////-----/////-----/////-----/////-----/////-----/////
    
    
    
    
    
    /////-----/////-----/////-----/////-----/////-----///// Report Routes Start /////-----/////-----/////-----/////-----/////-----/////
    
    Route::prefix('/report')->group(function () {
        // *************************************** Account Statement Routes Start *************************************** //
        Route::prefix('/account')->group(function () {
            Route::controller(AccountStatementController::class)->group(function () {
                ///////////// --------------- Account Summary Statement Routes ----------- ///////////////////
                Route::get('/summary', 'ShowAccountSummaryStatement')->name('show.accountSummary');
                Route::get('/summary/search', 'SearchAccountSummaryStatement')->name('search.accountSummary');
            
            
            
                ///////////// --------------- Account Summary(By Groupe) Statement Routes ----------- ///////////////////
                Route::get('/summarygroupe', 'ShowAccountSummaryGroupeStatement')->name('show.accountSummaryByGroupe');
                Route::get('/summarygroupe/search', 'SearchAccountSummaryGroupeStatement')->name('search.accountSummaryByGroupe');
            
            
            
                ///////////// --------------- Account Details Statement Routes ----------- ///////////////////
                Route::get('/details', 'ShowAccountDetailsStatement')->name('show.accountDetails');
                Route::get('/details/search', 'SearchAccountDetailsStatement')->name('search.accountDetails');
            });
        }); // End Account Statement Routes
        
        
        
        // *************************************** Party Statement Routes Start *************************************** //
        Route::prefix('/party')->group(function () {
            Route::controller(PartyStatementController::class)->group(function () {
                ///////////// --------------- Party Summary Statement Routes ----------- ///////////////////
                Route::get('/summary', 'PartySummaryReport')->name('show.partySummary');
                Route::get('/summary/search', 'SearchPartySummaryReport')->name('search.partySummary');
            
            
            
                ///////////// --------------- Party Detail Statement Routes ----------- ///////////////////
                Route::get('/details', 'PartyDetailsReport')->name('show.partyDetails');
                Route::get('/details/search', 'SearchPartyDetailsReport')->name('search.partyDetails');
            });
        }); // End Party Statement Routes
    }); // End Report Routes 
    
    /////-----/////-----/////-----/////-----/////-----///// Report Routes End /////-----/////-----/////-----/////-----/////-----/////
});