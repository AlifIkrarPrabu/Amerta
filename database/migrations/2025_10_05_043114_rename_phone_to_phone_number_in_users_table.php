    <?php

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
            // Periksa apakah kolom 'phone' ada sebelum mencoba mengganti namanya.
            if (Schema::hasColumn('users', 'phone')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->renameColumn('phone', 'phone_number');
                });
            } else {
                // Jika kolom 'phone_number' belum ada sama sekali, tambahkan kolom baru
                // Asumsi: Jika 'phone' tidak ada, maka 'phone_number' juga belum ada.
                if (!Schema::hasColumn('users', 'phone_number')) {
                    Schema::table('users', function (Blueprint $table) {
                        // Tambahkan kolom 'phone_number', atur nullable jika data lama mungkin kosong.
                        $table->string('phone_number', 15)->nullable()->after('email')->unique();
                    });
                }
            }
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            // Ini akan membalikkan perubahan (opsional)
            if (Schema::hasColumn('users', 'phone_number')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->renameColumn('phone_number', 'phone');
                });
            }
        }
    };
    
