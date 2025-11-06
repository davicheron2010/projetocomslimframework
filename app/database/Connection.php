<?php

namespace App\Database;

use PDO;

class Connection
{
    private static $pdo = null;
    public static function connection(): PDO
    {
        try {
            if (static::$pdo) {
                return static::$pdo;
            }
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,                      #Lança exceções em caso de erros.
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,                 #Define o modo de fetch padrão como array associativo.
                PDO::ATTR_EMULATE_PREPARES => false,                              # Desativa a emulação de prepared statements
                PDO::ATTR_PERSISTENT => true,                                     # Conexão persistente para melhorar perfomace.
                PDO::ATTR_STRINGIFY_FETCHES => false                              # Desativa a conversão de valores numéricos para string.
            ];
            # A função static::$pdo vai criar a conexão com o banco de dados
            statics::$pdo = new PDO(
                'pgsql:host=localhost;port=5432;dbname=integra_development', # Dsn (Data Source Name) para PostgreSQL
                'senac',                                                # Nome de usuário do bando de dados
                'senac',                                                # senha do usuário do banco de dados
                $options                                                 # Opções para a conexão PDO
            );
            statics::$pdo->exec("SET NAMES 'utf8");
            # Caso seja bem-sucedida a conexão retornamos a variável $pdo;
            return static::$pdo;
        } catch (\PDOException $e) {
            throw new \Exception("Erro" . $e->getMessage(), 1);
        }
    }
}
