<?php
// PATH.../database/migrations/....php

// ============MIGRATION=COMANDOS=======================
// // criar a migration simples
// php artisan make:migration nome_migracao
//
// // criar a migration com campos prontos
// php artisan make:migration criar_tabela_usuario --create=usuario
// //OU
// php artisan make:migration criar_tabela_usuario --table=usuario
//
// // criar as tabelas no banco de dados
// php artisan migrate
//
// // reverter migracao
// php artisan migrate:rollback
//
// // reverter todas as migrações
// php artisan migrate:reset
//
// // reverter todas migrações e depois recriar todas tabelas
// php artisan migrate:refresh
//
// // removerá todas as tabelas e depois recria as migrações
// php artisan migrate:fresh

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriarTabelaUsuario extends Migration
{

    // Run the migrations.
    public function up()
    {
      // VERIFICACOES
      // if (Schema::hasTable('users')) {/*verificar se a tabela exist*/}
      // if (Schema::hasColumn('users', 'email')) {/*verifivar se tabelas tem*/}
      // Schema::rename($from, $to); // renomear tabela


        Schema::create('usuario', function (Blueprint $table) {

          // MODIFICADORES TABELA
          $table->engine = 'InnoDB';
          $table->charset = 'utf8';
          $table->collation = 'utf8_unicode_ci';
          // $table->temporary(); Crie tabela temporária (exceto o SQL Server).
          // $table->charset('utf8') // conjunto de caracteres (MySQL)
          // $table->collation('utf8_unicode_ci') // (MySQL / PostgreSQL / SQL Server)
          // $table->primary('id'); // Adiciona uma chave primária.
          // $table->primary(['id', 'parent_id']); // Adiciona chaves compostas.
          // $table->unique('email'); // Adiciona um índice exclusivo.
          // $table->index('state'); // Adiciona um índice simples.

           // // REFERENCIA CHAVE ESTRANJEIRA
           // $table->foreign('este_id')->references('outro_id')->on('outro_tabela');

           // // DELETE EM CASCATA
           // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

          // MODIFICADORES COLUNAS
          // ->default($value); // Especifique um valor "padrão"
          // ->nullable($value = true) // Permite valores NULL
          // ->unsigned() // Definir colunas INTEGER como UNSIGNED (MySQL)
          // ->useCurrent() // Defina  TIMESTAMP como CURRENT_TIMESTAMP
          // ->autoIncrement() // AUTO-INCREMENTING PRIMARY KEY
          // ->unique(); // UNIQUE

          $table->bigIncrements('id1'); // UNSIGNED BIGINT AUTO-INCREMENTING PRIMARY KEY
          $table->bigInteger('bigInteger'); // BIGINT
          $table->unsignedBigInteger('unsignedBigInteger'); // UNSIGNED BIGINT

          $table->increments('id2'); // UNSIGNED INTEGER AUTO-INCREMENTING PRIMARY KEY
          $table->integer('integer'); // INTEGER
          $table->unsignedInteger('unsignedInteger'); // UNSIGNED INTEGER

          $table->mediumIncrements('id3'); // UNSIGNED MEDIUMINT  AUTO-INCREMENTING PRIMARY KEY
          $table->mediumInteger('mediumInteger'); // MEDIUMINT
          $table->unsignedMediumInteger('unsignedMediumInteger'); // UNSIGNED MEDIUMINT

          $table->smallIncrements('id4'); // UNSIGNED SMALLINT AUTO-INCREMENTING PRIMARY KEY
          $table->smallInteger('smallInteger'); // SMALLINT
          $table->unsignedSmallInteger('unsignedSmallInteger'); // UNSIGNED SMALLINT

          $table->tinyIncrements('id5'); // TINYINT AUTO-INCREMENTING PRIMARY KEY
          $table->tinyInteger('tinyInteger'); // TINYINT
          $table->unsignedTinyInteger('unsignedTinyInteger'); // TINYINT

          $table->decimal('decimal', 8, 2); // DECIMAL
          $table->unsignedDecimal('unsignedDecimal', 8, 2); // UNSIGNED DECIMAL
          $table->double('double', 8, 2); // DECIMAL EQUIVALENT DOUBLE
          $table->float('float', 8, 2); // DECIMAL EQUIVALENT FLOAT

          $table->binary('BLOB'); // BLOB
          $table->boolean('BOOLEAN'); // BOOLEAN
          $table->char('CHAR', 100); // CHAR
          $table->string('VARCHAR', 100); // VARCHAR
          $table->text('TEXT'); // TEXT
          $table->mediumText('MEDIUMTEXT'); // MEDIUMTEXT
          $table->longText('LONGTEXT'); // LONGTEXT
          $table->lineString('LINESTRING'); // LINESTRING
          $table->multiLineString('MULTILINESTRING'); // MULTILINESTRING
          $table->enum('ENUM', ['ITEM1', 'ITEM2']); // ENUM
          $table->set('SET', ['ITEM1', 'ITEM2']);	//  SET

          $table->year('year'); // YEAR = ANO
          $table->date('date'); // DATE
          $table->time('time'); // TIME
          $table->timeTz('timeTz'); // TIME TIMEZONE
          $table->dateTime('dateTime'); // DATETIME
          $table->dateTimeTz('created_at_tz'); // DATETIME TIMEZONE
          $table->timestamp('timestamp'); // TIMESTAMP
          $table->timestampTz('timestampTz'); // TIMESTAMP TIMEZONE
          $table->timestamps(); // TIMESTAMP NULLABLE AS CREATED_AT AND UPDATED_AT
          $table->timestampsTz(); // TIMESTAMP TIMEZONE NULLABLE AS CREATED_AT AND UPDATED_AT
          $table->softDeletes(); // TIMESTAMP AS DELETED_AT
          $table->softDeletesTz(); // TIMESTAMP TIMEZONE AS DELETED_AT

          $table->ipAddress('ipAddress'); // IP address
          $table->macAddress('macAddress'); // MAC address

          $table->json('json'); // JSON
          $table->jsonb('jsonb'); // JSONB
          $table->rememberToken(); // VARCHAR(100) NULLABLE



          // DROP
           // $table->dropColumn('votes'); // DROP COLUNA
           // $table->dropColumn(['votes', 'avatar', 'location']); // DROP COLUNAS
           // $table->dropRememberToken();
           // $table->dropSoftDeletes();
           // $table->dropSoftDeletesTz();
           // $table->dropTimestamps();
           // $table->dropTimestampsTz();
           // $table->dropPrimary('users_id_primary');
           // $table->dropUnique('users_email_unique');
           // $table->dropIndex('geo_state_index');
           // $table->dropSpatialIndex('geo_location_spatialindex');
           // $table->dropForeign(['user_id']);

           // //  ATIVAR OU DESATIVAR AS RESTRIÇÕES DE CHAVE ESTRANGEIRA
           // Schema::enableForeignKeyConstraints();
           // Schema::disableForeignKeyConstraints();

        });

    }

    // Reverse the migrations.
    public function down()
    {
        Schema::dropIfExists('usuario');
    }
}
