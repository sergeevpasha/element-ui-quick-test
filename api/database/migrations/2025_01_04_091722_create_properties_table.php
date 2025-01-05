<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    const TABLE_NAME = 'properties';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->comment('Properties (houses, apartments, etc.)');
            $table->id();
            $table->string('name')
                ->comment('Property name');
            $table->integer('price')
                ->index()
                ->default(0)
                ->comment('Property price');
            $table->smallInteger('bedrooms')
                ->index()
                ->default(0)
                ->comment('Number of bedrooms');
            $table->smallInteger('bathrooms')
                ->index()
                ->default(0)
                ->comment('Number of bathrooms');
            $table->smallInteger('storeys')
                ->index()
                ->default(0)
                ->comment('Number of storeys');
            $table->smallInteger('garages')
                ->index()
                ->default(0)
                ->comment('Number of garages');
        });

        // Prevent negative values

        DB::statement("ALTER TABLE " . self::TABLE_NAME . " ADD CONSTRAINT check_price_non_negative CHECK (price >= 0)");
        DB::statement("ALTER TABLE " . self::TABLE_NAME . " ADD CONSTRAINT check_bedrooms_non_negative CHECK (bedrooms >= 0)");
        DB::statement("ALTER TABLE " . self::TABLE_NAME . " ADD CONSTRAINT check_bathrooms_non_negative CHECK (bathrooms >= 0)");
        DB::statement("ALTER TABLE " . self::TABLE_NAME . " ADD CONSTRAINT check_storeys_non_negative CHECK (storeys >= 0)");
        DB::statement("ALTER TABLE " . self::TABLE_NAME . " ADD CONSTRAINT check_garages_non_negative CHECK (garages >= 0)");

        DB::statement("ALTER TABLE " . self::TABLE_NAME . " ADD COLUMN search_vector tsvector GENERATED ALWAYS AS (to_tsvector('english', name)) STORED");
        DB::statement("CREATE INDEX search_vector_idx ON " . self::TABLE_NAME . " USING GIN (search_vector)");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
};
