<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSupplierSalesDocumentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('supplier_sales_documents', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('supplierID');
			$table->integer('salesDocumentID');
			$table->string('status');
			$table->decimal('amount', 10,0)->nullable();
			$table->decimal('netTotal', 10,2)->nullable();
			$table->decimal('vatTotal', 10,2)->nullable();
			$table->decimal('total', 10,2)->nullable();
			$table->text('supplierNotes')->nullable();
			$table->timestamp('lastModified')->nullable();
			$table->string('lastModifierUsername')->nullable();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('supplier_sales_documents');
	}

}
