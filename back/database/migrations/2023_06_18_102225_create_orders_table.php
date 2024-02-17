<?php

use App\Models\Customer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->text('comment')
                ->nullable()
                ->comment('Комментарий к заказу');
            $table->integer('cost')
                ->comment('Итоговая стоимость');
            $table->dateTime('receipt_time')
                ->comment('Время приготовления');
            $table->boolean('can_earlier')
                ->comment('Можно ли доставить заказ раньше');
            $table->foreignId('customer_id')
                ->constrained();
            $table->foreignId('payment_method_id')
                ->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
