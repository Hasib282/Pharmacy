<?php

return [
    // ----------------------------- Administrator Menu Permissions ----------------------------- //
    1 => [ 
        ['uri' => 'api/admin/users/admins', 'method' => 'GET'],
        ['uri' => 'api/admin/users/admins/search', 'method' => 'GET'],
        ['uri' => 'api/admin/users/admins/details', 'method' => 'GET'],
        ['uri' => 'admin/users/admins', 'method' => 'GET'],
        ['uri' => 'admin/users/admins/search', 'method' => 'GET'],
    ],
    2 => [
        ['uri' => 'api/admin/users/admins', 'method' => 'POST'],
    ],
    3 => [
        ['uri' => 'api/admin/users/admins/edit', 'method' => 'GET'],
        ['uri' => 'api/admin/users/admins', 'method' => 'PUT'],
    ],
    4 => [
        ['uri' => 'api/admin/users/admins/delete', 'method' => 'DELETE'],
    ],
    5 => [
        ['uri' => 'api/admin/permission/userpermissions', 'method' => 'GET'],
        ['uri' => 'api/admin/permission/userpermissions/search', 'method' => 'GET'],
        ['uri' => 'admin/permission/userpermissions', 'method' => 'GET'],
        ['uri' => 'admin/permission/userpermissions/search', 'method' => 'GET'],
    ],
    6 => [
        ['uri' => 'api/admin/permission/userpermissions/edit', 'method' => 'GET'],
        ['uri' => 'api/admin/permission/userpermissions', 'method' => 'PUT'],
        ['uri' => 'api/admin/permission/userpermissions/copy', 'method' => 'PUT'],
        ['uri' => 'api/admin/permission/userpermissions/from', 'method' => 'GET'],
        ['uri' => 'api/admin/permission/userpermissions/to', 'method' => 'GET'],
    ],
    7 => [
        ['uri' => 'api/admin/banks', 'method' => 'GET'],
        ['uri' => 'api/admin/banks/search', 'method' => 'GET'],
        ['uri' => 'api/admin/banks/details', 'method' => 'GET'],
        ['uri' => 'admin/banks', 'method' => 'GET'],
        ['uri' => 'admin/banks/search', 'method' => 'GET'],
    ],
    8 => [
        ['uri' => 'api/admin/locations', 'method' => 'GET'],
        ['uri' => 'api/admin/locations/search', 'method' => 'GET'],
        ['uri' => 'admin/locations', 'method' => 'GET'],
        ['uri' => 'admin/locations/search', 'method' => 'GET'],
    ],
    9 => [
        ['uri' => 'api/admin/stores', 'method' => 'GET'],
        ['uri' => 'api/admin/stores/search', 'method' => 'GET'],
        ['uri' => 'admin/stores', 'method' => 'GET'],
        ['uri' => 'admin/stores/search', 'method' => 'GET'],
    ],
    10 => [
        ['uri' => 'api/admin/stores', 'method' => 'POST'],
    ],
    11 => [
        ['uri' => 'api/admin/stores/edit', 'method' => 'GET'],
        ['uri' => 'api/admin/stores', 'method' => 'PUT'],
    ],
    12 => [
        ['uri' => 'api/admin/stores/delete', 'method' => 'DELETE'],
    ],





    // ----------------------------- General Transaction Menu Permissions ----------------------------- //
    // SETUP
    13 => [
        ['uri' => 'api/transaction/setup/groupes', 'method' => 'GET'],
        ['uri' => 'api/transaction/setup/groupes/search', 'method' => 'GET'],
        ['uri' => 'transaction/setup/groupes', 'method' => 'GET'],
        ['uri' => 'transaction/setup/groupes/search', 'method' => 'GET'],
    ],
    14 => [
        ['uri' => 'api/transaction/setup/groupes', 'method' => 'POST'],
    ],
    15 => [
        ['uri' => 'api/transaction/setup/groupes/edit', 'method' => 'GET'],
        ['uri' => 'api/transaction/setup/groupes', 'method' => 'PUT'],
    ],
    16 => [
        ['uri' => 'api/transaction/setup/groupes/delete', 'method' => 'DELETE'],
    ],
    17 => [
        ['uri' => 'api/transaction/setup/heads', 'method' => 'GET'],
        ['uri' => 'api/transaction/setup/heads/search', 'method' => 'GET'],
        ['uri' => 'transaction/setup/heads', 'method' => 'GET'],
        ['uri' => 'transaction/setup/heads/search', 'method' => 'GET'],
    ],
    18 => [
        ['uri' => 'api/transaction/setup/heads', 'method' => 'POST'],
    ],
    19 => [
        ['uri' => 'api/transaction/setup/heads/edit', 'method' => 'GET'],
        ['uri' => 'api/transaction/setup/heads', 'method' => 'PUT'],
    ],
    20 => [
        ['uri' => 'api/transaction/setup/heads/delete', 'method' => 'DELETE'],
    ],



    // USERS
    21 => [
        ['uri' => 'api/transaction/users/usertype', 'method' => 'GET'],
        ['uri' => 'api/transaction/users/usertype/search', 'method' => 'GET'],
        ['uri' => 'transaction/users/usertype', 'method' => 'GET'],
        ['uri' => 'transaction/users/usertype/search', 'method' => 'GET'],
    ],
    22 => [
        ['uri' => 'api/transaction/users/usertype', 'method' => 'POST'],
    ],
    23 => [
        ['uri' => 'api/transaction/users/usertype/edit', 'method' => 'GET'],
        ['uri' => 'api/transaction/users/usertype', 'method' => 'PUT'],
    ],
    24 => [
        ['uri' => 'api/transaction/users/usertype/delete', 'method' => 'DELETE'],
    ],
    25 => [
        ['uri' => 'api/transaction/users/clients', 'method' => 'GET'],
        ['uri' => 'api/transaction/users/clients/search', 'method' => 'GET'],
        ['uri' => 'api/transaction/users/clients/details', 'method' => 'GET'],
        ['uri' => 'transaction/users/clients', 'method' => 'GET'],
        ['uri' => 'transaction/users/clients/search', 'method' => 'GET'],
    ],
    26 => [
        ['uri' => 'api/transaction/users/clients', 'method' => 'POST'],
    ],
    27 => [
        ['uri' => 'api/transaction/users/clients/edit', 'method' => 'GET'],
        ['uri' => 'api/transaction/users/clients', 'method' => 'PUT'],
    ],
    28 => [
        ['uri' => 'api/transaction/users/clients/delete', 'method' => 'DELETE'],
    ],
    29 => [
        ['uri' => 'api/transaction/users/suppliers', 'method' => 'GET'],
        ['uri' => 'api/transaction/users/suppliers/search', 'method' => 'GET'],
        ['uri' => 'api/transaction/users/suppliers/details', 'method' => 'GET'],
        ['uri' => 'transaction/users/suppliers', 'method' => 'GET'],
        ['uri' => 'transaction/users/suppliers/search', 'method' => 'GET'],
    ],
    30 => [
        ['uri' => 'api/transaction/users/suppliers', 'method' => 'POST'],
    ],
    31 => [
        ['uri' => 'api/transaction/users/suppliers/edit', 'method' => 'GET'],
        ['uri' => 'api/transaction/users/suppliers', 'method' => 'PUT'],
    ],
    32 => [
        ['uri' => 'api/transaction/users/suppliers/delete', 'method' => 'DELETE'],
    ],




    // Transactions
    33 => [
        ['uri' => 'api/transaction/receive', 'method' => 'GET'],
        ['uri' => 'api/transaction/receive/search', 'method' => 'GET'],
        ['uri' => 'transaction/receive', 'method' => 'GET'],
        ['uri' => 'transaction/receive/search', 'method' => 'GET'],
    ],
    34 => [
        ['uri' => 'api/transaction/receive', 'method' => 'POST'],
    ],
    35 => [
        ['uri' => 'api/transaction/receive/edit', 'method' => 'GET'],
        ['uri' => 'api/transaction/receive', 'method' => 'PUT'],
    ],
    36 => [
        ['uri' => 'api/transaction/receive/delete', 'method' => 'DELETE'],
    ],
    37 => [
        ['uri' => 'api/transaction/payment', 'method' => 'GET'],
        ['uri' => 'api/transaction/payment/search', 'method' => 'GET'],
        ['uri' => 'transaction/payment', 'method' => 'GET'],
        ['uri' => 'transaction/payment/search', 'method' => 'GET'],
    ],
    38 => [
        ['uri' => 'api/transaction/payment', 'method' => 'POST'],
    ],
    39 => [
        ['uri' => 'api/transaction/payment/edit', 'method' => 'GET'],
        ['uri' => 'api/transaction/payment', 'method' => 'PUT'],
    ],
    40 => [
        ['uri' => 'api/transaction/payment/delete', 'method' => 'DELETE'],
    ],




    // Party Payment
    41 => [
        ['uri' => 'api/transaction/party/receive', 'method' => 'GET'],
        ['uri' => 'api/transaction/party/receive/search', 'method' => 'GET'],
        ['uri' => 'transaction/party/receive', 'method' => 'GET'],
        ['uri' => 'transaction/party/receive/search', 'method' => 'GET'],
    ],
    42 => [
        ['uri' => 'api/transaction/party/receive', 'method' => 'POST'],
    ],
    43 => [
        ['uri' => 'api/transaction/party/receive/edit', 'method' => 'GET'],
        ['uri' => 'api/transaction/party/receive', 'method' => 'PUT'],
    ],
    44 => [
        ['uri' => 'api/transaction/party/receive/delete', 'method' => 'DELETE'],
    ],
    45 => [
        ['uri' => 'api/transaction/party/payment', 'method' => 'GET'],
        ['uri' => 'api/transaction/party/payment/search', 'method' => 'GET'],
        ['uri' => 'transaction/party/payment', 'method' => 'GET'],
        ['uri' => 'transaction/party/payment/search', 'method' => 'GET'],
    ],
    46 => [
        ['uri' => 'api/transaction/party/payment', 'method' => 'POST'],
    ],
    47 => [
        ['uri' => 'api/transaction/party/payment/edit', 'method' => 'GET'],
        ['uri' => 'api/transaction/party/payment', 'method' => 'PUT'],
    ],
    48 => [
        ['uri' => 'api/transaction/party/payment/delete', 'method' => 'DELETE'],
    ],







    // ----------------------------- Bank Transaction Menu Permissions ----------------------------- //
    49 => [
        ['uri' => 'api/transaction/bank/deposit', 'method' => 'GET'],
        ['uri' => 'api/transaction/bank/deposit/search', 'method' => 'GET'],
        ['uri' => 'transaction/bank/deposit', 'method' => 'GET'],
        ['uri' => 'transaction/bank/deposit/search', 'method' => 'GET'],
    ],
    50 => [
        ['uri' => 'api/transaction/bank/deposit', 'method' => 'POST'],
    ],
    51 => [
        ['uri' => 'api/transaction/bank/deposit/edit', 'method' => 'GET'],
        ['uri' => 'api/transaction/bank/deposit', 'method' => 'PUT'],
    ],
    52 => [
        ['uri' => 'api/transaction/bank/deposit/delete', 'method' => 'DELETE'],
    ],
    53 => [
        ['uri' => 'api/transaction/bank/withdraw', 'method' => 'GET'],
        ['uri' => 'api/transaction/bank/withdraw/search', 'method' => 'GET'],
        ['uri' => 'transaction/bank/withdraw', 'method' => 'GET'],
        ['uri' => 'transaction/bank/withdraw/search', 'method' => 'GET'],
    ],
    54 => [
        ['uri' => 'api/transaction/bank/withdraw', 'method' => 'POST'],
    ],
    55 => [
        ['uri' => 'api/transaction/bank/withdraw/edit', 'method' => 'GET'],
        ['uri' => 'api/transaction/bank/withdraw', 'method' => 'PUT'],
    ],
    56 => [
        ['uri' => 'api/transaction/bank/withdraw/delete', 'method' => 'DELETE'],
    ],






    // ----------------------------- HR & Payroll Menu Permissions ----------------------------- //
    // SETUP
    57 => [
        ['uri' => 'api/hr/setup/departments', 'method' => 'GET'],
        ['uri' => 'api/hr/setup/departments/search', 'method' => 'GET'],
        ['uri' => 'hr/setup/departments', 'method' => 'GET'],
        ['uri' => 'hr/setup/departments/search', 'method' => 'GET'],
    ],
    58 => [
        ['uri' => 'api/hr/setup/departments', 'method' => 'POST'],
    ],
    59 => [
        ['uri' => 'api/hr/setup/departments/edit', 'method' => 'GET'],
        ['uri' => 'api/hr/setup/departments', 'method' => 'PUT'],
    ],
    60 => [
        ['uri' => 'api/hr/setup/departments/delete', 'method' => 'DELETE'],
    ],
    61 => [
        ['uri' => 'api/hr/setup/designations', 'method' => 'GET'],
        ['uri' => 'api/hr/setup/designations/search', 'method' => 'GET'],
        ['uri' => 'hr/setup/designations', 'method' => 'GET'],
        ['uri' => 'hr/setup/designations/search', 'method' => 'GET'],
    ],
    62 => [
        ['uri' => 'api/hr/setup/designations', 'method' => 'POST'],
    ],
    63 => [
        ['uri' => 'api/hr/setup/designations/edit', 'method' => 'GET'],
        ['uri' => 'api/hr/setup/designations', 'method' => 'PUT'],
    ],
    64 => [
        ['uri' => 'api/hr/setup/designations/delete', 'method' => 'DELETE'],
    ],




    // USERS / EMPLOYEE
    65 => [
        ['uri' => 'api/hr/employee/usertype', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/usertype/search', 'method' => 'GET'],
        ['uri' => 'hr/employee/usertype', 'method' => 'GET'],
        ['uri' => 'hr/employee/usertype/search', 'method' => 'GET'],
    ],
    66 => [
        ['uri' => 'api/hr/employee/usertype', 'method' => 'POST'],
    ],
    67 => [
        ['uri' => 'api/hr/employee/usertype/edit', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/usertype', 'method' => 'PUT'],
    ],
    68 => [
        ['uri' => 'api/hr/employee/usertype/delete', 'method' => 'DELETE'],
    ],
    69 => [
        ['uri' => 'api/hr/employee/all', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/all/search', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/all/details', 'method' => 'GET'],
        ['uri' => 'hr/employee/all', 'method' => 'GET'],
        ['uri' => 'hr/employee/all/search', 'method' => 'GET'],
    ],
    70 => [
        ['uri' => 'api/hr/employee/all', 'method' => 'POST'],
    ],
    71 => [
        ['uri' => 'api/hr/employee/all/edit', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/all', 'method' => 'PUT'],
    ],
    72 => [
        ['uri' => 'api/hr/employee/all/delete', 'method' => 'DELETE'],
    ],
    73 => [
        ['uri' => 'api/hr/employee/personal', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/personal/search', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/personal/details', 'method' => 'GET'],
        ['uri' => 'hr/employee/personal', 'method' => 'GET'],
        ['uri' => 'hr/employee/personal/search', 'method' => 'GET'],
    ],
    74 => [
        ['uri' => 'api/hr/employee/personal', 'method' => 'POST'],
    ],
    75 => [
        ['uri' => 'api/hr/employee/personal/edit', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/personal', 'method' => 'PUT'],
    ],
    76 => [
        ['uri' => 'api/hr/employee/personal/delete', 'method' => 'DELETE'],
    ],
    77 => [
        ['uri' => 'api/hr/employee/education', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/education/search', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/education/details', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/education/grid', 'method' => 'GET'],
        ['uri' => 'hr/employee/education', 'method' => 'GET'],
        ['uri' => 'hr/employee/education/search', 'method' => 'GET'],
    ],
    78 => [
        ['uri' => 'api/hr/employee/education', 'method' => 'POST'],
    ],
    79 => [
        ['uri' => 'api/hr/employee/education/edit', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/education', 'method' => 'PUT'],
    ],
    80 => [
        ['uri' => 'api/hr/employee/education/delete', 'method' => 'DELETE'],
    ],
    81 => [
        ['uri' => 'api/hr/employee/training', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/training/search', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/training/details', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/training/grid', 'method' => 'GET'],
        ['uri' => 'hr/employee/training', 'method' => 'GET'],
        ['uri' => 'hr/employee/training/search', 'method' => 'GET'],
    ],
    82 => [
        ['uri' => 'api/hr/employee/training', 'method' => 'POST'],
    ],
    83 => [
        ['uri' => 'api/hr/employee/training/edit', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/training', 'method' => 'PUT'],
    ],
    84 => [
        ['uri' => 'api/hr/employee/training/delete', 'method' => 'DELETE'],
    ],
    85 => [
        ['uri' => 'api/hr/employee/experience', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/experience/search', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/experience/details', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/experience/grid', 'method' => 'GET'],
        ['uri' => 'hr/employee/experience', 'method' => 'GET'],
        ['uri' => 'hr/employee/experience/search', 'method' => 'GET'],
    ],
    86 => [
        ['uri' => 'api/hr/employee/experience', 'method' => 'POST'],
    ],
    87 => [
        ['uri' => 'api/hr/employee/experience/edit', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/experience', 'method' => 'PUT'],
    ],
    88 => [
        ['uri' => 'api/hr/employee/experience/delete', 'method' => 'DELETE'],
    ],
    89 => [
        ['uri' => 'api/hr/employee/organization', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/organization/search', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/organization/details', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/organization/grid', 'method' => 'GET'],
        ['uri' => 'hr/employee/organization', 'method' => 'GET'],
        ['uri' => 'hr/employee/organization/search', 'method' => 'GET'],
    ],
    90 => [
        ['uri' => 'api/hr/employee/organization', 'method' => 'POST'],
    ],
    91 => [
        ['uri' => 'api/hr/employee/organization/edit', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/organization', 'method' => 'PUT'],
    ],
    92 => [
        ['uri' => 'api/hr/employee/organization/delete', 'method' => 'DELETE'],
    ],
    93 => [
        ['uri' => 'api/hr/employee/attendence', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/attendence/search', 'method' => 'GET'],
        ['uri' => 'hr/employee/attendence', 'method' => 'GET'],
        ['uri' => 'hr/employee/attendence/search', 'method' => 'GET'],
    ],
    94 => [
        ['uri' => 'api/hr/employee/attendence', 'method' => 'POST'],
    ],
    95 => [
        ['uri' => 'api/hr/employee/attendence/edit', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/attendence', 'method' => 'PUT'],
    ],








    // Payroll / Transactions
    96 => [
        ['uri' => 'api/hr/payroll/heads', 'method' => 'GET'],
        ['uri' => 'api/hr/payroll/heads/search', 'method' => 'GET'],
        ['uri' => 'hr/payroll/heads', 'method' => 'GET'],
        ['uri' => 'hr/payroll/heads/search', 'method' => 'GET'],
    ],
    97 => [
        ['uri' => 'api/hr/payroll/heads', 'method' => 'POST'],
    ],
    98 => [
        ['uri' => 'api/hr/payroll/heads/edit', 'method' => 'GET'],
        ['uri' => 'api/hr/payroll/heads', 'method' => 'PUT'],
    ],
    99 => [
        ['uri' => 'api/hr/payroll/heads/delete', 'method' => 'DELETE'],
    ],
    100 => [
        ['uri' => 'api/hr/payroll/setup', 'method' => 'GET'],
        ['uri' => 'api/hr/payroll/setup/search', 'method' => 'GET'],
        ['uri' => 'hr/payroll/setup', 'method' => 'GET'],
        ['uri' => 'hr/payroll/setup/search', 'method' => 'GET'],
    ],
    101 => [ 
        ['uri' => 'api/hr/payroll/setup', 'method' => 'POST'],
    ],
    102 => [
        ['uri' => 'api/hr/payroll/setup/edit', 'method' => 'GET'],
        ['uri' => 'api/hr/payroll/setup', 'method' => 'PUT'],
    ],
    103 => [
        ['uri' => 'api/hr/payroll/setup/delete', 'method' => 'DELETE'],
    ],
    104 => [
        ['uri' => 'api/hr/payroll/middlewire', 'method' => 'GET'],
        ['uri' => 'api/hr/payroll/middlewire/search', 'method' => 'GET'],
        ['uri' => 'hr/payroll/middlewire', 'method' => 'GET'],
        ['uri' => 'hr/payroll/middlewire/search', 'method' => 'GET'],
    ],
    105 => [
        ['uri' => 'api/hr/payroll/middlewire', 'method' => 'POST'],
    ],
    106 => [
        ['uri' => 'api/hr/payroll/middlewire/edit', 'method' => 'GET'],
        ['uri' => 'api/hr/payroll/middlewire', 'method' => 'PUT'],
    ],
    107 => [
        ['uri' => 'api/hr/payroll/middlewire/delete', 'method' => 'DELETE'],
    ],
    108 => [
        ['uri' => 'api/hr/payroll/process', 'method' => 'GET'],
        ['uri' => 'api/hr/payroll/process/search', 'method' => 'GET'],
        ['uri' => 'hr/payroll/process', 'method' => 'GET'],
        ['uri' => 'hr/payroll/process/search', 'method' => 'GET'],
    ],
    109 => [
        ['uri' => 'api/hr/payroll/process', 'method' => 'POST'],
    ],
    110 => [
        ['uri' => 'api/hr/report/salary/summary', 'method' => 'GET'],
        ['uri' => 'api/hr/report/salary/summary/search', 'method' => 'GET'],
        ['uri' => 'hr/report/salary/summary', 'method' => 'GET'],
        ['uri' => 'hr/report/salary/summary/search', 'method' => 'GET'],
    ],
    111 => [
        ['uri' => 'api/hr/report/salary/details', 'method' => 'GET'],
        ['uri' => 'api/hr/report/salary/details/search', 'method' => 'GET'],
        ['uri' => 'hr/report/salary/details', 'method' => 'GET'],
        ['uri' => 'hr/report/salary/details/search', 'method' => 'GET'],
    ],







    // ----------------------------- Pharmacy Menu Permissions ----------------------------- //
    // SETUP
    112 => [
        ['uri' => 'api/pharmacy/setup/manufacturer', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/setup/manufacturer/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/setup/manufacturer', 'method' => 'GET'],
        ['uri' => 'pharmacy/setup/manufacturer/search', 'method' => 'GET'],
    ],
    113 => [
        ['uri' => 'api/pharmacy/setup/manufacturer', 'method' => 'POST'],
    ],
    114 => [
        ['uri' => 'api/pharmacy/setup/manufacturer/edit', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/setup/manufacturer', 'method' => 'PUT'],
    ],
    115 => [
        ['uri' => 'api/pharmacy/setup/manufacturer/delete', 'method' => 'DELETE'],
    ],
    116 => [
        ['uri' => 'api/pharmacy/setup/category', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/setup/category/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/setup/category', 'method' => 'GET'],
        ['uri' => 'pharmacy/setup/category/search', 'method' => 'GET'],
    ],
    117 => [
        ['uri' => 'api/pharmacy/setup/category', 'method' => 'POST'],
    ],
    118 => [
        ['uri' => 'api/pharmacy/setup/category/edit', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/setup/category', 'method' => 'PUT'],
    ],
    119 => [
        ['uri' => 'api/pharmacy/setup/category/delete', 'method' => 'DELETE'],
    ],
    120 => [
        ['uri' => 'api/pharmacy/setup/unit', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/setup/unit/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/setup/unit', 'method' => 'GET'],
        ['uri' => 'pharmacy/setup/unit/search', 'method' => 'GET'],
    ],
    121 => [
        ['uri' => 'api/pharmacy/setup/unit', 'method' => 'POST'],
    ],
    122 => [
        ['uri' => 'api/pharmacy/setup/unit/edit', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/setup/unit', 'method' => 'PUT'],
    ],
    123 => [
        ['uri' => 'api/pharmacy/setup/unit/delete', 'method' => 'DELETE'],
    ],
    124 => [
        ['uri' => 'api/pharmacy/setup/form', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/setup/form/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/setup/form', 'method' => 'GET'],
        ['uri' => 'pharmacy/setup/form/search', 'method' => 'GET'],
    ],
    125 => [
        ['uri' => 'api/pharmacy/setup/form', 'method' => 'POST'],
    ],
    126 => [
        ['uri' => 'api/pharmacy/setup/form/edit', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/setup/form', 'method' => 'PUT'],
    ],
    127 => [
        ['uri' => 'api/pharmacy/setup/form/delete', 'method' => 'DELETE'],
    ],
    128 => [
        ['uri' => 'api/pharmacy/setup/groupes', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/setup/groupes/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/setup/groupes', 'method' => 'GET'],
        ['uri' => 'pharmacy/setup/groupes/search', 'method' => 'GET'],
    ],
    129 => [
        ['uri' => 'api/pharmacy/setup/groupes', 'method' => 'POST'],
    ],
    130 => [
        ['uri' => 'api/pharmacy/setup/groupes/edit', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/setup/groupes', 'method' => 'PUT'],
    ],
    131 => [
        ['uri' => 'api/pharmacy/setup/groupes/delete', 'method' => 'DELETE'],
    ],
    132 => [
        ['uri' => 'api/pharmacy/setup/product', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/setup/product/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/setup/product', 'method' => 'GET'],
        ['uri' => 'pharmacy/setup/product/search', 'method' => 'GET'],
    ],
    133 => [
        ['uri' => 'api/pharmacy/setup/product', 'method' => 'POST'],
    ],
    134 => [
        ['uri' => 'api/pharmacy/setup/product/edit', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/setup/product', 'method' => 'PUT'],
    ],
    135 => [
        ['uri' => 'api/pharmacy/setup/product/delete', 'method' => 'DELETE'],
    ],






    // USERS
    136 => [
        ['uri' => 'api/pharmacy/users/usertype', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/users/usertype/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/users/usertype', 'method' => 'GET'],
        ['uri' => 'pharmacy/users/usertype/search', 'method' => 'GET'],
    ],
    137 => [
        ['uri' => 'api/pharmacy/users/usertype', 'method' => 'POST'],
    ],
    138 => [
        ['uri' => 'api/pharmacy/users/usertype/edit', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/users/usertype', 'method' => 'PUT'],
    ],
    139 => [
        ['uri' => 'api/pharmacy/users/usertype/delete', 'method' => 'DELETE'],
    ],
    140 => [
        ['uri' => 'api/pharmacy/users/clients', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/users/clients/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/users/clients', 'method' => 'GET'],
        ['uri' => 'pharmacy/users/clients/search', 'method' => 'GET'],
    ],
    141 => [
        ['uri' => 'api/pharmacy/users/clients', 'method' => 'POST'],
    ],
    142 => [
        ['uri' => 'api/pharmacy/users/clients/edit', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/users/clients', 'method' => 'PUT'],
    ],
    143 => [
        ['uri' => 'api/pharmacy/users/clients/delete', 'method' => 'DELETE'],
    ],
    144 => [
        ['uri' => 'api/pharmacy/users/suppliers', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/users/suppliers/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/users/suppliers', 'method' => 'GET'],
        ['uri' => 'pharmacy/users/suppliers/search', 'method' => 'GET'],
    ],
    145 => [
        ['uri' => 'api/pharmacy/users/suppliers', 'method' => 'POST'],
    ],
    146 => [
        ['uri' => 'api/pharmacy/users/suppliers/edit', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/users/suppliers', 'method' => 'PUT'],
    ],
    147 => [
        ['uri' => 'api/pharmacy/users/suppliers/delete', 'method' => 'DELETE'],
    ],
    
    






    // Transactions
    148 => [
        ['uri' => 'api/pharmacy/transaction/purchase', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/transaction/purchase/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/transaction/purchase', 'method' => 'GET'],
        ['uri' => 'pharmacy/transaction/purchase/search', 'method' => 'GET'],
    ],
    149 => [
        ['uri' => 'api/pharmacy/transaction/purchase', 'method' => 'POST'],
    ],
    150 => [
        ['uri' => 'api/pharmacy/transaction/purchase/edit', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/transaction/purchase', 'method' => 'PUT'],
    ],
    151 => [
        ['uri' => 'api/pharmacy/transaction/purchase/delete', 'method' => 'DELETE'],
    ],
    152 => [
        ['uri' => 'api/pharmacy/transaction/purchase/verify/delete', 'method' => 'DELETE'],
    ],
    153 => [
        ['uri' => 'api/pharmacy/transaction/issue', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/transaction/issue/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/transaction/issue', 'method' => 'GET'],
        ['uri' => 'pharmacy/transaction/issue/search', 'method' => 'GET'],
    ],
    154 => [
        ['uri' => 'api/pharmacy/transaction/issue', 'method' => 'POST'],
    ],
    155 => [
        ['uri' => 'api/pharmacy/transaction/issue/edit', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/transaction/issue', 'method' => 'PUT'],
    ],
    156 => [
        ['uri' => 'api/pharmacy/transaction/issue/delete', 'method' => 'DELETE'],
    ],
    157 => [
        ['uri' => 'api/pharmacy/transaction/return/client', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/transaction/return/client/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/transaction/return/client', 'method' => 'GET'],
        ['uri' => 'pharmacy/transaction/return/client/search', 'method' => 'GET'],
    ],
    158 => [
        ['uri' => 'api/pharmacy/transaction/return/client', 'method' => 'POST'],
    ],
    159 => [
        ['uri' => 'api/pharmacy/transaction/return/client/edit', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/transaction/return/client', 'method' => 'PUT'],
    ],
    160 => [
        ['uri' => 'api/pharmacy/transaction/return/client/delete', 'method' => 'DELETE'],
    ],
    161 => [
        ['uri' => 'api/pharmacy/transaction/return/supplier', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/transaction/return/supplier/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/transaction/return/supplier', 'method' => 'GET'],
        ['uri' => 'pharmacy/transaction/return/supplier/search', 'method' => 'GET'],
    ],
    162 => [
        ['uri' => 'api/pharmacy/transaction/return/supplier', 'method' => 'POST'],
    ],
    163 => [
        ['uri' => 'api/pharmacy/transaction/return/supplier/edit', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/transaction/return/supplier', 'method' => 'PUT'],
    ],
    164 => [
        ['uri' => 'api/pharmacy/transaction/return/supplier/delete', 'method' => 'DELETE'],
    ],
    





    // ADJUSTMENT
    165 => [
        ['uri' => 'api/pharmacy/adjustment/positive', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/adjustment/positive/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/adjustment/positive', 'method' => 'GET'],
        ['uri' => 'pharmacy/adjustment/positive/search', 'method' => 'GET'],
    ],
    166 => [
        ['uri' => 'api/pharmacy/adjustment/positive', 'method' => 'POST'],
    ],
    167 => [
        ['uri' => 'api/pharmacy/adjustment/positive/edit', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/adjustment/positive', 'method' => 'PUT'],
    ],
    168 => [
        ['uri' => 'api/pharmacy/adjustment/positive/delete', 'method' => 'DELETE'],
    ],
    169 => [
        ['uri' => 'api/pharmacy/adjustment/negative', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/adjustment/negative/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/adjustment/negative', 'method' => 'GET'],
        ['uri' => 'pharmacy/adjustment/negative/search', 'method' => 'GET'],
    ],
    170 => [
        ['uri' => 'api/pharmacy/adjustment/negative', 'method' => 'POST'],
    ],
    171 => [
        ['uri' => 'api/pharmacy/adjustment/negative/edit', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/adjustment/negative', 'method' => 'PUT'],
    ],
    172 => [
        ['uri' => 'api/pharmacy/adjustment/negative/delete', 'method' => 'DELETE'],
    ],






    // PARTY PAYMENT
    173 => [
        ['uri' => 'api/pharmacy/party/receive', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/party/receive/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/party/receive', 'method' => 'GET'],
        ['uri' => 'pharmacy/party/receive/search', 'method' => 'GET'],
    ],
    174 => [
        ['uri' => 'api/pharmacy/party/receive', 'method' => 'POST'],
    ],
    175 => [
        ['uri' => 'api/pharmacy/party/receive/edit', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/party/receive', 'method' => 'PUT'],
    ],
    176 => [
        ['uri' => 'api/pharmacy/party/receive/delete', 'method' => 'DELETE'],
    ],
    177 => [
        ['uri' => 'api/pharmacy/party/payment', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/party/payment/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/party/payment', 'method' => 'GET'],
        ['uri' => 'pharmacy/party/payment/search', 'method' => 'GET'],
    ],
    178 => [
        ['uri' => 'api/pharmacy/party/payment', 'method' => 'POST'],
    ],
    179 => [
        ['uri' => 'api/pharmacy/party/payment/edit', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/party/payment', 'method' => 'PUT'],
    ],
    180 => [
        ['uri' => 'api/pharmacy/party/payment/delete', 'method' => 'DELETE'],
    ],
    






    // REPORTS
    181 => [
        ['uri' => 'api/pharmacy/report/item/flow', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/report/item/flow/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/item/flow', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/item/flow/search', 'method' => 'GET'],
    ],
    182 => [
        ['uri' => 'api/pharmacy/report/stock/summary', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/report/stock/summary/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/stock/summary', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/stock/summary/search', 'method' => 'GET'],
    ],
    183 => [
        ['uri' => 'api/pharmacy/report/stock/details', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/report/stock/details/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/stock/details', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/stock/details/search', 'method' => 'GET'],
    ],
    184 => [
        ['uri' => 'api/pharmacy/report/profitability/statement', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/report/profitability/statement/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/profitability/statement', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/profitability/statement/search', 'method' => 'GET'],
    ],
    185 => [
        ['uri' => 'api/pharmacy/report/expiry/statement', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/report/expiry/statement/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/expiry/statement', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/expiry/statement/search', 'method' => 'GET'],
    ],
    186 => [
        ['uri' => 'api/pharmacy/report/purchase/summary', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/report/purchase/summary/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/purchase/summary', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/purchase/summary/search', 'method' => 'GET'],
    ],
    187 => [
        ['uri' => 'api/pharmacy/report/purchase/details', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/report/purchase/details/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/purchase/details', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/purchase/details/search', 'method' => 'GET'],
    ],
    188 => [
        ['uri' => 'api/pharmacy/report/issue/summary', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/report/issue/summary/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/issue/summary', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/issue/summary/search', 'method' => 'GET'],
    ],
    189 => [
        ['uri' => 'api/pharmacy/report/issue/details', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/report/issue/details/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/issue/details', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/issue/details/search', 'method' => 'GET'],
    ],
    190 => [
        ['uri' => 'api/pharmacy/report/return/client/summary', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/report/return/client/summary/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/return/client/summary', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/return/client/summary/search', 'method' => 'GET'],
    ],
    191 => [
        ['uri' => 'api/pharmacy/report/return/client/details', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/report/return/client/details/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/return/client/details', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/return/client/details/search', 'method' => 'GET'],
    ],
    192 => [
        ['uri' => 'api/pharmacy/report/return/supplier/summary', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/report/return/supplier/summary/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/return/supplier/summary', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/return/supplier/summary/search', 'method' => 'GET'],
    ],
    193 => [
        ['uri' => 'api/pharmacy/report/return/supplier/details', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/report/return/supplier/details/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/return/supplier/details', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/return/supplier/details/search', 'method' => 'GET'],
    ],









    








    








    // ----------------------------- Reports & Queries Menu Permissions ----------------------------- //
    276 => [
        ['uri' => 'api/report/account/summary', 'method' => 'GET'],
        ['uri' => 'api/report/account/summary/search', 'method' => 'GET'],
        ['uri' => 'report/account/summary', 'method' => 'GET'],
        ['uri' => 'report/account/summary/search', 'method' => 'GET'],
    ],
    277 => [
        ['uri' => 'api/report/account/summarygroupe', 'method' => 'GET'],
        ['uri' => 'api/report/account/summarygroupe/search', 'method' => 'GET'],
        ['uri' => 'report/account/summarygroupe', 'method' => 'GET'],
        ['uri' => 'report/account/summarygroupe/search', 'method' => 'GET'],
    ],
    278 => [
        ['uri' => 'api/report/account/details', 'method' => 'GET'],
        ['uri' => 'api/report/account/details/search', 'method' => 'GET'],
        ['uri' => 'report/account/details', 'method' => 'GET'],
        ['uri' => 'report/account/details/search', 'method' => 'GET'],
    ],
    279 => [
        ['uri' => 'api/report/party/summary', 'method' => 'GET'],
        ['uri' => 'api/report/party/summary/search', 'method' => 'GET'],
        ['uri' => 'report/party/summary', 'method' => 'GET'],
        ['uri' => 'report/party/summary/search', 'method' => 'GET'],
    ],
    280 => [
        ['uri' => 'api/report/party/details', 'method' => 'GET'],
        ['uri' => 'api/report/party/details/search', 'method' => 'GET'],
        ['uri' => 'report/party/details', 'method' => 'GET'],
        ['uri' => 'report/party/details/search', 'method' => 'GET'],
    ],
    













    281 => [
        ['uri' => 'api/admin/locations', 'method' => 'POST'],
    ],
    282 => [
        ['uri' => 'api/admin/locations/edit', 'method' => 'GET'],
        ['uri' => 'api/admin/locations', 'method' => 'PUT'],
    ],
    283 => [
        ['uri' => 'api/admin/locations/delete', 'method' => 'DELETE'],
    ],


    284 => [
        ['uri' => 'api/admin/banks', 'method' => 'POST'],
    ],
    285 => [
        ['uri' => 'api/admin/banks/edit', 'method' => 'GET'],
        ['uri' => 'api/admin/banks', 'method' => 'PUT'],
    ],
    286 => [
        ['uri' => 'api/admin/banks/delete', 'method' => 'DELETE'],
    ],
    
    
    287 => [ 
        ['uri' => 'api/admin/payment_method', 'method' => 'GET'],
        ['uri' => 'api/admin/payment_method/search', 'method' => 'GET'],
        ['uri' => 'api/admin/payment_method/details', 'method' => 'GET'],
        ['uri' => 'admin/payment_method', 'method' => 'GET'],
        ['uri' => 'admin/payment_method/search', 'method' => 'GET'],
    ],
    288 => [
        ['uri' => 'api/admin/payment_method', 'method' => 'POST'],
    ],
    289 => [
        ['uri' => 'api/admin/payment_method/edit', 'method' => 'GET'],
        ['uri' => 'api/admin/payment_method', 'method' => 'PUT'],
    ],
    290 => [
        ['uri' => 'api/admin/payment_method/delete', 'method' => 'DELETE'],
    ],
    
    
    291 => [ 
        ['uri' => 'api/admin/corporate', 'method' => 'GET'],
        ['uri' => 'api/admin/corporate/search', 'method' => 'GET'],
        ['uri' => 'api/admin/corporate/details', 'method' => 'GET'],
        ['uri' => 'admin/corporate', 'method' => 'GET'],
        ['uri' => 'admin/corporate/search', 'method' => 'GET'],
    ],
    292 => [
        ['uri' => 'api/admin/corporate', 'method' => 'POST'],
    ],
    293 => [
        ['uri' => 'api/admin/corporate/edit', 'method' => 'GET'],
        ['uri' => 'api/admin/corporate', 'method' => 'PUT'],
    ],
    294 => [
        ['uri' => 'api/admin/corporate/delete', 'method' => 'DELETE'],
    ],
    
];