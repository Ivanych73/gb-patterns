<?php

interface AbstractDbConnection
{
    public function getConnection();
}

interface AbstractDbRecord
{
    public function getRecord();
}

interface AbstractDbQueryBuilder
{
    public function getQueryBuilder();
}

class MySqlConnection implements AbstractDbConnection
{
    public function getConnection(){
        return 'It is a new mysql connection';
    }
}

class PostgreConnection implements AbstractDbConnection
{
    public function getConnection(){
        return 'It is a new postgresql connection';
    }
}

class OracleConnection implements AbstractDbConnection
{
    public function getConnection(){
        return 'It is a new oracle connection';
    }
}

class MySqlRecord implements AbstractDbRecord
{
    public function getRecord(){
        return 'It is a new mysql record';
    }
}

class PostgreRecord implements AbstractDbRecord
{
    public function getRecord(){
        return 'It is a new postgresql record';
    }
}

class OracleRecord implements AbstractDbRecord
{
    public function getRecord(){
        return 'It is a new oracle record';
    }
}

class MySqlQueryBuilder implements AbstractDbQueryBuilder
{
    public function getQueryBuilder(){
        return 'It is a new mysql query builder';
    }
}

class PostgreQueryBuilder implements AbstractDbQueryBuilder
{
    public function getQueryBuilder(){
        return 'It is a new postgresql query builder';
    }
}

class OracleQueryBuilder implements AbstractDbQueryBuilder
{
    public function getQueryBuilder(){
        return 'It is a new oracle query builder';
    }
}

abstract class AbstractDbFactory
{
    abstract public function getDbConnection(): AbstractDbConnection;
    abstract public function getDbRecord(): AbstractDbRecord;
    abstract public function getDbQueryBuilder(): AbstractDbQueryBuilder;
}

class MySQLFactory extends AbstractDbFactory
{
    public function getDbConnection(): AbstractDbConnection
    {
        return new MySqlConnection;
    }

    public function getDbRecord(): AbstractDbRecord
    {
        return new MySqlRecord;
    }

    public function getDbQueryBuilder(): AbstractDbQueryBuilder
    {
        return new MySqlQueryBuilder;
    }
}

class PostgreSQLFactory extends AbstractDbFactory
{
    public function getDbConnection(): AbstractDbConnection
    {
        return new PostgreConnection;
    }

    public function getDbRecord(): AbstractDbRecord
    {
        return new PostgreRecord;
    }

    public function getDbQueryBuilder(): AbstractDbQueryBuilder
    {
        return new PostgreQueryBuilder;
    }
}

class OracleFactory extends AbstractDbFactory
{
    public function getDbConnection(): AbstractDbConnection
    {
        return new OracleConnection;
    }

    public function getDbRecord(): AbstractDbRecord
    {
        return new OracleRecord;
    }

    public function getDbQueryBuilder(): AbstractDbQueryBuilder
    {
        return new OracleQueryBuilder;
    }
}

$newOracleSql = New OracleFactory;

echo $newOracleSql->getDbConnection()->getConnection()."<br>";
echo $newOracleSql->getDbRecord()->getRecord()."<br>";
echo $newOracleSql->getDbQueryBuilder()->getQueryBuilder()."<br>";