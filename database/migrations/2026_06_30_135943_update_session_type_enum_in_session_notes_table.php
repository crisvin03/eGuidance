<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Step 1: Expand the ENUM first to include both old AND new values
        DB::statement("ALTER TABLE session_notes MODIFY COLUMN session_type ENUM(
            'initial',
            'individual',
            'group',
            'crisis',
            'follow_up',
            'assessment',
            'referral'
        ) NOT NULL DEFAULT 'individual'");

        // Step 2: Now safely migrate old 'initial' values to 'individual'
        DB::table('session_notes')->where('session_type', 'initial')->update(['session_type' => 'individual']);

        // Step 3: Remove 'initial' from the ENUM (final clean state)
        DB::statement("ALTER TABLE session_notes MODIFY COLUMN session_type ENUM(
            'individual',
            'group',
            'crisis',
            'follow_up',
            'assessment',
            'referral'
        ) NOT NULL DEFAULT 'individual'");
    }

    public function down(): void
    {
        // Revert to original enum values (map individual back to initial)
        DB::table('session_notes')->where('session_type', 'individual')->update(['session_type' => 'initial']);

        DB::statement("ALTER TABLE session_notes MODIFY COLUMN session_type ENUM(
            'initial',
            'follow_up',
            'crisis',
            'group'
        ) NOT NULL DEFAULT 'initial'");
    }
};
