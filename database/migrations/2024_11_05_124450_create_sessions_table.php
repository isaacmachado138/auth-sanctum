<?php 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionsTable extends Migration
{
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->unique(); // ID da sessão
            $table->text('payload'); // Dados da sessão
            $table->integer('last_activity')->index(); // Timestamp da última atividade
            $table->string('user_id')->nullable(); // ID do usuário (se aplicável)
            $table->string('ip_address')->nullable(); // Endereço IP do usuário
            $table->string('user_agent')->nullable(); // User agent do navegador
        });
    }

    public function down()
    {
        Schema::dropIfExists('sessions'); // Remove a tabela ao reverter a migration
    }
}
