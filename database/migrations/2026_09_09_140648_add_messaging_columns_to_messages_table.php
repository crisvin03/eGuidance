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
        Schema::table('messages', function (Blueprint $table) {
            if (!Schema::hasColumn('messages', 'conversation_id')) {
                $table->foreignId('conversation_id')->after('id')->constrained()->onDelete('cascade');
            }
            if (!Schema::hasColumn('messages', 'sender_id')) {
                $table->foreignId('sender_id')->after('conversation_id')->constrained('users')->onDelete('cascade');
            }
            if (!Schema::hasColumn('messages', 'message')) {
                $table->text('message')->after('sender_id');
            }
            if (!Schema::hasColumn('messages', 'attachment')) {
                $table->string('attachment')->nullable()->after('message');
            }
            if (!Schema::hasColumn('messages', 'read_at')) {
                $table->timestamp('read_at')->nullable()->after('attachment');
            }
        });
        
        // Add indexes
        Schema::table('messages', function (Blueprint $table) {
            if (!Schema::hasIndex('messages', 'messages_conversation_id_index')) {
                $table->index('conversation_id');
            }
            if (!Schema::hasIndex('messages', 'messages_sender_id_index')) {
                $table->index('sender_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign(['conversation_id']);
            $table->dropForeign(['sender_id']);
            $table->dropIndex(['conversation_id']);
            $table->dropIndex(['sender_id']);
            $table->dropColumn(['conversation_id', 'sender_id', 'message', 'attachment', 'read_at']);
        });
    }
};
