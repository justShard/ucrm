<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Таблиця: doc_access
        Schema::create('doc_access', function (Blueprint $table) {
            $table->id('access_id');
            $table->string('access_name', 32)->unique();
        });

        // Таблиця: docs_status
        Schema::create('docs_status', function (Blueprint $table) {
            $table->id('docs_status_id');
            $table->string('docs_status_name', 32)->unique();
            $table->boolean('active')->default(1);
        });

        // Таблиця: docs_type
        Schema::create('docs_type', function (Blueprint $table) {
            $table->id('docs_type_id');
            $table->string('docs_type_name', 64)->unique();
            $table->boolean('active')->default(1);
        });

        // Таблиця: priority (було: priority_id)
        Schema::create('priority', function (Blueprint $table) {
            $table->id('priority_id');
            $table->string('priority_name', 32)->unique();
        });

        // Таблиця: employee
        Schema::create('employee', function (Blueprint $table) {
            $table->id('employee_id');
            $table->string('employee_name', 128); // виправлено тип: було integer, стало string
        });

        // Таблиця: files
        Schema::create('files', function (Blueprint $table) {
            $table->id('file_id');
            $table->string('file_path', 256);
            $table->string('file_type', 8)->default('');
            $table->integer('size')->nullable();
            $table->date('date_created')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('hash', 256)->nullable();
            $table->unsignedBigInteger('employee_id');

            $table->foreign('employee_id')->references('employee_id')->on('employee');
        });

        // Таблиця: docs
        Schema::create('docs', function (Blueprint $table) {
            $table->id('docs_id');
            $table->string('docs_hash', 128); // виправлено тип: було integer, стало string
            $table->string('docs_name', 32);
            $table->unsignedBigInteger('docs_type_id')->nullable();
            $table->unsignedBigInteger('docs_status_id')->nullable();
            $table->unsignedBigInteger('access_id')->nullable();
            $table->unsignedBigInteger('priority_id')->nullable();
            $table->string('abstract', 256)->nullable();
            $table->unsignedBigInteger('parent_docs_id')->nullable();
            $table->dateTime('deadline')->nullable();
            $table->timestamp('date_created')->useCurrent();
            $table->timestamp('date_updated')->useCurrent();

            $table->foreign('docs_type_id')->references('docs_type_id')->on('docs_type');
            $table->foreign('docs_status_id')->references('docs_status_id')->on('docs_status');
            $table->foreign('access_id')->references('access_id')->on('doc_access');
            $table->foreign('priority_id')->references('priority_id')->on('priority'); // виправлено ім'я таблиці
        });

        // Таблиця: docs_employee
        Schema::create('docs_employee', function (Blueprint $table) {
            $table->unsignedBigInteger('docs_id');
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('position_id')->nullable();
            $table->boolean('signed')->default(0);

            $table->primary(['docs_id', 'employee_id']);
            $table->foreign('docs_id')->references('docs_id')->on('docs');
            $table->foreign('employee_id')->references('employee_id')->on('employee');
        });

        // Таблиця: docs_files
        Schema::create('docs_files', function (Blueprint $table) {
            $table->unsignedBigInteger('docs_id');
            $table->unsignedBigInteger('file_id');

            $table->primary(['docs_id', 'file_id']); // виправлено: прибрано дублікати унікальних індексів
            $table->foreign('docs_id')->references('docs_id')->on('docs');
            $table->foreign('file_id')->references('file_id')->on('files');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('docs_files');
        Schema::dropIfExists('docs_employee');
        Schema::dropIfExists('docs');
        Schema::dropIfExists('files');
        Schema::dropIfExists('employee');
        Schema::dropIfExists('priority'); // виправлено назву таблиці
        Schema::dropIfExists('docs_type');
        Schema::dropIfExists('docs_status');
        Schema::dropIfExists('doc_access');
    }
};