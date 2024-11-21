<?php

// Middlewares
// use App\Http\Middleware\ValidUser;
use App\Http\Middleware\CheckPermission;
// use App\Http\Middleware\SuperAdminAccess;
use App\Http\Controllers\ProfileController;



// Admin Setup Related Controllers
use App\Http\Controllers\Frontend\Admin_Setup\AdminSetupController;
use App\Http\Controllers\Frontend\Admin_Setup\UsersController;
use App\Http\Controllers\Frontend\Admin_Setup\AuthSetupController;


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


// Report Controllers
use App\Http\Controllers\Frontend\ReportController;
use App\Http\Controllers\Frontend\Report\AccountStatementController;
use App\Http\Controllers\Frontend\Report\PartyStatementController;
use App\Http\Controllers\Frontend\Report\BalanceSheetController;


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

// Route::get('/', function () {
//     return view('layouts.layout')->name('dashboard');
// });



// Don't Give Access to this routes if user is not valid
Route::middleware([CheckPermission::class])->group(function () {
    // *************************************** Login Controller Routes Start *************************************** //
    Route::controller(AuthController::class)->group(function () {
        Route::get('/login', 'Login')->name('login')->withoutMiddleware(CheckPermission::class);
        Route::get('/dashboard', 'Dashboard')->name('dashboard')->withoutMiddleware(CheckPermission::class);;
    });


    // *************************************** Forget Password Controller Routes Start *************************************** //
    Route::controller(ForgetPasswordController::class)->group(function () {
        Route::get('/forgotpassword', 'ForgotPassord')->name('forgotPassword');
        Route::get('/resetpassword', 'ResetPassword')->name('resetPassword');
    });


    // Route::middleware(CheckPermission::class)->group(function () {
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
                ///////////// --------------- Admin Routes ----------- ///////////////////
                Route::get('/admins', 'ShowAdmins')->name('show.admins');
                Route::get('/admins/search', 'SearchAdmins')->name('search.admins');



                ///////////// --------------- Super Admin Routes ----------- ///////////////////
                Route::get('/superadmins', 'ShowSuperAdmins')->name('show.superAdmins');
                Route::get('/superadmins/search', 'SearchSuperAdmins')->name('search.superAdmins');



                ///////////// --------------- Client Routes ----------- ///////////////////
                Route::get('/clients', 'ShowClients')->name('show.clients');
                Route::get('/clients/search', 'SearchClients')->name('search.clients');



                ///////////// --------------- Supplire Routes ----------- ///////////////////
                Route::get('/suppliers', 'ShowSuppliers')->name('show.suppliers');
                Route::get('/suppliers/search', 'SearchSuppliers')->name('search.suppliers');
            }); // End Users Controller
        }); // End User Route



        // *************************************** Auth Routes Start *************************************** //
        Route::prefix('/auth')->group(function () {
            Route::controller(AuthSetupController::class)->group(function () {
                ///////////// --------------- Role routes ----------- ///////////////////
                Route::get('/roles', 'ShowRoles')->name('show.roles');
                Route::get('/roles/search', 'SearchRoles')->name('search.roles');
                

                // !!!!!!!!!!!!!!!!!!!! --------------- Permission Routes Start ----------- !!!!!!!!!!!!!!!!!!!! //
                Route::prefix('/permission')->group(function () {
                    ///////////// --------------- Permission Main Heads routes ----------- ///////////////////
                    Route::get('/mainhead', 'ShowPermissionMainheads')->name('show.permissionMainheads');
                    Route::get('/mainhead/search', 'SearchPermissionMainheads')->name('search.permissionMainheads');
                    
                    
                    
                    ///////////// --------------- Permission Heads routes ----------- ///////////////////
                    Route::get('/', 'ShowPermissions')->name('show.permissions');
                    Route::get('/search', 'SearchPermissions')->name('search.permissions');



                    ///////////// --------------- Role Permission routes ----------- ///////////////////
                    Route::get('/rolepermissions', 'ShowRolePermissions')->name('show.rolePermissions');
                    Route::get('/rolepermissions/search', 'SearchRolePermissions')->name('search.rolePermissions');



                    ///////////// --------------- Route Permission routes ----------- ///////////////////
                    Route::get('/routepermissions', 'ShowRoutePermissions')->name('show.routePermissions');
                    Route::get('/routepermissions/search', 'SearchRoutePermissions')->name('search.routePermissions');
                    


                    ///////////// --------------- User Permission routes ----------- ///////////////////
                    Route::get('/userpermissions', 'ShowUserPermissions')->name('show.userPermissions');
                    Route::get('/userpermissions/search', 'SearchUserPermissions')->name('search.userPermissions');
                }); // End Permission Routes
            }); // End Auth Setup Controller
        }); // End Auth Routes



        


        Route::controller(AdminSetupController::class)->group(function () {
            // *************************************** Main Heads Routes Start *************************************** //
            Route::get('/companytype', 'ShowCompanyType')->name('show.companytype');
            Route::get('/companytype/search', 'SearchCompanyType')->name('search.companytype');



            // *************************************** Company Routes Start *************************************** //
            Route::get('/companies', 'ShowCompanies')->name('show.companies');
            Route::get('/companies/search', 'SearchCompanies')->name('search.companies');



            // *************************************** Bank Routes Start *************************************** //
            Route::get('/banks', 'ShowBanks')->name('show.banks');
            Route::get('/banks/search', 'SearchBanks')->name('search.banks');
            


            // *************************************** Location Routes Start *************************************** //
            Route::get('/locations', 'ShowLocations')->name('show.locations');
            Route::get('/locations/search', 'SearchLocations')->name('search.locations');
            


            // *************************************** Store Routes Start *************************************** //
            Route::get('/stores', 'ShowStores')->name('show.stores');
            Route::get('/stores/search', 'SearchStores')->name('search.stores');



            // *************************************** Main Heads Routes Start *************************************** //
            Route::get('/mainheads', 'ShowTransactionMainHead')->name('show.mainhead');
            Route::get('/mainheads/search', 'SearchTransactionMainHead')->name('search.mainhead');
            


            // *************************************** TranWith(User Type) Routes Start *************************************** //
            Route::get('/tranwith', 'ShowTranWith')->name('show.tranwith');
            Route::get('/tranwith/search', 'SearchTranWith')->name('search.tranwith');


            /// *************************************** TranGroupe Routes Start *************************************** //
            Route::get('/trangroupes', 'ShowTransactionGroupes')->name('show.tranGroupes');
            Route::get('/trangroupes/search', 'SearchTransactionGroupes')->name('search.tranGroupes');



            // *************************************** TranHead Routes Start *************************************** //
            Route::get('/tranheads', 'ShowTransactionHeads')->name('show.tranHeads');
            Route::get('/tranheads/search', 'SearchTransactionHeads')->name('search.tranHeads');
        }); // End Admin Setup Controller
    }); // End Admin Routes

    /////-----/////-----/////-----/////-----/////-----///// Admin Setup Routes /////-----/////-----/////-----/////-----/////-----/////





    /////-----/////-----/////-----/////-----/////-----///// Transaction Routes Start /////-----/////-----/////-----/////-----/////-----/////

    Route::prefix('/transaction')->group(function () {
        // *************************************** General Transaction Routes Start *************************************** //
        Route::controller(GeneralTransactionController::class)->group(function () {
            Route::get('/receive', 'ShowTransactionReceive')->name('show.transactionReceive');
            Route::get('/receive/search', 'SearchTransaction')->name('search.transactionReceive');

            Route::get('/payment', 'ShowTransactionPayment')->name('show.transactionPayment');
            Route::get('/payment/search', 'SearchTransaction')->name('search.transactionPayment');
        }); // End GeneralTransactionController 



        // *************************************** Bank Transaction Routes Start *************************************** //
        Route::controller(BankTransactionController::class)->group(function () {
            Route::prefix('/bank')->group(function () {
                Route::get('/withdraw', 'ShowBankWithdraws')->name('show.withdraws');
                Route::get('/withdraw/search', 'SearchBankTransactions')->name('search.withdraws');

                Route::get('/deposit', 'ShowBankDeposits')->name('show.deposits');
                Route::get('/deposit/search', 'SearchBankTransactions')->name('search.deposits');
            }); // End Bank Transaction Route
        }); // End BankTransactionController 



        // *************************************** Party Transaction Routes Start *************************************** //
        Route::controller(PartyTransactionController::class)->group(function () {
            Route::prefix('/party')->group(function () {
                Route::get('/receive', 'ShowPartyReceive')->name('show.partyReceive');
                Route::get('/receive/search', 'SearchParty')->name('search.partyReceive');

                Route::get('/payment', 'ShowPartyPayment')->name('show.partyPayment');
                Route::get('/payment/search', 'SearchParty')->name('search.partyPayment');
            }); // End Party Transaction Routres
        }); // End PartyTransactionController
    }); // End Transaction Routes

    /////-----/////-----/////-----/////-----/////-----///// Transaction Controllers End /////-----/////-----/////-----/////-----/////-----/////





    /////-----/////-----/////-----/////-----/////-----///// HR Controllers Start /////-----/////-----/////-----/////-----/////-----/////

    Route::prefix('/hr')->group(function () {
        // *************************************** HR Setup Routes Start *************************************** //
        Route::controller(HRSetupController::class)->group(function () {
            // *************************************** Department Routes Start *************************************** //
            Route::get('/departments', 'ShowDepartments')->name('show.departments');
            Route::get('/departments/search', 'SearchDepartments')->name('search.departments');



            // *************************************** Designations Routes Start *************************************** //
            Route::get('/designations', 'ShowDesignations')->name('show.designations');
            Route::get('/designations/search', 'SearchDesignations')->name('search.designations');
        });
        





        // *************************************** Hr Employee Routes Start *************************************** //
        Route::prefix('/employee')->group(function () {
            Route::controller(EmployeeInfoController::class)->group(function () {
                ///////////// --------------- Employee Routes ----------- ///////////////////
                Route::get('/all', 'ShowEmployees')->name('show.employees');
                Route::get('/all/details', 'ShowEmployeeDetails')->name('detail.employees');
                Route::get('/all/search', 'SearchEmployees')->name('search.employees');
                //Search List Routes Start
                Route::get('/get', 'GetEmployeeByName')->name('get.employees')->withoutMiddleware(CheckPermission::class);



                ///////////// --------------- Employee Personal Details Routes ----------- ///////////////////
                Route::get('/personal',  'PersonalDetails')->name('show.employeePersonal');
                Route::get('/personal/details',  'ShowPersonalDetails')->name('detail.employeePersonal');
                Route::get('/personal/search',  'SearchPersonalDetails')->name('search.employeePersonal');



                ///////////// --------------- Employee Education Details Routes ----------- ///////////////////
                Route::get('/education',  'EducationDetails')->name('show.employeeEducation');
                Route::get('/education/details',  'ShowEmployeesEducationDetails')->name('detail.employeeEducation');
                Route::get('/education/grid',  'EmployeesEducationDetailsGrid')->name('grid.employeeEducation');
                Route::get('/education/search',  'SearchEducationDetails')->name('search.employeeEducation');
                
                

                ///////////// --------------- Employee Training Details Routes ----------- ///////////////////
                Route::get('/training',  'TrainingDetails')->name('show.employeeTraining');
                Route::get('/training/details',  'ShowTrainingDetails')->name('detail.employeeTraining');
                Route::get('/training/grid',  'EmployeeTrainingDetailsGrid')->name('grid.employeeTraining');
                Route::get('/training/search',  'SearchTrainingDetails')->name('search.employeeTraining');



                ///////////// --------------- Employee Experience Details Routes ----------- ///////////////////
                Route::get('/experience',  'ExperienceDetails')->name('show.employeeExperience');
                Route::get('/experience/details',  'ShowExperienceDetails')->name('detail.employeeExperience');
                Route::get('/experience/grid',  'EmployeeExperienceDetailsGrid')->name('grid.employeeExperience');
                Route::get('/experience/search',  'SearchExperienceDetails')->name('search.employeeExperience');
                


                ///////////// --------------- Employee Organization Routes ----------- ///////////////////
                Route::get('/organization',  'OrganizationDetails')->name('show.employeeOrganization');
                Route::get('/organization/details',  'ShowOrganizationDetails')->name('detail.employeeOrganization');
                Route::get('/organization/grid',  'EmployeeOrganizationDetailsGrid')->name('grid.employeeOrganization');
                Route::get('/organization/search',  'SearchOrganizationDetails')->name('search.employeeOrganization');
                


                ///////////// --------------- Attendence Routes ----------- ///////////////////
                Route::get('/attendence/list','EmployeeAttendenceList')->name('show.employeeAttendence'); 
                Route::get('/attendence/add','AddEmployeeAttendence')->name('add.employeeAttendence'); 
                Route::post('/attendence/insert','EmployeeAttendenceStore')->name('insert.employeeAttendence'); 
                Route::get('/attendence/edit/{date}','EditEmployeeAttendence')->name('edit.employeeAttendence'); 
                Route::get('/attendence/view/{date}','ViewEmployeeAttendence')->name('view.employeeAttendence');
            });
        }); // End Hr Employee Routes





        // *************************************** HR Payroll Routes Start *************************************** //
        Route::prefix('/payroll')->group(function () {
            Route::controller(PayRollController::class)->group(function(){
                ///////////// --------------- Payroll Setup Routes ----------- ///////////////////
                Route::get('/setup','ShowPayrollSetup')->name('show.payrollSetup');
                Route::get('/setup/search','SearchPayrollSetup')->name('search.payrollSetup');



                ///////////// --------------- Payroll Middlewire Routes ----------- ///////////////////
                Route::get('/middlewire','ShowPayrollMiddlewire')->name('show.payrollMiddlewire');
                Route::get('/middlewire/search','SearchPayrollMiddlewire')->name('search.payrollMiddlewire');
                
                
                
                ///////////// --------------- Payroll Installment(Salary Payment) Routes ----------- ///////////////////
                Route::get('/process','ShowPayroll')->name('show.payroll');
                Route::get('/process/search', 'SearchPayroll')->name('search.payroll');
                // Search List Routes Start
                Route::get('/get/user/date', 'GetPayrollByUserIdAndDate')->name('get.payrollByDate')->withoutMiddleware(CheckPermission::class);
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
                Route::get('/manufacturer/search',  'SearchManufacturer')->name('search.invManufacturer');



                ///////////////////// ------------------ Item/Product Category Routes Start ------------------ /////////////////////
                // Crude Routes Start
                Route::get('/category', 'ShowItemCategory')->name('show.invCategory');
                Route::get('/category/search', 'SearchItemCategory')->name('search.invCategory');



                //////////////// ------------------ Item/Product Form Routes Start ------------------- //////////////////
                // Crude Routes Start
                Route::get('/form', 'ShowForm')->name('show.invForm');
                Route::get('/form/search', 'SearchForm')->name('search.invForm');



                //////////////// ------------------ Item/Product Unit Routes Start ------------------- //////////////////
                // Crude Routes Start
                Route::get('/unit', 'ShowUnit')->name('show.invUnit');
                Route::get('/unit/search', 'SearchUnit')->name('search.invUnit');



                //////////////// ------------------ Inventory Product Routes Start ------------------- //////////////////
                // Crud Routes Start
                Route::get('/product', 'ShowInventoryProduct')->name('show.invProduct');
                Route::get('/product/search', 'SearchInventoryProduct')->name('search.invProduct');
            });
        }); // End Inventory Setup Routes



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
                Route::get('/manufacturer/search',  'SearchManufacturer')->name('search.pharmacyManufacturer');



                ///////////// --------------- Pharmacy Category Routes ----------- ///////////////////
                Route::get('/category', 'ShowItemCategory')->name('show.pharmacyCategory');
                Route::get('/category/search', 'SearchItemCategory')->name('search.pharmacyCategory');



                ///////////// --------------- Pharmacy Form Routes ----------- ///////////////////
                Route::get('/form', 'ShowForm')->name('show.pharmacyForm');
                Route::get('/form/search', 'SearchForm')->name('search.pharmacyForm');



                ///////////// --------------- Pharmacy Unit Routes ----------- ///////////////////
                Route::get('/unit', 'ShowUnit')->name('show.pharmacyUnit');
                Route::get('/unit/search', 'SearchUnit')->name('search.pharmacyUnit');



                ///////////// --------------- Pharmacy Products Routes ----------- ///////////////////
                Route::get('/product', 'ShowPharmacyProduct')->name('show.pharmacyProduct');
                Route::get('/product/search', 'SearchPharmacyProduct')->name('search.pharmacyProduct');
            }); // End Pharmacy 
        }); // End Pharmacy Setup Routes



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
        
        
        
        // *************************************** Balancesheet Routes Start *************************************** //
        Route::prefix('/balancesheet')->group(function () {
            Route::controller(BalanceSheetController::class)->group(function () {
                ///////////// --------------- Balancesheet Summary Report Routes ----------- ///////////////////
                Route::get('/summary', 'BalanceSheetSummaryReport')->name('show.balanceSheetSummary');
                Route::get('/summary/search', 'SearchBalanceSheetSummaryReport')->name('search.balanceSheetSummary');
            
            
            
                ///////////// --------------- Balancesheet Detail Report Routes ----------- ///////////////////
                Route::get('/details', 'BalanceSheetDetailsReport')->name('show.balanceSheetDetails');
                Route::get('/details/search', 'SearchBalanceSheetDetailsReport')->name('search.balanceSheetDetails');
            });
        }); // End Balancesheet Statement Routes



        
        Route::controller(ReportController::class)->group(function () {
            // *************************************** Report By Groupe Routes Start *************************************** //
            Route::get('/groupe', 'ReportByGroupe')->name('show.groupeReport');
            Route::get('/groupe/search', 'SearchReportByGroupeDate')->name('search.groupeReport');



            // *************************************** Summary Report Routes Start *************************************** //
            Route::get('/summary', 'SummaryReport')->name('show.summaryReport');
            Route::get('/summary/search', 'SearchSummaryReport')->name('search.summaryReport');


            // Common Routes
            Route::get('/invoice/details', 'ReportInvoiceDetails')->name('show.reportInvoiceDetails');
        });
    }); // End Report Routes 
    
    /////-----/////-----/////-----/////-----/////-----///// Report Routes End /////-----/////-----/////-----/////-----/////-----/////
    // });
});