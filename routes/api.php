<?php

use App\Http\Middleware\ApiValidUser;
use App\Http\Middleware\SuperAdminAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Auth Controllers
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Auth\ForgetPasswordController;

// Admin Setup Users Controllers
use App\Http\Controllers\API\Backend\Admin_Setup\Users\RoleController;
use App\Http\Controllers\API\Backend\Admin_Setup\Users\AdminController;
use App\Http\Controllers\API\Backend\Admin_Setup\Users\SuperAdminController;
use App\Http\Controllers\API\Backend\Admin_Setup\Users\ClientController;
use App\Http\Controllers\API\Backend\Admin_Setup\Users\SupplierController;

// Admin Setup Permission Controllers
use App\Http\Controllers\API\Backend\Admin_Setup\Permission\PermissionMainHeadController;
use App\Http\Controllers\API\Backend\Admin_Setup\Permission\PermissionHeadController;
use App\Http\Controllers\API\Backend\Admin_Setup\Permission\RoutePermissionController;
use App\Http\Controllers\API\Backend\Admin_Setup\Permission\RolePermissionController;
use App\Http\Controllers\API\Backend\Admin_Setup\Permission\UserPermissionController;

// Admin Setup Controllers
use App\Http\Controllers\API\Backend\Admin_Setup\CompanyController;
use App\Http\Controllers\API\Backend\Admin_Setup\CompanyTypeController;
use App\Http\Controllers\API\Backend\Admin_Setup\BankController;
use App\Http\Controllers\API\Backend\Admin_Setup\LocationController;
use App\Http\Controllers\API\Backend\Admin_Setup\MainHeadController;
use App\Http\Controllers\API\Backend\Admin_Setup\StoreController;
use App\Http\Controllers\API\Backend\Admin_Setup\TranWithController;
use App\Http\Controllers\API\Backend\Admin_Setup\TranGroupController;
use App\Http\Controllers\API\Backend\Admin_Setup\TranHeadController;

// Transactions Controllers
use App\Http\Controllers\API\Backend\Transactions\GeneralTransactionController;
use App\Http\Controllers\API\Backend\Transactions\BankTransactionController;
use App\Http\Controllers\API\Backend\Transactions\PartyTransactionController;


// HR Setup Controllers
use App\Http\Controllers\API\Backend\HR_Setup\DepartmentController;
use App\Http\Controllers\API\Backend\HR_Setup\DesignationController;


// HR Setup Employee Controllers
use App\Http\Controllers\API\Backend\HR_Setup\Employee\EmployeeController;
use App\Http\Controllers\API\Backend\HR_Setup\Employee\PersonalDetailsController;
use App\Http\Controllers\API\Backend\HR_Setup\Employee\EducationDetailsController;
use App\Http\Controllers\API\Backend\HR_Setup\Employee\ExperienceDetailsController;
use App\Http\Controllers\API\Backend\HR_Setup\Employee\OrganizationDetailsController;
use App\Http\Controllers\API\Backend\HR_Setup\Employee\TrainingDetailsController;
use App\Http\Controllers\API\Backend\HR_Setup\Employee\AttendenceController;


// HR Setup Employee Controllers
use App\Http\Controllers\API\Backend\HR_Setup\Payroll\PayrollSetupController;
use App\Http\Controllers\API\Backend\HR_Setup\Payroll\PayrollMiddlewireController;
use App\Http\Controllers\API\Backend\HR_Setup\Payroll\PayrollProcessController;


// HR Setup Controllers
use App\Http\Controllers\API\Backend\HR_Setup\Report\SalarySummaryController;
use App\Http\Controllers\API\Backend\HR_Setup\Report\SalaryDetailController;


// Inventory Setup Controllers
use App\Http\Controllers\API\Backend\Inventory\Inventory_Setup\InventoryManufacturerController;
use App\Http\Controllers\API\Backend\Inventory\Inventory_Setup\InventoryCategoryController;
use App\Http\Controllers\API\Backend\Inventory\Inventory_Setup\InventoryFormController;
use App\Http\Controllers\API\Backend\Inventory\Inventory_Setup\InventoryUnitController;
use App\Http\Controllers\API\Backend\Inventory\Inventory_Setup\InventoryProductsController;


// Inventory Transaction Controllers
use App\Http\Controllers\API\Backend\Inventory\Inventory_Transaction\InventoryIssueController;
use App\Http\Controllers\API\Backend\Inventory\Inventory_Transaction\InventoryPurchaseController;
use App\Http\Controllers\API\Backend\Inventory\Inventory_Transaction\Return\InventoryClientReturnController;
use App\Http\Controllers\API\Backend\Inventory\Inventory_Transaction\Return\InventorySupplierReturnController;


// Inventory Adjustment Controllers
use App\Http\Controllers\API\Backend\Inventory\Inventory_Adjustment\InventoryAdjustmentController;


// Inventory Report Controllers
use App\Http\Controllers\API\Backend\Inventory\Inventory_Reports\InventoryItemFlowStatementController;
use App\Http\Controllers\API\Backend\Inventory\Inventory_Reports\Purchase_Statement\InventoryPurchaseDetailController;
use App\Http\Controllers\API\Backend\Inventory\Inventory_Reports\Purchase_Statement\InventoryPurchaseSummaryController;
use App\Http\Controllers\API\Backend\Inventory\Inventory_Reports\Issue_Statement\InventoryIssueDetailController;
use App\Http\Controllers\API\Backend\Inventory\Inventory_Reports\Issue_Statement\InventoryIssueSummaryController;
use App\Http\Controllers\API\Backend\Inventory\Inventory_Reports\Return_Statement\InventoryClientReturnDetailController;
use App\Http\Controllers\API\Backend\Inventory\Inventory_Reports\Return_Statement\InventoryClientReturnSummaryController;
use App\Http\Controllers\API\Backend\Inventory\Inventory_Reports\Return_Statement\InventorySupplierReturnDetailController;
use App\Http\Controllers\API\Backend\Inventory\Inventory_Reports\Return_Statement\InventorySupplierReturnSummaryController;
use App\Http\Controllers\API\Backend\Inventory\Inventory_Reports\Stock_Statement\InventoryStockDetailController;
use App\Http\Controllers\API\Backend\Inventory\Inventory_Reports\Stock_Statement\InventoryStockSummaryController;
use App\Http\Controllers\API\Backend\Inventory\Inventory_Reports\InventoryProfitabilityStatementController;
use App\Http\Controllers\API\Backend\Inventory\Inventory_Reports\InventoryExpiryStatementController;


// Pharmacy Setup Controllers
use App\Http\Controllers\API\Backend\Pharmacy\Pharmacy_Setup\PharmacyManufacturerController;
use App\Http\Controllers\API\Backend\Pharmacy\Pharmacy_Setup\PharmacyCategoryController;
use App\Http\Controllers\API\Backend\Pharmacy\Pharmacy_Setup\PharmacyFormController;
use App\Http\Controllers\API\Backend\Pharmacy\Pharmacy_Setup\PharmacyUnitController;
use App\Http\Controllers\API\Backend\Pharmacy\Pharmacy_Setup\PharmacyProductsController;


// Pharmacy Transaction Controllers
use App\Http\Controllers\API\Backend\Pharmacy\Pharmacy_Transaction\PharmacyIssueController;
use App\Http\Controllers\API\Backend\Pharmacy\Pharmacy_Transaction\PharmacyPurchaseController;
use App\Http\Controllers\API\Backend\Pharmacy\Pharmacy_Transaction\Return\PharmacyClientReturnController;
use App\Http\Controllers\API\Backend\Pharmacy\Pharmacy_Transaction\Return\PharmacySupplierReturnController;


// Pharmacy Adjustment Controllers
use App\Http\Controllers\API\Backend\Pharmacy\Pharmacy_Adjustment\PharmacyAdjustmentController;


// Pharmacy Report Controllers
use App\Http\Controllers\API\Backend\Pharmacy\Pharmacy_Reports\PharmacyItemFlowStatementController;
use App\Http\Controllers\API\Backend\Pharmacy\Pharmacy_Reports\Purchase_Statement\PharmacyPurchaseDetailController;
use App\Http\Controllers\API\Backend\Pharmacy\Pharmacy_Reports\Purchase_Statement\PharmacyPurchaseSummaryController;
use App\Http\Controllers\API\Backend\Pharmacy\Pharmacy_Reports\Issue_Statement\PharmacyIssueDetailController;
use App\Http\Controllers\API\Backend\Pharmacy\Pharmacy_Reports\Issue_Statement\PharmacyIssueSummaryController;
use App\Http\Controllers\API\Backend\Pharmacy\Pharmacy_Reports\Return_Statement\PharmacyClientReturnDetailController;
use App\Http\Controllers\API\Backend\Pharmacy\Pharmacy_Reports\Return_Statement\PharmacyClientReturnSummaryController;
use App\Http\Controllers\API\Backend\Pharmacy\Pharmacy_Reports\Return_Statement\PharmacySupplierReturnDetailController;
use App\Http\Controllers\API\Backend\Pharmacy\Pharmacy_Reports\Return_Statement\PharmacySupplierReturnSummaryController;
use App\Http\Controllers\API\Backend\Pharmacy\Pharmacy_Reports\Stock_Statement\PharmacyStockDetailController;
use App\Http\Controllers\API\Backend\Pharmacy\Pharmacy_Reports\Stock_Statement\PharmacyStockSummaryController;
use App\Http\Controllers\API\Backend\Pharmacy\Pharmacy_Reports\PharmacyProfitabilityStatementController;
use App\Http\Controllers\API\Backend\Pharmacy\Pharmacy_Reports\PharmacyExpiryStatementController;


// Report Account Statement Controllers
use App\Http\Controllers\API\Backend\Reports\Account_Statement\AccountDetailsController;
use App\Http\Controllers\API\Backend\Reports\Account_Statement\AccountSummaryByGroupController;
use App\Http\Controllers\API\Backend\Reports\Account_Statement\AccountSummaryController;


// Report Balance Sheet Controllers
use App\Http\Controllers\API\Backend\Reports\Balance_Sheet\BalanceSheetDetailsController;
use App\Http\Controllers\API\Backend\Reports\Balance_Sheet\BalanceSheetSummaryController;


// Report Party Statement Controllers
use App\Http\Controllers\API\Backend\Reports\Party_Statement\PartyDetailsController;
use App\Http\Controllers\API\Backend\Reports\Party_Statement\PartySummaryController;


// Report Controllers
use App\Http\Controllers\API\Backend\Reports\ReportsByGroupController;
use App\Http\Controllers\API\Backend\Reports\ReportsBySummaryController;





// *************************************** Forget Password Controller Routes Start *************************************** //
Route::controller(ForgetPasswordController::class)->group(function () {
    Route::post('/forgotpassword', 'ForgotPassword');
    Route::post('/resetpassword',  'ResetPassword');
});

Route::post('/login', [AuthController::class, 'Login'])->middleware(['web']);

// Route::middleware(['auth:sanctum'])->group(function () {
Route::middleware(['auth:sanctum', ApiValidUser::class])->group(function () {
    Route::post('/logout', [AuthController::class, 'Logout'])->middleware(['web']);


    /////-----/////-----/////-----/////-----/////-----///// Admin Setup Routes Start /////-----/////-----/////-----/////-----/////-----/////
    
    Route::prefix('/admin')->group(function () {
        Route::middleware([SuperAdminAccess::class])->group(function () {
            // *************************************** Company Type Routes Start *************************************** //
            Route::controller(CompanyTypeController::class)->group(function () {
                Route::get('/companytype', 'ShowAll');
                Route::post('/companytype', 'Insert');
                Route::get('/companytype/edit', 'Edit');
                Route::put('/companytype', 'Update');
                Route::delete('/companytype', 'Delete');
                Route::get('/companytype/search', 'Search');
                Route::get('/companytype/get', 'Get');
            });



            // *************************************** Company Controller Start *************************************** //
            Route::controller(CompanyController::class)->group(function () {
                Route::get('/companies', 'ShowAll');
                Route::post('/companies', 'Insert');
                Route::get('/companies/edit', 'Edit');
                Route::put('/companies', 'Update');
                Route::delete('/companies', 'Delete');
                Route::get('/companies/search', 'Search');
                Route::get('/companies/get', 'Get')->withoutMiddleware(SuperAdminAccess::class);
                Route::get('/companies/details', 'Details');
            });
        });



        // *************************************** User Routes Start *************************************** //
        Route::prefix('/users')->group(function () {
            Route::middleware([SuperAdminAccess::class])->group(function () {
                ///////////// --------------- Role Routes ----------- ///////////////////
                Route::controller(RoleController::class)->group(function () {
                    Route::get('/roles', 'ShowAll');
                    Route::post('/roles', 'Insert');
                    Route::get('/roles/edit', 'Edit');
                    Route::put('/roles', 'Update');
                    Route::delete('/roles', 'Delete');
                    Route::get('/roles/search', 'Search');
                    Route::get('/roles/get', 'Get')->withoutMiddleware(SuperAdminAccess::class);
                });



                ///////////// --------------- Super Admin Routes ----------- ///////////////////
                Route::controller(SuperAdminController::class)->group(function () {
                    Route::get('/superadmins', 'ShowAll');
                    Route::post('/superadmins', 'Insert');
                    Route::get('/superadmins/edit', 'Edit');
                    Route::put('/superadmins', 'Update');
                    Route::delete('/superadmins', 'Delete');
                    Route::get('/superadmins/search', 'Search');
                });
            });
            

            ///////////// --------------- Admin Routes ----------- ///////////////////
            Route::controller(AdminController::class)->group(function () {
                Route::get('/admins', 'ShowAll');
                Route::post('/admins', 'Insert');
                Route::get('/admins/edit', 'Edit');
                Route::put('/admins', 'Update');
                Route::delete('/admins', 'Delete');
                Route::get('/admins/search', 'Search');
                Route::get('/admins/details', 'Details');
            });
            
            

            ///////////// --------------- Client Routes ----------- ///////////////////
            Route::controller(ClientController::class)->group(function () {
                Route::get('/clients', 'ShowAll');
                Route::post('/clients', 'Insert');
                Route::get('/clients/edit', 'Edit');
                Route::put('/clients', 'Update');
                Route::delete('/clients', 'Delete');
                Route::get('/clients/search', 'Search');
                Route::get('/clients/details', 'Details');
            });
            
            

            ///////////// --------------- Supplier Routes ----------- ///////////////////
            Route::controller(SupplierController::class)->group(function () {
                Route::get('/suppliers', 'ShowAll');
                Route::post('/suppliers', 'Insert');
                Route::get('/suppliers/edit', 'Edit');
                Route::put('/suppliers', 'Update');
                Route::delete('/suppliers', 'Delete');
                Route::get('/suppliers/search', 'Search');
                Route::get('/suppliers/details', 'Details');
            });
        }); // End User Routes



        // *************************************** Permission Routes Start *************************************** //
        Route::prefix('/permission')->group(function () {
            Route::middleware([SuperAdminAccess::class])->group(function () {
                ///////////// --------------- Permission Main Heads Routes ----------- ///////////////////
                Route::controller(PermissionMainHeadController::class)->group(function () {
                    Route::get('/mainhead', 'ShowAll');
                    Route::post('/mainhead', 'Insert');
                    Route::get('/mainhead/edit', 'Edit');
                    Route::put('/mainhead', 'Update');
                    Route::delete('/mainhead', 'Delete');
                    Route::get('/mainhead/search', 'Search');
                    Route::get('/mainhead/get', 'Get')->withoutMiddleware(SuperAdminAccess::class);
                });
                
                
                
                ///////////// --------------- Permission Heads Routes ----------- ///////////////////
                Route::controller(PermissionHeadController::class)->group(function () {
                    Route::get('/', 'ShowAll');
                    Route::post('/', 'Insert');
                    Route::get('/edit', 'Edit');
                    Route::put('/', 'Update');
                    Route::delete('/', 'Delete');
                    Route::get('/search', 'Search');
                    Route::get('/get', 'Get')->withoutMiddleware(SuperAdminAccess::class);
                });
                
                
                
                ///////////// --------------- Route Permission Routes ----------- ///////////////////
                Route::controller(RoutePermissionController::class)->group(function () {
                    Route::get('/routepermissions', 'ShowAll');
                    Route::get('/routepermissions/edit', 'Edit');
                    Route::put('/routepermissions', 'Update');
                    Route::get('/routepermissions/search', 'Search');
                });
            });
            
            
            
            ///////////// --------------- Role Permission Routes ----------- ///////////////////
            Route::controller(RolePermissionController::class)->group(function () {
                Route::get('/rolepermissions', 'ShowAll');
                Route::get('/rolepermissions/edit', 'Edit');
                Route::put('/rolepermissions', 'Update');
                Route::get('/rolepermissions/search', 'Search');
            });



            ///////////// --------------- User Permission Routes ----------- ///////////////////
            Route::controller(UserPermissionController::class)->group(function () {
                Route::get('/userpermissions', 'ShowAll');
                Route::get('/userpermissions/edit', 'Edit');
                Route::put('/userpermissions', 'Update');
                Route::get('/userpermissions/search', 'Search');
                // Copy Permission
                Route::put('/userpermissions/copy', 'Copy');
                Route::get('/userpermissions/from', 'UserFrom');
                Route::get('/userpermissions/to', 'UserTo');
            });
        }); // End Permission Routes



        // *************************************** Bank Controller Start *************************************** //
        Route::controller(BankController::class)->group(function () {
            Route::get('/banks', 'ShowAll');
            Route::post('/banks', 'Insert');
            Route::get('/banks/edit', 'Edit');
            Route::put('/banks', 'Update');
            Route::delete('/banks', 'Delete');
            Route::get('/banks/search', 'Search');
            Route::get('/banks/get', 'Get');
            Route::get('/banks/details', 'Details');
        });



        // *************************************** Location Controller Start *************************************** //
        Route::controller(LocationController::class)->group(function () {
            Route::get('/locations', 'ShowAll');
            Route::post('/locations', 'Insert');
            Route::get('/locations/edit', 'Edit');
            Route::put('/locations', 'Update');
            Route::delete('/locations', 'Delete');
            Route::get('/locations/search', 'Search');
            Route::get('/locations/get', 'Get');
            Route::get('/locations/get/division', 'GetLocationByDivision');
        });
        


        // *************************************** Main Head Routes Start *************************************** //
        Route::controller(MainHeadController::class)->group(function () {
            Route::get('/mainheads', 'ShowAll');
            Route::post('/mainheads', 'Insert');
            Route::get('/mainheads/edit', 'Edit');
            Route::put('/mainheads', 'Update');
            Route::delete('/mainheads', 'Delete');
            Route::get('/mainheads/search', 'Search');
            Route::get('/mainheads/get', 'Get');
        });
        
        

        // *************************************** Store Routes Start *************************************** //
        Route::controller(StoreController::class)->group(function () {
            Route::get('/stores', 'ShowAll');
            Route::post('/stores', 'Insert');
            Route::get('/stores/edit', 'Edit');
            Route::put('/stores', 'Update');
            Route::delete('/stores', 'Delete');
            Route::get('/stores/search', 'Search');
            Route::get('/stores/get', 'Get');
        });
        


        // *************************************** Tranwith Routes Start *************************************** //
        Route::controller(TranWithController::class)->group(function () {
            Route::get('/tranwith', 'ShowAll');
            Route::post('/tranwith', 'Insert');
            Route::get('/tranwith/edit', 'Edit');
            Route::put('/tranwith', 'Update');
            Route::delete('/tranwith', 'Delete');
            Route::get('/tranwith/search', 'Search');
            Route::get('/tranwith/get', 'Get');
        });
        


        // *************************************** TranGroupe Routes Start *************************************** //
        Route::controller(TranGroupController::class)->group(function () {
            Route::get('/trangroupes', 'ShowAll');
            Route::post('/trangroupes', 'Insert');
            Route::get('/trangroupes/edit', 'Edit');
            Route::put('/trangroupes', 'Update');
            Route::delete('/trangroupes', 'Delete');
            Route::get('/trangroupes/search', 'Search');
            Route::get('/trangroupes/get', 'Get');
            Route::get('/trangroupes/get/type', 'GetByType');
        });
        


        // *************************************** TranHead Routes Start *************************************** //
        Route::controller(TranHeadController::class)->group(function () {
            Route::get('/tranheads', 'ShowAll');
            Route::post('/tranheads', 'Insert');
            Route::get('/tranheads/edit', 'Edit');
            Route::put('/tranheads', 'Update');
            Route::delete('/tranheads', 'Delete');
            Route::get('/tranheads/search', 'Search');
            Route::get('/tranheads/get', 'Get');
        });
    });

    /////-----/////-----/////-----/////-----/////-----///// Admin Setup Routes End /////-----/////-----/////-----/////-----/////-----/////





    /////-----/////-----/////-----/////-----/////-----///// Transaction Routes Start /////-----/////-----/////-----/////-----/////-----/////

    Route::prefix('/transaction')->group(function () {
        // *************************************** General Transaction Routes Start *************************************** //
        Route::controller(GeneralTransactionController::class)->group(function () {
            ///////////// --------------- Transaction Receive Routes ----------- ///////////////////
            Route::get('/receive', 'ShowAllReceive');
            Route::post('/receive', 'Insert');
            Route::get('/receive/edit', 'Edit');
            Route::put('/receive', 'Update');
            Route::delete('/receive', 'Delete');
            Route::get('/receive/search', 'Search');



            ///////////// --------------- Transaction Payment Routes ----------- ///////////////////
            Route::get('/payment', 'ShowAllPayment');
            Route::post('/payment', 'Insert');
            Route::get('/payment/edit', 'Edit');
            Route::put('/payment', 'Update');
            Route::delete('/payment', 'Delete');
            Route::get('/payment/search', 'Search');


            // Common Transaction Related Routes
            Route::get('/get/user', 'GetUser');
            Route::get('/get/transactiongrid', 'GetTransactionGrid');
            Route::get('/get/batch', 'GetBatch');
            Route::get('/get/batch/details', 'GetBatchDetails');
            Route::get('/get/product/stock', 'GetProductStock');
        }); // End GeneralTransactionController 



        // *************************************** Bank Transaction Routes Start *************************************** //
        Route::controller(BankTransactionController::class)->group(function () {
            Route::prefix('/bank')->group(function () {
                ///////////// --------------- Bank Withdraw Routes ----------- ///////////////////
                Route::get('/withdraw', 'ShowAllWithdraws');
                Route::post('/withdraw', 'Insert');
                Route::get('/withdraw/edit', 'Edit');
                Route::put('/withdraw', 'Update');
                Route::delete('/withdraw', 'Delete');
                Route::get('/withdraw/search', 'Search');



                ///////////// --------------- Bank Deposit Routes ----------- ///////////////////
                Route::get('/deposit', 'ShowAllDeposits');
                Route::post('/deposit', 'Insert');
                Route::get('/deposit/edit', 'Edit');
                Route::put('/deposit', 'Update');
                Route::delete('/deposit', 'Delete');
                Route::get('/deposit/search', 'Search');
            });
        }); // End BankTransactionController 



        // *************************************** Party Transaction Routes Start *************************************** //
        Route::controller(PartyTransactionController::class)->group(function () {
            Route::prefix('/party')->group(function () {
                ///////////// --------------- Receive From Client Routes ----------- ///////////////////
                Route::get('/receive', 'ShowAllReceive');
                Route::post('/receive', 'Insert');
                Route::get('/receive/edit', 'Edit');
                // Route::put('/receive', 'Update');
                // Route::delete('/receive', 'Delete');
                Route::get('/receive/search', 'Search');


                ///////////// --------------- Payment To Supplier Routes ----------- ///////////////////
                Route::get('/payment', 'ShowAllPayment');
                Route::post('/payment', 'Insert');
                Route::get('/payment/edit', 'Edit');
                // Route::put('/payment', 'Update');
                // Route::delete('/payment', 'Delete');
                Route::get('/payment/search', 'Search');

                // Common Routes
                Route::get('/get/due', 'GetDueList');
            });
        }); // End PartyTransactionController
    }); // End Transaction Routes

    /////-----/////-----/////-----/////-----/////-----///// Transaction Routes End /////-----/////-----/////-----/////-----/////-----/////





    /////-----/////-----/////-----/////-----/////-----///// HR Routes Starts /////-----/////-----/////-----/////-----/////-----/////
    
    Route::prefix('/hr')->group(function () {
        // *************************************** Department Routes Start *************************************** //
        Route::controller(DepartmentController::class)->group(function () {
            Route::get('/departments', 'ShowAll');
            Route::post('/departments', 'Insert');
            Route::get('/departments/edit', 'Edit');
            Route::put('/departments', 'Update');
            Route::delete('/departments', 'Delete');
            Route::get('/departments/search', 'Search');
            Route::get('/department/get', 'Get');
        });



        // *************************************** Designation Routes Start *************************************** //
        Route::controller(DesignationController::class)->group(function () {
            Route::get('/designations', 'ShowAll');
            Route::post('/designations', 'Insert');
            Route::get('/designations/edit', 'Edit');
            Route::put('/designations', 'Update');
            Route::delete('/designations', 'Delete');
            Route::get('/designations/search', 'Search');
            Route::get('/designation/get', 'Get');
        });



        // *************************************** Employee Routes Start *************************************** //
        Route::prefix('/employee')->group(function () {
            ///////////// --------------- All Employeee Routes ----------- ///////////////////
            Route::controller(EmployeeController::class)->group(function () {
                Route::get('/all', 'ShowAll');
                // Route::post('/all', 'Insert');
                // Route::get('/all/edit', 'Edit');
                // Route::put('/all', 'Update');
                Route::delete('/all', 'Delete');
                Route::get('/all/search', 'Search');
                Route::get('/all/details', 'Details');
            });


            
            ///////////// --------------- Employee Personal Details Routes ----------- ///////////////////
            Route::controller(PersonalDetailsController::class)->group(function () {
                Route::get('/personal', 'ShowAll');
                Route::post('/personal', 'Insert');
                Route::get('/personal/edit', 'Edit');
                Route::put('/personal', 'Update');
                Route::delete('/personal', 'Delete');
                Route::get('/personal/search', 'Search');
                Route::get('/personal/details', 'Details');
            });



            ///////////// --------------- Employee Education Details Routes ----------- ///////////////////
            Route::controller(EducationDetailsController::class)->group(function () {
                Route::get('/education', 'ShowAll');
                Route::post('/education', 'Insert');
                Route::get('/education/edit', 'Edit');
                Route::put('/education', 'Update');
                Route::delete('/education', 'Delete');
                Route::get('/education/search', 'Search');
                Route::get('/education/details', 'Details');
                Route::get('/education/grid', 'Grid');
            });



            ///////////// --------------- Employee Training Details Routes ----------- ///////////////////
            Route::controller(TrainingDetailsController::class)->group(function () {
                Route::get('/training', 'ShowAll');
                Route::post('/training', 'Insert');
                Route::get('/training/edit', 'Edit');
                Route::put('/training', 'Update');
                Route::delete('/training', 'Delete');
                Route::get('/training/search', 'Search');
                Route::get('/training/details', 'Details');
                Route::get('/training/grid', 'Grid');
            });



            ///////////// --------------- Employee Experience Details Routes ----------- ///////////////////
            Route::controller(ExperienceDetailsController::class)->group(function () {
                Route::get('/experience', 'ShowAll');
                Route::post('/experience', 'Insert');
                Route::get('/experience/edit', 'Edit');
                Route::put('/experience', 'Update');
                Route::delete('/experience', 'Delete');
                Route::get('/experience/search', 'Search');
                Route::get('/experience/details', 'Details');
                Route::get('/experience/grid', 'Grid');
            });



            ///////////// --------------- Employee Organization Details Routes ----------- ///////////////////
            Route::controller(OrganizationDetailsController::class)->group(function () {
                Route::get('/organization', 'ShowAll');
                Route::post('/organization', 'Insert');
                Route::get('/organization/edit', 'Edit');
                Route::put('/organization', 'Update');
                Route::delete('/organization', 'Delete');
                Route::get('/organization/search', 'Search');
                Route::get('/organization/details', 'Details');
                Route::get('/organization/grid', 'Grid');
            });
            
            
            

            ///////////// --------------- Employee Attendence Details Routes ----------- ///////////////////
            Route::controller(AttendenceController::class)->group(function () {
                Route::get('/attendence', 'ShowAll');
                Route::post('/attendence', 'Insert');
                Route::get('/attendence/edit', 'Edit');
                Route::put('/attendence', 'Update');
                // Route::delete('/attendence', 'Delete');
                Route::get('/attendence/search', 'Search');
            });
        }); // End Hr Employee Routes



        // *************************************** Payroll Routes Start *************************************** //
        Route::prefix('/payroll')->group(function () {
            ///////////// --------------- Payroll Setup Routes ----------- ///////////////////
            Route::controller(PayrollSetupController::class)->group(function () {
                Route::get('/setup', 'ShowAll');
                Route::post('/setup', 'Insert');
                Route::get('/setup/edit', 'Edit');
                Route::put('/setup', 'Update');
                Route::delete('/setup', 'Delete');
                Route::get('/setup/search', 'Search');
            });



            ///////////// --------------- Payroll Middlewire Routes ----------- ///////////////////
            Route::controller(PayrollMiddlewireController::class)->group(function () {
                Route::get('/middlewire', 'ShowAll');
                Route::post('/middlewire', 'Insert');
                Route::get('/middlewire/edit', 'Edit');
                Route::put('/middlewire', 'Update');
                Route::delete('/middlewire', 'Delete');
                Route::get('/middlewire/search', 'Search');
            });



            ///////////// --------------- Payroll Process Routes ----------- ///////////////////
            Route::controller(PayrollProcessController::class)->group(function () {
                Route::get('/process', 'ShowAll');
                Route::post('/process', 'Insert');
                Route::get('/process/edit', 'Edit');
                // Route::put('/process', 'Update');
                // Route::delete('/process', 'Delete');
                Route::get('/process/search', 'Search');
                Route::get('/get', 'Get');
                // Route::get('/get/data', 'GetByDate');
            });
        }); // End HR Payroll Routes



        // *************************************** Hr Report Routes Start *************************************** //
        Route::prefix('/report/salary')->group(function () {
            ///////////// --------------- Salary Summary Report Routes ----------- ///////////////////
            Route::controller(SalarySummaryController::class)->group(function () {
                Route::get('/summary', 'ShowAll');
                Route::get('/summary/search', 'Search');
            });



            ///////////// --------------- Salary Details Report Routes ----------- ///////////////////
            Route::controller(SalaryDetailController::class)->group(function () {
                Route::get('/details', 'ShowAll');
                Route::get('/details/search', 'Search');
            });
        }); // End Hr Report Routes
    }); // HR Routes End 

    /////-----/////-----/////-----/////-----/////-----///// HR Routes End /////-----/////-----/////-----/////-----/////-----/////

    



    /////-----/////-----/////-----/////-----/////-----///// Inventory Routes Start /////-----/////-----/////-----/////-----/////-----/////
    
    Route::prefix('/inventory')->group(function () {
        // *************************************** Inventory Setup Routes Start *************************************** //
        Route::prefix('/setup')->group(function () {
            ///////////// --------------- Inventory Manufacturer Routes ----------- ///////////////////
            Route::controller(InventoryManufacturerController::class)->group(function () {
                Route::get('/manufacturer', 'ShowAll');
                Route::post('/manufacturer', 'Insert');
                Route::get('/manufacturer/edit', 'Edit');
                Route::put('/manufacturer', 'Update');
                Route::delete('/manufacturer', 'Delete');
                Route::get('/manufacturer/search', 'Search');
                Route::get('/manufacturer/get',  'Get');
            });
    
    

            ///////////// --------------- Inventory Category Routes ----------- ///////////////////
            Route::controller(InventoryCategoryController::class)->group(function () {
                Route::get('/category', 'ShowAll');
                Route::post('/category', 'Insert');
                Route::get('/category/edit', 'Edit');
                Route::put('/category', 'Update');
                Route::delete('/category', 'Delete');
                Route::get('/category/search', 'Search');
                Route::get('/category/get', 'Get');
            });
    
    

            ///////////// --------------- Inventory Unit Routes ----------- ///////////////////
            Route::controller(InventoryUnitController::class)->group(function () {
                Route::get('/unit', 'ShowAll');
                Route::post('/unit', 'Insert');
                Route::get('/unit/edit', 'Edit');
                Route::put('/unit', 'Update');
                Route::delete('/unit', 'Delete');
                Route::get('/unit/search', 'Search');
                Route::get('/unit/get', 'Get');
            });
    
    

            ///////////// --------------- Inventory Form Routes ----------- ///////////////////
            Route::controller(InventoryFormController::class)->group(function () {
                Route::get('/form', 'ShowAll');
                Route::post('/form', 'Insert');
                Route::get('/form/edit', 'Edit');
                Route::put('/form', 'Update');
                Route::delete('/form', 'Delete');
                Route::get('/form/search', 'Search');
                Route::get('/form/get', 'Get');
            });
    
    

            ///////////// --------------- Inventory Products Routes ----------- ///////////////////
            Route::controller(InventoryProductsController::class)->group(function () {
                Route::get('/product', 'ShowAll');
                Route::post('/product', 'Insert');
                Route::get('/product/edit', 'Edit');
                Route::put('/product', 'Update');
                Route::delete('/product', 'Delete');
                Route::get('/product/search', 'Search');
                Route::get('/product/get', 'Get');
                Route::get('/product/get/list', 'GetProductList');
            });
        }); // End Inventory Setup Routes



        // *************************************** Inventory Transaction Routes Start *************************************** //
        Route::prefix('/transaction')->group(function () {
            ///////////// --------------- Inventory Purchase Routes ----------- ///////////////////
            Route::controller(InventoryPurchaseController::class)->group(function () {
                Route::get('/purchase', 'ShowAll');
                Route::post('/purchase', 'Insert');
                Route::get('/purchase/edit', 'Edit');
                Route::put('/purchase', 'Update');
                Route::delete('/purchase', 'Delete');
                Route::get('/purchase/search', 'Search');
                Route::delete('/purchase/verify', 'Verify');
            });



            ///////////// --------------- Inventory Issue Routes ----------- ///////////////////
            Route::controller(InventoryIssueController::class)->group(function () {
                Route::get('/issue', 'ShowAll');
                Route::post('/issue', 'Insert');
                Route::get('/issue/edit', 'Edit');
                Route::put('/issue', 'Update');
                Route::delete('/issue', 'Delete');
                Route::get('/issue/search', 'Search');
            });


            
            ///////////// --------------- Inventory Return Routes ----------- ///////////////////
            Route::prefix('/return')->group(function () {
                // *************** Inventory Supplier Return Routes *************** //
                Route::controller(InventorySupplierReturnController::class)->group(function () {
                    Route::get('/supplier', 'ShowAll');
                    Route::post('/supplier', 'Insert');
                    // Route::get('/supplier/edit', 'Edit');
                    // Route::put('/supplier', 'Update');
                    Route::delete('/supplier', 'Delete');
                    Route::get('/supplier/search', 'Search');
                });
                
                
                
                // *************** Inventory Client Return Routes *************** //
                Route::controller(InventoryClientReturnController::class)->group(function () {
                    Route::get('/client', 'ShowAll');
                    Route::post('/client', 'Insert');
                    // Route::get('/client/edit', 'Edit');
                    // Route::put('/client', 'Update');
                    Route::delete('/client', 'Delete');
                    Route::get('/client/search', 'Search');
                });
            }); // End Inventory Transaction Return Routes
        }); // End Inventory Transaction Routes



        // *************************************** Inventory Adjustment Routes Start *************************************** //
        Route::prefix('/adjustment')->group(function () {
            Route::controller(InventoryAdjustmentController::class)->group(function () {
                ///////////// --------------- Inventory Positive Adjustment Routes ----------- ///////////////////
                Route::get('/positive', 'ShowAllPositive');
                Route::post('/positive', 'Insert');
                Route::get('/positive/edit', 'Edit');
                Route::put('/positive', 'Update');
                Route::delete('/positive', 'Delete');
                Route::get('/positive/search', 'Search');



                ///////////// --------------- Inventory Negative Adjustment Routes ----------- ///////////////////
                Route::get('/negative', 'ShowAllNegative');
                Route::post('/negative', 'Insert');
                Route::get('/negative/edit', 'Edit');
                Route::put('/negative', 'Update');
                Route::delete('/negative', 'Delete');
                Route::get('/negative/search', 'Search');
            });
        }); // End Inventory Adjustment Routes



        // *************************************** Inventory Report Routes Start *************************************** //
        Route::prefix('/report')->group(function () {
            ///////////// --------------- Inventory Item Flow Statement Routes ----------- ///////////////////
            Route::controller(InventoryItemFlowStatementController::class)->group(function () {
                Route::get('/item/flow', 'ShowAll');
                Route::get('/item/flow/search', 'Search');
            });
    
    

            ///////////// --------------- Inventory Purchase Statement Routes ----------- ///////////////////
            Route::prefix('/purchase')->group(function () {
                // *************** Inventory Purchase Summary Statement Routes *************** //
                Route::controller(InventoryPurchaseSummaryController::class)->group(function () {
                    Route::get('/summary', 'ShowAll');
                    Route::get('/summary/search', 'Search');
                });
                
                
                
                // *************** Inventory Purchase Detail Statement Routes *************** //
                Route::controller(InventoryPurchaseDetailController::class)->group(function () {
                    Route::get('/details', 'ShowAll');
                    Route::get('/details/search', 'Search');
                });
            });


            
            ///////////// --------------- Inventory Issue Statement Routes ----------- ///////////////////
            Route::prefix('/issue')->group(function () {
                // *************** Inventory Issue Summary Statement Routes *************** //
                Route::controller(InventoryIssueSummaryController::class)->group(function () {
                    Route::get('/summary', 'ShowAll');
                    Route::get('/summary/search', 'Search');
                });
                
                
                
                // *************** Inventory Issue Detail Statement Routes *************** //
                Route::controller(InventoryIssueDetailController::class)->group(function () {
                    Route::get('/details', 'ShowAll');
                    Route::get('/details/search', 'Search');
                });
            });



            ///////////// --------------- Inventory Return Statement Routes ----------- ///////////////////
            Route::prefix('/return')->group(function () {
                // *************** Inventory Client Return Summary Statement Routes *************** //
                Route::controller(InventoryClientReturnSummaryController::class)->group(function () {
                    Route::get('/client/summary', 'ShowAll');
                    Route::get('/client/summary/search', 'Search');
                });
                
                
                
                // *************** Inventory Client Return Detail Statement Routes *************** //
                Route::controller(InventoryClientReturnDetailController::class)->group(function () {
                    Route::get('/client/details', 'ShowAll');
                    Route::get('/client/details/search', 'Search');
                });



                // *************** Inventory Supplier Return Summary Statement Routes *************** //
                Route::controller(InventorySupplierReturnSummaryController::class)->group(function () {
                    Route::get('/supplier/summary', 'ShowAll');
                    Route::get('/supplier/summary/search', 'Search');
                });
                
                
                
                // *************** Inventory Supplier Return Detail Statement Routes *************** //
                Route::controller(InventorySupplierReturnDetailController::class)->group(function () {
                    Route::get('/supplier/details', 'ShowAll');
                    Route::get('/supplier/details/search', 'Search');
                });
            });



            ///////////// --------------- Inventory Stock Statement Routes ----------- ///////////////////
            Route::prefix('/stock')->group(function () {
                // *************** Inventory Stock Summary Statement Routes *************** //
                Route::controller(InventoryStockSummaryController::class)->group(function () {
                    Route::get('/summary', 'ShowAll');
                    Route::get('/summary/search', 'Search');
                });
                
                
                
                // *************** Inventory Stock Detail Statement Routes *************** //
                Route::controller(InventoryStockDetailController::class)->group(function () {
                    Route::get('/details', 'ShowAll');
                    Route::get('/details/search', 'Search');
                });
            });



            ///////////// --------------- Inventory Profitability Statement Routes ----------- ///////////////////
            Route::controller(InventoryProfitabilityStatementController::class)->group(function () {
                Route::get('/profitability/statement', 'ShowAll');
                Route::get('/profitability/statement/search', 'Search');
            });



            ///////////// --------------- Inventory Expiry Statement Routes ----------- ///////////////////
            Route::controller(InventoryExpiryStatementController::class)->group(function () {
                Route::get('/expiry/statement', 'ShowAll');
                Route::get('/expiry/statement/search', 'Search');
            });
        }); // End Inventory Report Routes
    }); // End Inventory Routes

    /////-----/////-----/////-----/////-----/////-----///// Inventory Routes End /////-----/////-----/////-----/////-----/////-----/////
    
    



    /////-----/////-----/////-----/////-----/////-----///// Pharmacy Routes Start /////-----/////-----/////-----/////-----/////-----/////
    
    Route::prefix('/pharmacy')->group(function () {
        // *************************************** Pharmacy Setup Routes Start *************************************** //
        Route::prefix('/setup')->group(function () {
            ///////////// --------------- Pharmacy Manufacturer Routes ----------- ///////////////////
            Route::controller(PharmacyManufacturerController::class)->group(function () {
                Route::get('/manufacturer', 'ShowAll');
                Route::post('/manufacturer', 'Insert');
                Route::get('/manufacturer/edit', 'Edit');
                Route::put('/manufacturer', 'Update');
                Route::delete('/manufacturer', 'Delete');
                Route::get('/manufacturer/search', 'Search');
                Route::get('/manufacturer/get', 'Get');
            });
    
    
            
            ///////////// --------------- Pharmacy Category Routes ----------- ///////////////////
            Route::controller(PharmacyCategoryController::class)->group(function () {
                Route::get('/category', 'ShowAll');
                Route::post('/category', 'Insert');
                Route::get('/category/edit', 'Edit');
                Route::put('/category', 'Update');
                Route::delete('/category', 'Delete');
                Route::get('/category/search', 'Search');
                Route::get('/category/get', 'Get');
            });
    
    

            ///////////// --------------- Pharmacy Unit Routes ----------- ///////////////////
            Route::controller(PharmacyUnitController::class)->group(function () {
                Route::get('/unit', 'ShowAll');
                Route::post('/unit', 'Insert');
                Route::get('/unit/edit', 'Edit');
                Route::put('/unit', 'Update');
                Route::delete('/unit', 'Delete');
                Route::get('/unit/search', 'Search');
                Route::get('/unit/get', 'Get');
            });
    
    

            ///////////// --------------- Pharmacy Form Routes ----------- ///////////////////
            Route::controller(PharmacyFormController::class)->group(function () {
                Route::get('/form', 'ShowAll');
                Route::post('/form', 'Insert');
                Route::get('/form/edit', 'Edit');
                Route::put('/form', 'Update');
                Route::delete('/form', 'Delete');
                Route::get('/form/search', 'Search');
                Route::get('/form/get', 'Get');
            });
    
    

            ///////////// --------------- Pharmacy Products Routes ----------- ///////////////////
            Route::controller(PharmacyProductsController::class)->group(function () {
                Route::get('/product', 'ShowAll');
                Route::post('/product', 'Insert');
                Route::get('/product/edit', 'Edit');
                Route::put('/product', 'Update');
                Route::delete('/product', 'Delete');
                Route::get('/product/search', 'Search');
                Route::get('/product/get', 'Get');
                Route::get('/product/get/list', 'GetProductList');
            });
        }); // End Pharmacy Setup Routes



        // *************************************** Pharmacy Transaction Routes Start *************************************** //
        Route::prefix('/transaction')->group(function () {
            ///////////// --------------- Pharmacy Purchase Routes ----------- ///////////////////
            Route::controller(PharmacyPurchaseController::class)->group(function () {
                Route::get('/purchase', 'ShowAll');
                Route::post('/purchase', 'Insert');
                Route::get('/purchase/edit', 'Edit');
                Route::put('/purchase', 'Update');
                Route::delete('/purchase', 'Delete');
                Route::get('/purchase/search', 'Search');
                Route::delete('/purchase/verify', 'Verify');
            });



            ///////////// --------------- Pharmacy Issue Routes ----------- ///////////////////
            Route::controller(PharmacyIssueController::class)->group(function () {
                Route::get('/issue', 'ShowAll');
                Route::post('/issue', 'Insert');
                Route::get('/issue/edit', 'Edit');
                Route::put('/issue', 'Update');
                Route::delete('/issue', 'Delete');
                Route::get('/issue/search', 'Search');
            });


            
            ///////////// --------------- Pharmacy Return Routes ----------- ///////////////////
            Route::prefix('/return')->group(function () {
                // *************** Pharmacy Supplier Return Routes *************** //
                Route::controller(PharmacySupplierReturnController::class)->group(function () {
                    Route::get('/supplier', 'ShowAll');
                    Route::post('/supplier', 'Insert');
                    Route::get('/supplier/edit', 'Edit');
                    Route::put('/supplier', 'Update');
                    Route::delete('/supplier', 'Delete');
                    Route::get('/supplier/search', 'Search');
                });
                
                
                
                // *************** Pharmacy Client Return Routes *************** //
                Route::controller(PharmacyClientReturnController::class)->group(function () {
                    Route::get('/client', 'ShowAll');
                    Route::post('/client', 'Insert');
                    Route::get('/client/edit', 'Edit');
                    Route::put('/client', 'Update');
                    Route::delete('/client', 'Delete');
                    Route::get('/client/search', 'Search');
                });
            }); // End Pharmacy Transaction Return Routes
        }); // End Pharmacy Transaction Routes



        // *************************************** Pharmacy Adjustment Routes Start *************************************** //
        Route::prefix('/adjustment')->group(function () {
            Route::controller(PharmacyAdjustmentController::class)->group(function () {
                ///////////// --------------- Pharmacy Positive Adjustment Routes ----------- ///////////////////
                Route::get('/positive', 'ShowAllPositive');
                Route::post('/positive', 'Insert');
                Route::get('/positive/edit', 'Edit');
                Route::put('/positive', 'Update');
                Route::delete('/positive', 'Delete');
                Route::get('/positive/search', 'Search');



                ///////////// --------------- Pharmacy Negative Adjustment Routes ----------- ///////////////////
                Route::get('/negative', 'ShowAllNegative');
                Route::post('/negative', 'Insert');
                Route::get('/negative/edit', 'Edit');
                Route::put('/negative', 'Update');
                Route::delete('/negative', 'Delete');
                Route::get('/negative/search', 'Search');
            });
        }); // End Pharmacy Adjustment Routes



        // *************************************** Pharmacy Report Routes Start *************************************** //
        Route::prefix('/report')->group(function () {
            ///////////// --------------- Pharmacy Item Flow Statement Routes ----------- ///////////////////
            Route::controller(PharmacyItemFlowStatementController::class)->group(function () {
                Route::get('/item/flow', 'ShowAll');
                Route::get('/item/flow/search', 'Search');
            });
    


            ///////////// --------------- Pharmacy Purchase Statement Routes ----------- ///////////////////
            Route::prefix('/purchase')->group(function () {
                // *************** Pharmacy Purchase Summary Statement Routes *************** //
                Route::controller(PharmacyPurchaseSummaryController::class)->group(function () {
                    Route::get('/summary', 'ShowAll');
                    Route::get('/summary/search', 'Search');
                });
                
                
                
                // *************** Pharmacy Purchase Detail Statement Routes *************** //
                Route::controller(PharmacyPurchaseDetailController::class)->group(function () {
                    Route::get('/details', 'ShowAll');
                    Route::get('/details/search', 'Search');
                });
            });


            
            ///////////// --------------- Pharmacy Issue Statement Routes ----------- ///////////////////
            Route::prefix('/issue')->group(function () {
                // *************** Pharmacy Issue Summary Statement Routes *************** //
                Route::controller(PharmacyIssueSummaryController::class)->group(function () {
                    Route::get('/summary', 'ShowAll');
                    Route::get('/summary/search', 'Search');
                });
                
                
                
                // *************** Pharmacy Issue Detail Statement Routes *************** //
                Route::controller(PharmacyIssueDetailController::class)->group(function () {
                    Route::get('/details', 'ShowAll');
                    Route::get('/details/search', 'Search');
                });
            });



            ///////////// --------------- Pharmacy Return Statement Routes ----------- ///////////////////
            Route::prefix('/return')->group(function () {
                // *************** Pharmacy Client Return Summary Statement Routes *************** //
                Route::controller(PharmacyClientReturnSummaryController::class)->group(function () {
                    Route::get('/client/summary', 'ShowAll');
                    Route::get('/client/summary/search', 'Search');
                });
                
                
                
                // *************** Pharmacy Client Return Detail Statement Routes *************** //
                Route::controller(PharmacyClientReturnDetailController::class)->group(function () {
                    Route::get('/client/details', 'ShowAll');
                    Route::get('/client/details/search', 'Search');
                });



                // *************** Pharmacy Supplier Return Summary Statement Routes *************** //
                Route::controller(PharmacySupplierReturnSummaryController::class)->group(function () {
                    Route::get('/supplier/summary', 'ShowAll');
                    Route::get('/supplier/summary/search', 'Search');
                });
                
                
                
                // *************** Pharmacy Supplier Return Detail Statement Routes *************** //
                Route::controller(PharmacySupplierReturnDetailController::class)->group(function () {
                    Route::get('/supplier/details', 'ShowAll');
                    Route::get('/supplier/details/search', 'Search');
                });
            });



            ///////////// --------------- Pharmacy Stock Statement Routes ----------- ///////////////////
            Route::prefix('/stock')->group(function () {
                // *************** Pharmacy Stock Summary Statement Routes *************** //
                Route::controller(PharmacyStockSummaryController::class)->group(function () {
                    Route::get('/summary', 'ShowAll');
                    Route::get('/summary/search', 'Search');
                });
                
                
                
                // *************** Pharmacy Stock Detail Statement Routes *************** //
                Route::controller(PharmacyStockDetailController::class)->group(function () {
                    Route::get('/details', 'ShowAll');
                    Route::get('/details/search', 'Search');
                });
            });



            ///////////// --------------- Pharmacy Profitability Statement Routes ----------- ///////////////////
            Route::controller(PharmacyProfitabilityStatementController::class)->group(function () {
                Route::get('/profitability/statement', 'ShowAll');
                Route::get('/profitability/statement/search', 'Search');
            });



            ///////////// --------------- Pharmacy Expiry Statement Routes ----------- ///////////////////
            Route::controller(PharmacyExpiryStatementController::class)->group(function () {
                Route::get('/expiry/statement', 'ShowAll');
                Route::get('/expiry/statement/search', 'Search');
            });
        }); // End Pharmacy Report Routes
    }); // End Pharmacy Routes

    /////-----/////-----/////-----/////-----/////-----///// Pharmacy Routes End /////-----/////-----/////-----/////-----/////-----/////
    
    
    
    
    
    /////-----/////-----/////-----/////-----/////-----///// Report Routes Start /////-----/////-----/////-----/////-----/////-----/////
    
    Route::prefix('/report')->group(function () {
        // *************************************** Account Statement Routes Start *************************************** //
        Route::prefix('/account')->group(function () {
            ///////////// --------------- Account Summary Statement Routes ----------- ///////////////////
            Route::controller(AccountSummaryController::class)->group(function () {
                Route::get('/summary', 'ShowAll');
                Route::get('/summary/search', 'Search');
            });
            
            
            
            ///////////// --------------- Account Summary(By Groupe) Statement Routes ----------- ///////////////////
            Route::controller(AccountSummaryByGroupController::class)->group(function () {
                Route::get('/summarygroupe', 'ShowAll');
                Route::get('/summarygroupe/search', 'Search');
            });
            
            
            
            ///////////// --------------- Account Details Statement Routes ----------- ///////////////////
            Route::controller(AccountDetailsController::class)->group(function () {
                Route::get('/details', 'ShowAll');
                Route::get('/details/search', 'Search');
            });
        }); // End Account Statement Routes
        
        
        
        // *************************************** Party Statement Routes Start *************************************** //
        Route::prefix('/party')->group(function () {
            ///////////// --------------- Party Summary Statement Routes ----------- ///////////////////
            Route::controller(PartySummaryController::class)->group(function () {
                Route::get('/summary', 'ShowAll');
                Route::get('/summary/search', 'Search');
            });
            
            
            
            ///////////// --------------- Party Detail Statement Routes ----------- ///////////////////
            Route::controller(PartyDetailsController::class)->group(function () {
                Route::get('/details', 'ShowAll');
                Route::get('/details/search', 'Search');
            });
        }); // End Party Statement Routes
        
        
        
        // *************************************** Balancesheet Routes Start *************************************** //
        Route::prefix('/balancesheet')->group(function () {
            ///////////// --------------- Balancesheet Summary Report Routes ----------- ///////////////////
            Route::controller(BalanceSheetSummaryController::class)->group(function () {
                Route::get('/summary', 'ShowAll');
                Route::get('/summary/search', 'Search');
            });
            
            
            
            ///////////// --------------- Balancesheet Detail Report Routes ----------- ///////////////////
            Route::controller(BalanceSheetDetailsController::class)->group(function () {
                Route::get('/details', 'ShowAll');
                Route::get('/details/search', 'Search');
            });
        }); // End Balancesheet Statement Routes



        // *************************************** Report By Groupe Routes Start *************************************** //
        Route::controller(ReportsByGroupController::class)->group(function () {
            Route::get('/groupe', 'ShowAll');
            Route::get('/groupe/search', 'Search');
        });



        // *************************************** Summary Report Routes Start *************************************** //
        Route::controller(ReportsBySummaryController::class)->group(function () {
            Route::get('/summary', 'ShowAll');
            Route::get('/summary/search', 'Search');
        });
    }); // End Report Routes 
    
    /////-----/////-----/////-----/////-----/////-----///// Report Routes End /////-----/////-----/////-----/////-----/////-----/////
});

Route::get('/get/invoice', [GeneralTransactionController::class, 'Invoice'])->middleware('web');
