<?php
// app/config/schema.php
//
// types: int | float | date | text | string:<max length>

return [

    'categories' => [
        'pk'       => 'CategoryID',
        'read'     => ['CategoryID', 'CategoryName', 'Description'],
        'write'    => ['CategoryName', 'Description'],
        'required' => ['CategoryName'],
        'types'    => ['CategoryName' => 'string:255', 'Description' => 'string:255'],
        'allow'    => ['list', 'show', 'create', 'update', 'delete'],
    ],

    'suppliers' => [
        'pk'       => 'SupplierID',
        'read'     => ['SupplierID', 'SupplierName', 'ContactName', 'Address', 'City', 'PostalCode', 'Country', 'Phone'],
        'write'    => ['SupplierName', 'ContactName', 'Address', 'City', 'PostalCode', 'Country', 'Phone'],
        'required' => ['SupplierName'],
        'types'    => [
            'SupplierName' => 'string:255', 'ContactName' => 'string:255', 'Address' => 'string:255',
            'City' => 'string:255', 'PostalCode' => 'string:255', 'Country' => 'string:255', 'Phone' => 'string:255',
        ],
        'allow'    => ['list', 'show', 'create', 'update', 'delete'],
    ],

    'shippers' => [
        'pk'       => 'ShipperID',
        'read'     => ['ShipperID', 'ShipperName', 'Phone'],
        'write'    => ['ShipperName', 'Phone'],
        'required' => ['ShipperName'],
        'types'    => ['ShipperName' => 'string:255', 'Phone' => 'string:255'],
        'allow'    => ['list', 'show', 'create', 'update', 'delete'],
    ],

    'customers' => [
        'pk'       => 'CustomerID',
        'read'     => ['CustomerID', 'CustomerName', 'ContactName', 'Address', 'City', 'PostalCode', 'Country'],
        'write'    => ['CustomerName', 'ContactName', 'Address', 'City', 'PostalCode', 'Country'],
        'required' => ['CustomerName'],
        'types'    => [
            'CustomerName' => 'string:255', 'ContactName' => 'string:255', 'Address' => 'string:255',
            'City' => 'string:255', 'PostalCode' => 'string:255', 'Country' => 'string:255',
        ],
        'allow'    => ['list', 'show', 'create', 'update', 'delete'],
    ],

    'employees' => [
        'pk'       => 'EmployeeID',
        'read'     => ['EmployeeID', 'LastName', 'FirstName', 'Photo', 'Notes'],   // BirthDate left out on purpose
        'write'    => ['LastName', 'FirstName', 'BirthDate', 'Photo', 'Notes'],
        'required' => ['LastName', 'FirstName'],
        'types'    => [
            'LastName' => 'string:255', 'FirstName' => 'string:255', 'BirthDate' => 'date',
            'Photo' => 'string:255', 'Notes' => 'text',
        ],
        'allow'    => ['list', 'show', 'create', 'update'],   // no delete
    ],

    'products' => [
        'pk'       => 'ProductID',
        'read'     => ['ProductID', 'ProductName', 'SupplierID', 'CategoryID', 'Unit', 'Price'],
        'write'    => ['ProductName', 'SupplierID', 'CategoryID', 'Unit', 'Price'],
        'required' => ['ProductName', 'Price'],
        'types'    => [
            'ProductName' => 'string:255', 'SupplierID' => 'int', 'CategoryID' => 'int',
            'Unit' => 'string:255', 'Price' => 'float',
        ],
        'allow'    => ['list', 'show', 'create', 'update', 'delete'],
    ],

    'orders' => [
        'pk'       => 'OrderID',
        'read'     => ['OrderID', 'CustomerID', 'EmployeeID', 'OrderDate', 'ShipperID'],
        'write'    => ['CustomerID', 'EmployeeID', 'OrderDate', 'ShipperID'],
        'required' => ['CustomerID', 'OrderDate'],
        'types'    => ['CustomerID' => 'int', 'EmployeeID' => 'int', 'OrderDate' => 'date', 'ShipperID' => 'int'],
        'allow'    => ['list', 'show', 'create', 'update'],   // no delete
    ],

    'order_details' => [
        'pk'       => 'OrderDetailID',
        'read'     => ['OrderDetailID', 'OrderID', 'ProductID', 'Quantity'],
        'write'    => ['OrderID', 'ProductID', 'Quantity'],
        'required' => ['OrderID', 'ProductID', 'Quantity'],
        'types'    => ['OrderID' => 'int', 'ProductID' => 'int', 'Quantity' => 'int'],
        'allow'    => ['list', 'show', 'create', 'update'],   // no delete
    ],

];