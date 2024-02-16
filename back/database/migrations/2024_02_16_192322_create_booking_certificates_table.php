<?php

use App\Domain\Bookings\Models\Booking;
use App\Domain\Certificates\Models\CertificateType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('booking_certificates', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->foreignIdFor(Booking::class)->comment('Идентификатор бронирования')->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(CertificateType::class)->comment('Идентификатор типа сертификата')->constrained();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_certificates');
    }
};
