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
        Schema::create('registrotitulos', function (Blueprint $table) {
            $table->increments('idregistro'); // Esto define automáticamente la clave primaria
            $table->string('ciinfper', 20)->nullable();
            $table->char('idcarr', 6)->nullable();
            $table->integer('folio')->nullable();
            $table->string('acta', 50)->nullable();
            $table->integer('numerolibro')->nullable();
            $table->text('detalle')->nullable();
            $table->tinyText('elaborado')->nullable();
            $table->tinyText('impreso')->nullable();
            $table->integer('contadorimpresion')->nullable();
            $table->date('fechaincorporacion')->nullable();
            $table->date('fechainicio')->nullable();
            $table->date('fechafin')->nullable();
            $table->date('fechainvestigacion')->nullable();
            $table->date('fecharefrendacion')->nullable();
            $table->dateTime('fechaelaboracion')->nullable();
            $table->string('requsitograduacion', 45)->nullable();
            $table->string('nombretesis', 45)->nullable();
            $table->string('tituloadmision', 245)->nullable();
            $table->integer('tipocolegio')->nullable();
            $table->string('procedenciatittuloadmision', 45)->nullable();
            $table->string('reconocimientoestudiosprevios', 45)->nullable();
            $table->string('recnocimientoaniosprevios', 45)->nullable();
            $table->string('actadegrado', 45)->nullable();
            $table->string('numeroespecis', 45)->nullable();
            $table->string('idsede', 45)->nullable();
            $table->string('tipodocumento', 45)->nullable();
            $table->string('insttucionestudiosprevios', 45)->nullable();
            $table->string('recnocimneitoestudiosprevios', 45)->nullable();
            $table->string('tipoduracionestudiosprevios', 45)->nullable();
            $table->string('mecanismotitulaion', 45)->nullable();
            $table->string('linktesis', 45)->nullable();
            $table->double('notapromedioacumulado')->nullable();
            $table->double('notatrabajotitulacion')->nullable();
            $table->text('observaciones')->nullable();
            $table->string('carreraestudioeprevios', 45)->nullable();
            $table->string('usuarioreg', 45)->nullable();
            $table->string('usuariomod', 45)->nullable();
            $table->dateTime('fechamod')->nullable();
            
            // Unique keys
            $table->unique(['idcarr', 'acta'], 'ver');
            $table->unique(['ciinfper', 'idcarr'], 'ver2');
            
            // Indexes
            $table->index('ciinfper', 'cedula_idx');
            $table->index('idcarr');
            $table->index('fechaincorporacion', 'fechainc');
            
            // Foreign keys
            $table->foreign('ciinfper')->references('CIInfPer')->on('informacionpersonal')->onDelete('NO ACTION')->onUpdate('CASCADE');
            //$table->foreign('idcarr')->references('idCarr')->on('carrera')->onDelete('NO ACTION')->onUpdate('CASCADE');
            
            // Timestamps
            $table->timestamps(); // Esto incluye los campos created_at y updated_at
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrotitulos');
    }
};
