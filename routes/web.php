<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', 'Auth\LoginController@showLoginForm')->name('home.page');

Auth::routes();
Auth::routes(['verify' => true]);
Route::get('logout', 'Auth\LoginController@logout');
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('signup/account', 'Auth\RegisterController@signup')->name('signup');
Route::get('signup', 'Auth\RegisterController@signup_form')->name('signup.page');

Route::get('/verify/account/{code}', 'Auth\LoginController@verify_account')->name('account.verify');
Route::get('/verify/business/email/{code}/{email}', 'Auth\LoginController@verify_business_email')->name('verify.business.email');

Route::prefix('dashboard')->middleware('auth')->group(function(){
   Route::get('/', 'app\dashboard\dashboardController@dashboard')->name('wingu.dashboard');
});


/*
|--------------------------------------------------------------------------
| Finance
|--------------------------------------------------------------------------
|
| Erp Financial section
*/
Route::prefix('finance')->middleware('auth')->group(function () {
   Route::get('/dashboard',['middleware' => ['permission:access-finance'], 'uses' => 'app\finance\dashboard\dashboardController@home','as' => 'finance.index']);
   Route::post('/ajax/price','app\finance\products\productController@productPrice')->name('finance.ajax.product.price');

   /* === customer === */
   Route::get('customer',['middleware' => ['permission:read-contact'], 'uses' => 'app\finance\contact\contactController@index','as' => 'finance.contact.index']);
   Route::get('customer/create',['middleware' => ['permission:create-contact'], 'uses' => 'app\finance\contact\contactController@create','as' => 'finance.contact.create']);
   Route::post('post-customer',['middleware' => ['permission:create-contact'], 'uses' => 'app\finance\contact\contactController@store','as' => 'finance.contact.store']);
   Route::get('customer/{id}/edit',['middleware' => ['permission:update-contact'], 'uses' => 'app\finance\contact\contactController@edit','as' => 'finance.contact.edit']);
   Route::post('customer/{id}/update',['middleware' => ['permission:update-contact'], 'uses' => 'app\finance\contact\contactController@update','as' => 'finance.contact.update']);
   Route::get('customer/{id}/show',['middleware' => ['permission:read-contact'], 'uses' => 'app\finance\contact\contactController@show','as' => 'finance.contact.show']);
   Route::get('customer/{id}/delete',['middleware' => ['permission:delete-contact'], 'uses' => 'app\finance\contact\contactController@delete','as' => 'finance.contact.delete']);

   Route::get('delete-contact-person/{id}',['middleware' => ['permission:delete-contact'], 'uses' => 'app\finance\contact\contactController@delete_contact_person','as' => 'finance.contactperson.delete']);

   //express customer
   Route::get('/express/customer',['middleware' => ['permission:read-contact'], 'uses' => 'app\finance\contact\contactController@express_list','as' => 'finance.contact.express']);
   Route::post('/express/customer/create',['middleware' => ['permission:create-contact'], 'uses' => 'app\finance\contact\contactController@express_store','as' => 'finance.contact.express.store']);

   //client comments
   Route::get('customer/{id}/comments',['middleware' => ['permission:read-contact'],'uses' => 'app\finance\contact\commentsController@index','as' => 'finance.customers.comments']);
   Route::post('customer/comments/post',['middleware' => ['permission:read-contact'],'uses' => 'app\finance\contact\commentsController@store','as' => 'finance.customers.comments.post']);
   Route::get('customer/comments/{id}/delete',['middleware' => ['permission:read-contact'],'uses' => 'app\finance\contact\commentsController@delete','as' => 'finance.customers.comments.delete']);

   //client invoices
   Route::get('customer/{id}/invoices',['uses' => 'app\finance\contact\contactController@show','as' => 'finance.customers.invoices']);

   //client subscriptions
   Route::get('customer/{id}/subscriptions',['uses' => 'app\finance\contact\contactController@show','as' => 'finance.customers.subscriptions']);

   //client quotes
   Route::get('customer/{id}/quotes',['uses' => 'app\finance\contact\contactController@show','as' => 'finance.customers.quotes']);

   //client creditnotes
   Route::get('customer/{id}/creditnotes',['uses' => 'app\finance\contact\contactController@show','as' => 'finance.customers.creditnotes']);

   //client lpos
   Route::get('customer/{id}/lpos',['uses' => 'app\finance\contact\contactController@show','as' => 'finance.customers.lpos']);

   //client projects
   Route::get('customer/{id}/projects',['uses' => 'app\finance\contact\contactController@show','as' => 'finance.customers.projects']);

   //statement
   Route::get('customer/{id}/statement',['uses' => 'app\finance\contact\statementController@index','as' => 'finance.customers.statement']);
   Route::get('customer/{id}/statement/pdf',['uses' => 'app\finance\contact\statementController@pdf','as' => 'finance.customers.statement.pdf']);
   Route::get('customer/{id}/statement/print',['uses' => 'app\finance\contact\statementController@print','as' => 'finance.customers.statement.print']);
   Route::get('customer/{id}/statement/mail',['uses' => 'app\finance\contact\statementController@mail','as' => 'finance.customers.statement.mail']);
   Route::post('customer/{id}/statement/send',['uses' => 'app\finance\contact\statementController@send','as' => 'finance.customers.statement.send']);

   //customer mail
   Route::get('/customer/{id}/mail', ['uses' => 'app\finance\contact\mailController@index','as' => 'finance.customer.mail']);
   Route::get('/customer/{id}/mail/{customerID}/details', ['uses' => 'app\finance\contact\mailController@details','as' => 'finance.customer.mail.details']);
   Route::get('/customer/{id}/send', ['uses' => 'app\finance\contact\mailController@send','as' => 'finance.customer.send']);
   Route::post('/customer/mail/store', ['uses' => 'app\finance\contact\mailController@store','as' => 'finance.customer.mail.store']);

   //customer documents
   Route::get('/customer/{id}/documents', ['uses' => 'app\finance\contact\documentsController@index','as' => 'finance.customer.documents']);
   Route::post('/customer/documents/store', ['uses' => 'app\finance\contact\documentsController@store','as' => 'finance.customer.documents.store']);
   Route::post('/customer/documents/{id}/update', ['uses' => 'app\finance\contact\documentsController@update','as' => 'finance.customer.documents.update']);
   Route::get('/customer/documents/{id}/{leadID}/delete', ['uses' => 'app\finance\contact\documentsController@delete','as' => 'finance.customer.documents.delete']);

   //customer sms
   Route::get('/customer/{id}/sms', ['uses' => 'app\finance\contact\smsController@index','as' => 'finance.customer.sms']);
   Route::post('/customer/sms/send', ['uses' => 'app\finance\contact\smsController@send','as' => 'finance.customer.sms.send']);

   //customer notes
   Route::get('/customer/{id}/notes', ['uses' => 'app\finance\contact\notesController@index','as' => 'finance.customer.notes']);
   Route::post('/customer/notes/store', ['uses' => 'app\finance\contact\notesController@store','as' => 'finance.customer.notes.store']);
   Route::post('/customer/{id}/notes/update', ['uses' => 'app\finance\contact\notesController@update','as' => 'finance.customer.notes.update']);
   Route::get('/customer/{id}/notes/delete', ['uses' => 'app\finance\contact\notesController@delete','as' => 'finance.customer.notes.delete']);

   //customer call logs
   Route::get('/customer/{id}/calllogs', ['uses' => 'app\finance\contact\calllogController@index','as' => 'finance.customer.calllog']);
   Route::post('/customer/calllog/store', ['uses' => 'app\finance\contact\calllogController@store','as' => 'finance.customer.calllog.store']);
   Route::post('/customer/{id}/calllog/update', ['uses' => 'app\finance\contact\calllogController@update','as' => 'finance.customer.calllog.update']);
   Route::get('/customer/{id}/calllog/store', ['uses' => 'app\finance\contact\calllogController@delete','as' => 'finance.customer.calllog.delete']);

   //customer events
   Route::get('/customer/{id}/events', ['uses' => 'app\finance\contact\eventsController@index','as' => 'finance.customer.events']);
   Route::post('/customer/events/store', ['uses' => 'app\finance\contact\eventsController@store','as' => 'finance.customer.events.store']);
   Route::post('/customer/events/{id}/update', ['uses' => 'app\finance\contact\eventsController@update','as' => 'finance.customer.events.update']);
   Route::get('/customer/events/{id}/delete', ['uses' => 'app\finance\contact\eventsController@delete','as' => 'finance.customer.events.delete']);

   //import customer
   Route::get('customer/import',['middleware' => ['permission:create-contact'],'uses' => 'app\finance\contact\importController@import','as' => 'finance.contact.import']);
   Route::post('customer/import/store',['middleware' => ['permission:create-contact'],'uses' => 'app\finance\contact\importController@import_contact','as' => 'finance.contact.import.store']);
   Route::get('customer/download/import/sample/',['middleware' => ['permission:read-contact'],'uses' => 'app\finance\contact\importController@download_import_sample','as' => 'finance.customer.download.sample.import']);

   //export customer list
   Route::get('customer/export/{type}',['middleware' => ['permission:read-contact'],'uses' => 'app\finance\contact\importController@export','as' => 'finance.contact.export']);

   //customer category
   Route::get('customer/category',['middleware' => ['permission:read-customercategory'], 'uses' => 'app\finance\contact\groupsController@index','as' => 'finance.contact.groups.index']);
   Route::post('customer/category/store',['middleware' => ['permission:create-customercategory'],'uses' => 'app\finance\contact\groupsController@store','as' => 'finance.contact.groups.store']);
   Route::get('customer/category/{id}/edit',['middleware' => ['permission:update-customercategory'],'uses' => 'app\finance\contact\groupsController@edit','as' => 'finance.contact.groups.edit']);
   Route::post('customer/category/{id}/update',['middleware' => ['permission:update-customercategory'],'uses' => 'app\finance\contact\groupsController@update','as' => 'finance.contact.groups.update']);
   Route::get('customer/category/{id}/delete',['middleware' => ['permission:delete-customercategory'],'uses' => 'app\finance\contact\groupsController@delete','as' => 'finance.contact.groups.delete']);


   /* === supplier === */
   Route::get('supplier',['middleware' => ['permission:read-vendors'], 'uses' => 'app\finance\supplier\supplierController@index','as' => 'finance.supplier.index']);
   Route::get('supplier/create',['middleware' => ['permission:create-vendors'], 'uses' => 'app\finance\supplier\supplierController@create','as' => 'finance.supplier.create']);
   Route::post('post-supplier',['middleware' => ['permission:create-vendors'], 'uses' => 'app\finance\supplier\supplierController@store','as' => 'finance.supplier.store']);
   Route::get('supplier/{id}/edit',['middleware' => ['permission:update-vendors'], 'uses' => 'app\finance\supplier\supplierController@edit','as' => 'finance.supplier.edit']);
   Route::post('supplier/{id}/update',['middleware' => ['permission:update-vendors'], 'uses' => 'app\finance\supplier\supplierController@update','as' => 'finance.supplier.update']);
   Route::get('supplier/{id}/show',['middleware' => ['permission:read-vendors'], 'uses' => 'app\finance\supplier\supplierController@show','as' => 'finance.supplier.show']);
   Route::get('supplier/{id}/delete',['middleware' => ['permission:delete-vendors'], 'uses' => 'app\finance\supplier\supplierController@delete','as' => 'finance.supplier.delete']);
   Route::get('delete-supplier-person/{id}',['middleware' => ['permission:delete-vendors'], 'uses' => 'app\finance\supplier\supplierController@delete_contact_person','as' => 'finance.supplier.vendor.person']);
   Route::get('supplier/{id}/trash',['middleware' => ['permission:delete-vendors'], 'uses' => 'app\finance\supplier\supplierController@trash','as' => 'vendor.trash.update']);
   Route::get('supplier/download/import/sample/',['uses' => 'app\finance\supplier\importController@download_import_sample','as' => 'finance.supplier.download.sample.import']);

   //express suppliers
   Route::get('express/supplier/list',['middleware' => ['permission:create-vendors'], 'uses' => 'app\finance\supplier\supplierController@express_list','as' => 'finance.supplier.express.list']);
   Route::post('express/supplier/save',['middleware' => ['permission:create-vendors'], 'uses' => 'app\finance\supplier\supplierController@express_save','as' => 'finance.supplier.express.store']);

   //supplier category
   Route::get('supplier/category',['uses' => 'app\finance\supplier\groupsController@index','as' => 'finance.supplier.groups.index']);
   Route::post('supplier/category/store',['uses' => 'app\finance\supplier\groupsController@store','as' => 'finance.supplier.groups.store']);
   Route::get('supplier/category/{id}/edit',['uses' => 'app\finance\supplier\groupsController@edit','as' => 'finance.supplier.groups.edit']);
   Route::post('supplier/category/{id}/update',['uses' => 'app\finance\supplier\groupsController@update','as' => 'finance.supplier.groups.update']);
   Route::get('supplier/category/{id}/delete',['uses' => 'app\finance\supplier\groupsController@delete','as' => 'finance.supplier.groups.delete']);

   //import
   Route::get('supplier/import',['middleware' => ['permission:read-vendors'], 'uses' => 'app\finance\supplier\importController@index','as' => 'supplier.import.index']);
   Route::post('supplier/post/import',['middleware' => ['permission:read-vendors'], 'uses' => 'app\finance\supplier\importController@import','as' => 'supplier.import']);

   //export
   Route::get('supplier/export/{type}',['middleware' => ['permission:read-vendors'], 'uses' => 'app\finance\supplier\importController@export','as' => 'supplier.export']);

   /* === product === */
   Route::get('items',['middleware' => ['permission:read-products'], 'uses' => 'app\finance\products\productController@index','as' => 'finance.product.index']);
   Route::get('items/create',['middleware' => ['permission:create-products'], 'uses' => 'app\finance\products\productController@create','as' => 'finance.products.create']);
   Route::post('items/store',['middleware' => ['permission:create-products'], 'uses' => 'app\finance\products\productController@store','as' => 'finance.products.store']);
   Route::get('items/{id}/edit',['middleware' => ['permission:update-products'], 'uses' => 'app\finance\products\productController@edit','as' => 'finance.products.edit']);
   Route::post('items/{id}/update',['middleware' => ['permission:update-products'], 'uses' => 'app\finance\products\productController@update','as' => 'finance.products.update']);
   Route::get('items/{id}/details',['middleware' => ['permission:read-products'], 'uses' => 'app\finance\products\productController@details','as' => 'finance.products.details']);
   Route::get('items/{id}/destroy',['middleware' => ['permission:delete-products'], 'uses' => 'app\finance\products\productController@destroy','as' => 'finance.products.destroy']);

   //express products
   Route::get('/express/items',['middleware' => ['permission:read-products'], 'uses' => 'app\finance\products\productController@express_list','as' => 'finance.product.express.list']);
   Route::post('/express/items/create',['middleware' => ['permission:create-products'], 'uses' => 'app\finance\products\productController@express_store','as' => 'finance.products.express.create']);

   //import product
   Route::get('items/import',['middleware' => ['permission:create-products'], 'uses' => 'app\finance\products\importController@index','as' => 'finance.products.import']);
   Route::post('items/post/import',['middleware' => ['permission:create-products'], 'uses' => 'app\finance\products\importController@import','as' => 'finance.products.post.import']);

   //export products
   Route::get('items/export/{type}',['middleware' => ['permission:create-products'], 'uses' => 'app\finance\products\importController@export','as' => 'finance.products.export']);

   //download csv sample for products
   Route::get('items/download/import/sample',['middleware' => ['permission:create-products'], 'uses' => 'app\finance\products\importController@download_import_sample','as' => 'finance.products.sample.download']);

   /* === product description === */
   Route::get('items/{id}/description',['middleware' => ['permission:update-products'], 'uses' => 'app\finance\products\productController@description','as' => 'finance.description']);
   Route::post('items/{id}/description/update',['middleware' => ['permission:update-products'], 'uses' => 'app\finance\products\productController@description_update','as' => 'finance.description.update']);

   /* === product price === */
   Route::get('item/price/{id}/edit',['middleware' => ['permission:update-products'], 'uses' => 'app\finance\products\productController@price','as' => 'finance.price']);
   Route::post('price/{id}/update',['middleware' => ['permission:update-products'], 'uses' => 'app\finance\products\productController@price_update','as' => 'finance.price.update']);

   /* === product variants === */
   Route::get('item/{id}/variants',['middleware' => ['permission:update-products'], 'uses' => 'app\finance\products\variantsController@index','as' => 'finance.products.variants.index']);
   Route::post('item/{id}/variants/store',['middleware' => ['permission:update-products'], 'uses' => 'app\finance\products\variantsController@store','as' => 'finance.products.variants.store']);
   Route::get('item/{id}/variants/{variantID}/edit',['middleware' => ['permission:update-products'], 'uses' => 'app\finance\products\variantsController@edit','as' => 'finance.products.variants.edit']);
   Route::post('item/variants/{id}/update',['middleware' => ['permission:update-products'], 'uses' => 'app\finance\products\variantsController@update','as' => 'finance.products.variants.update']);

   /* === product inventory === */
   Route::get('items/inventory/{id}/edit',['middleware' => ['permission:update-products'], 'uses' => 'app\finance\products\inventoryController@inventory','as' => 'finance.inventory']);
   Route::post('items/{id}/inventory/{productID}/update',['middleware' => ['permission:update-products'], 'uses' => 'app\finance\products\inventoryController@inventroy_update','as' => 'finance.inventory.update']);
   Route::post('items/inventory/settings/{productID}/update',['middleware' => ['permission:update-products'], 'uses' => 'app\finance\products\inventoryController@inventory_settings','as' => 'finance.inventory.settings.update']);
   Route::post('items/inventory/outlet/link',['middleware' => ['permission:update-products'], 'uses' => 'app\finance\products\inventoryController@inventory_outlet_link','as' => 'finance.inventory.outlet.link']);
   Route::get('items/{productID}/inventory/outle/{id}/link/delete',['middleware' => ['permission:update-products'], 'uses' => 'app\finance\products\inventoryController@delete_inventroy','as' => 'finance.inventory.outlet.link.delete']);

   /* === product images === */
   Route::get('items/images/{id}/edit',['middleware' => ['permission:update-products'], 'uses' => 'app\finance\products\imagesController@edit','as' => 'finance.product.images']);
   Route::post('items/images/{id}/update',['middleware' => ['permission:update-products'], 'uses' => 'app\finance\products\imagesController@update','as' => 'finance.product.images.update']);
   Route::post('items/images/store',['middleware' => ['permission:update-products'], 'uses' => 'app\finance\products\imagesController@store','as' => 'finance.product.images.store']);
   Route::post('items/images/{id}/destroy',['middleware' => ['permission:update-products'], 'uses' => 'app\finance\products\imagesController@destroy','as' => 'finance.product.images.destroy']);

   /* === product settings === */
   Route::get('items/{id}/settings',['middleware' => ['permission:update-products'], 'uses' => 'app\finance\products\settingsController@edit','as' => 'finance.product.settings.edit']);
   Route::get('items/{id}/settings/update',['middleware' => ['permission:update-products'], 'uses' => 'app\finance\products\settingsController@update','as' => 'finance.product.settings.update']);

   /* === stock control === */
   Route::get('stock/control/',['middleware' => ['permission:read-stockcontrol'],'uses' => 'app\finance\products\stockcontrolController@index','as' => 'finance.product.stock.control']);
   Route::get('order/stock',['middleware' => ['permission:read-stockcontrol'],'uses' => 'app\finance\products\stockcontrolController@order','as' => 'finance.product.stock.order']);
   Route::get('order/stock/{id}/show',['middleware' => ['permission:read-stockcontrol'],'uses' => 'app\finance\products\stockcontrolController@show','as' => 'finance.product.stock.order.show']);
   Route::post('post/order/stock',['middleware' => ['permission:create-stockcontrol'],'uses' => 'app\finance\products\stockcontrolController@store','as' => 'finance.product.stock.order.post']);
   Route::post('lpo/ajax/price','app\finance\products\stockcontrolController@productPrice')->name('finance.ajax.product.stock.price');
   Route::get('order/stock/{id}/edit',['middleware' => ['permission:update-stockcontrol'],'uses' => 'app\finance\products\stockcontrolController@edit','as' => 'finance.product.stock.order.edit']);
   Route::post('order/stock/{id}/update',['middleware' => ['permission:update-stockcontrol'],'uses' => 'app\finance\products\stockcontrolController@update','as' => 'finance.product.stock.order.update']);
   Route::get('order/stock/{id}/pdf',['middleware' => ['permission:read-stockcontrol'],'uses' => 'app\finance\products\stockcontrolController@pdf','as' => 'finance.product.stock.order.pdf']);
   Route::get('order/stock/{id}/print',['middleware' => ['permission:update-stockcontrol'],'uses' => 'app\finance\products\stockcontrolController@print','as' => 'finance.product.stock.order.print']);
   Route::get('order/stock/{id}/delivered',['middleware' => ['permission:update-stockcontrol'],'uses' => 'app\finance\products\stockcontrolController@delivered','as' => 'finance.stock.delivered']);

   //send order
   Route::get('stock/{id}/mail',['middleware' => ['permission:update-stockcontrol'],'uses' => 'app\finance\products\stockcontrolController@mail','as' => 'finance.stock.mail']);
   Route::post('stock/mail/send',['middleware' => ['permission:update-stockcontrol'],'uses' => 'app\finance\products\stockcontrolController@send','as' => 'finance.stock.mail.send']);
   Route::post('stock/attach/files',['middleware' => ['permission:update-stockcontrol'],'uses' => 'app\finance\products\stockcontrolController@attachment_files','as' => 'finance.stock.attach']);


   /* === product category === */
   Route::get('items/category',['middleware' => ['permission:read-productcategory'],'uses' => 'app\finance\products\categoryController@index','as' => 'finance.product.category']);
   Route::post('items/category/store',['middleware' => ['permission:create-productcategory'], 'uses' => 'app\finance\products\categoryController@store','as' => 'finance.product.category.store']);
   Route::get('items/category/{id}/edit',['middleware' => ['permission:update-productcategory'], 'uses' => 'app\finance\products\categoryController@edit','as' => 'finance.product.category.edit']);
   Route::post('product.category/{id}/update',['middleware' => ['permission:update-productcategory'], 'uses' => 'app\finance\products\categoryController@update','as' => 'finance.product.category.update']);
   Route::get('items/category/{id}/destroy',['middleware' => ['permission:delete-productcategory'], 'uses' => 'app\finance\products\categoryController@destroy','as' => 'finance.product.category.destroy']);

   /* === product brands === */
   Route::get('items/brand',['middleware' => ['permission:read-productbrand'],'uses' => 'app\finance\products\brandController@index','as' => 'finance.product.brand']);
   Route::post('items/brand/store',['middleware' => ['permission:create-productbrand'], 'uses' => 'app\finance\products\brandController@store','as' => 'finance.product.brand.store']);
   Route::get('items/brand/{id}/edit',['middleware' => ['permission:update-productbrand'], 'uses' => 'app\finance\products\brandController@edit','as' => 'finance.product.brand.edit']);
   Route::post('product.brand/{id}/update',['middleware' => ['permission:update-productbrand'], 'uses' => 'app\finance\products\brandController@update','as' => 'finance.product.brand.update']);
   Route::get('items/brand/{id}/destroy',['middleware' => ['permission:delete-productbrand'], 'uses' => 'app\finance\products\brandController@destroy','as' => 'finance.product.brand.destroy']);

   /* === product tags === */
   Route::get('items/tags',['middleware' => ['permission:read-producttags'],'uses' => 'app\finance\products\tagsController@index','as' => 'finance.product.tags']);
   Route::post('items/tags/store',['middleware' => ['permission:create-producttags'], 'uses' => 'app\finance\products\tagsController@store','as' => 'finance.product.tags.store']);
   Route::get('items/tags/{id}/edit',['middleware' => ['permission:update-producttags'], 'uses' => 'app\finance\products\tagsController@edit','as' => 'finance.product.tags.edit']);
   Route::post('product.tags/{id}/update',['middleware' => ['permission:update-producttags'], 'uses' => 'app\finance\products\tagsController@update','as' => 'finance.product.tags.update']);
   Route::get('items/tags/{id}/destroy',['middleware' => ['permission:delete-producttags'], 'uses' => 'app\finance\products\tagsController@destroy','as' => 'finance.product.tags.destroy']);

    /* === product attributes === */
    Route::get('items/attributes',['middleware' => ['permission:read-productattributes'],'uses' => 'app\finance\products\attributeController@index','as' => 'finance.product.attributes']);
    Route::post('items/attributes/store',['middleware' => ['permission:create-productattributes'],'uses' => 'app\finance\products\attributeController@store','as' => 'finance.product.attributes.store']);
    Route::get('items/attributes/{id}/edit',['middleware' => ['permission:update-productattributes'],'uses' => 'app\finance\products\attributeController@edit','as' => 'finance.product.attributes.edit']);
    Route::post('items/attributes/{id}/update',['middleware' => ['permission:update-productattributes'],'uses' => 'app\finance\products\attributeController@update','as' => 'finance.product.attributes.update']);
    Route::get('items/attributes/{id}/delete',['middleware' => ['permission:delete-productattributes'],'uses' => 'app\finance\products\attributeController@delete','as' => 'finance.product.attributes.delete']);

    /* === attribute values === */
    Route::get('items/attributes/{id}/values',['middleware' => ['permission:create-productattributevalues'],'uses' => 'app\finance\products\attributeValueController@create','as' => 'finance.product.attributes.value.create']);
    Route::post('items/attributes/values/store',['middleware' => ['permission:create-productattributevalues'],'uses' => 'app\finance\products\attributeValueController@store','as' => 'finance.product.attributes.value.store']);
    Route::get('items/attributes/values/{id}/edit',['middleware' => ['permission:update-productattributevalues'],'uses' => 'app\finance\products\attributeValueController@edit','as' => 'finance.product.attributes.value.edit']);
    Route::post('items/attributes/values/{id}/update',['middleware' => ['permission:update-productattributevalues'],'uses' => 'app\finance\products\attributeValueController@update','as' => 'finance.product.attributes.value.update']);
    Route::get('items/attributes/values/{id}/delete',['middleware' => ['permission:delete-productattributevalues'],'uses' => 'app\finance\products\attributeValueController@delete','as' => 'finance.product.attributes.value.delete']);

   /* === Normal Expense === */
   Route::get('expense',['middleware' => ['permission:read-expense'], 'uses' => 'app\finance\expense\expenseController@index','as' => 'finance.expense.index']);
   Route::get('expense/create',['middleware' => ['permission:create-expense'], 'uses' => 'app\finance\expense\expenseController@create','as' => 'finance.expense.create']);
   Route::post('expense/store',['middleware' => ['permission:create-expense'], 'uses' => 'app\finance\expense\expenseController@store','as' => 'finance.expense.store']);
   Route::get('expense/{id}/edit',['middleware' => ['permission:update-expense'], 'uses' => 'app\finance\expense\expenseController@edit','as' => 'finance.expense.edit']);
   Route::post('expense/{id}/update',['middleware' => ['permission:update-expense'], 'uses' => 'app\finance\expense\expenseController@update','as' => 'finance.expense.update']);
   Route::get('expense/{id}/destroy',['middleware' => ['permission:delete-expense'], 'uses' => 'app\finance\expense\expenseController@destroy','as' => 'finance.expense.destroy']);

   /* === Expense Mileage === */
   // Route::get('expense/mileage',['uses' => 'app\finance\expense\mileageController@index','as' => 'finance.mileage.index']);
   // Route::get('expense/mileage/create',['uses' => 'app\finance\expense\mileageController@create','as' => 'finance.mileage.create']);
   // Route::post('expense/mileage/store',['uses' => 'app\finance\expense\mileageController@store','as' => 'finance.mileage.store']);
   // Route::get('expense/mileage/{id}/edit',['uses' => 'app\finance\expense\mileageController@edit','as' => 'finance.mileage.edit']);
   // Route::post('expense/mileage/{id}/update',['uses' => 'app\finance\expense\mileageController@update','as' => 'finance.mileage.update']);
   // Route::get('expense/mileage/{id}/destroy',['uses' => 'app\finance\expense\mileageController@destroy','as' => 'finance.mileage.destroy']);

   /* === General Expense === */
   Route::get('expence/{id}/file/delete',['uses' => 'app\finance\expense\expenseController@file_delete','as' => 'finance.expense.file.delete']);
   Route::get('expence/{id}/file/download',['uses' => 'app\finance\expense\expenseController@download','as' => 'finance.expense.file.download']);

   /* === Expense Category settings === */

   //expense category
   Route::get('expense/category',['middleware' => ['permission:read-expensecategory'],'uses' => 'app\finance\expense\expenseCategoryController@index','as' => 'finance.expense.category.index']);
   Route::post('expense/category/store',['middleware' => ['permission:create-expensecategory'],'uses' => 'app\finance\expense\expenseCategoryController@store','as' => 'finance.expense.category.store']);
   Route::get('expense-category/{id}/edit',['middleware' => ['permission:update-expensecategory'],'uses' => 'app\finance\expense\expenseCategoryController@edit','as' => 'finance.expense.category.edit']);
   Route::post('expense-category/{id}/update',['middleware' => ['permission:update-expensecategory'],'uses' => 'app\finance\expense\expenseCategoryController@update','as' => 'finance.expense.category.update']);
   Route::get('expense-category/{id}/delete',['middleware' => ['permission:delete-expensecategory'],'uses' => 'app\finance\expense\expenseCategoryController@destroy','as' => 'finance.expense.category.destroy']);

   //express category CRUD
   Route::post('/express/expense/category/store',['middleware' => ['permission:create-expensecategory'],'uses' => 'app\finance\expense\expenseCategoryController@express','as' => 'finance.express.expense.category.store']);
   Route::get('/express/expense/category/list',['middleware' => ['permission:create-expensecategory'],'uses' => 'app\finance\expense\expenseCategoryController@list','as' => 'finance.express.expense.category.list']);


   /* === payments === */
   Route::get('payments',['middleware' => ['permission:read-payments'],'uses' => 'app\finance\payments\paymentsController@index','as' => 'finance.payments.received']);
   Route::get('payments/create',['middleware' => ['permission:create-payments'],'uses' => 'app\finance\payments\paymentsController@create','as' => 'finance.payments.create']);
   Route::post('payments/store',['middleware' => ['permission:create-payments'],'uses' => 'app\finance\payments\paymentsController@store','as' => 'finance.payments.store']);
   Route::get('payments/{id}/edit',['middleware' => ['permission:update-payments'],'uses' => 'app\finance\payments\paymentsController@edit','as' => 'finance.payments.edit']);
   Route::post('payments/{id}/update',['middleware' => ['permission:update-payments'],'uses' => 'app\finance\payments\paymentsController@update','as' => 'finance.payments.update']);
   Route::get('payments/{id}/show',['middleware' => ['permission:read-payments'],'uses' => 'app\finance\payments\paymentsController@show','as' => 'finance.payments.show']);
   Route::get('payments/{id}/files',['middleware' => ['permission:create-payments'],'uses' => 'app\finance\payments\paymentsController@files','as' => 'finance.received.files']);
   Route::post('paymentsfile/store',['middleware' => ['permission:create-payments'],'uses' => 'app\finance\payments\paymentsController@file_store','as' => 'finance.receivedfile.store']);
   Route::get('retrive_client/{id}',['middleware' => ['permission:read-payments'],'uses' => 'app\finance\payments\paymentsController@retrive_client','as' => 'finance.retrive.client']);
   Route::get('payment/delete/file/{id}',['middleware' => ['permission:delete-payments'],'uses' => 'app\finance\payments\paymentsController@file_delete','as' => 'finance.payment.file.delete']);
   Route::get('payment/download/file/{id}',['middleware' => ['permission:read-payments'],'uses' => 'app\finance\payments\paymentsController@download','as' => 'finance.payment.file.download']);
   Route::get('payments/{id}/delete',['middleware' => ['permission:delete-payments'],'uses' => 'app\finance\payments\paymentsController@delete','as' => 'finance.payments.delete']);
   Route::get('payments/{id}/print',['middleware' => ['permission:read-payments'],'uses' => 'app\finance\payments\paymentsController@print','as' => 'finance.payments.print']);
   Route::get('payments/{id}/pdf',['middleware' => ['permission:read-payments'],'uses' => 'app\finance\payments\paymentsController@pdf','as' => 'finance.payments.pdf']);
   Route::get('payments/{id}/mail',['middleware' => ['permission:read-payments'],'uses' => 'app\finance\payments\paymentsController@mail','as' => 'finance.payments.mail']);
   Route::post('payments/send',['middleware' => ['permission:read-payments'],'uses' => 'app\finance\payments\paymentsController@send','as' => 'finance.payments.send']);


   /* ================= invoice ================= */
   Route::get('invoices',['middleware' => ['permission:read-invoice'],'uses' => 'app\finance\invoice\invoiceController@index','as' => 'finance.invoice.index']);
   Route::get('invoice/{id}/show',['middleware' => ['permission:read-invoice'],'uses' => 'app\finance\invoice\invoiceController@show','as' => 'finance.invoice.show']);
   Route::get('invoice/{id}/delete',['middleware' => ['permission:delete-invoice'],'uses' => 'app\finance\invoice\invoiceController@delete_invoice','as' => 'finance.invoice.delete']);

   Route::get('invoice/{id}/pdf',['middleware' => ['permission:read-invoice'],'uses' => 'app\finance\invoice\invoiceController@pdf','as' => 'finance.invoice.pdf']);
   Route::get('invoice/{id}/print',['middleware' => ['permission:read-invoice'],'uses' => 'app\finance\invoice\invoiceController@print','as' => 'finance.invoice.print']);
   Route::get('invoice/{id}/deliverynote',['middleware' => ['permission:read-invoice'],'uses' => 'app\finance\invoice\invoiceController@deliverynote','as' => 'finance.invoice.deliverynote']);

   Route::get('invoice/file/{status}/{id}',['middleware' => ['permission:update-invoice'],'uses' => 'app\finance\invoice\invoiceController@update_file_status','as' => 'finance.invoice.attachment.status']);

   Route::post('invoice/payment',['middleware' => ['permission:read-invoice'],'uses' => 'app\finance\invoice\invoiceController@payment','as' => 'finance.invoice.payment']);
   Route::post('invoice/payment/stk/{businessID}',['middleware' => ['permission:read-invoice'],'uses' => 'app\settings\integrations\payments\mpesa\daraja\stkpushController@stkpush','as' => 'finance.invoice.payments.stkpush']);


   //product invoice
   Route::get('invoice/create',['middleware' => ['permission:read-invoice'],'uses' => 'app\finance\invoice\productinvoiceController@create','as' => 'finance.invoice.product.create']);
   Route::post('invoice/store',['middleware' => ['permission:read-invoice'],'uses' => 'app\finance\invoice\productinvoiceController@store','as' => 'finance.invoice.product.store']);
   Route::get('invoice/{id}/edit',['middleware' => ['permission:read-invoice'],'uses' => 'app\finance\invoice\productinvoiceController@edit','as' => 'finance.invoice.product.edit']);
   Route::post('invoice/{id}/update',['middleware' => ['permission:read-invoice'],'uses' => 'app\finance\invoice\productinvoiceController@update','as' => 'finance.invoice.product.update']);

   Route::get('invoice/{id}/mail',['middleware' => ['permission:read-invoice'],'uses' => 'app\finance\invoice\invoiceController@mail','as' => 'finance.invoice.mail']);
   Route::post('invoice/send/mail',['middleware' => ['permission:read-invoice'],'uses' => 'app\finance\invoice\invoiceController@send','as' => 'finance.invoice.send.mail']);

   Route::post('invoice/invoice/attachment',['middleware' => ['permission:create-invoice'],'uses' => 'app\finance\invoice\invoiceController@attachment','as' => 'finance.invoice.attachment']);
   Route::post('invoice/attachment/files',['middleware' => ['permission:create-invoice'],'uses' => 'app\finance\invoice\invoiceController@attachment_files','as' => 'finance.invoice.attachment.files']);
   Route::get('invoice/attachment/{ud}/delete',['middleware' => ['permission:delete-invoice'],'uses' => 'app\finance\invoice\invoiceController@delete_file','as' => 'finance.invoice.attachment.delete']);

   //test invoice
   Route::get('invoice/create/test',['middleware' => ['permission:read-invoice'],'uses' => 'app\finance\invoice\invoiceTestController@create','as' => 'finance.invoice.product.test']);



   //Random invoice
   Route::get('invoice/random/create',['middleware' => ['permission:create-invoice'],'uses' => 'app\finance\invoice\randominvoiceController@create','as' => 'finance.invoice.random.create']);
   Route::post('invoice/random/store',['middleware' => ['permission:create-invoice'],'uses' => 'app\finance\invoice\randominvoiceController@store','as' => 'finance.invoice.random.store']);
   Route::get('invoice/random/{id}/edit',['middleware' => ['permission:update-invoice'],'uses' => 'app\finance\invoice\randominvoiceController@edit','as' => 'finance.invoice.random.edit']);
   Route::post('invoice/random/{id}/update',['middleware' => ['permission:update-invoice'],'uses' => 'app\finance\invoice\randominvoiceController@update','as' => 'finance.invoice.random.update']);

   //recurring invoice
   Route::get('invoice/recurring/create',['middleware' => ['permission:create-invoice'],'uses' => 'app\finance\invoice\recurringController@create','as' => 'finance.invoice.recurring.create']);
   Route::post('invoice/recurring/store',['middleware' => ['permission:create-invoice'],'uses' => 'app\finance\invoice\recurringController@store','as' => 'finance.invoice.recurring.store']);
   Route::get('invoice/recurring/{id}/edit',['middleware' => ['permission:update-invoice'],'uses' => 'app\finance\invoice\recurringController@edit','as' => 'finance.invoice.recurring.edit']);
   Route::post('invoice/recurring/{id}/update',['middleware' => ['permission:update-invoice'],'uses' => 'app\finance\invoice\recurringController@update','as' => 'finance.invoice.recurring.update']);

   /* ================= sales orders ================= */
   Route::get('salesorders',['uses' => 'app\finance\salesorders\salesordersController@index','as' => 'finance.salesorders.index']);
   Route::get('salesorders/create',['uses' => 'app\finance\salesorders\salesordersController@create','as' => 'finance.salesorders.create']);
   Route::post('salesorders/store',['uses' => 'app\finance\salesorders\salesordersController@store','as' => 'finance.salesorders.store']);
   Route::get('salesorders/{id}/edit',['uses' => 'app\finance\salesorders\salesordersController@edit','as' => 'finance.salesorders.edit']);
   Route::post('salesorders/{id}/update',['uses' => 'app\finance\salesorders\salesordersController@update','as' => 'finance.salesorders.update']);
   Route::get('salesorders/{id}/delete',['uses' => 'app\finance\salesorders\salesordersController@delete_salesorder','as' => 'finance.salesorders.delete']);
   Route::get('salesorders/{id}/show',['uses' => 'app\finance\salesorders\salesordersController@show','as' => 'finance.salesorders.show']);
   Route::get('salesorders/{id}/pdf',['uses' => 'app\finance\salesorders\salesordersController@pdf','as' => 'finance.salesorders.pdf']);
   Route::get('salesorders/{id}/print',['uses' => 'app\finance\salesorders\salesordersController@print','as' => 'finance.salesorders.print']);
   Route::post('salesorders/attachment',['uses' => 'app\finance\salesorders\salesordersController@attachment','as' => 'finance.salesorders.attachment']);
   Route::post('salesorders/attachment/files',['uses' => 'app\finance\salesorders\salesordersController@attachment_files','as' => 'finance.salesorders.attachment.files']);
   Route::get('salesorders/file/{status}/{id}',['uses' => 'app\finance\salesorders\salesordersController@update_file_status','as' => 'finance.salesorders.attachment.status']);
   Route::get('salesorders/attached/file/{id}/delete',['uses' => 'app\finance\salesorders\salesordersController@delete_file','as' => 'finance.salesorders.attachment.delete']);

   Route::get('salesorders/status/{salesorderID}/{status}/change',['uses' => 'app\finance\salesorders\salesordersController@change_status','as' => 'finance.salesorders.status.change']);

   //conver sales order to invoice
   Route::get('salesorders/{id}/convert',['uses' => 'app\finance\salesorders\salesordersController@convert_to_invoice','as' => 'finance.salesorders.convert']);

   //send sales order
   Route::get('salesorders/{id}/mail',['uses' => 'app\finance\salesorders\salesordersController@mail','as' => 'finance.salesorders.mail']);
   Route::post('salesorders/mail/send',['uses' => 'app\finance\salesorders\salesordersController@send','as' => 'finance.salesorders.mail.send']);

   //sales order settings
   Route::get('settings/salesorders',[ 'uses' => 'app\finance\settings\salesordersController@index','as' => 'finance.settings.salesorders']);
   Route::post('settings/salesorders/generated/{id}/update',[ 'uses' => 'app\finance\settings\salesordersController@update_generated_number','as' => 'finance.settings.salesorders.generated.update']);

   Route::get('settings/salesorders/{id}/defaults',[ 'uses' => 'app\finance\settings\salesordersController@index','as' => 'finance.settings.salesorders.defaults']);
   Route::post('settings/salesorders/defaults/{id}/update',[ 'uses' => 'app\finance\settings\salesordersController@update_defaults','as' => 'finance.settings.salesorders.defaults.update']);

   Route::get('settings/salesorders/{id}/tabs',[ 'uses' => 'app\finance\settings\salesordersController@index','as' => 'finance.settings.salesorders.tabs']);
   Route::post('settings/salesorders/tabs/{id}/update',[ 'uses' => 'app\finance\settings\salesordersController@update_tabs','as' => 'finance.settings.salesorders.tabs.update']);


   /* ================= Quotes ================= */
   Route::get('quotes',['middleware' => ['permission:read-quotes'],'uses' => 'app\finance\quotes\quotesController@index','as' => 'finance.quotes.index']);
   Route::get('quotes/create',['middleware' => ['permission:create-quotes'],'uses' => 'app\finance\quotes\quotesController@create','as' => 'finance.quotes.create']);
   Route::post('quotes/store',['middleware' => ['permission:create-quotes'],'uses' => 'app\finance\quotes\quotesController@store','as' => 'finance.quotes.store']);
   Route::get('quotes/{id}/edit',['middleware' => ['permission:update-quotes'],'uses' => 'app\finance\quotes\quotesController@edit','as' => 'finance.quotes.edit']);
   Route::post('quotes/{id}/update',['middleware' => ['permission:update-quotes'],'uses' => 'app\finance\quotes\quotesController@update','as' => 'finance.quotes.update']);
   Route::get('quotes/{id}/delete',['middleware' => ['permission:delete-quotes'],'uses' => 'app\finance\quotes\quotesController@delete','as' => 'finance.quotes.delete']);
   Route::get('quotes/{id}/show',['middleware' => ['permission:read-quotes'],'uses' => 'app\finance\quotes\quotesController@show','as' => 'finance.quotes.show']);
   Route::get('quotes/{id}/pdf',['middleware' => ['permission:read-quotes'],'uses' => 'app\finance\quotes\quotesController@pdf','as' => 'finance.quotes.pdf']);
   Route::get('quotes/{id}/print',['middleware' => ['permission:read-quotes'],'uses' => 'app\finance\quotes\quotesController@print','as' => 'finance.quotes.print']);
   Route::post('quotes/attachment',['middleware' => ['permission:create-quotes'],'uses' => 'app\finance\quotes\quotesController@attachment','as' => 'finance.quotes.attachment']);
   Route::post('quotes/attachment/files',['middleware' => ['permission:create-quotes'],'uses' => 'app\finance\quotes\quotesController@attachment_files','as' => 'finance.quotes.attachment.files']);
   Route::get('quotes/file/{status}/{id}',['middleware' => ['permission:create-quotes'],'uses' => 'app\finance\quotes\quotesController@update_file_status','as' => 'finance.quotes.attachment.status']);
   Route::get('quotes/attached/file/{id}/delete',['middleware' => ['permission:create-quotes'],'uses' => 'app\finance\quotes\quotesController@delete_file','as' => 'finance.quotes.attachment.delete']);
   Route::get('quotes/attachment/{quotesID}/{status}/change',['middleware' => ['permission:create-quotes'],'uses' => 'app\finance\quotes\quotesController@change_status','as' => 'finance.quotes.status.change']);
   Route::get('quotes/{id}/convert',['middleware' => ['permission:create-quotes'],'uses' => 'app\finance\quotes\quotesController@convert_to_invoice','as' => 'finance.quotes.convert']);
   Route::get('quotes/{id}/delete',['middleware' => ['permission:delete-quotes'],'uses' => 'app\finance\quotes\quotesController@delete_quotes','as' => 'finance.quotes.delete']);

   //send quotes
   Route::get('quotes/{id}/mail',['uses' => 'app\finance\quotes\quotesController@mail','as' => 'finance.quotes.mail']);
   Route::post('quotes/mail/send',['uses' => 'app\finance\quotes\quotesController@send','as' => 'finance.quotes.mail.send']);

   /* ================= lpo ================= */
   Route::get('purchaseorders',['middleware' => ['permission:read-lpo'],'uses' => 'app\finance\lpo\lpoController@index','as' => 'finance.lpo.index']);
   Route::get('purchaseorders/create',['middleware' => ['permission:create-lpo'],'uses' => 'app\finance\lpo\lpoController@create','as' => 'finance.lpo.create']);
   Route::post('purchaseorders/store',['middleware' => ['permission:create-lpo'],'uses' => 'app\finance\lpo\lpoController@store','as' => 'finance.lpo.store']);
   Route::get('purchaseorders/{id}/edit',['middleware' => ['permission:update-lpo'],'uses' => 'app\finance\lpo\lpoController@edit','as' => 'finance.lpo.edit']);
   Route::post('purchaseorders/{id}/update',['middleware' => ['permission:update-lpo'],'uses' => 'app\finance\lpo\lpoController@update','as' => 'finance.lpo.update']);
   Route::get('purchaseorders/{id}/delete',['middleware' => ['permission:delete-lpo'],'uses' => 'app\finance\lpo\lpoController@delete','as' => 'finance.lpo.delete']);
   Route::get('purchaseorders/{id}/show',['middleware' => ['permission:read-lpo'],'uses' => 'app\finance\lpo\lpoController@show','as' => 'finance.lpo.show']);
   Route::get('purchaseorders/{id}/pdf',['middleware' => ['permission:read-lpo'],'uses' => 'app\finance\lpo\lpoController@pdf','as' => 'finance.lpo.pdf']);
   Route::get('purchaseorders/{id}/print',['middleware' => ['permission:read-lpo'],'uses' => 'app\finance\lpo\lpoController@print','as' => 'finance.lpo.print']);
   Route::post('purchaseorders/attachment',['middleware' => ['permission:read-lpo'],'uses' => 'app\finance\lpo\lpoController@attachment','as' => 'finance.lpo.attachment']);
   Route::post('purchaseorders/attachment/files',['middleware' => ['permission:read-lpo'],'uses' => 'app\finance\lpo\lpoController@attachment_files','as' => 'finance.lpo.attachment.files']);
   Route::get('purchaseorders/file/{status}/{id}',['middleware' => ['permission:read-lpo'],'uses' => 'app\finance\lpo\lpoController@update_file_status','as' => 'finance.lpo.attachment.status']);
   Route::get('purchaseorders/attached/file/{id}/delete',['middleware' => ['permission:read-lpo'],'uses' => 'app\finance\lpo\lpoController@delete_file','as' => 'finance.lpo.attachment.delete']);
   Route::get('purchaseorders/attachment/{lpoID}/{status}/change',['middleware' => ['permission:read-lpo'],'uses' => 'app\finance\lpo\lpoController@change_status','as' => 'finance.lpo.status.change']);
   Route::get('purchaseorders/{id}/convert',['middleware' => ['permission:read-lpo'],'uses' => 'app\finance\lpo\lpoController@convert_to_invoice','as' => 'finance.lpo.convert']);
   Route::get('purchaseorders/{id}/delete',['middleware' => ['permission:delete-lpo'],'uses' => 'app\finance\lpo\lpoController@delete_lpo','as' => 'finance.lpo.delete']);
   Route::get('purchaseorders/{id}/convert',['middleware' => ['permission:delete-lpo'],'uses' => 'app\finance\lpo\lpoController@convert','as' => 'finance.lpo.convert']);

   //send lpo
   Route::get('purchaseorders/{id}/mail',['middleware' => ['permission:create-lpo'],'uses' => 'app\finance\lpo\lpoController@mail','as' => 'finance.lpo.mail']);
   Route::post('purchaseorders/mail/send',['middleware' => ['permission:create-lpo'],'uses' => 'app\finance\lpo\lpoController@send','as' => 'finance.lpo.mail.send']);

   /* ================= credit note ================= */
   Route::get('creditnote',['middleware' => ['permission:read-creditnote'],'uses' => 'app\finance\creditnote\creditnoteController@index','as' => 'finance.creditnote.index']);
   Route::get('creditnote/create',['middleware' => ['permission:create-creditnote'],'uses' => 'app\finance\creditnote\creditnoteController@create','as' => 'finance.creditnote.create']);
   Route::post('creditnote/store',['middleware' => ['permission:create-creditnote'],'uses' => 'app\finance\creditnote\creditnoteController@store','as' => 'finance.creditnote.store']);
   Route::get('creditnote/{id}/edit',['middleware' => ['permission:update-creditnote'],'uses' => 'app\finance\creditnote\creditnoteController@edit','as' => 'finance.creditnote.edit']);
   Route::post('creditnote/{id}/update',['middleware' => ['permission:update-creditnote'],'uses' => 'app\finance\creditnote\creditnoteController@update','as' => 'finance.creditnote.update']);
   Route::get('creditnote/{id}/delete',['middleware' => ['permission:delete-creditnote'],'uses' => 'app\finance\creditnote\creditnoteController@delete','as' => 'finance.creditnote.delete']);
   Route::get('creditnote/{id}/show',['middleware' => ['permission:read-creditnote'],'uses' => 'app\finance\creditnote\creditnoteController@show','as' => 'finance.creditnote.show']);
   Route::get('creditnote/{id}/pdf',['middleware' => ['permission:read-creditnote'],'uses' => 'app\finance\creditnote\creditnoteController@pdf','as' => 'finance.creditnote.pdf']);
   Route::get('creditnote/{id}/print',['middleware' => ['permission:read-creditnote'],'uses' => 'app\finance\creditnote\creditnoteController@print','as' => 'finance.creditnote.print']);
   Route::post('creditnote/attachment',['middleware' => ['permission:read-creditnote'],'uses' => 'app\finance\creditnote\creditnoteController@attachment','as' => 'finance.creditnote.attachment']);
   Route::post('creditnote/attachment/files',['middleware' => ['permission:read-creditnote'],'uses' => 'app\finance\creditnote\creditnoteController@attachment_files','as' => 'finance.creditnote.attachment.files']);
   Route::get('creditnote/file/{status}/{id}',['middleware' => ['permission:read-creditnote'],'uses' => 'app\finance\creditnote\creditnoteController@update_file_status','as' => 'finance.creditnote.attachment.status']);
   Route::get('creditnote/attached/file/{id}/delete',['middleware' => ['permission:delete-creditnote'],'uses' => 'app\finance\creditnote\creditnoteController@delete_file','as' => 'finance.creditnote.attachment.delete']);
   Route::get('creditnote/attachment/{creditnoteID}/{status}/change',['middleware' => ['permission:delete-creditnote'],'uses' => 'app\finance\creditnote\creditnoteController@change_status','as' => 'finance.creditnote.status.change']);
   Route::get('creditnote/{id}/convert',['middleware' => ['permission:create-creditnote'],'uses' => 'app\finance\creditnote\creditnoteController@convert_to_invoice','as' => 'finance.creditnote.convert']);
   Route::post('creditnote/apply/credit',['middleware' => ['permission:read-creditnote'],'uses' => 'app\finance\creditnote\creditnoteController@apply_credit','as' => 'finance.creditnote.apply.credit']);
   Route::get('creditnote/{id}/delete',['middleware' => ['permission:delete-creditnote'],'uses' => 'app\finance\creditnote\creditnoteController@delete_creditnote','as' => 'finance.creditnote.delete']);

   //send creditnote
   Route::get('creditnote/{id}/mail',['middleware' => ['permission:read-creditnote'],'uses' => 'app\finance\creditnote\creditnoteController@mail','as' => 'finance.creditnote.mail']);
   Route::post('creditnote/mail/send',['middleware' => ['permission:read-creditnote'],'uses' => 'app\finance\creditnote\creditnoteController@send','as' => 'finance.creditnote.mail.send']);

   /* === settings === */
   //invoices
   Route::get('settings/invoice',['middleware' => ['permission:create-invoice'],'uses' => 'app\finance\settings\invoiceController@index','as' => 'finance.settings.invoice']);
   Route::post('settings/invoice/generated/{id}/update',['middleware' => ['permission:create-invoice'],'uses' => 'app\finance\settings\invoiceController@update_generated_number','as' => 'finance.settings.invoice.generated.update']);

   Route::get('settings/invoice/{id}/defaults',['middleware' => ['permission:create-invoice'],'uses' => 'app\finance\settings\invoiceController@index','as' => 'finance.settings.invoice.defaults']);
   Route::post('settings/invoice/defaults/{id}/update',['middleware' => ['permission:create-invoice'],'uses' => 'app\finance\settings\invoiceController@update_defaults','as' => 'finance.settings.invoice.defaults.update']);

   Route::get('settings/invoice/{id}/workflow',['middleware' => ['permission:create-invoice'],'uses' => 'app\finance\settings\invoiceController@index','as' => 'finance.settings.invoice.workflow']);
   Route::post('settings/invoice/workflow/{id}/update',['middleware' => ['permission:create-invoice'],'uses' => 'app\finance\settings\invoiceController@update_workflow','as' => 'finance.settings.invoice.workflow.update']);

   Route::get('settings/invoice/{id}/payments',['middleware' => ['permission:create-invoice'],'uses' => 'app\finance\settings\invoiceController@index','as' => 'finance.settings.invoice.payments']);
   Route::post('settings/invoice/payments/{id}/update',['middleware' => ['permission:create-invoice'],'uses' => 'app\finance\settings\invoiceController@update_payments','as' => 'finance.settings.invoice.payments.update']);

   Route::get('settings/invoice/{id}/tabs',['middleware' => ['permission:create-invoice'],'uses' => 'app\finance\settings\invoiceController@index','as' => 'finance.settings.invoice.tabs']);
   Route::post('settings/invoice/tabs/{id}/update',['middleware' => ['permission:create-invoice'],'uses' => 'app\finance\settings\invoiceController@update_tabs','as' => 'finance.settings.invoice.tabs.update']);

   //quotes
   Route::get('settings/quote',['middleware' => ['permission:create-quotes'], 'uses' => 'app\finance\settings\quoteController@index','as' => 'finance.settings.quote']);
   Route::post('settings/quote/generated/{id}/update',['middleware' => ['permission:create-quotes'],'uses' => 'app\finance\settings\quoteController@update_generated_number','as' => 'finance.settings.quote.generated.update']);

   Route::get('settings/quote/{id}/defaults',['middleware' => ['permission:create-quotes'],'uses' => 'app\finance\settings\quoteController@index','as' => 'finance.settings.quote.defaults']);
   Route::post('settings/quote/defaults/{id}/update',['middleware' => ['permission:create-quotes'],'uses' => 'app\finance\settings\quoteController@update_defaults','as' => 'finance.settings.quote.defaults.update']);

   Route::get('settings/quote/{id}/tabs',['middleware' => ['permission:create-quotes'],'uses' => 'app\finance\settings\quoteController@index','as' => 'finance.settings.quote.tabs']);
   Route::post('settings/quote/tabs/{id}/update',['middleware' => ['permission:create-quotes'],'uses' => 'app\finance\settings\quoteController@update_tabs','as' => 'finance.settings.quote.tabs.update']);

   //creditnote
   Route::get('settings/creditnote',['middleware' => ['permission:create-creditnote'],'uses' => 'app\finance\settings\creditnoteController@index','as' => 'finance.settings.creditnote']);
   Route::post('settings/creditnote/generated/{id}/update',['middleware' => ['permission:create-creditnote'],'uses' => 'app\finance\settings\creditnoteController@update_generated_number','as' => 'finance.settings.creditnote.generated.update']);

   Route::get('settings/creditnote/{id}/defaults',['middleware' => ['permission:create-creditnote'],'uses' => 'app\finance\settings\creditnoteController@index','as' => 'finance.settings.creditnote.defaults']);
   Route::post('settings/creditnote/defaults/{id}/update',['middleware' => ['permission:create-creditnote'],'uses' => 'app\finance\settings\creditnoteController@update_defaults','as' => 'finance.settings.creditnote.defaults.update']);

   Route::get('settings/creditnote/{id}/tabs',['middleware' => ['permission:create-creditnote'],'uses' => 'app\finance\settings\creditnoteController@index','as' => 'finance.settings.creditnote.tabs']);
   Route::post('settings/creditnote/tabs/{id}/update',['middleware' => ['permission:create-creditnote'],'uses' => 'app\finance\settings\creditnoteController@update_tabs','as' => 'finance.settings.creditnote.tabs.update']);

   //taxes
   Route::get('settings/taxes',['middleware' => ['permission:create-taxes'],'uses' => 'app\finance\settings\taxesController@index','as' => 'finance.settings.taxes']);
   Route::post('settings/taxes/store',['middleware' => ['permission:create-taxes'],'uses' => 'app\finance\settings\taxesController@store','as' => 'finance.settings.taxes.store']);
   Route::get('settings/taxes/{id}/edit',['middleware' => ['permission:create-taxes'],'uses' => 'app\finance\settings\taxesController@edit','as' => 'finance.settings.taxes.edit']);
   Route::post('settings/taxes/update',['middleware' => ['permission:create-taxes'],'uses' => 'app\finance\settings\taxesController@update','as' => 'finance.settings.update']);
   Route::get('settings/taxes/{id}/delete',['middleware' => ['permission:create-taxes'],'uses' => 'app\finance\settings\taxesController@delete','as' => 'finance.settings.delete']);

   //tax express
   Route::get('/taxes/express',['middleware' => ['permission:create-taxes'],'uses' => 'app\finance\settings\taxesController@express_list','as' => 'finance.settings.taxes.express']);
   Route::post('/taxes/express/store',['middleware' => ['permission:create-taxes'],'uses' => 'app\finance\settings\taxesController@store_express','as' => 'finance.settings.taxes.express.store']);

   //Local purchase order
   Route::get('settings/lpo',['middleware' => ['permission:create-lpo'],'uses' => 'app\finance\settings\lpoController@index','as' => 'finance.settings.lpo']);
   Route::post('settings/lpo/generated/{id}/update',['middleware' => ['permission:create-lpo'],'uses' => 'app\finance\settings\lpoController@update_generated_number','as' => 'finance.settings.lpo.generated.update']);

   Route::get('settings/lpo/{id}/defaults',['middleware' => ['permission:create-lpo'],'uses' => 'app\finance\settings\lpoController@index','as' => 'finance.settings.lpo.defaults']);
   Route::post('settings/lpo/defaults/{id}/update',['middleware' => ['permission:create-lpo'],'uses' => 'app\finance\settings\lpoController@update_defaults','as' => 'finance.settings.lpo.defaults.update']);

   Route::get('settings/lpo/{id}/tabs',['middleware' => ['permission:create-lpo'],'uses' => 'app\finance\settings\lpoController@index','as' => 'finance.settings.lpo.tabs']);
   Route::post('settings/lpo/tabs/{id}/update',['middleware' => ['permission:create-lpo'],'uses' => 'app\finance\settings\lpoController@update_tabs','as' => 'finance.settings.lpo.tabs.update']);


   // bank accounts
   Route::get('account/',['middleware' => ['permission:read-bankaccount'], 'uses' => 'app\finance\account\accountController@index','as' => 'finance.account']);
   Route::get('account/create',['middleware' => ['permission:create-bankaccount'], 'uses' => 'app\finance\account\accountController@create','as' => 'finance.account.create']);
   Route::post('account/store',['middleware' => ['permission:create-bankaccount'], 'uses' => 'app\finance\account\accountController@store','as' => 'finance.account.store']);
   Route::get('account/{id}/edit',['middleware' => ['permission:update-bankaccount'], 'uses' => 'app\finance\account\accountController@edit','as' => 'finance.account.edit']);
   Route::post('account/{id}/update',['middleware' => ['permission:update-bankaccount'], 'uses' => 'app\finance\account\accountController@update','as' => 'finance.account.update']);
   Route::get('account/{id}/delete',['middleware' => ['permission:delete-bankaccount'], 'uses' => 'app\finance\account\accountController@delete','as' => 'finance.account.delete']);

   //express account crud
   Route::post('/express/account/store',['middleware' => ['permission:create-bankaccount'], 'uses' => 'app\finance\account\accountController@express','as' => 'finance.account.express']);
   Route::get('access/bank/account/', 'app\finance\account\accountController@list')->name('finance.bank.account.access');

   // income category
   Route::get('income/category/',['middleware' => ['permission:read-incomecategory'], 'uses' => 'app\finance\income\incomeController@index','as' => 'finance.income.category']);
   Route::get('income/category/create',['middleware' => ['permission:create-incomecategory'], 'uses' => 'app\finance\income\incomeController@create','as' => 'finance.income.category.create']);
   Route::post('income/category/store',['middleware' => ['permission:create-incomecategory'], 'uses' => 'app\finance\income\incomeController@store','as' => 'finance.income.category.store']);
   Route::get('income/category/{id}/edit',['middleware' => ['permission:update-incomecategory'], 'uses' => 'app\finance\income\incomeController@edit','as' => 'finance.income.category.edit']);
   Route::post('income/category/update',['middleware' => ['permission:update-incomecategory'], 'uses' => 'app\finance\income\incomeController@update','as' => 'finance.income.category.update']);
   Route::get('income/category/{id}/delete',['middleware' => ['permission:delete-incomecategory'], 'uses' => 'app\finance\income\incomeController@delete','as' => 'finance.income.category.delete']);
   Route::post('express/income/category/create',['middleware' => ['permission:create-incomecategory'], 'uses' => 'app\finance\income\incomeController@express']);
   Route::get('express/income/category/get',['middleware' => ['permission:read-incomecategory'], 'uses' => 'app\finance\income\incomeController@get_express','as' => 'finance.income.express.category']);

   //payment mode
   Route::get('settings/payment/modes',['middleware' => ['permission:read-paymentmode'], 'uses' => 'app\finance\payments\paymentModeController@index','as' => 'finance.payment.mode']);
   Route::post('settings/payment/modes/store',['middleware' => ['permission:create-paymentmode'], 'uses' => 'app\finance\payments\paymentModeController@store','as' => 'finance.payment.mode.store']);
   Route::post('settings/payment/modes/{id}/update',['middleware' => ['permission:update-paymentmode'], 'uses' => 'app\finance\payments\paymentModeController@update','as' => 'finance.payment.mode.update']);
   Route::get('settings/payment/modes/{id}/delete',['middleware' => ['permission:delete-paymentmode'], 'uses' => 'app\finance\payments\paymentModeController@delete','as' => 'finance.payment.mode.delete']);

   //payment method express
   Route::get('express/payment/list',['middleware' => ['permission:read-paymentmode'], 'uses' => 'app\finance\payments\paymentModeController@express_list','as' => 'finance.payment.mode.express']);
   Route::post('express/payment/modes/store',['middleware' => ['permission:create-paymentmode'], 'uses' => 'app\finance\payments\paymentModeController@express_store','as' => 'finance.payment.mode.express.store']);

   /**
   * Reports
   */
   Route::get('/reports',['middleware' => ['permission:read-financereport'], 'uses' => 'app\finance\report\reportsController@dashboard','as' => 'finance.report']);

   //statement of account
   Route::get('report/account-statement',['middleware' => ['permission:read-financereport'], 'uses' => 'app\finance\report\accountStatementController@index','as' => 'finance.report.account.statement']);
   Route::post('report/account-statement/process',['middleware' => ['permission:read-financereport'], 'uses' => 'app\finance\report\accountStatementController@process','as' => 'finance.report.account.statement.process']);
   Route::get('report/account-statement/{clientID}/{from}/{to}/{transaction}/results',['middleware' => ['permission:read-financereport'], 'uses' => 'app\finance\report\accountStatementController@results','as' => 'finance.report.account.statement.results']);
   Route::get('report/account-statement/{clientID}/{from}/{to}/{transaction}/export/excel',['middleware' => ['permission:read-financereport'], 'uses' => 'app\finance\report\accountStatementController@excel','as' => 'finance.report.account.statement.export.excel']);
   Route::get('report/account-statement/{clientID}/{from}/{to}/{transaction}/export/pdf',['middleware' => ['permission:read-financereport'], 'uses' => 'app\finance\report\accountStatementController@pdf','as' => 'finance.report.account.statement.export.pdf']);
   Route::get('report/account-statement/{clientID}/{from}/{to}/{transaction}/export/print',['middleware' => ['permission:read-financereport'], 'uses' => 'app\finance\report\accountStatementController@print','as' => 'finance.report.account.statement.export.print']);

   //profit and loss
   //Route::get('report/profitandloss',['middleware' => ['permission:read-financereport'], 'uses' => 'app\finance\report\profitandlossController@index','as' => 'finance.report.profitandloss']);

   //balance sheet
   Route::get('report/balancesheet',['middleware' => ['permission:read-financereport'], 'uses' => 'app\finance\report\balancesheetController@index','as' => 'finance.report.balancesheet']);

   //sales by customer
   Route::get('report/sales/customer',['uses' => 'app\finance\report\sales\customerController@salesbycustomer','as' => 'finance.report.sales.customer']);
   Route::get('report/sales/customer/print/{to}/{from}',['uses' => 'app\finance\report\sales\customerController@print','as' => 'finance.report.sales.customer.print']);
   Route::get('report/sales/customer/pdf/{to}/{from}',['uses' => 'app\finance\report\sales\customerController@pdf','as' => 'finance.report.sales.customer.pdf']);

   //sales by item
   Route::get('report/sales/item',['uses' => 'app\finance\report\sales\itemController@salesbyitem','as' => 'finance.report.sales.item']);
   Route::get('report/sales/item/print/{to}/{from}',['uses' => 'app\finance\report\sales\itemController@print','as' => 'finance.report.sales.item.print']);
   Route::get('report/sales/item/pdf/{to}/{from}',['uses' => 'app\finance\report\sales\itemController@pdf','as' => 'finance.report.sales.item.pdf']);

   //sales by sales person
   Route::get('report/sales/salesperson',['uses' => 'app\finance\report\sales\salespersonController@salesbysalesperson','as' => 'finance.report.sales.salesperson']);
   Route::get('report/sales/salesperson/print/{to}/{from}',['uses' => 'app\finance\report\sales\salespersonController@print','as' => 'finance.report.sales.salesperson.print']);
   Route::get('report/sales/salesperson/pdf/{to}/{from}',['uses' => 'app\finance\report\sales\salespersonController@pdf','as' => 'finance.report.sales.salesperson.pdf']);

   //Customer Balances report
   Route::get('report/receivables/customerbalances',['uses' => 'app\finance\report\receivables\customerbalancesController@balance','as' => 'finance.report.receivables.balance']);
   Route::get('report/sales/receivables/print/{to}/{from}',['uses' => 'app\finance\report\receivables\customerbalancesController@print','as' => 'finance.report.receivables.balance.print']);
   Route::get('report/sales/receivables/pdf/{to}/{from}',['uses' => 'app\finance\report\receivables\customerbalancesController@pdf','as' => 'finance.report.receivables.balance.pdf']);

   //aging report
   Route::get('report/receivables/aging',['uses' => 'app\finance\report\receivables\agingController@report','as' => 'finance.report.receivables.aging']);
   Route::get('report/receivables/aging/extract/{format}/{to}/{from}',['uses' => 'app\finance\report\receivables\agingController@extract','as' => 'finance.report.receivables.aging.extract']);

   //profite and loss
   Route::get('report/profilandloss',['uses' => 'app\finance\report\profitandlossController@details','as' => 'finance.report.profitandloss']);
   Route::get('report/profilandloss/pdf/{to}/{from}',['uses' => 'app\finance\report\profitandlossController@pdf','as' => 'finance.report.profitandloss.pdf']);

   //Expense Summary
   Route::get('report/expensesummary',['uses' => 'app\finance\report\expensesummaryController@details','as' => 'finance.report.expensesummary']);
   Route::get('report/expensesummary/extract/{to}/{from}',['uses' => 'app\finance\report\expensesummaryController@extract','as' => 'finance.report.expensesummary.extract']);

   //Income Summary
   Route::get('report/incomesummary',['uses' => 'app\finance\report\incomesummaryController@report','as' => 'finance.report.incomesummary']);
   Route::get('report/incomesummary/{to}/{from}/extract',['uses' => 'app\finance\report\incomesummaryController@extract','as' => 'finance.report.incomesummary.extract']);

   /**
   * Inventory report
   */
   //inventory summary
   Route::get('report/inventory/summary',['uses' => 'app\finance\report\inventory\summaryController@report','as' => 'finance.report.inventory.summary']);
   Route::get('report/inventory/summary/{to}/{from}/print',['uses' => 'app\finance\report\inventory\summaryController@print','as' => 'finance.report.inventory.summary.print']);
   Route::get('report/inventory/summary/{to}/{from}/pdf',['uses' => 'app\finance\report\inventory\summaryController@pdf','as' => 'finance.report.inventory.summary.pdf']);

   //Inventory Valuation Summary
   Route::get('report/inventory/valuation/summary',['uses' => 'app\finance\report\inventory\valuationController@report','as' => 'finance.report.inventory.valuation.summary']);
   Route::get('report/inventory/valuation/summary/{to}/{from}/print',['uses' => 'app\finance\report\inventory\valuationController@print','as' => 'finance.report.inventory.valuation.summary.print']);
   Route::get('report/inventory/valuation/summary/{to}/{from}/pdf',['uses' => 'app\finance\report\inventory\valuationController@pdf','as' => 'finance.report.inventory.valuation.summary.pdf']);

   //Inventory product sale report
   Route::get('report/inventory/product-sale/summary',['uses' => 'app\finance\report\inventory\productsaleController@report','as' => 'finance.report.inventory.sale.summary']);
   Route::get('report/inventory/product-sale/summary/{to}/{from}/print',['uses' => 'app\finance\report\inventory\productsaleController@print','as' => 'finance.report.inventory.sale.summary.print']);
   Route::get('report/inventory/product-sale/summary/{to}/{from}/pdf',['uses' => 'app\finance\report\inventory\productsaleController@pdf','as' => 'finance.report.inventory.sale.summary.pdf']);

});

/*
|--------------------------------------------------------------------------
| Human resource
|--------------------------------------------------------------------------
|
| Manage contents of your website quick and first
*/
Route::prefix('hrm')->middleware('auth')->group(function () {

   Route::get('/', ['middleware' => ['permission:access-humanresource'], 'uses' => 'app\hr\dashboard\dashboardController@dashboard','as' => 'hrm.dashboard']);

   /*=== create employee ==*/
   //Route::get('employee', ['middleware' => ['permission:read-employee'], 'uses' => 'app\hr\employee\employeeController@index','as' => 'hrm.employee.index']);
   Route::get('employee/list', ['middleware' => ['permission:read-employee'], 'uses' => 'app\hr\employee\employeeController@index','as' => 'hrm.employee.index']);
   Route::get('employee/create', ['middleware' => ['permission:create-employee'], 'uses' => 'app\hr\employee\employeeController@create','as' => 'hrm.employee.create']);
   Route::post('employee/store', ['middleware' => ['permission:create-employee'], 'uses' => 'app\hr\employee\employeeController@store','as' => 'hrm.employee.store']);
   Route::post('employee/{id}/update', ['middleware' => ['permission:update-employee'], 'uses' => 'app\hr\employee\employeeController@update','as' => 'hrm.employee.update']);

   /*=== view employee details ===*/
   Route::get('employee/{id}/show', ['middleware' => ['permission:read-employee'], 'uses' => 'app\hr\employee\employeeController@show','as' => 'hrm.employee.show']);

   /*=== staff profile ===*/
   Route::get('employee/{id}/edit', ['middleware' => ['permission:update-employee'], 'uses' => 'app\hr\employee\employeeController@edit','as' => 'hrm.employee.edit']);
   Route::post('employee/{id}/update', ['middleware' => ['permission:update-employee'], 'uses' => 'app\hr\employee\employeeController@update','as' => 'hrm.employee.update']);


   /*=== personal info ===*/
   Route::get('personal-info/{id}/edit', ['middleware' => ['permission:read-employeepersonalinformation'], 'uses' => 'app\hr\employee\personalinfoController@edit','as' => 'hrm.personalinfo.edit']);
   Route::post('personal-info/{id}/update', ['middleware' => ['permission:update-employeepersonalinformation'], 'uses' => 'app\hr\employee\personalinfoController@update','as' => 'hrm.personalinfo.update']);


   /*=== company structure ===*/
   Route::get('employee/company-structure/{id}/edit', ['middleware' => ['permission:update-employeecompanystructure'], 'uses' => 'app\hr\employee\companyStructureController@edit','as' => 'hrm.employee.company.structure.edit']);
   Route::post('employee/company/structure/update', ['middleware' => ['permission:update-employeecompanystructure'], 'uses' => 'app\hr\employee\companyStructureController@update','as' => 'hrm.employee.company.structure.update']);


   /*=== employee salary ===*/
   Route::get('salary/{id}/edit', ['middleware' => ['permission:read-employeesalary'], 'uses' => 'app\hr\employee\salaryController@edit','as' => 'hrm.employee.salary.edit']);
   Route::post('salary/{id}/update', ['middleware' => ['permission:update-employeesalary'], 'uses' => 'app\hr\employee\salaryController@update','as' => 'hrm.employee.salary.update']);


   /*=== bank information ===*/
   Route::get('bank-information/{id}/edit', ['middleware' => ['permission:read-employeebankinformation'], 'uses' => 'app\hr\employee\bankinformationController@edit','as' => 'hrm.employeebankinformation.edit']);
   Route::post('bank-information/{id}/update', ['middleware' => ['permission:update-employeebankinformation'], 'uses' => 'app\hr\employee\bankinformationController@update','as' => 'hrm.employeebankinformation.update']);


   /*=== Academic information ===*/
   Route::get('academic-information/{id}/edit', ['middleware' => ['permission:read-employeeacademicinformation'], 'uses' => 'app\hr\employee\academicinformationController@edit','as' => 'hrm.employeeacademicinformation.edit']);
   Route::post('academic-information/{id}/update', ['middleware' => ['permission:update-employeeacademicinformation'], 'uses' => 'app\hr\employee\academicinformationController@update','as' => 'hrm.employeeacademicinformation.update']);


   /*=== Institution ===*/
   Route::post('institution-information-post',['middleware' => ['permission:read-employeeacademicinformation'], 'uses' => 'app\hr\employee\academicinformationController@post_institution','as' => 'hrm.institutioninformation.post']);
   Route::get('delete-institution/{id}',['middleware' => ['permission:delete-employeeacademicinformation'], 'uses' => 'app\hr\employee\academicinformationController@delete_institution','as' => 'hrm.institution.delete']);
   Route::get('institution-edit/{id}',['middleware' => ['permission:update-employeeacademicinformation'], 'uses' => 'app\hr\employee\academicinformationController@edit_institution','as' => 'hrm.institution.edit']);


   /*=== work experience ===*/
   Route::get('experience/{id}/edit',['middleware' => ['permission:read-employeeworkexperience'], 'uses' => 'app\hr\employee\workexperienceController@edit','as' => 'hrm.experience.edit']);
   Route::post('experience/post',['middleware' => ['permission:store-employeeworkexperience'], 'uses' => 'app\hr\employee\workexperienceController@store','as' => 'hrm.experience.store']);
   Route::get('experience/{id}/delete',['middleware' => ['permission:delete-employeeworkexperience'], 'uses' => 'app\hr\employee\workexperienceController@delete','as' => 'hrm.experience.delete']);


   /*=== employee alocations ===*/
   Route::get('allocation/{id}/edit',['middleware' => ['permission:update-employeealocations'], 'uses' => 'app\hr\employee\allocationController@edit','as' => 'hrm.allocation.edit']);
   Route::post('allocation/post',['middleware' => ['permission:create-employeealocations'], 'uses' => 'app\hr\employee\allocationController@store','as' => 'hrm.allocation.store']);
   Route::get('delete/{id}/allocation',['middleware' => ['permission:delete-employeealocations'], 'uses' => 'app\hr\employee\allocationController@delete','as' => 'hrm.allocation.delete']);


   /*=== family info ===*/
   Route::get('family-information/{id}/edit',['middleware' => ['permission:read-employeefamilyinformation'], 'uses' => 'app\hr\employee\familyController@edit','as' => 'hrm.famillyinfo.edit']);
   Route::post('family-information-post',['middleware' => ['permission:create-employeefamilyinformation'], 'uses' => 'app\hr\employee\familyController@post_family','as' => 'hrm.famillyinfo.post']);
   Route::get('delete-family-information/{id}',['middleware' => ['permission:delete-employeefamilyinformation'],  'uses' => 'app\hr\employee\familyController@delete_family_information','as' => 'hrm.famillyinfo.delete']);


   /*=== employee files ===*/
   Route::get('files/{id}/edit',['middleware' => ['permission:read-employeefiles'], 'uses' => 'app\hr\employee\filesController@edit','as' => 'hrm.employeefile.edit']);
   Route::post('file-post',['uses' => 'app\hr\employee\filesController@post_file','as' => 'hrm.employeefile.post']);
   Route::get('delete-file/{id}',['middleware' => ['permission:delete-employeefiles'], 'uses' => 'app\hr\employee\filesController@delete_file','as' => 'hrm.employeefile.delete']);

   /*=== employee roles ===*/
   Route::get('roles/{id}/edit',['middleware' => ['permission:read-employeeroles'], 'uses' => 'app\hr\employee\employeerolesController@edit','as' => 'hrm.employeerole.edit']);

   /*=== employee deductions ===*/
   Route::get('employee/deductions/{id}/edit',['middleware' => ['permission:read-employeedeductions'], 'uses' => 'app\hr\employee\deductionsController@index','as' => 'hrm.employee.deductions']);
   Route::post('employee/deductions/allocate',['middleware' => ['permission:read-employeedeductions'], 'uses' => 'app\hr\employee\deductionsController@allocate','as' => 'hrm.employee.deductions.allocate']);
   Route::get('employee/deductions/delete/{id}/allocate',['middleware' => ['permission:read-employeedeductions'], 'uses' => 'app\hr\employee\deductionsController@delete','as' => 'hrm.employee.deductions.delete.allocate']);


   /* ================== leave ================== */
   Route::get('leave',['middleware' => ['permission:read-leave'], 'uses' => 'app\hr\leave\leaveController@index','as' => 'hrm.leave.index']);
   Route::get('leave/create',['middleware' => ['permission:create-leave'], 'uses' => 'app\hr\leave\leaveController@create','as' => 'hrm.leave.create']);
   Route::post('leave/store',['middleware' => ['permission:create-leave'], 'uses' => 'app\hr\leave\leaveController@store','as' => 'hrm.leave.store']);
   Route::get('leave/{id}/edit',['middleware' => ['permission:update-leave'], 'uses' => 'app\hr\leave\leaveController@edit','as' => 'hrm.leave.edit']);
   Route::post('leave/{id}/update',['middleware' => ['permission:update-leave'], 'uses' => 'app\hr\leave\leaveController@update','as' => 'hrm.leave.update']);
   Route::get('leave/balance',['middleware' => ['permission:read-leave'], 'uses' => 'app\hr\leave\leaveController@balance','as' => 'hrm.leave.balance']);
   Route::get('leave/calendar',['middleware' => ['permission:read-leave'], 'uses' => 'app\hr\leave\leaveController@calendar','as' => 'hrm.leave.calendar']);

   Route::get('leave/{id}/approve',['middleware' => ['permission:create-leave'], 'uses' => 'app\hr\leave\leaveController@approve','as' => 'hrm.leave.approve']);
   Route::get('leave/{id}/denay',['middleware' => ['permission:create-leave'], 'uses' => 'app\hr\leave\leaveController@denay','as' => 'hrm.leave.denay']);
   Route::get('leave/{id}/delete',['middleware' => ['permission:delete-leave'], 'uses' => 'app\hr\leave\leaveController@delete','as' => 'hrm.leave.delete']);

   //apply leave
   Route::get('leave/apply',['uses' => 'app\hr\leave\leaveapplyController@application','as' => 'hrm.leave.apply']);
   Route::post('leave/apply/store',['uses' => 'app\hr\leave\leaveapplyController@store','as' => 'hrm.leave.apply.store']);
   Route::get('leave/apply/{id}/edit',['uses' => 'app\hr\leave\leaveapplyController@edit','as' => 'hrm.leave.apply.edit']);
   Route::post('leave/apply/{id}/update',['uses' => 'app\hr\leave\leaveapplyController@update','as' => 'hrm.leave.apply.update']);
   Route::get('leave/my-leave-list',['uses' => 'app\hr\leave\leaveapplyController@my_list','as' => 'hrm.leave.apply.index']);


   //leave settings
   Route::get('leave/settings',['middleware' => ['permission:read-leavesettings'], 'uses' => 'app\hr\leave\settingsController@index','as' => 'hrm.leave.settings']);
   Route::get('leave/holiday',['middleware' => ['permission:read-leavesettings'], 'uses' => 'app\hr\leave\settingsController@index','as' => 'hrm.leave.settings.holiday']);
   Route::post('leave/holiday/store',['middleware' => ['permission:create-leavesettings'], 'uses' => 'app\hr\leave\settingsController@store_holiday','as' => 'hrm.leave.settings.holiday.store']);
   Route::get('leave/workdays',['middleware' => ['permission:read-leavesettings'], 'uses' => 'app\hr\leave\settingsController@index','as' => 'hrm.leave.settings.workdays']);

   //leave type
   Route::get('leave/type',['middleware' => ['permission:read-leavetype'], 'uses' => 'app\hr\leave\settingsController@index','as' => 'hrm.leave.settings.type']);
   Route::post('leave/type/store',['middleware' => ['permission:create-leavetype'], 'uses' => 'app\hr\leave\settingsController@store_type','as' => 'hrm.leave.settings.type.store']);
   Route::get('leave/type/{id}/delete',['middleware' => ['permission:create-leavetype'], 'uses' => 'app\hr\leave\settingsController@delete','as' => 'hrm.leave.settings.type.delete']);

   /* ================== payroll ================== */
   //people
   Route::get('payroll/people',['middleware' => ['permission:read-payroll'], 'uses' => 'app\hr\payroll\peopleController@index','as' => 'hrm.payroll.people']);
   Route::get('payroll/{id}/show',['middleware' => ['permission:read-payroll'], 'uses' => 'app\hr\payroll\peopleController@show','as' => 'hrm.payroll.people.show']);
   Route::post('payroll/{id}/show/update',['middleware' => ['permission:update-payroll'], 'uses' => 'app\hr\payroll\peopleController@update','as' => 'hrm.payroll.people.show.update']);

   //payroll
   Route::get('payrolls',['middleware' => ['permission:read-payroll'], 'uses' => 'app\hr\payroll\runPayrollController@index','as' => 'hrm.payroll.index']);
   Route::get('payroll/{id}/details',['middleware' => ['permission:read-payroll'], 'uses' => 'app\hr\payroll\runPayrollController@payroll_details','as' => 'hrm.payroll.details']);
   Route::get('payroll/{employeeID}/{id}/payslip',['middleware' => ['permission:read-payroll'], 'uses' => 'app\hr\payroll\runPayrollController@payslip','as' => 'hrm.payroll.payslip']);
   Route::get('payroll/{employeeID}/{id}/payslip/delete',['middleware' => ['permission:delete-payroll'], 'uses' => 'app\hr\payroll\runPayrollController@payslip_delete','as' => 'hrm.payroll.payslip.delete']);
   Route::get('payroll/{id}/delete',['middleware' => ['permission:delete-payroll'], 'uses' => 'app\hr\payroll\runPayrollController@delete_payroll','as' => 'hrm.payroll.delete']);

   //mpesa payroll payment
   Route::post('payroll/mpesa/payment',['middleware' => ['permission:create-payroll'], 'uses' => 'app\hr\payroll\mpesaPaymentController@process_payment','as' => 'hrm.payroll.mpesa.payment']);

   //payroll process
   Route::get('/payroll/process',['middleware' => ['permission:create-payroll'], 'uses' => 'app\hr\payroll\runPayrollController@create','as' => 'hrm.payroll.process']);
   Route::post('payroll/process/post',['middleware' => ['permission:create-payroll'], 'uses' => 'app\hr\payroll\runPayrollController@run','as' => 'hrm.payroll.process.post']);
   Route::get('payroll/process/{payroll_date}/{type}/{branch}/review',['middleware' => ['permission:create-payroll'], 'uses' => 'app\hr\payroll\runPayrollController@review','as' => 'hrm.payroll.process.review']);
   Route::post('payroll/process/run',['middleware' => ['permission:create-payroll'], 'uses' => 'app\hr\payroll\runPayrollController@process','as' => 'hrm.payroll.process.run']);


   //settings
   Route::get('payroll/settings',['middleware' => ['permission:read-payrollsettings'], 'uses' => 'app\hr\payroll\settingsController@payday','as' => 'hrm.payroll.settings.payday']);
   Route::post('payroll/settings/update',['middleware' => ['permission:update-payrollsettings'], 'uses' => 'app\hr\payroll\settingsController@update','as' => 'hrm.payroll.settings.payday.update']);

   //payroll settings
   Route::get('payroll/settings/approval',['middleware' => ['permission:read-payrollsettings'], 'uses' => 'app\hr\payroll\settingsController@approval','as' => 'hrm.payroll.settings.approval']);
   Route::post('payroll/settings/approval/update',['middleware' => ['permission:update-payrollsettings'], 'uses' => 'app\hr\payroll\settingsController@approval_update','as' => 'hrm.payroll.settings.approval.update']);

   //deductions
   Route::get('payroll/settings/deduction',['middleware' => ['permission:read-payrolldeductions'], 'uses' => 'app\hr\payroll\deductionsController@index','as' => 'hrm.payroll.settings.deduction']);
   Route::post('payroll/settings/deduction/store',['middleware' => ['permission:create-payrolldeductions'], 'uses' => 'app\hr\payroll\deductionsController@store','as' => 'hrm.payroll.settings.deduction.store']);
   Route::get('payroll/settings/deduction/{id}/edit',['middleware' => ['permission:update-payrolldeductions'], 'uses' => 'app\hr\payroll\deductionsController@edit','as' => 'hrm.payroll.settings.deduction.edit']);
   Route::post('payroll/settings/deduction/update',['middleware' => ['permission:update-payrolldeductions'], 'uses' => 'app\hr\payroll\deductionsController@update','as' => 'hrm.payroll.settings.deduction.update']);
   Route::get('payroll/settings/deduction/{id}/delete',['middleware' => ['permission:delete-payrolldeductions'], 'uses' => 'app\hr\payroll\deductionsController@delete','as' => 'hrm.payroll.settings.deduction.delete']);

   //benefits
   Route::get('payroll/settings/benefits',['middleware' => ['permission:read-payrollbenefits'], 'uses' => 'app\hr\payroll\benefitsController@index','as' => 'hrm.payroll.settings.benefits']);
   Route::post('payroll/settings/benefits/store',['middleware' => ['permission:create-payrollbenefits'], 'uses' => 'app\hr\payroll\benefitsController@store','as' => 'hrm.payroll.settings.benefits.store']);
   Route::get('payroll/settings/benefits/{id}/edit',['middleware' => ['permission:update-payrollbenefits'], 'uses' => 'app\hr\payroll\benefitsController@edit','as' => 'hrm.payroll.settings.benefits.edit']);
   Route::post('payroll/settings/benefits/update',['middleware' => ['permission:update-payrollbenefits'], 'uses' => 'app\hr\payroll\benefitsController@update','as' => 'hrm.payroll.settings.benefits.update']);
   Route::get('payroll/settings/benefits/{id}/delete',['middleware' => ['permission:delete-payrollbenefits'], 'uses' => 'app\hr\payroll\benefitsController@delete','as' => 'hrm.payroll.settings.benefits.delete']);

   /* ================== hr Calendar ================== */
   Route::get('calendar',['middleware' => ['permission:delete-hrcalendar'], 'uses' => 'app\hr\calendar\calendarController@index','as' => 'hrm.calendar']);

   /* ================== Organization ================== */
   //job title
   Route::get('organization/positions',['uses' => 'app\hr\organization\positionsController@index','as' => 'hrm.positions']);
   Route::post('organization/positions/store',['uses' => 'app\hr\organization\positionsController@store','as' => 'hrm.positions.store']);
   Route::get('organization/positions/{id}/edit',['uses' => 'app\hr\organization\positionsController@edit','as' => 'hrm.positions.edit']);
   Route::post('organization/positions/{id}/update',['uses' => 'app\hr\organization\positionsController@update','as' => 'hrm.positions.update']);
   Route::get('organization/positions/{id}/destroy',['uses' => 'app\hr\organization\positionsController@destroy','as' => 'hrm.positions.destroy']);

   //departments
   Route::get('organization/departments',['middleware' => ['permission:read-departments'], 'uses' => 'app\hr\organization\departmentsController@index','as' => 'hrm.departments']);
   Route::get('organization/departments/create',['middleware' => ['permission:create-departments'], 'uses' => 'app\hr\organization\departmentsController@create','as' => 'hrm.departments.create']);
   Route::post('organization/departments/store',['middleware' => ['permission:create-departments'], 'uses' => 'app\hr\organization\departmentsController@store','as' => 'hrm.departments.store']);
   Route::get('organization/departments/{id}/edit',['middleware' => ['permission:read-departments'], 'uses' => 'app\hr\organization\departmentsController@edit','as' => 'hrm.departments.edit']);
   Route::post('organization/departments/{id}/update',['middleware' => ['permission:read-departments'], 'uses' => 'app\hr\organization\departmentsController@update','as' => 'hrm.departments.update']);
   Route::get('organization/departments/{id}/delete',['middleware' => ['permission:read-departments'], 'uses' => 'app\hr\organization\departmentsController@delete','as' => 'hrm.departments.delete']);

   //branches
   Route::get('organization/branches',['middleware' => ['permission:read-branches'], 'uses' => 'app\hr\organization\branchesController@index','as' => 'hrm.branches']);
   Route::get('organization/branches/create',['middleware' => ['permission:create-branches'], 'uses' => 'app\hr\organization\branchesController@create','as' => 'hrm.branches.create']);
   Route::post('organization/branches/store',['middleware' => ['permission:create-branches'], 'uses' => 'app\hr\organization\branchesController@store','as' => 'hrm.branches.store']);
   Route::get('organization/branches/{id}/edit',['middleware' => ['permission:update-branches'], 'uses' => 'app\hr\organization\branchesController@edit','as' => 'hrm.branches.edit']);
   Route::post('organization/branches/{id}/update',['middleware' => ['permission:update-branches'], 'uses' => 'app\hr\organization\branchesController@update','as' => 'hrm.branches.update']);
   Route::get('organization/branches/{id}/delete',['middleware' => ['permission:delete-branches'], 'uses' => 'app\hr\organization\branchesController@delete','as' => 'hrm.branches.delete']);

   /* === Announcements === */
   Route::get('announcements',['middleware' => ['permission:read-hrannouncements'], 'uses' => 'app\hr\Announcements\AnnouncementsController@announcements_list','as' => 'hrm.announcements.list']);
   Route::get('announcements/{id}/show',['middleware' => ['permission:read-hrannouncements'],'uses' => 'app\hr\Announcements\AnnouncementsController@show','as' => 'hrm.announcements.show']);

   /* === exit details === */
   Route::get('exit-details',['middleware' => ['permission:read-hrexitdetails'], 'uses' => 'app\hr\ExitDetails\ExitdetailsController@index','as' => 'hrm.exitdetails.index']);
   Route::get('exit-details/create',['middleware' => ['permission:create-hrexitdetails'], 'uses' => 'app\hr\ExitDetails\ExitdetailsController@create','as' => 'hrm.exitdetails.create']);
   Route::get('exit-details/{id}/edit',['middleware' => ['permission:update-hrexitdetails'], 'uses' => 'app\hr\ExitDetails\ExitdetailsController@edit','as' => 'hrm.exitdetails.edit']);

   /* === Company Policy === */
   Route::get('company-policy',['middleware' => ['permission:read-companyprolicy'], 'uses' => 'app\hr\CompanyProfile\CompanyProfileController@index','as' => 'hrm.companyprofile.index']);
   Route::get('company-policy/create',['middleware' => ['permission:create-companyprolicy'], 'uses' => 'app\hr\CompanyProfile\CompanyProfileController@create','as' => 'hrm.companyprofile.create']);
   Route::get('company-policy/{id}/edit',['middleware' => ['permission:update-companyprolicy'], 'uses' => 'app\hr\CompanyProfile\CompanyProfileController@edit','as' => 'hrm.companyprofile.edit']);


   /* === Travel === */
   Route::get('travel/myTravels',['middleware' => ['permission:update-travel'], 'uses' => 'app\hr\travel\travelController@my_travels','as' => 'hrm.travel.my']);
   Route::get('travel',['middleware' => ['permission:update-travel'], 'uses' => 'app\hr\travel\travelController@index','as' => 'hrm.travel.index']);
   Route::get('travel/create',['middleware' => ['permission:update-travel'], 'uses' => 'app\hr\travel\travelController@create','as' => 'hrm.travel.create']);
   Route::post('travel/store',['middleware' => ['permission:update-travel'], 'uses' => 'app\hr\travel\travelController@store','as' => 'hrm.travel.store']);
   Route::get('travel/{id}/edit',['middleware' => ['permission:update-travel'], 'uses' => 'app\hr\travel\travelController@edit','as' => 'hrm.travel.edit']);
   Route::post('travel/{id}/update',['middleware' => ['permission:update-travel'], 'uses' => 'app\hr\travel\travelController@update','as' => 'hrm.travel.update']);
   Route::get('travel/{id}/delete',['middleware' => ['permission:update-travel'], 'uses' => 'app\hr\travel\travelController@delete','as' => 'hrm.travel.delete']);

   /* === Travel Expense === */
   Route::get('travel/expenses',['uses' => 'app\hr\travel\expensesController@index','as' => 'hrm.travel.expenses']);
   Route::get('travel/expenses/create',['uses' => 'app\hr\travel\expensesController@create','as' => 'hrm.travel.expenses.create']);
   Route::post('travel/expenses/store',['uses' => 'app\hr\travel\expensesController@store','as' => 'hrm.travel.expenses.store']);
   Route::get('travel/expenses/{id}/edit',['uses' => 'app\hr\travel\expensesController@edit','as' => 'hrm.travel.expenses.edit']);
   Route::post('travel/expenses/{id}/update',['uses' => 'app\hr\travel\expensesController@update','as' => 'hrm.travel.expenses.update']);
   Route::get('travel/expenses/{id}/show',['uses' => 'app\hr\travel\expensesController@show','as' => 'hrm.travel.expenses.show']);
   Route::get('travel/expenses/{id}/delete',['uses' => 'app\hr\travel\expensesController@delete','as' => 'hrm.travel.expenses.delete']);
   Route::get('travel/expenses/{expenseID}/delete/{id}/files',['uses' => 'app\hr\travel\expensesController@delete_file','as' => 'hrm.travel.expenses.delete.files']);

   /* === Assets === */
   //Route::get('Compensation',['uses' => 'app\hr\Assets\AssetsController@index','as' => 'hrm.assets.index']);

   // Route::get('assets/create',[
   //     'uses' => 'app\hr\Assets\AssetsController@create',
   //     'as' => 'assets.create',
   //     'middleware' => 'roles',
   //     'roles' => ['Admin','Human resource','Chief Executive Officer']
   // ]);


   // Route::get('assets/{id}/edit',
   //     'uses' => 'app\hr\Assets\AssetsController@edit',
   //     'as' => 'assets.edit',
   //     'middleware' => 'roles',
   //     'roles' => ['Admin','Human resource','Chief Executive Officer']
   // ]);

   /* === Settings === */

});


/*
|--------------------------------------------------------------------------
| crm
|--------------------------------------------------------------------------
|
| customer relationship manager
*/
Route::prefix('crm')->middleware('auth')->group(function () {

   /*========== dashboard ==========*/
   Route::get('/', ['uses' => 'app\crm\dashboard\dashboardController@dashboard','as' => 'crm.dashboard']);

   /*========== leads ==========*/
   Route::get('/leads', ['middleware' => ['permission:read-leads'], 'uses' => 'app\crm\leads\leadsController@index','as' => 'crm.leads.index']);
   Route::get('/leads/{id}/show', ['middleware' => ['permission:read-leads'], 'uses' => 'app\crm\leads\leadsController@show','as' => 'crm.leads.show']);
   Route::get('/leads/create', ['middleware' => ['permission:create-leads'], 'uses' => 'app\crm\leads\leadsController@create','as' => 'crm.leads.create']);
   Route::post('/leads/store', ['middleware' => ['permission:create-leads'], 'uses' => 'app\crm\leads\leadsController@store','as' => 'crm.leads.store']);
   Route::get('/leads/{id}/edit', ['uses' => 'app\crm\leads\leadsController@edit','as' => 'crm.leads.edit']);
   Route::post('/leads/{id}/update', ['middleware' => ['permission:update-leads'], 'uses' => 'app\crm\leads\leadsController@update','as' => 'crm.leads.update']);
   Route::get('/leads/{id}/delete', ['middleware' => ['permission:delete-leads'], 'uses' => 'app\crm\leads\leadsController@delete','as' => 'crm.leads.delete']);
   Route::get('/leads/{id}/convert', ['middleware' => ['permission:delete-leads'], 'uses' => 'app\crm\leads\leadsController@convert','as' => 'crm.leads.convert']);

   /*========== notes ==========*/
   Route::get('/leads/{id}/notes', ['middleware' => ['permission:read-leadnotes'], 'uses' => 'app\crm\leads\notesController@notes','as' => 'crm.leads.notes']);
   Route::post('/leads/notes/store', ['middleware' => ['permission:create-leadnotes'], 'uses' => 'app\crm\leads\notesController@store','as' => 'crm.leads.notes.store']);
   Route::post('/leads/{id}/notes/update', ['middleware' => ['permission:update-leadnotes'], 'uses' => 'app\crm\leads\notesController@update','as' => 'crm.leads.notes.update']);
   Route::get('/leads/{id}/notes/delete', ['middleware' => ['permission:delete-leadnotes'], 'uses' => 'app\crm\leads\notesController@delete','as' => 'crm.leads.notes.delete']);

   //call logs
   Route::get('/leads/{id}/calllog', ['middleware' => ['permission:read-leadnotes'], 'uses' => 'app\crm\leads\calllogController@calllog','as' => 'crm.leads.calllog']);
   Route::post('/leads/calllog/store', ['middleware' => ['permission:create-leadnotes'],'uses' => 'app\crm\leads\calllogController@store_calllog','as' => 'crm.leads.calllog.store']);
   Route::post('/leads/{id}/calllog/store', ['uses' => 'app\crm\leads\calllogController@update_calllog','as' => 'crm.leads.calllog.update']);
   Route::get('/leads/{id}/calllog/delete', ['uses' => 'app\crm\leads\calllogController@delete','as' => 'crm.leads.calllog.delete']);

   //lead status
   Route::get('/lead/status', ['middleware' => ['permission:read-leadstatus'], 'uses' => 'app\crm\leads\statusController@index','as' => 'crm.leads.status']);
   Route::post('/lead/status/store', ['middleware' => ['permission:create-leadstatus'], 'uses' => 'app\crm\leads\statusController@store','as' => 'crm.leads.status.store']);
   Route::post('/lead/status/{id}/update', ['middleware' => ['permission:update-leadstatus'], 'uses' => 'app\crm\leads\statusController@update','as' => 'crm.leads.status.update']);
   Route::get('/lead/status/{id}/delete', ['middleware' => ['permission:delete-leadstatus'], 'uses' => 'app\crm\leads\statusController@delete','as' => 'crm.leads.status.delete']);

   //lead sources
   Route::get('/lead/sources', ['middleware' => ['permission:read-leadsources'], 'uses' => 'app\crm\leads\sourcesController@index','as' => 'crm.leads.sources']);
   Route::post('/lead/sources/store', ['middleware' => ['permission:create-leadsources'], 'uses' => 'app\crm\leads\sourcesController@store','as' => 'crm.leads.sources.store']);
   Route::post('/lead/sources/{id}/update', ['middleware' => ['permission:update-leadsources'], 'uses' => 'app\crm\leads\sourcesController@update','as' => 'crm.leads.sources.update']);
   Route::get('/lead/sources/{id}/delete', ['middleware' => ['permission:delete-leadsources'], 'uses' => 'app\crm\leads\sourcesController@delete','as' => 'crm.leads.sources.delete']);

   //lead tasks
   Route::get('/leads/{id}/tasks', ['middleware' => ['permission:read-leadtasks'], 'uses' => 'app\crm\leads\tasksController@index','as' => 'crm.leads.tasks']);
   Route::post('/leads/tasks/store', ['uses' => 'app\crm\leads\tasksController@store','as' => 'crm.leads.tasks.store']);
   Route::post('/leads/tasks/{id}/update', ['middleware' => ['permission:update-leadtasks'], 'uses' => 'app\crm\leads\tasksController@update','as' => 'crm.leads.tasks.update']);
   Route::get('/leads/tasks/{id}/delete', ['middleware' => ['permission:delete-leadtasks'], 'uses' => 'app\crm\leads\tasksController@delete','as' => 'crm.leads.tasks.delete']);

   //lead events
   Route::get('/leads/{id}/events', ['middleware' => ['permission:read-leadevents'], 'uses' => 'app\crm\leads\eventsController@index','as' => 'crm.leads.events']);
   Route::post('/leads/events/store', ['middleware' => ['permission:create-leadevents'], 'uses' => 'app\crm\leads\eventsController@store','as' => 'crm.leads.events.store']);
   Route::post('/leads/events/{id}/update', ['middleware' => ['permission:update-leadevents'], 'uses' => 'app\crm\leads\eventsController@update','as' => 'crm.leads.events.update']);
   Route::get('/leads/events/{id}/delete', ['middleware' => ['permission:delete-leadevents'], 'uses' => 'app\crm\leads\eventsController@delete','as' => 'crm.leads.events.delete']);

   //lead documents
   Route::get('/leads/{id}/documents', ['middleware' => ['permission:read-leaddocuments'], 'uses' => 'app\crm\leads\documentsController@index','as' => 'crm.leads.documents']);
   Route::post('/leads/documents/store', ['middleware' => ['permission:create-leaddocuments'], 'uses' => 'app\crm\leads\documentsController@store','as' => 'crm.leads.documents.store']);
   Route::post('/leads/documents/{id}/update', ['middleware' => ['permission:update-leaddocuments'], 'uses' => 'app\crm\leads\documentsController@update','as' => 'crm.leads.documents.update']);
   Route::get('/leads/documents/{id}/{leadID}/delete', ['middleware' => ['permission:delete-leaddocuments'], 'uses' => 'app\crm\leads\documentsController@delete','as' => 'crm.leads.documents.delete']);

   //lead mail
   Route::get('/leads/{id}/mail', ['middleware' => ['permission:read-leadmails'], 'uses' => 'app\crm\leads\mailController@index','as' => 'crm.leads.mail']);
   Route::get('/leads/{id}/mail/{leadID}/details', ['middleware' => ['permission:read-leadmails'], 'uses' => 'app\crm\leads\mailController@details','as' => 'crm.leads.details']);
   Route::get('/leads/{id}/send', ['middleware' => ['permission:read-leadmails'], 'uses' => 'app\crm\leads\mailController@send','as' => 'crm.leads.send']);
   Route::post('/leads/mail/store', ['middleware' => ['permission:create-leadmails'], 'uses' => 'app\crm\leads\mailController@store','as' => 'crm.leads.mail.store']);

   //lead sms
   Route::get('/leads/{id}/sms', ['uses' => 'app\crm\leads\smsController@index','as' => 'crm.leads.sms']);
   Route::post('/leads/sms/send', ['uses' => 'app\crm\leads\smsController@send','as' => 'crm.leads.sms.send']);

   /*========== mail ==========*/
   Route::get('/mail/inbox', ['middleware' => ['permission:read-mail'], 'uses' => 'app\crm\mail\mailController@inbox','as' => 'crm.mail.inbox']);
   Route::get('/mail/sent', ['middleware' => ['permission:read-mail'], 'uses' => 'app\crm\mail\mailController@sent','as' => 'crm.mail.sent']);
   Route::get('/mail/compose', ['middleware' => ['permission:create-mail'], 'uses' => 'app\crm\mail\mailController@compose','as' => 'crm.mail.compose']);
   Route::get('/mail/{id}/details', ['middleware' => ['permission:read-mail'], 'uses' => 'app\crm\mail\mailController@details','as' => 'crm.mail.details']);

   /*========== customers ==========*/
   Route::get('/customer', ['middleware' => ['permission:create-crmcustomers'], 'uses' => 'app\crm\customers\customersController@index','as' => 'crm.customers.index']);
   Route::get('/customer/create', ['middleware' => ['permission:create-crmcustomers'], 'uses' => 'app\crm\customers\customersController@create','as' => 'crm.customers.create']);
   Route::post('/customer/store', ['middleware' => ['permission:create-crmcustomers'], 'uses' => 'app\crm\customers\customersController@contact_store','as' => 'crm.customers.store']);
   Route::get('/customer/{id}/edit', ['middleware' => ['permission:update-crmcustomers'], 'uses' => 'app\crm\customers\customersController@edit','as' => 'crm.customers.edit']);
   Route::post('/customer/{id}/update', ['middleware' => ['permission:update-crmcustomers'], 'uses' => 'app\crm\customers\customersController@contact_update','as' => 'crm.customers.update']);
   Route::get('/customer/{id}/show', ['middleware' => ['permission:read-crmcustomers'], 'uses' => 'app\crm\customers\customersController@show','as' => 'crm.customers.show']);
   Route::get('/customer/{id}/customer-persons', ['middleware' => ['permission:create-crmcustomers'], 'uses' => 'app\crm\customers\customersController@show','as' => 'crm.customers.persons']);
   Route::get('/customer/{id}/notes', ['middleware' => ['permission:create-crmcustomers'], 'uses' => 'app\crm\customers\customersController@show','as' => 'crm.customers.notes']);
   Route::post('/customer/notes/store', ['middleware' => ['permission:create-crmcustomers'], 'uses' => 'app\crm\customers\customersController@note_store','as' => 'crm.post.note']);
   Route::get('/customer/{id}/delete', ['middleware' => ['permission:delete-crmcustomers'], 'uses' => 'app\crm\customers\customersController@delete','as' => 'crm.customers.delete']);

   //client comments
   Route::get('customer/{id}/comments',['middleware' => ['permission:read-contact'],'uses' => 'app\crm\customers\commentsController@index','as' => 'crm.customers.comments']);
   Route::post('customer/comments/post',['middleware' => ['permission:read-contact'],'uses' => 'app\crm\customers\commentsController@store','as' => 'crm.customers.comments.post']);
   Route::get('customer/comments/{id}/delete',['middleware' => ['permission:read-contact'],'uses' => 'app\crm\customers\commentsController@delete','as' => 'crm.customers.comments.delete']);

   //client invoices
   Route::get('customer/{id}/invoices',['uses' => 'app\crm\customers\customersController@show','as' => 'crm.customers.invoices']);

   //client subscriptions
   Route::get('customer/{id}/subscriptions',['uses' => 'app\crm\customers\customersController@show','as' => 'crm.customers.subscriptions']);

   //client quotes
   Route::get('customer/{id}/quotes',['uses' => 'app\crm\customers\customersController@show','as' => 'crm.customers.quotes']);

   //client creditnotes
   Route::get('customer/{id}/creditnotes',['uses' => 'app\crm\customers\customersController@show','as' => 'crm.customers.creditnotes']);

   //client lpos
   Route::get('customer/{id}/lpos',['uses' => 'app\crm\customers\customersController@show','as' => 'crm.customers.lpos']);

   //client projects
   Route::get('customer/{id}/projects',['uses' => 'app\crm\customers\customersController@show','as' => 'crm.customers.projects']);

   //statement
   Route::get('customer/{id}/statement',['uses' => 'app\crm\customers\statementController@index','as' => 'crm.customers.statement']);
   Route::get('customer/{id}/statement/pdf',['uses' => 'app\crm\customers\statementController@pdf','as' => 'crm.customers.statement.pdf']);
   Route::get('customer/{id}/statement/print',['uses' => 'app\crm\customers\statementController@print','as' => 'crm.customers.statement.print']);
   Route::get('customer/{id}/statement/mail',['uses' => 'app\crm\customers\statementController@mail','as' => 'crm.customers.statement.mail']);
   Route::post('customer/{id}/statement/send',['uses' => 'app\crm\customers\statementController@send','as' => 'crm.customers.statement.send']);

   //customer mail
   Route::get('/customer/{id}/mail', ['uses' => 'app\crm\customers\mailController@index','as' => 'crm.customer.mail']);
   Route::get('/customer/{id}/mail/{customerID}/details', ['uses' => 'app\crm\customers\mailController@details','as' => 'crm.customer.details']);
   Route::get('/customer/{id}/send', ['uses' => 'app\crm\customers\mailController@send','as' => 'crm.customer.send']);
   Route::post('/customer/mail/store', ['uses' => 'app\crm\customers\mailController@store','as' => 'crm.customer.mail.store']);

   //customer documents
   Route::get('/customer/{id}/documents', ['uses' => 'app\crm\customers\documentsController@index','as' => 'crm.customer.documents']);
   Route::post('/customer/documents/store', ['uses' => 'app\crm\customers\documentsController@store','as' => 'crm.customer.documents.store']);
   Route::post('/customer/documents/{id}/update', ['uses' => 'app\crm\customers\documentsController@update','as' => 'crm.customer.documents.update']);
   Route::get('/customer/documents/{id}/{leadID}/delete', ['uses' => 'app\crm\customers\documentsController@delete','as' => 'crm.customer.documents.delete']);

   //customer sms
   Route::get('/customer/{id}/sms', ['uses' => 'app\crm\customers\smsController@index','as' => 'crm.customer.sms']);
   Route::post('/customer/sms/send', ['uses' => 'app\crm\customers\smsController@send','as' => 'crm.customer.sms.send']);

   //import customer
   Route::get('customer/import',['uses' => 'app\crm\customers\importController@import','as' => 'crm.customers.import']);
   Route::post('customer/import/store',['uses' => 'app\crm\customers\importController@import_contact','as' => 'crm.customers.import.store']);
   Route::get('customer/download/import/sample/',['uses' => 'app\crm\customers\importController@download_import_sample','as' => 'crm.customer.download.sample.import']);

   //export customer list
   Route::get('customer/export/{type}',['uses' => 'app\crm\customers\importController@export','as' => 'crm.customers.export']);

   //customer category
   Route::get('customer/category',['uses' => 'app\crm\customers\groupsController@index','as' => 'crm.customers.groups.index']);
   Route::post('customer/category/store',['uses' => 'app\crm\customers\groupsController@store','as' => 'crm.customers.groups.store']);
   Route::get('customer/category/{id}/edit',['uses' => 'app\crm\customers\groupsController@edit','as' => 'crm.customers.groups.edit']);
   Route::post('customer/category/{id}/update',['uses' => 'app\crm\customers\groupsController@update','as' => 'crm.customers.groups.update']);
   Route::get('customer/category/{id}/delete',['uses' => 'app\crm\customers\groupsController@delete','as' => 'crm.customers.groups.delete']);

   //customer notes
   Route::get('/customer/{id}/notes', ['uses' => 'app\crm\customers\notesController@index','as' => 'crm.customer.notes']);
   Route::post('/customer/notes/store', ['uses' => 'app\crm\customers\notesController@store','as' => 'crm.customer.notes.store']);
   Route::post('/customer/{id}/notes/update', ['uses' => 'app\crm\customers\notesController@update','as' => 'crm.customer.notes.update']);
   Route::get('/customer/{id}/notes/delete', ['uses' => 'app\crm\customers\notesController@delete','as' => 'crm.customer.notes.delete']);

   //customer call logs
   Route::get('/customer/{id}/calllogs', ['uses' => 'app\crm\customers\calllogController@index','as' => 'crm.customer.calllog']);
   Route::post('/customer/calllog/store', ['uses' => 'app\crm\customers\calllogController@store','as' => 'crm.customer.calllog.store']);
   Route::post('/customer/{id}/calllog/update', ['uses' => 'app\crm\customers\calllogController@update','as' => 'crm.customer.calllog.update']);
   Route::get('/customer/{id}/calllog/store', ['uses' => 'app\crm\customers\calllogController@delete','as' => 'crm.customer.calllog.delete']);

   //customer events
   Route::get('/customer/{id}/events', ['uses' => 'app\crm\customers\eventsController@index','as' => 'crm.customer.events']);
   Route::post('/customer/events/store', ['uses' => 'app\crm\customers\eventsController@store','as' => 'crm.customer.events.store']);
   Route::post('/customer/events/{id}/update', ['uses' => 'app\crm\customers\eventsController@update','as' => 'crm.customer.events.update']);
   Route::get('/customer/events/{id}/delete', ['uses' => 'app\crm\customers\eventsController@delete','as' => 'crm.customer.events.delete']);


   /*========== sms ==========*/
   Route::get('/sms', ['uses' => 'app\crm\sms\smsController@sent','as' => 'crm.sms.sent']);
   Route::post('/sms/send/single', ['uses' => 'app\crm\sms\smsController@send','as' => 'crm.sms.send.single']);
   Route::post('/sms/send/bulk', ['uses' => 'app\crm\sms\smsController@sent','as' => 'crm.sms.send.bulk']);
   Route::get('/sms/retreve/from/{id}', ['uses' => 'app\crm\sms\smsController@retrieve_from']);

   /*==================== social ====================*/
   //publications
   Route::get('social/dashboard', ['uses' => 'app\crm\social\dashboardController@dashboard','as' => 'crm.social.dashboard']);

   //posts
   Route::get('social/posts', ['uses' => 'app\crm\social\postsController@index','as' => 'crm.social.post.index']);
   Route::get('social/posts/create', ['uses' => 'app\crm\social\postsController@create','as' => 'crm.social.post.create']);
   Route::post('social/social/store', ['uses' => 'app\crm\social\postsController@store','as' => 'crm.social.post.store']);

   Route::get('marketing/retrive/channel/{id}', ['uses' => 'app\crm\digitalmarketing\publicationsController@retrieve_channels']);
   Route::get('marketing/publications/{id}/edit', ['uses' => 'app\crm\digitalmarketing\publicationsController@edit','as' => 'crm.publications.edit']);
   Route::post('marketing/publications/{id}/update', ['uses' => 'app\crm\digitalmarketing\publicationsController@update','as' => 'crm.publications.update']);
   Route::get('marketing/publications/{postID}/channel/{channelID}', ['uses' => 'app\crm\digitalmarketing\publicationsController@post_per_channel','as' => 'crm.publications.post.channel']);
   Route::get('marketing/publish/{postID}/{channelID}', ['uses' => 'app\crm\digitalmarketing\publicationsController@publish','as' => 'crm.publications.post.publish']);

   //accounts
   Route::get('marketing/account', ['uses' => 'app\crm\digitalmarketing\accountController@index','as' => 'crm.account.index']);
   Route::get('marketing/account/create', ['uses' => 'app\crm\digitalmarketing\accountController@create','as' => 'crm.account.create']);
   Route::post('marketing/account/store', ['uses' => 'app\crm\digitalmarketing\accountController@store','as' => 'crm.account.store']);
   Route::get('marketing/account/{id}/edit', ['uses' => 'app\crm\digitalmarketing\accountController@edit','as' => 'crm.account.edit']);
   Route::post('marketing/account/{id}/update', ['uses' => 'app\crm\digitalmarketing\accountController@update','as' => 'crm.account.update']);
   Route::get('marketing/account/{id}/delete', ['uses' => 'app\crm\digitalmarketing\accountController@delete','as' => 'crm.marketing.account.delete']);

   //medium
   Route::get('marketing/medium', ['uses' => 'app\crm\digitalmarketing\mediumController@index','as' => 'crm.medium.index']);
   Route::get('marketing/medium/create', ['uses' => 'app\crm\digitalmarketing\mediumController@create','as' => 'crm.medium.create']);
   Route::post('marketing/medium/store', ['uses' => 'app\crm\digitalmarketing\mediumController@store','as' => 'crm.medium.store']);
   Route::get('marketing/medium/{id}/edit', ['uses' => 'app\crm\digitalmarketing\mediumController@edit','as' => 'crm.medium.edit']);
   Route::post('marketing/medium/{id}/update', ['uses' => 'app\crm\digitalmarketing\mediumController@update','as' => 'crm.medium.update']);
   Route::get('marketing/medium/{id}/delete', ['uses' => 'app\crm\digitalmarketing\mediumController@delete','as' => 'crm.medium.delete']);

   //channel
   Route::get('marketing/{id}/channel', ['uses' => 'app\crm\digitalmarketing\channelController@index','as' => 'crm.channel.index']);
   Route::post('marketing/channel/store', ['uses' => 'app\crm\digitalmarketing\channelController@store','as' => 'crm.channel.store']);
   Route::get('marketing/{accountID}/channel/{id}/edit', ['uses' => 'app\crm\digitalmarketing\channelController@edit','as' => 'crm.channel.edit']);
   Route::post('marketing/channel/{id}/update', ['uses' => 'app\crm\digitalmarketing\channelController@update','as' => 'crm.channel.update']);
   Route::get('marketing/channel/{id}/delete', ['uses' => 'app\crm\digitalmarketing\channelController@delete','as' => 'crm.channel.delete']);

   /* === ur Shortener === */
   Route::get('shortener',['uses' => 'app\cms\shortener\ShortenerController@index','as' => 'url.shortener']);
   Route::post('/store/url/',['uses' => 'app\cms\shortener\ShortenerController@store','as' => 'url.store']);
   Route::get('/url/{code}',['uses' => 'app\cms\shortener\ShortenerController@get', 'as' => 'url.get']);
   Route::get('/short/{id}/delete', 'app\cms\shortener\ShortenerController@delete')->name('url.delete');


   /*==================== deals ====================*/
   //deals
   Route::get('deals', ['uses' => 'app\crm\deals\dealsController@index','as' => 'crm.deals.index']);
   Route::get('deals/create', ['uses' => 'app\crm\deals\dealsController@create','as' => 'crm.deals.create']);
   Route::post('deals/store', ['uses' => 'app\crm\deals\dealsController@store','as' => 'crm.deals.store']);
   Route::get('deals/{id}/edit', ['uses' => 'app\crm\deals\dealsController@edit','as' => 'crm.deals.edit']);
   Route::post('deals/{id}/update', ['uses' => 'app\crm\deals\dealsController@update','as' => 'crm.deals.update']);
   Route::get('deals/{id}/show', ['uses' => 'app\crm\deals\dealsController@show','as' => 'crm.deals.show']);
   Route::get('deals/{id}/delete', ['uses' => 'app\crm\deals\dealsController@delete','as' => 'crm.deals.delete']);

   Route::get('deals/{id}/stages', ['uses' => 'app\crm\deals\dealsController@stages','as' => 'crm.deals.stages']);

   //deal call log
   Route::get('deals/{id}/call_log', ['uses' => 'app\crm\deals\calllogController@index','as' => 'crm.deals.calllog.index']);
   Route::post('deals/{id}/call_log/store', ['uses' => 'app\crm\deals\calllogController@store','as' => 'crm.deals.calllog.store']);
   Route::post('deals/{id}/call_log/update', ['uses' => 'app\crm\deals\calllogController@update','as' => 'crm.deals.calllog.update']);
   Route::get('deals/{id}/call_log/delete', ['uses' => 'app\crm\deals\calllogController@delete','as' => 'crm.deals.calllog.delete']);

   //deal notes
   Route::get('deals/{id}/notes', ['uses' => 'app\crm\deals\notesController@index','as' => 'crm.deals.notes.index']);
   Route::post('deals/{id}/notes/store', ['uses' => 'app\crm\deals\notesController@store','as' => 'crm.deals.notes.store']);
   Route::post('deals/{id}/notes/update', ['uses' => 'app\crm\deals\notesController@update','as' => 'crm.deals.notes.update']);
   Route::get('deals/{id}/notes/delete', ['uses' => 'app\crm\deals\notesController@delete','as' => 'crm.deals.notes.delete']);

   //deal task
   Route::get('deals/{id}/task', ['uses' => 'app\crm\deals\tasksController@index','as' => 'crm.deals.task.index']);
   Route::post('deals/{id}/task/store', ['uses' => 'app\crm\deals\tasksController@store','as' => 'crm.deals.task.store']);
   Route::post('deals/{id}/task/update', ['uses' => 'app\crm\deals\tasksController@update','as' => 'crm.deals.task.update']);
   Route::get('deals/{id}/task/delete', ['uses' => 'app\crm\deals\tasksController@delete','as' => 'crm.deals.task.delete']);

   //deal appointments
   Route::get('deals/{id}/appointments', ['uses' => 'app\crm\deals\appointmentsController@index','as' => 'crm.deals.appointments.index']);
   Route::post('deals/{id}/appointments/store', ['uses' => 'app\crm\deals\appointmentsController@store','as' => 'crm.deals.appointments.store']);
   Route::post('deals/{id}/appointments/update', ['uses' => 'app\crm\deals\appointmentsController@update','as' => 'crm.deals.appointments.update']);
   Route::get('deals/{id}/appointments/delete', ['uses' => 'app\crm\deals\appointmentsController@delete','as' => 'crm.deals.appointments.delete']);


   //pipeline
   Route::get('pipeline', ['uses' => 'app\crm\deals\pipelineController@index','as' => 'crm.pipeline.index']);
   Route::post('pipeline/store', ['uses' => 'app\crm\deals\pipelineController@store','as' => 'crm.pipeline.store']);
   Route::get('pipeline/{id}/edit', ['uses' => 'app\crm\deals\pipelineController@edit','as' => 'crm.pipeline.edit']);
   Route::post('pipeline/{id}/update', ['uses' => 'app\crm\deals\pipelineController@update','as' => 'crm.pipeline.update']);
   Route::get('pipeline/{id}/show', ['uses' => 'app\crm\deals\pipelineController@show','as' => 'crm.pipeline.show']);
   Route::get('pipeline/{id}/delete', ['uses' => 'app\crm\deals\pipelineController@delete','as' => 'crm.pipeline.delete']);

   //stage
   Route::post('pipeline/stages/store', ['uses' => 'app\crm\deals\stagesController@store','as' => 'crm.pipeline.stage.store']);
   Route::get('pipeline/stages/{id}/edit', ['uses' => 'app\crm\deals\stagesController@edit','as' => 'crm.pipeline.stage.edit']);
   Route::post('pipeline/stages/{id}/update', ['uses' => 'app\crm\deals\stagesController@update','as' => 'crm.pipeline.stage.update']);
   Route::get('pipeline/stages/{id}/delete', ['uses' => 'app\crm\deals\stagesController@delete','as' => 'crm.pipeline.stage.delete']);
   Route::put('pipeline/stages/position', ['uses' => 'app\crm\deals\stagesController@position','as' => 'stage_position_update']);

   /*==================== reports ====================*/
   //reports dashboard
   Route::get('reports', ['uses' => 'app\crm\reports\dashboardController@dashboard','as' => 'crm.reports']);

   //lead by status
   Route::get('reports/leads_by_status', ['uses' => 'app\crm\reports\leadsByStatusController@filter','as' => 'crm.reports.leads.status.filter']);
   Route::get('reports/leads_by_status/export/{statusID}/{start}/{end}', ['uses' => 'app\crm\reports\leadsByStatusController@export','as' => 'crm.reports.leads.status.export']);

   //lead by source
   Route::get('reports/leads_by_source', ['uses' => 'app\crm\reports\leadsBySourceController@filter','as' => 'crm.reports.leads.source.filter']);
   Route::get('reports/leads_by_source/export/{sourceID}/{start}/{end}', ['uses' => 'app\crm\reports\leadsBySourceController@export','as' => 'crm.reports.leads.source.export']);

   //lead by industry
   Route::get('reports/leads_by_industry', ['uses' => 'app\crm\reports\leadsByIndustryController@filter','as' => 'crm.reports.leads.industry.filter']);
   Route::get('reports/leads_by_industry/export/{sourceID}/{start}/{end}', ['uses' => 'app\crm\reports\leadsByIndustryController@export','as' => 'crm.reports.leads.industry.export']);




});


/*
|--------------------------------------------------------------------------
| Content management (CMS)
|--------------------------------------------------------------------------
|
| Manage contents of your website quick and first
*/
Route::prefix('cms')->middleware('auth')->group(function(){
   Route::get('/', ['middleware' => ['permission:read-crm'], 'uses' => 'app\cms\dashboard\dashboardController@dashboard', 'as' => 'cms.dashboard']);

   /* === group knowledge base === */
   Route::get('knowledge_base/groups', ['middleware' => ['permission:read-groupknowledgebase'], 'uses' => 'app\cms\knowledgebase\groupsController@index', 'as' => 'cms.groups.index']);
   Route::post('knowledge_base/groups/store', ['middleware' => ['permission:create-groupknowledgebase'], 'uses' => 'app\cms\knowledgebase\groupsController@store', 'as' => 'cms.groups.store']);
   Route::get('knowledge_base/groups/{id}/edit', ['middleware' => ['permission:update-groupknowledgebase'], 'uses' => 'app\cms\knowledgebase\groupsController@edit', 'as' => 'cms.groups.edit']);
   Route::post('knowledge_base/groups/{id}/update', ['middleware' => ['permission:update-groupknowledgebase'], 'uses' => 'app\cms\knowledgebase\groupsController@update', 'as' => 'cms.groups.update']);
   Route::get('knowledge_base/groups/{id}/delete', ['middleware' => ['permission:delete-groupknowledgebase'], 'uses' => 'app\cms\knowledgebase\groupsController@destroy', 'as' => 'cms.groups.delete']);

   /* === knowledge base === */
   Route::get('knowledge_base', ['middleware' => ['permission:read-knowledgebase'], 'uses' => 'app\cms\knowledgebase\knowledgebaseController@index', 'as' => 'cms.knowledgebase.index']);
   Route::get('knowledge_base/create', ['middleware' => ['permission:create-knowledgebase'], 'uses' => 'app\cms\knowledgebase\knowledgebaseController@create', 'as' => 'cms.knowledgebase.create']);
   Route::post('knowledge_base/store', ['middleware' => ['permission:create-knowledgebase'], 'uses' => 'app\cms\knowledgebase\knowledgebaseController@store', 'as' => 'cms.knowledgebase.store']);
   Route::get('knowledge_base/{id}/edit', ['middleware' => ['permission:update-knowledgebase'], 'uses' => 'app\cms\knowledgebase\knowledgebaseController@edit', 'as' => 'cms.knowledgebase.edit']);
   Route::post('knowledge_base/{id}/update', ['middleware' => ['permission:update-knowledgebase'], 'uses' => 'app\cms\knowledgebase\knowledgebaseController@update', 'as' => 'cms.knowledgebase.update']);
   Route::get('knowledge_base/{id}/delete', ['middleware' => ['permission:delete-knowledgebase'], 'uses' => 'app\cms\knowledgebase\knowledgebaseController@destroy', 'as' => 'cms.knowledgebase.delete']);
   Route::get('knowledge_base/{id}/show', ['middleware' => ['permission:read-knowledgebase'], 'uses' => 'app\cms\knowledgebase\knowledgebaseController@show', 'as' => 'cms.knowledgebase.show']);

   /* === proposals === */
   Route::get('proposals', 'app\cms\proposals\proposalController@index')->name('cms.proposal.index');
   Route::get('proposal/create', 'app\cms\proposals\proposalController@create')->name('cms.proposal.create');
   Route::post('proposal/store', 'app\cms\proposals\proposalController@store')->name('cms.proposal.store');
   Route::get('proposal/{id}/show', 'app\cms\proposals\proposalController@show')->name('cms.proposal.show');
   Route::get('proposal/{id}/edit', 'app\cms\proposals\proposalController@edit')->name('cms.proposal.edit');
   Route::post('proposal/{id}/update', 'app\cms\proposals\proposalController@update')->name('cms.proposal.update');
   Route::get('proposal/{id}/delete', 'app\cms\proposals\proposalController@destroy')->name('cms.proposal.delete');

   /* === pages === */
   Route::get('website/pages',['uses' => 'app\cms\website\pageController@index','as' => 'cms.page.index']);
   Route::get('website/page/new', 'app\cms\website\pageController@create')->name('cms.page.new');
   Route::get('website/pages/{id}/edit',['uses' => 'app\cms\website\pageController@edit','as' => 'cms.page.edit']);
   Route::post('/pages/{id}/update',['uses' => 'app\cms\website\pageController@update','as' => 'cms.page.update']);
   Route::get('website/pages/{id}/destroy',['uses' => 'app\cms\website\pageController@destroy','as' => 'cms.page.destroy']);

   /* === custom field === */
   Route::post('page/custom/field', 'app\cms\website\pageController@custom_field')->name('custom.page.field');
   Route::get('website/field/delete/{id}','app\cms\website\pageController@custom_field_delete')->name('custom.field.delete');

   /* === pages templates === */
   Route::post('/page/template/post', 'app\cms\website\templateController@store')->name('post.page.template');

   /* === Slider === */
   Route::get('website/slider',['uses' => 'app\cms\website\sliderController@index','as' => 'cms.slider.index']);
   Route::get('website/slider/create',['uses' => 'app\cms\website\sliderController@create','as' => 'cms.slider.create']);
   Route::post('/slider/store',['uses' => 'app\cms\website\sliderController@store','as' => 'cms.slider.store']);
   Route::get('website/slider/{id}/edit',['uses' => 'app\cms\website\sliderController@edit','as' => 'cms.slider.edit']);
   Route::post('/slider/{id}/update',['uses' => 'app\cms\website\sliderController@update','as' => 'cms.slider.update']);
   Route::get('website/slider/{id}/destroy',['uses' => 'app\cms\website\sliderController@destroy','as' => 'cms.slider.destroy']);

   /* === posts === */
   Route::get('website/posts', 'app\cms\website\postsController@index')->name('cms.posts.index');
   Route::get('website/posts/create', 'app\cms\website\postsController@create')->name('cms.posts.create');
   Route::post('/posts/store', 'app\cms\website\postsController@store')->name('cms.posts.store');
   Route::get('website/posts/{id}/edit', 'app\cms\website\postsController@edit')->name('cms.posts.edit');
   Route::post('/posts/{id}/update', 'app\cms\website\postsController@update')->name('cms.posts.update');
   Route::get('website/posts/{id}/delete', 'app\cms\website\postsController@destroy')->name('cms.posts.delete');

   /* === comment === */
   Route::get('website/posts/{id}/comment',['uses' => 'app\cms\website\postsController@comment','as' => 'posts.comments']);
   Route::post('/posts/comment/store',['uses' => 'app\cms\website\postsController@comment_store','as' => 'postscomment.store']);

   /* === attachment === */
   Route::get('website/posts/{id}/attachment', 'app\cms\website\postsController@attachment')->name('posts.attachment');
   Route::post('attachment/store',['uses' => 'app\cms\website\AttachmentController@store','as' => 'attachment.store']);

   /* === post category === */
   Route::get('website/posts/category', 'app\cms\website\categoryController@index')->name('cms.post.category.index');
   Route::get('website/posts/category/create', 'app\cms\website\categoryController@create')->name('cms.post.category.create');
   Route::post('website/posts/category/store', 'app\cms\website\categoryController@store')->name('cms.post.category.store');
   Route::get('website/posts/category/{id}/edit', 'app\cms\website\categoryController@edit')->name('cms.post.category.edit');
   Route::post('website/posts/category/{id}/update', 'app\cms\website\categoryController@update')->name('cms.post.category.update');
   Route::get('website/posts/category/{id}/destroy', 'app\cms\website\categoryController@destroy')->name('cms.post.category.destroy');

   /* === post tags === */
   Route::get('websiteposts/tags',['uses' => 'app\cms\website\tagsController@index','as' => 'cms.post.tags.index']);
   Route::get('websiteposts/tags/{id}/edit',['uses' => 'app\cms\website\tagsController@edit','as' => 'cms.post.tags.edit']);
   Route::post('posts/tags/store',['uses' => 'app\cms\website\tagsController@store','as' => 'cms.post.tags.store']);
   Route::post('posts/tags/{id}/update',['uses' => 'app\cms\website\tagsController@update','as' => 'cms.post.tags.update']);
   Route::get('websiteposts/tags/{id}/destroy',['uses' => 'app\cms\website\tagsController@destroy','as' => 'cms.post.tags.destroy']);

   /* === media === */
   Route::get('websitemedia', 'app\cms\website\MediaController@index')->name('cms.media.index');
   Route::post('/media/store', 'app\cms\website\MediaController@store')->name('cms.media.store');

   /*====== affiliate =====*/
   Route::get('website/affiliate', 'Modules\affiliate\AffiliateController@index')->name('affiliate.index');
   Route::get('website/affiliate/create', 'Modules\affiliate\AffiliateController@create')->name('affiliate.create');
   Route::post('/affiliate/create', 'Modules\affiliate\AffiliateController@store')->name('affiliate.store');
   Route::get('website/affiliate/{id}/edit', 'Modules\affiliate\AffiliateController@edit')->name('affiliate.edit');
   Route::post('/affiliate/{id}/update', 'Modules\affiliate\AffiliateController@update')->name('affiliate.update');
   Route::get('website/affiliate/{id}/delete', 'Modules\affiliate\AffiliateController@delete')->name('affiliate.delete');


});



/*
|--------------------------------------------------------------------------
| Assets
|--------------------------------------------------------------------------
*/
Route::prefix('assets')->middleware('auth')->group(function () {
   //Route::get('/dashboard', ['uses' => 'app\assets\dashboardController@dashboard','as' => 'assets.dashboard']);
   Route::get('/dashboard', ['middleware' => ['permission:access-assets'], 'uses' => 'app\assets\asset\assetsController@index','as' => 'assets.dashboard']);

   //assets
   Route::get('/list', ['middleware' => ['permission:read-assets'], 'uses' => 'app\assets\asset\assetsController@index','as' => 'assets.index']);
   Route::get('/create', ['middleware' => ['permission:create-assets'], 'uses' => 'app\assets\asset\assetsController@create','as' => 'assets.create']);
   Route::post('/store', ['middleware' => ['permission:create-assets'], 'uses' => 'app\assets\asset\assetsController@store','as' => 'assets.store']);
   Route::get('/{id}/edit', ['middleware' => ['permission:update-assets'], 'uses' => 'app\assets\asset\assetsController@edit','as' => 'assets.edit']);
   Route::post('/{id}/update', ['middleware' => ['permission:update-assets'], 'uses' => 'app\assets\asset\assetsController@update','as' => 'assets.update']);
   Route::get('/{id}/view', ['middleware' => ['permission:read-assets'], 'uses' => 'app\assets\asset\assetsController@show','as' => 'assets.show']);
   Route::get('/{id}/delete', ['middleware' => ['permission:delete-assets'], 'uses' => 'app\assets\asset\assetsController@delete','as' => 'assets.delete']);

   Route::get('/retrive/model/{id}', 'app\assets\asset\assetsController@retrive_model')->name('model.retrive');
   Route::get('/{id}/vehicle', ['uses' => 'app\assets\asset\assetsController@vehicle','as' => 'assets.details.vehicle']);

   //asset maintenances
   Route::get('/{id}/maintenances', ['uses' => 'app\assets\asset\assetsController@show','as' => 'assets.maintenances.index']);
   Route::get('/{id}/maintenance/create', ['uses' => 'app\assets\asset\assetsController@show','as' => 'assets.maintenances.create']);
   Route::post('/{id}/maintenance/store', ['uses' => 'app\assets\asset\maintenancesController@store','as' => 'assets.maintenances.store']);
   Route::get('/{assetID}/maintenance/{editID}/edit', ['uses' => 'app\assets\asset\maintenancesController@edit','as' => 'assets.maintenances.edit']);
   Route::post('/{assetID}/maintenance/{editID}/update', ['uses' => 'app\assets\asset\maintenancesController@update','as' => 'assets.maintenances.update']);

   //asset events
   Route::get('/{id}/events', ['uses' => 'app\assets\asset\assetsController@show','as' => 'assets.event.index']);
   Route::get('/events/{id}/delete', ['uses' => 'app\assets\asset\eventController@delete','as' => 'assets.event.delete']);

   //checkout
   Route::post('/checkout/events/store', ['uses' => 'app\assets\asset\eventController@check_out_store','as' => 'assets.event.checkout.store']);
   Route::post('/checkout/{id}/events/update', ['uses' => 'app\assets\asset\eventController@check_out_update','as' => 'assets.event.checkout.update']);

   //checkin
   Route::post('/checkin/events/store', ['uses' => 'app\assets\asset\eventController@check_in_store','as' => 'assets.event.checkin.store']);
   Route::post('/checkin/{id}/events/update', ['uses' => 'app\assets\asset\eventController@check_in_update','as' => 'assets.event.checkin.update']);

   //lease
   Route::post('/lease/events/store', ['uses' => 'app\assets\asset\eventController@lease_store','as' => 'assets.event.lease.store']);
   Route::post('/lease/{id}/events/update', ['uses' => 'app\assets\asset\eventController@lease_update','as' => 'assets.event.lease.update']);


   //licenses
   Route::get('/licenses', ['middleware' => ['permission:read-assets'], 'uses' => 'app\assets\license\licensesController@index','as' => 'licenses.assets.index']);
   Route::get('/licenses/create', ['middleware' => ['permission:read-assets'], 'uses' => 'app\assets\license\licensesController@create','as' => 'licenses.assets.create']);
   Route::post('/licenses/store', ['middleware' => ['permission:create-assets'], 'uses' => 'app\assets\license\licensesController@store','as' => 'licenses.assets.store']);
   Route::get('/licenses/{id}/edit', ['middleware' => ['permission:update-assets'], 'uses' => 'app\assets\license\licensesController@edit','as' => 'licenses.assets.edit']);
   Route::post('/licenses/{id}/update', ['middleware' => ['permission:update-assets'], 'uses' => 'app\assets\license\licensesController@update','as' => 'licenses.assets.update']);
   Route::get('/licenses/{id}/view', ['middleware' => ['permission:read-assets'], 'uses' => 'app\assets\license\licensesController@show','as' => 'licenses.assets.show']);
   Route::get('/licenses/{id}/delete', ['middleware' => ['permission:delete-assets'], 'uses' => 'app\assets\license\licensesController@delete','as' => 'licenses.assets.delete']);

   //licenses maintenances
   Route::get('licenses/{id}/maintenances', ['uses' => 'app\assets\license\licensesController@show','as' => 'licenses.maintenances.index']);
   Route::get('licenses/{id}/maintenance/create', ['uses' => 'app\assets\license\maintenancesController@show','as' => 'licenses.maintenances.create']);
   Route::post('licenses/{id}/maintenance/store', ['uses' => 'app\assets\license\maintenancesController@store','as' => 'licenses.maintenances.store']);
   Route::get('licenses/{assetID}/maintenance/{editID}/edit', ['uses' => 'app\assets\license\maintenancesController@edit','as' => 'licenses.maintenances.edit']);
   Route::post('licenses/{assetID}/maintenance/{editID}/update', ['uses' => 'app\assets\license\maintenancesController@update','as' => 'licenses.maintenances.update']);
   Route::get('licenses/{assetID}/maintenance/{id}/delete', ['uses' => 'app\assets\license\maintenancesController@delete','as' => 'licenses.maintenances.delete']);

   //assets type
   Route::get('/types', ['uses' => 'app\assets\typeController@index','as' => 'assets.type.index']);
   Route::post('/type/store', ['uses' => 'app\assets\typeController@store','as' => 'assets.type.store']);
   Route::get('/type/{id}/edit', ['uses' => 'app\assets\typeController@edit','as' => 'assets.type.edit']);
   Route::post('/type/{id}/update', ['uses' => 'app\assets\typeController@update','as' => 'assets.type.update']);
   Route::get('/type/{id}/delete', ['uses' => 'app\assets\typeController@delete','as' => 'assets.type.delete']);

});

/*
|--------------------------------------------------------------------------
| property management
|--------------------------------------------------------------------------
|
| Manage your properties
*/
Route::prefix('property-management')->middleware('auth')->group(function () {
   /* ==== Dashboard ==== */
   Route::get('/dashboard',['uses' => 'app\property\dashboardController@dashboard', 'as' => 'dashboard.property']);

   /* =======================================================================================================================================
   ==                                                    property                                                                          ==
   =========================================================================================================================================*/
   Route::get('properties',['uses' => 'app\property\propertyController@index', 'as' => 'property.index']);
   Route::get('property/create', ['uses' => 'app\property\propertyController@create','as' => 'property.create']);
   Route::post('property/store', ['uses' => 'app\property\propertyController@store','as' => 'property.store']);
   Route::get('property/{id}/edit', ['uses' => 'app\property\propertyController@edit','as' => 'property.edit']);
   Route::post('property/{id}/update', ['uses' => 'app\property\propertyController@update','as' => 'property.update']);
   Route::get('property/{id}/details', ['uses' => 'app\property\propertyController@show','as' => 'property.show']);
   Route::get('property/{id}/remove/image', ['uses' => 'app\property\propertyController@remove_image','as' => 'property.remove.image']);
   Route::get('property/{id}/information', ['uses' => 'app\property\propertyController@information','as' => 'property.information']);
   Route::post('property/{id}/information/update', ['uses' => 'app\property\propertyController@update_information','as' => 'property.information.update']);
   Route::get('property/{id}/delete', ['uses' => 'app\property\propertyController@delete','as' => 'property.delete']);
   //Route::get('property/{id}/edit', ['uses' => 'app\property\propertyController@edit','as' => 'property.details']);
   Route::get('property/units/{id}/vacant', ['uses' => 'app\property\propertyController@vacant','as' => 'property.vacant']);
   Route::get('property/units/{id}/occupied', ['uses' => 'app\property\propertyController@occupied','as' => 'property.occupied']);
   Route::post('property/document/upload', ['uses' => 'app\property\propertyController@document_upload','as' => 'property.document.upload']);

   //leases
   Route::get('property/{id}/leases',['uses' => 'app\property\leasesController@index','as' => 'property.leases']);
   Route::get('property/{id}/add/leases',['uses' => 'app\property\leasesController@create','as' => 'property.leases.create']);
   Route::post('property/store/lease',['uses' => 'app\property\leasesController@store','as' => 'property.leases.store']);

   //units
   Route::get('property/{id}/units', ['uses' => 'app\property\property\unitsController@index','as' => 'property.units']);
   Route::get('property/{id}/units/add', ['uses' => 'app\property\property\unitsController@create','as' => 'property.units.create']);
   Route::post('property/units/store', ['uses' => 'app\property\property\unitsController@store','as' => 'property.units.store']);
   Route::get('property/{pid}/units/{uid}/edit', ['uses' => 'app\property\property\unitsController@edit','as' => 'property.units.edit']);
   Route::get('property/units/{uid}/upload_document', ['uses' => 'app\property\property\unitsController@edit','as' => 'property.units.document']);
   Route::post('property/units/{uid}/update', ['uses' => 'app\property\property\unitsController@update','as' => 'property.units.update']);
   Route::get('property/{pid}/units/{uid}/delete', ['uses' => 'app\property\property\unitsController@delete','as' => 'property.units.delete']);

   //bulk units upload
   Route::get('property/{id}/units/bulk', ['uses' => 'app\property\property\unitsController@bulk','as' => 'property.units.bulk.create']);
   Route::post('property/units/bulk/store', ['uses' => 'app\property\property\unitsController@store_bulk','as' => 'property.units.bulk.store']);

   //invoices
   Route::get('property/{propertyID}/invoices',['uses' => 'app\property\accounting\invoicesController@index','as' => 'property.invoice.index']);
   Route::get('property/{propertyID}/invoices/create',['uses' => 'app\property\accounting\invoicesController@create','as' => 'property.invoice.create']);
   Route::post('property/{propertyID}/invoices/store',['uses' => 'app\property\accounting\invoicesController@store','as' => 'property.invoice.store']);
   Route::get('property/{propertyID}/rental/{invoiceID}/edit/invoices', ['uses' => 'app\property\accounting\invoicesController@edit','as' => 'property.invoice.edit']);
   Route::post('property/{propertyID}/rental/{invoiceID}/update/invoices', ['uses' => 'app\property\accounting\invoicesController@update','as' => 'property.invoice.update']);
   Route::get('property/{propertyID}/invoices/{invoiceID}/details',['uses' => 'app\property\accounting\invoicesController@show','as' => 'property.invoice.show']);
   Route::get('property/{propertyID}/invoices/{invoiceID}/delete',['uses' => 'app\property\accounting\invoicesController@delete','as' => 'property.invoice.delete']);
   Route::get('property/{propertyID}/invoices/{tenantID}/leases',['uses' => 'app\property\accounting\invoicesController@get_leases','as' => 'property.invoice.tenant.leases']);
   Route::post('property/{propertyID}/invoices/{invoiceID}/payments',['uses' => 'app\property\accounting\invoicesController@payments','as' => 'property.invoice.payment']);

   //bulk invoiceing
   Route::get('property/{propertyID}/invoices/bulk',['uses' => 'app\property\accounting\invoicesController@create_bulk','as' => 'property.invoice.create.bulk']);
   Route::post('property/{propertyID}/invoices/bulk/store',['uses' => 'app\property\accounting\invoicesController@store_bulk','as' => 'property.invoice.store.bulk']);

   //print invoice
   Route::get('property/{propertyID}/invoices/{invoiceID}/print',['uses' => 'app\property\accounting\invoicesController@print','as' => 'property.invoice.print']);

   //invoice payments
   Route::get('property/{propertyID}/payments',['uses' => 'app\property\accounting\paymentsController@index','as' => 'property.payments']);
   Route::get('property/{propertyID}/payments/create',['uses' => 'app\property\accounting\paymentsController@create','as' => 'property.payments.create']);
   Route::post('/payments/store',['uses' => 'app\property\accounting\paymentsController@store','as' => 'property.payments.store']);
   Route::get('property/{propertyID}/payments/{paymentID}/edit',['uses' => 'app\property\accounting\paymentsController@edit','as' => 'property.payments.edit']);
   Route::post('/{propertyID}/payments/{paymentID}/update',['uses' => 'app\property\accounting\paymentsController@update','as' => 'property.payments.update']);
   Route::get('property/{propertyID}/payments/{paymentID}/show',['uses' => 'app\property\accounting\paymentsController@show','as' => 'property.payments.show']);
   Route::get('retrive/{propertyID}/invoice/{tenantID}',['uses' => 'app\property\accounting\paymentsController@retrive_tenant_invoice']);
   Route::get('{propertyID}/payments/file/{fileID}/{parentID}/delete',['uses' => 'app\property\accounting\paymentsController@delete_file','as' => 'property.payments.delete.file']);
   Route::get('{propertyID}/payments/{parentID}/delete',['uses' => 'app\property\accounting\paymentsController@destroy','as' => 'property.payments.delete']);

   //utility billing
   Route::get('property/{propertyID}/utility',['uses' => 'app\property\accounting\utilityController@index','as' => 'property.utility.billing.index']);
   Route::get('property/{propertyID}/utility/create',['uses' => 'app\property\accounting\utilityController@create','as' => 'property.utility.billing.create']);
   Route::post('/{propertyID}/prepare/utility',['uses' => 'app\property\accounting\utilityController@prepare_bulk_billing','as' => 'property.prepare.utility.billing']);
   Route::get('property/{propertyID}/prepare/{utility}/utility/bill/{from}/{to}',['uses' => 'app\property\accounting\utilityController@record_bulk_reading','as' => 'property.record.bulk.reading']);
   Route::post('/{propertyID}/utility/store',['uses' => 'app\property\accounting\utilityController@store','as' => 'property.utility.billing.store']);
   Route::get('property/{propertyID}/{invoiceID}/edit/utility', ['uses' => 'app\property\accounting\utilityController@edit','as' => 'property.utility.billing.edit']);

   Route::post('/{propertyID}/{invoiceID}/calculate/utility/consumption', ['uses' => 'app\property\accounting\utilityController@calculate_consumption','as' => 'property.calculate.utility.consumption']);
   Route::post('/{propertyID}/{invoiceID}/update/utility/consumption', ['uses' => 'app\property\accounting\utilityController@update_utility_billing','as' => 'property.update.utility.consumption']);

   Route::get('property/{propertyID}/utility/{invoiceID}/details',['uses' => 'app\property\accounting\utilityController@show','as' => 'property.utility.billing.show']);
   Route::get('property/{propertyID}/utility/{invoiceID}/delete',['uses' => 'app\property\accounting\utilityController@delete','as' => 'property.utility.billing.delete']);
   Route::get('property/{propertyID}/utility/{tenantID}/leases',['uses' => 'app\property\accounting\utilityController@get_leases','as' => 'property.utility.billing.tenant.leases']);

   //utility payment
   Route::post('property/{propertyID}/utility/{invoiceID}/payments',['uses' => 'app\property\accounting\utilityController@pay_utility','as' => 'property.utility.payment']);

   //mail utility
   Route::get('property/{propertyID}/utility/{invoiceID}/compose/mail',['uses' => 'app\property\accounting\utilityController@compose_mail','as' => 'property.utility.compose.mail']);
   Route::post('property/{propertyID}/utility/compose/send',['uses' => 'app\property\accounting\utilityController@send_mail','as' => 'property.utility.send.mail']);

   //invoice settings
   Route::get('settings/{id}/invoice', ['uses' => 'app\property\settings\invoiceSettingsController@edit','as' => 'property.invoice.settings']);
   Route::post('settings/{id}/invoice/update', ['uses' => 'app\property\settings\invoiceSettingsController@update','as' => 'property.invoice.settings.update']);

   //credit note settings
   Route::get('settings/{id}/creditnote', ['uses' => 'app\property\settings\creditnoteSettingsController@edit','as' => 'property.creditnote.settings']);
   Route::post('settings/{id}/invoice/creditnote', ['uses' => 'app\property\settings\creditnoteSettingsController@update','as' => 'property.creditnote.settings.update']);

   //billing  process
   Route::post('rental/billing/process', ['uses' => 'app\property\accounting\rentController@bulk_process','as' => 'property.billing.process']);

   //billing filter
   Route::get('rental/{id}/billing/{datefrom}/{dateto}/{type}/history', ['uses' => 'app\property\accounting\rentController@history','as' => 'property.billing.history']);
   Route::get('rental/{id}/billing/history', ['uses' => 'app\property\accounting\rentController@search_history','as' => 'property.billing.history.search']);
   Route::post('rental/billing/search/results', ['uses' => 'app\property\accounting\rentController@search_results','as' => 'property.billing.history.search.results']);
   Route::post('property/billing/missing/invoice', ['uses' => 'app\property\accounting\rentController@missing_billings','as' => 'property.billing.missing.invoice']);

   //documents
   Route::get('property/{id}/documents', ['uses' => 'app\property\documentsController@index','as' => 'property.documents']);

   //images
   Route::get('property/{id}/gallery', ['uses' => 'app\property\galleryController@index','as' => 'property.gallery']);

   //property payment integration
   Route::get('payment/{id}/integration', ['uses' => 'app\property\settings\paymentIntegrationController@index','as' => 'property.payment.integration.settings']);
   Route::get('payment/{id}/integration/{integrationID}/delete', ['uses' => 'app\property\settings\paymentIntegrationController@delete','as' => 'property.payment.integration.settings.delete']);
   Route::post('payment/{id}/integration', ['uses' => 'app\property\settings\paymentIntegrationController@activation','as' => 'property.payment.integration.settings.activation']);

   //mpesa api
   Route::get('{propertyID}/integration/{getwayID}/mpesaapi', ['uses' => 'app\property\integration\payments\mpesaController@api','as' => 'property.mpesaapi.integration']);
   Route::post('{propertyID}/integration/{id}/mpesaapi/update', ['uses' => 'app\property\integration\payments\mpesaController@api_update','as' => 'property.mpesaapi.integration.update']);

   //mpesa till
   Route::get('{propertyID}/integration/{getwayID}/mpesatill/ ', ['uses' => 'app\property\integration\payments\mpesaController@till','as' => 'property.mpesatill.integration']);
   Route::post('{propertyID}/integration/{id}/mpesatill/update', ['uses' => 'app\property\integration\payments\mpesaController@till_update','as' => 'property.mpesatill.integration.update']);

   //mpesa paybill
   Route::get('{propertyID}/integration/{getwayID}/mpesapaybill/', ['uses' => 'app\property\integration\payments\mpesaController@paybill','as' => 'property.mpesapaybill.integration']);
   Route::post('{propertyID}/integration/{id}/mpesapaybill/update', ['uses' => 'app\property\integration\payments\mpesaController@paybill_update','as' => 'property.mpesapaybill.integration.update']);

   //bank 1
   Route::get('{propertyID}/integration/{getwayID}/bank1', ['uses' => 'app\property\integration\payments\bankController@bank','as' => 'property.bank1.integration']);
   Route::post('{propertyID}/integration/{id}/bank1/update', ['uses' => 'app\property\integration\payments\bankController@bank1_update','as' => 'property.bank1.integration.update']);

   //bank 2
   Route::get('{propertyID}/integration/{getwayID}/bank2', ['uses' => 'app\property\integration\payments\bankController@bank','as' => 'property.bank2.integration']);
   Route::post('{propertyID}/integration/{id}/bank2/update', ['uses' => 'app\property\integration\payments\bankController@bank2_update','as' => 'property.bank2.integration.update']);

   //bank 3
   Route::get('{propertyID}/integration/{getwayID}/bank3', ['uses' => 'app\property\integration\payments\bankController@bank','as' => 'property.bank3.integration']);
   Route::post('{propertyID}/integration/{id}/bank3/update', ['uses' => 'app\property\integration\payments\bankController@bank3_update','as' => 'property.bank3.integration.update']);

   //bank 4
   Route::get('{propertyID}/integration/{getwayID}/bank4', ['uses' => 'app\property\integration\payments\bankController@bank','as' => 'property.bank4.integration']);
   Route::post('{propertyID}/integration/{id}/bank4/update', ['uses' => 'app\property\integration\payments\bankController@bank4_update','as' => 'property.bank4.integration.update']);

   //bank 5
   Route::get('{propertyID}/integration/{getwayID}/bank5', ['uses' => 'app\property\integration\payments\bankController@bank','as' => 'property.bank5.integration']);
   Route::post('{propertyID}/integration/{id}/bank5/update', ['uses' => 'app\property\integration\payments\bankController@bank5_update','as' => 'property.bank5.integration.update']);

   //property images
   Route::get('{propertyID}/images', ['uses' => 'app\property\imagesController@index','as' => 'property.images']);
   Route::post('{propertyID}/images/upload', ['uses' => 'app\property\imagesController@upload_image','as' => 'property.images.upload']);
   Route::get('{propertyID}/images/{id}/delete', ['uses' => 'app\property\imagesController@delete','as' => 'property.images.delete']);

   //property documents
   //Route::get('{propertyID}/documents', ['uses' => 'app\property\documentsController@index','as' => 'property.documents']);
   Route::post('{propertyID}/documents/upload', ['uses' => 'app\property\documentsController@upload_document','as' => 'property.documents.upload']);
   Route::post('{propertyID}/documents/{documentID}/update', ['uses' => 'app\property\documentsController@update','as' => 'property.documents.update']);
   Route::get('{propertyID}/documents/{id}/delete', ['uses' => 'app\property\documentsController@delete','as' => 'property.documents.delete']);

   //expenses
   Route::get('{propertyID}/expenses', ['uses' => 'app\property\accounting\expenseController@index','as' => 'property.expense']);
   Route::get('{propertyID}/expenses/create', ['uses' => 'app\property\accounting\expenseController@create','as' => 'property.expense.create']);
   Route::post('{propertyID}/expenses/store', ['uses' => 'app\property\accounting\expenseController@store','as' => 'property.expense.store']);
   Route::get('{propertyID}/expenses/{id}/edit', ['uses' => 'app\property\accounting\expenseController@edit','as' => 'property.expense.edit']);
   Route::post('{propertyID}/expenses/{id}/update', ['uses' => 'app\property\accounting\expenseController@update','as' => 'property.expense.update']);
   Route::get('{propertyID}/expenses/{parentID}/file/{fileID}/delete', ['uses' => 'app\property\accounting\expenseController@delete_file','as' => 'property.expense.delete.file']);
   Route::get('{propertyID}/expenses/{parentID}/delete', ['uses' => 'app\property\accounting\expenseController@destroy','as' => 'property.expense.delete']);

   //credit note
   Route::get('{propertyID}/creditnote',['uses' => 'app\property\accounting\creditnoteController@index','as' => 'property.creditnote.index']);
   Route::get('{propertyID}/creditnote/create',['uses' => 'app\property\accounting\creditnoteController@create','as' => 'property.creditnote.create']);
   Route::post('{propertyID}/creditnote/store',['uses' => 'app\property\accounting\creditnoteController@store','as' => 'property.creditnote.store']);
   Route::get('{propertyID}/creditnote/{id}/edit',['uses' => 'app\property\accounting\creditnoteController@edit','as' => 'property.creditnote.edit']);
   Route::post('{propertyID}/creditnote/{id}/update',['uses' => 'app\property\accounting\creditnoteController@update','as' => 'property.creditnote.update']);
   Route::get('{propertyID}/creditnote/{id}/delete',['uses' => 'app\property\accounting\creditnoteController@delete','as' => 'property.creditnote.delete']);
   Route::get('{propertyID}/creditnote/{id}/show',['uses' => 'app\property\accounting\creditnoteController@show','as' => 'property.creditnote.show']);
   Route::get('{propertyID}/creditnote/{id}/pdf',['uses' => 'app\property\accounting\creditnoteController@pdf','as' => 'property.creditnote.pdf']);
   Route::get('{propertyID}/creditnote/{id}/print',['uses' => 'app\property\accounting\creditnoteController@print','as' => 'property.creditnote.print']);
   Route::post('creditnote/apply/credit',['uses' => 'app\property\accounting\creditnoteController@apply_credit','as' => 'property.creditnote.apply.credit']);
   Route::get('{propertyID}/creditnote/{id}/delete',['uses' => 'app\property\accounting\creditnoteController@delete_creditnote','as' => 'property.creditnote.delete']);

   //send creditnote
   Route::get('{propertyID}/creditnote/{id}/mail',['uses' => 'app\property\accounting\creditnoteController@mail','as' => 'property.creditnote.mail']);
   Route::post('creditnote/mail/send',['uses' => 'app\property\accounting\creditnoteController@send','as' => 'property.creditnote.mail.send']);

   //report
   Route::get('{propertyID}/reports',['uses' => 'app\property\reports\reportsController@dashboard','as' => 'property.reports']);

   //profit and loss
   Route::get('{propertyID}/reports/profitandloss',['uses' => 'app\property\reports\profitandlossController@report','as' => 'property.reports.profitandloss']);
   Route::get('{propertyID}/report/profilandloss/generate/{to}/{from}',['uses' => 'app\property\reports\profitandlossController@generate','as' => 'property.reports.profitandloss.generate']);

   //Expense Summary
   Route::get('{propertyID}/reports/expensesummary',['uses' => 'app\property\reports\expensesummaryController@report','as' => 'property.reports.expensesummary']);
   Route::get('{propertyID}/report/expensesummary/generate/{to}/{from}',['uses' => 'app\property\reports\expensesummaryController@generate','as' => 'property.reports.expensesummary.generate']);

   //Income Summary
   Route::get('{propertyID}/reports/incomesummary',['uses' => 'app\property\reports\incomesummaryController@report','as' => 'property.reports.incomesummary']);
   Route::get('{propertyID}/report/incomesummary/generate/{to}/{from}',['uses' => 'app\property\reports\incomesummaryController@generate','as' => 'property.reports.incomesummary.generate']);



   /* =======================================================================================================================================
   ==                                                    marketing                                                                         ==
   =========================================================================================================================================*/
   //listing
   Route::get('/marketing/listings', ['uses' => 'app\property\marketing\listingController@index','as' => 'property.lisitng']);
   Route::get('/property/{id}/list', ['uses' => 'app\property\marketing\listingController@add_to_list','as' => 'list.property']);
   Route::get('/marketing/property/{id}/edit', ['uses' => 'app\property\marketing\listingController@edit','as' => 'list.property.edit']);
   Route::post('/marketing/property/update', ['uses' => 'app\property\marketing\listingController@update','as' => 'list.property.update']);
   Route::get('/marketing/property/{id}/details', ['uses' => 'app\property\marketing\listingController@show','as' => 'list.property.details']);
   Route::get('/marketing/property/{propertyID}/{listID}/cancel', ['uses' => 'app\property\marketing\listingController@cancel_listing','as' => 'list.property.cancel']);
   Route::get('/marketing/property/{id}/image/{imageID}/delete', ['uses' => 'app\property\marketing\listingController@delete_image','as' => 'list.property.delete.image']);
   Route::get('/marketing/property/{id}/image/{imageID}/cover', ['uses' => 'app\property\marketing\listingController@image_cover','as' => 'list.property.image.cover']);
   Route::get('/marketing/property/{id}/delete', ['uses' => 'app\property\marketing\listingController@delete','as' => 'list.property.delete']);

   //listing leads
   Route::get('/inquiry', ['uses' => 'app\property\marketing\inquiryController@index','as' => 'property.inquiry']);

   /* =======================================================================================================================================
   ==                                                    tenants                                                                           ==
   =========================================================================================================================================*/
   //tenants in property
   Route::get('/{propertyID}/tenants', ['uses' => 'app\property\property\tenants\tenantsController@index','as' => 'property.tenants']);
   Route::get('tenants/{propertyID}/{tenantID}/show',['uses' => 'app\property\property\tenants\tenantsController@show','as' => 'property.tenants.show']);
   Route::get('property/{id}/tenant/contactperson', ['uses' => 'app\property\property\tenants\tenantsController@delete_contact_person','as' => 'tenant.contactperson.delete']);
   Route::get('delete-vendor-person/{id}',['uses' => 'app\property\property\tenants\tenantsController@delete_vendor_person','as' => 'tenantsperson.delete']);
   Route::get('tenants/{id}/trash',['uses' => 'app\property\property\tenants\tenantsController@trash','as' => 'tenants.trash.update']);

   //tenant notes
   Route::get('tenants/{propertyID}/{tenantID}/notes',['uses' => 'app\property\property\tenants\notesController@index','as' => 'tenants.notes']);
   Route::post('tenants/notes/store',['uses' => 'app\property\property\tenants\notesController@store','as' => 'tenants.notes.store']);
   Route::post('tenants/notes/{id}/update',['uses' => 'app\property\property\tenants\notesController@update','as' => 'tenants.notes.update']);
   Route::get('tenants/{id}/notes/delete',['uses' => 'app\property\property\tenants\notesController@delete','as' => 'tenants.notes.delete']);

   //billing
   Route::get('tenants/{propertyID}/{tenantID}/invoices',['uses' => 'app\property\property\tenants\invoicesController@index','as' => 'tenants.invoice.index']);

   //statement
   Route::get('tenants/{id}/statement',['uses' => 'app\property\property\tenants\tenantsController@show','as' => 'tenants.statement']);

   //units
   Route::get('tenants/{propertyID}/{tenantID}/units',['uses' => 'app\property\property\tenants\unitsController@index','as' => 'tenants.units.index']);


   //Tenant Lease
   Route::get('/tenant/{propertyID}/{tenantID}/lease',['uses' => 'app\property\property\tenants\leasesController@index','as' => 'property.tenant.lease']);
   Route::get('/tenant/{propertyID}/{tenantID}/{leaseID}/lease/details',['uses' => 'app\property\property\tenants\leasesController@show','as' => 'property.tenant.lease.show']);
   Route::get('/tenant/{propertyID}/{tenantID}/edit/{leaseID}/lease',['uses' => 'app\property\property\tenants\leasesController@edit','as' => 'property.tenant.lease.edit']);
   Route::post('tenant/update/{leaseID}/lease',['uses' => 'app\property\property\tenants\leasesController@update','as' => 'property.tenant.lease.update']);
   Route::get('tenant/lease/{leaseID}/delete',['uses' => 'app\property\property\tenants\leasesController@delete_lease','as' => 'property.tenant.lease.delete']);

   Route::post('tenant/lease/utility/store',['uses' => 'app\property\property\tenants\leasesController@add_utility','as' => 'property.tenant.lease.add.utility']);
   Route::post('tenant/lease/utility/update',['uses' => 'app\property\property\tenants\leasesController@update_utility','as' => 'property.tenant.lease.update.utility']);
   Route::get('tenant/lease/{leaseID}/utility/{id}/delete',['uses' => 'app\property\property\tenants\leasesController@delete_utility','as' => 'property.leases.delete.utility']);
   Route::post('tenant/lease/terminate',['uses' => 'app\property\property\tenants\leasesController@lease_termination','as' => 'property.lease.terminate']);


   /* === utility === */
   Route::get('utility/{id}/billing',['uses' => 'app\property\accounting\utilityController@index','as' => 'utility.billing.index']);
   Route::post('utility/billing/hold',['uses' => 'app\property\accounting\utilityController@hold_utility','as' => 'utility.billing.hold']);
   Route::get('utility/{id}/readings',['uses' => 'app\property\accounting\utilityController@utility_readings','as' => 'utility.readings']);
   Route::post('utility/bill/readings',['uses' => 'app\property\accounting\utilityController@bill_utility','as' => 'utility.bill.readings']);
   Route::post('utility/bill/search',['uses' => 'app\property\accounting\utilityController@utility_search','as' => 'utility.bill.search']);
   Route::get('utility/{propertyID}/billing/{periodID}/history',['uses' => 'app\property\accounting\utilityController@history','as' => 'utility.billing.history']);
   Route::post('utility/billing/{id}/update',['uses' => 'app\property\accounting\utilityController@utility_update','as' => 'utility.billing.update']);

   /* =======================================================================================================================================
   ==                                                    Agents                                                                         ==
   =========================================================================================================================================*/
   Route::get('agents',['uses' => 'app\property\agentsController@index','as' => 'property.agents']);
   Route::get('agents/create',['uses' => 'app\property\agentsController@create','as' => 'property.agents.create']);
   Route::post('agents/store',['uses' => 'app\property\agentsController@store','as' => 'property.agents.store']);
   Route::get('agents/{id}/edit',['uses' => 'app\property\agentsController@edit','as' => 'property.agents.edit']);
   Route::post('agents/{id}/update',['uses' => 'app\property\agentsController@update','as' => 'property.agents.update']);
   Route::get('agents/{id}/delete',['uses' => 'app\property\agentsController@delete','as' => 'property.agents.delete']);


   /* =======================================================================================================================================
   ==                                                    Supplier                                                                         ==
   =========================================================================================================================================*/
   Route::get('supplier',['uses' => 'app\property\supplierController@index','as' => 'property.supplier']);
   Route::get('supplier/create',['uses' => 'app\property\supplierController@create','as' => 'property.supplier.create']);
   Route::post('supplier/store',['uses' => 'app\property\supplierController@store','as' => 'property.supplier.store']);
   Route::get('supplier/{id}/edit',['uses' => 'app\property\supplierController@edit','as' => 'property.supplier.edit']);
   Route::post('supplier/{id}/update',['uses' => 'app\property\supplierController@update','as' => 'property.supplier.update']);
   Route::get('supplier/{id}/delete',['uses' => 'app\property\supplierController@delete','as' => 'property.supplier.delete']);


   /* =======================================================================================================================================
   ==                                                    landlords                                                                         ==
   =========================================================================================================================================*/
   //landlords
   Route::get('landlord',[ 'uses' => 'app\property\landlords\landlordController@index','as' => 'landlord.index']);
   Route::get('landlord/create',['uses' => 'app\property\landlords\landlordController@create','as' => 'landlord.create']);
   Route::post('post-landlords',['uses' => 'app\property\landlords\landlordController@store','as' => 'landlord.store']);
   Route::get('landlord/{id}/edit',['uses' => 'app\property\landlords\landlordController@edit','as' => 'landlord.edit']);
   Route::post('landlord/{id}/update',['uses' => 'app\property\landlords\landlordController@update','as' => 'landlord.update']);
   Route::get('landlord/{id}/show',['uses' => 'app\property\landlords\landlordController@show','as' => 'landlord.show']);
   Route::get('landlord/{id}/delete',['uses' => 'app\property\landlords\landlordController@delete','as' => 'landlord.delete']);
   Route::get('landlord/{id}/delete-contact-person',['uses' => 'app\property\landlords\landlordController@delete_contact_person','as' => 'landlordperson.delete']);
   Route::get('landlord/{id}/trash',['uses' => 'app\property\landlords\landlordController@trash','as' => 'landlord.trash.update']);

   //import
   Route::get('landlord/import',['uses' => 'app\property\landlords\importController@import','as' => 'landlord.import.index']);
   Route::post('landlord/post/import',['uses' => 'app\property\landlords\importController@import_contact','as' => 'landlord.import']);
   Route::get('landlord/download/import/sample/',['uses' => 'app\property\landlords\importController@download_import_sample','as' => 'landlord.download.sample.import']);

   //export
   Route::get('landlord/export',['uses' => 'app\property\landlords\importController@export','as' => 'landlord.export']);

   /* =======================================================================================================================================
   ==                                                    Tenants                                                                           ==
   =========================================================================================================================================*/
   /* === Tenants === */
   Route::get('tenants',['uses' => 'app\property\tenants\tenantsController@index','as' => 'tenants.index']);
   Route::get('tenants/create',['uses' => 'app\property\tenants\tenantsController@create','as' => 'tenants.create']);
   Route::post('tenants/store',['uses' => 'app\property\tenants\tenantsController@store','as' => 'tenants.store']);
   Route::get('tenants/{id}/edit',['uses' => 'app\property\tenants\tenantsController@edit','as' => 'tenants.edit']);
   Route::post('tenants/{id}/update',['uses' => 'app\property\tenants\tenantsController@update','as' => 'tenants.update']);
   Route::get('tenants/{code}/delete',['uses' => 'app\property\tenants\tenantsController@delete','as' => 'tenants.delete']);

   //import
   Route::get('tenants/import',['uses' => 'app\property\tenants\importController@index','as' => 'tenants.import.index']);
   Route::post('tenants/post/import',['uses' => 'app\property\tenants\importController@import','as' => 'tenants.import']);
   Route::get('tenants/download/import/sample/',['uses' => 'app\property\property\tenants\importController@download_import_sample','as' => 'tenants.download.sample.import']);

   //export
   Route::get('tenants/export',['uses' => 'app\property\tenants\importController@export','as' => 'tenants.export']);


   /* =======================================================================================================================================
   ==                                                    Maintenance                                                                       ==
   =========================================================================================================================================*/
   /* === Maintenance === */
   Route::get('maintenance',['uses' => 'app\property\maintenance\maintenanceController@index','as' => 'property.maintenance']);
   Route::get('maintenance/create',['uses' => 'app\property\maintenance\maintenanceController@create','as' => 'property.maintenance.create']);
   Route::post('maintenance/store',['uses' => 'app\property\maintenance\maintenanceController@store','as' => 'property.maintenance.store']);
   Route::get('maintenance/{id}/edit',['uses' => 'app\property\maintenance\maintenanceController@edit','as' => 'property.maintenance.edit']);
   Route::get('maintenance/property/units/{id}',['uses' => 'app\property\maintenance\maintenanceController@get_units','as' => 'pm.maintenance.get.units']);
   Route::get('maintenance/property/units/tenant/{id}',['uses' => 'app\property\maintenance\maintenanceController@get_tenant','as' => 'pm.maintenance.get.units.tenant']);
   Route::get('maintenance/get/category/{id}',['uses' => 'app\property\maintenance\maintenanceController@get_maintenance_category','as' => 'pm.maintenance.get.category']);


   //category
   Route::get('maintenance/category',['uses' => 'app\property\maintenance\maintenanceCategoryController@index','as' => 'maintenance.category.index']);
   Route::post('maintenance/category/store',['uses' => 'app\property\maintenance\maintenanceCategoryController@store','as' => 'maintenance.category.store']);
   Route::get('maintenance/category/{id}/edit',['uses' => 'app\property\maintenance\maintenanceCategoryController@edit','as' => 'maintenance.category.edit']);
   Route::post('maintenance/category/{id}/update',['uses' => 'app\property\maintenance\maintenanceCategoryController@update','as' => 'maintenance.category.update']);
   Route::get('maintenance/category/{id}/delete',['uses' => 'app\property\maintenance\maintenanceCategoryController@delete','as' => 'maintenance.category.delete']);


   /* =======================================================================================================================================
   ==                                                    Settings                                                                          ==
   =========================================================================================================================================*/
  /* === taxes === */
   Route::get('taxes',['uses' => 'app\property\settings\taxesController@index','as' => 'property.taxes']);
   Route::post('taxes/store',['uses' => 'app\property\settings\taxesController@store','as' => 'property.taxes.store']);
   Route::get('taxes/{id}/edit',['uses' => 'app\property\settings\taxesController@edit','as' => 'property.taxes.edit']);
   Route::post('taxes/update',['uses' => 'app\property\settings\taxesController@update','as' => 'property.taxes.update']);
   Route::get('taxes/{id}/delete',['uses' => 'app\property\settings\taxesController@delete','as' => 'property.taxes.delete']);

   //tax express
   Route::get('/taxes/express',['uses' => 'app\property\settings\taxesController@express_list','as' => 'property.taxes.express']);
   Route::post('/taxes/express/store',['uses' => 'app\property\settings\taxesController@store_express','as' => 'property.taxes.express.store']);

   /* === income category === */
   Route::get('income/category/',['uses' => 'app\property\settings\incomeController@index','as' => 'property.income.category']);
   Route::get('income/category/create',['uses' => 'app\property\settings\incomeController@create','as' => 'property.income.category.create']);
   Route::post('income/category/store',['uses' => 'app\property\settings\incomeController@store','as' => 'property.income.category.store']);
   Route::get('income/category/{id}/edit',['uses' => 'app\property\settings\incomeController@edit','as' => 'property.income.category.edit']);
   Route::post('income/category/update',['uses' => 'app\property\settings\incomeController@update','as' => 'property.income.category.update']);
   Route::get('income/category/{id}/delete',['uses' => 'app\property\settings\incomeController@delete','as' => 'property.income.category.delete']);
   Route::post('express/income/category/create',['uses' => 'app\property\settings\incomeController@express']);
   Route::get('express/income/category/get',['uses' => 'app\property\settings\incomeController@get_express','as' => 'property.income.express.category']);

   /* === payment methods === */
   Route::get('payment/methods',['uses' => 'app\property\settings\paymentMethodsController@index','as' => 'property.payment.method']);
   Route::post('payment/methods/store',['uses' => 'app\property\settings\paymentMethodsController@store','as' => 'property.payment.method.store']);
   Route::post('payment/methods/{id}/update',['uses' => 'app\property\settings\paymentMethodsController@update','as' => 'property.payment.method.update']);
   Route::get('payment/methods/{id}/delete',['uses' => 'app\property\settings\paymentMethodsController@delete','as' => 'property.payment.method.delete']);

   //payment method express
   Route::get('express/payment/list',['uses' => 'app\property\settings\paymentMethodsController@express_list','as' => 'property.payment.mode.express']);
   Route::post('express/payment/modes/store',['uses' => 'app\property\settings\paymentMethodsController@express_store','as' => 'property.payment.mode.express.store']);

   //expense category
   Route::get('expense/category',['uses' => 'app\property\settings\expenseCategoryController@index','as' => 'property.expense.category.index']);
   Route::post('expense/category/store',['uses' => 'app\property\settings\expenseCategoryController@store','as' => 'property.expense.category.store']);
   Route::get('expense-category/{id}/edit',['uses' => 'app\property\settings\expenseCategoryController@edit','as' => 'property.expense.category.edit']);
   Route::post('expense-category/{id}/update',['uses' => 'app\property\settings\expenseCategoryController@update','as' => 'property.expense.category.update']);
   Route::get('expense-category/{id}/delete',['uses' => 'app\property\settings\expenseCategoryController@destroy','as' => 'property.expense.category.destroy']);

   //express category CRUD
   Route::post('/express/expense/category/store',['uses' => 'app\property\settings\expenseCategoryController@express','as' => 'property.express.expense.category.store']);
   Route::get('/express/expense/category/list',['uses' => 'app\property\settings\expenseCategoryController@list','as' => 'property.express.expense.category.list']);

   /* === utilities === */
   Route::get('utilities',['uses' => 'app\property\settings\utilitiesController@index','as' => 'property.utilities']);
   Route::get('utilities/create',['uses' => 'app\property\settings\utilitiesController@create','as' => 'property.utilities.create']);
   Route::post('utilities/store',['uses' => 'app\property\settings\utilitiesController@store','as' => 'property.utilities.store']);
   Route::get('utilities/{id}/edit',['uses' => 'app\property\settings\utilitiesController@edit','as' => 'property.utilities.edit']);
   Route::post('utilities/{id}/update',['uses' => 'app\property\settings\utilitiesController@update','as' => 'property.utilities.update']);
   Route::get('utilities/{id}/delete',['uses' => 'app\property\settings\utilitiesController@delete','as' => 'property.utilities.delete']);
});


/*
|--------------------------------------------------------------------------
| settings
|--------------------------------------------------------------------------
|
| Manage contents of your website quick and first
*/

// Route::group(['prefix' => 'admin', 'middleware' => ['role:admin']], function() {
//    Route::get('/', 'AdminController@welcome');
//    Route::get('/manage', ['middleware' => ['permission:manage-admins'], 'uses' =>'AdminController@manageAdmins']);
// });

//Route::get('content', ['middleware' => ['permission:content-list'], 'uses' => 'cms.pages\contentController@index'])->name('content.index');

Route::prefix('settings')->middleware('auth','role:admin')->group(function () {
   /* ==== Dashboard ==== */
   Route::get('/',['uses' => 'app\settings\business\businessController@index', 'as' => 'settings.index']);

   /* ==== Business Profile ==== */
   Route::get('/businessprofile',['middleware' => ['permission:read-businessprofile'], 'uses' => 'app\settings\business\businessController@index','as' => 'settings.business.index']);
   Route::get('/businessprofile/edit',['middleware' => ['permission:edit-businessprofile'], 'uses' => 'app\settings\business\businessController@index','as' => 'settings.business.edit']);
   Route::post('/businessprofile/{id}/update',['middleware' => ['permission:update-businessprofile'], 'uses' => 'app\settings\business\businessController@update','as' => 'settings.business.update']);
   Route::get('/businessprofile/{id}/delete/logo',['middleware' => ['permission:delete-businessprofile'], 'uses' => 'app\settings\business\businessController@delete_logo','as' => 'settings.business.delete.logo']);

   /* ==== Users ==== */
   Route::get('/users',['middleware' => ['permission:read-users'], 'uses' => 'app\settings\users\UserController@index','as' => 'settings.users.index']);
   Route::get('/users/create',['middleware' => ['permission:create-users'], 'uses' => 'app\settings\users\UserController@create','as' => 'settings.users.create']);
   Route::post('/users/store',['middleware' => ['permission:create-users'], 'uses' => 'app\settings\users\UserController@store','as' => 'settings.users.store']);
   Route::get('/users/{id}/edit',['middleware' => ['permission:update-users'], 'uses' => 'app\settings\users\UserController@edit', 'as' => 'settings.users.edit']);
   Route::post('/users/{id}/update',['middleware' => ['permission:update-users'], 'uses' => 'app\settings\users\UserController@update', 'as' => 'settings.users.update']);

   /* ==== Language ==== */
   Route::get('/language',['uses' => 'app\settings\language\languageController@index', 'as' => 'language.index']);
   Route::get('/language/{id}/{section}',['uses' => 'app\settings\Language\LanguageController@show', 'as' => 'language.show']);
   Route::post('/language/translate/section',['uses' => 'app\settings\Language\LanguageController@post_show', 'as' => 'language.translate.section']);
   Route::post('/language/translate',['uses' => 'app\settings\Language\LanguageController@translate','as' => 'language.translate']);
   Route::get('/language/{id}/edit',['uses' => 'app\settings\Language\LanguageController@edit','as' => 'language.edit']);
   Route::post('/language/{id}/update',['uses' => 'app\settings\Language\LanguageController@update','as' => 'language.update']);
   Route::post('settings/defaultLanguage',['uses' => 'app\settings\language\languageController@defaultLanguage','as' => 'language.defaultLanguage']);
   Route::post('language/store',['uses' => 'app\settings\Language\LanguageController@store','as' => 'language.store']);
   Route::get('language/{id}/delete',['uses' => 'app\settings\Language\LanguageController@destroy','as' => 'language.destroy']);

   /* === roles === */
   Route::get('/roles', [ 'uses' =>'app\settings\users\rolesController@index'])->name('settings.roles.index');
   Route::get('/roles/{id}/show',['uses' => 'app\settings\users\rolesController@show', 'as' => 'settings.roles.show']);
   Route::get('/roles/create', ['uses' => 'app\settings\users\rolesController@create', 'as' => 'settings.roles.create']);
   Route::post('/roles/store',['uses' => 'app\settings\users\rolesController@store', 'as' => 'settings.roles.store']);
   Route::get('/roles/{id}/edit',['uses' => 'app\settings\users\rolesController@edit', 'as' => 'settings.roles.edit']);
   Route::post('/roles/{id}/update',['uses' => 'app\settings\users\rolesController@update', 'as' => 'settings.roles.update']);
   Route::get('/roles/{id}/delete',['middleware' => ['permission:delete-roles'],'uses' => 'app\settings\users\rolesController@delete', 'as' => 'settings.roles.delete']);

   /* ==== Applications ==== */
   Route::get('/account/applications',['uses' => 'app\settings\applications\applicationController@index', 'as' => 'settings.applications']);
   Route::get('/account/application/{id}/delete',['uses' => 'app\settings\applications\applicationController@delete', 'as' => 'settings.application.delete']);
   Route::get('/account/application/{applicationID}/billing',['uses' => 'app\settings\applications\applicationController@billing', 'as' => 'settings.applications.billing']);

   /* ==== billing ==== */
   Route::get('/account/billing',['uses' => 'app\settings\billingController@index', 'as' => 'settings.billing']);

   /* ==== integrations ==== */
   //payment
   Route::get('/payment/integrations',['middleware' => ['permission:read-paymentintegrations'], 'uses' => 'app\settings\integrations\payments\paymentsController@index', 'as' => 'settings.integrations.payments']);
   Route::post('/payment/integrations/store',['middleware' => ['permission:create-paymentintegrations'], 'uses' => 'app\settings\integrations\payments\paymentsController@store', 'as' => 'settings.integrations.payments.store']);
   Route::get('/payment/integrations{id}/status/{statusID}',['middleware' => ['permission:create-paymentintegrations'], 'uses' => 'app\settings\integrations\payments\paymentsController@status', 'as' => 'settings.integrations.payments.status']);
   Route::get('/payment/integrations/{id}/delete',['middleware' => ['permission:create-paymentintegrations'], 'uses' => 'app\settings\integrations\payments\paymentsController@delete', 'as' => 'settings.integrations.payments.delete']);

   //pesapal
   Route::get('payment/integrations/{id}/pesapal',['middleware' => ['permission:update-paymentintegrations'],'uses' => 'app\settings\integrations\payments\pesapalController@edit', 'as' => 'settings.integrations.payments.pesapal.edit']);
   Route::post('payment/integrations/{id}/pesapal/update',['middleware' => ['permission:update-paymentintegrations'],'uses' => 'app\settings\integrations\payments\pesapalController@update', 'as' => 'settings.integrations.payments.pesapal.update']);

   //paypal
   Route::get('payment/integrations/{id}/paypal',['middleware' => ['permission:update-paymentintegrations'],'uses' => 'app\settings\integrations\payments\paypalController@edit', 'as' => 'settings.integrations.payments.paypal.edit']);
   Route::post('payment/integrations/{id}/paypal/update',['middleware' => ['permission:update-paymentintegrations'],'uses' => 'app\settings\integrations\payments\paypalController@update', 'as' => 'settings.integrations.payments.paypal.update']);

   //kepler9
   Route::get('payment/integrations/{id}/kepler9',['middleware' => ['permission:update-paymentintegrations'],'uses' => 'app\settings\integrations\payments\kepler9Controller@edit', 'as' => 'settings.payments.integrations.kepler9']);
   Route::post('payment/integrations/{id}/kepler9/update',['middleware' => ['permission:update-paymentintegrations'],'uses' => 'app\settings\integrations\payments\kepler9Controller@update', 'as' => 'settings.integrations.payments.kepler9.update']);

   //ipay
   Route::get('payment/integrations/{id}/ipay',['middleware' => ['permission:update-paymentintegrations'],'uses' => 'app\settings\integrations\payments\ipayController@edit', 'as' => 'settings.payments.integrations.ipay']);
   Route::post('payment/integrations/{id}/ipay/update',['middleware' => ['permission:update-paymentintegrations'],'uses' => 'app\settings\integrations\payments\ipayController@update', 'as' => 'settings.payments.integrations.ipay.update']);

   //daraja
   Route::get('payment/integrations/{id}/mpesa',['middleware' => ['permission:update-paymentintegrations'],'uses' => 'app\settings\integrations\payments\mpesa\darajaController@edit', 'as' => 'settings.integrations.payments.mpesa.edit']);
   Route::post('payment/integrations/{id}/mpesa/update',['middleware' => ['permission:update-paymentintegrations'],'uses' => 'app\settings\integrations\payments\mpesa\darajaController@update', 'as' => 'settings.integrations.payments.mpesa.update']);
   Route::get('daraja/register/url/{businessID}', 'app\settings\integrations\payments\mpesa\darajaController@registerUrls')->name('settings.integrations.daraja.register.urls');


   // Route::get('payment/integrations/{id}/lipana/process',['uses' => 'app\settings\integrations\payments\mpesa\darajaController@process_payment', 'as' => 'settings.integrations.payments.mpesa.process']);

   // Route::get('payment/integrations/lipana/confirmation/url',['uses' => 'app\settings\integrations\payments\mpesa\mpesaController@confirmation_url', 'as' => 'settings.integrations.payments.mpesa.confirm']);

   // Route::get('payment/integrations/lipana/validation/url',['uses' => 'app\settings\integrations\payments\mpesa\mpesaController@validation_url', 'as' => 'settings.integrations.payments.mpesa.validation']);

   // Route::get('payment/integrations/lipana/register/url',['uses' => 'app\settings\integrations\payments\mpesa\mpesaController@register_url', 'as' => 'settings.integrations.payments.mpesa.register.url']);

   // Route::get('payment/integrations/lipana/simulate',['uses' => 'app\settings\integrations\payments\mpesa\mpesaController@simulate', 'as' => 'settings.integrations.payments.mpesa.simulate']);

   //mpesa phone number
   Route::get('payment/integrations/{id}/mpesa-phone-number',['uses' => 'app\settings\integrations\payments\mpesa\phonenumberController@phone_number', 'as' => 'settings.payments.integrations.mpesa.phonenumber']);
   Route::post('payment/integrations/{id}/mpesa-phone-number/update',['uses' => 'app\settings\integrations\payments\mpesa\phonenumberController@update_phone_number', 'as' => 'settings.payments.integrations.mpesa.phonenumber.update']);

   //mpesa till number
   Route::get('payment/integrations/{id}/mpesa-till-number',['uses' => 'app\settings\integrations\payments\mpesa\tillnumberController@till_number', 'as' => 'settings.payments.integrations.mpesa.tillnumber']);
   Route::post('payment/integrations/{id}/mpesa-till-number/update',['uses' => 'app\settings\integrations\payments\mpesa\tillnumberController@update_till_number', 'as' => 'settings.payments.integrations.mpesa.tillnumber.update']);

   //mpesa paybill number
   Route::get('payment/integrations/{id}/mpesa-paybill-number',['uses' => 'app\settings\integrations\payments\mpesa\paybillnumberController@paybill_number', 'as' => 'settings.payments.integrations.mpesa.paybillnumber']);
   Route::post('payment/integrations/{id}/mpesa-paybill-number/update',['uses' => 'app\settings\integrations\payments\mpesa\paybillnumberController@update_paybill_number', 'as' => 'settings.payments.integrations.mpesa.paybillnumber.update']);

   /* ==== Telephony integrations ==== */
   Route::get('/integrations/telephony',['middleware' => ['permission:read-telephonyintegrations'],'uses' => 'app\settings\integrations\telephony\telephonyController@index', 'as' => 'settings.integrations.telephony']);
   Route::post('/integrations/telephony/store',['middleware' => ['permission:create-telephonyintegrations'],'uses' => 'app\settings\integrations\telephony\telephonyController@store', 'as' => 'settings.integrations.telephony.store']);

   //twilio
   Route::get('/integrations/telephony/{id}/twilio',['middleware' => ['permission:update-telephonyintegrations'], 'uses' => 'app\settings\integrations\telephony\twilioController@edit', 'as' => 'settings.integrations.telephony.twilio.edit']);
   Route::post('/integrations/telephony/{id}/twilio/update',['middleware' => ['permission:update-telephonyintegrations'], 'uses' => 'app\settings\integrations\telephony\twilioController@update', 'as' => 'settings.integrations.telephony.twilio.update']);

   //africas talking
   Route::get('/integrations/telephony/{id}/africasTalking',['middleware' => ['permission:update-telephonyintegrations'], 'uses' => 'app\settings\integrations\telephony\africasTalkingController@edit', 'as' => 'settings.integrations.telephony.africasTalking.edit']);
   Route::post('/integrations/telephony/{id}/africasTalking/update',['middleware' => ['permission:update-telephonyintegrations'], 'uses' => 'app\settings\integrations\telephony\africasTalkingController@update', 'as' => 'settings.integrations.telephony.africasTalking.update']);
});

Route::prefix('applications')->middleware('auth')->group(function () {
   Route::get('/setup',['uses' => 'app\wingu\applicationController@application_setup', 'as' => 'application.setup']);
   Route::get('/{moduleID}/add-to-cart',['uses' => 'app\wingu\applicationController@add_to_cart', 'as' => 'application.add.cart']);
   Route::get('/{cartID}/remove-item',['uses' => 'app\wingu\applicationController@remove_cart', 'as' => 'application.remove.cart']);
   Route::post('/install',['uses' => 'app\wingu\applicationController@install', 'as' => 'application.install']);

   Route::get('/',['uses' => 'app\wingu\applicationController@add_application', 'as' => 'application']);
});

//paypall
Route::post('/subscriptions/paypal',['uses' => 'app\wingu\paypalController@payment', 'as' => 'wingu.subscription.paypal']);
Route::get('/subscriptions/paypal/callback',['uses' => 'app\wingu\paypalController@callback', 'as' => 'wingu.subscription.paypal.callback']);
Route::get('/subscriptions/paypal/cancel',['uses' => 'app\wingu\paypalController@cancel', 'as' => 'wingu.subscription.paypal.cancel']);

//ipay
Route::get('/application/ipay/callback',['uses' => 'app\wingu\ipayController@callback', 'as' => 'wingu.application.payment']);

//record email openings
Route::get('track/email/{code}/{businessID}/{mailID}', ['uses' => 'app\crm\mail\mailController@track']);
Route::get('track/invoice/{trackCode}/{businessID}/{invoiceID}', ['uses' => 'app\crm\trackController@invoice']);
Route::get('track/salesorder/{trackCode}/{businessID}/{salesID}', ['uses' => 'app\crm\trackController@salesorder']);
Route::get('track/quote/{trackCode}/{businessID}/{quoteID}', ['uses' => 'app\crm\trackController@quote']);

//test lab section
Route::get('/lab/mailchimp', 'lab\mailchimpController@index');


//callbacks
Route::get('/callbacks/ipay',['uses' => 'app\callbacks\callbacksController@ipay', 'as' => 'callback.ipay']);

//landing page callback
Route::get('/landingpage/callback',['uses' => 'app\crm\callbacks\landingpage@collect_data', 'as' => 'crm.callback.landingpage']);






