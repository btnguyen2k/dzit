<?php
class Quack_Bo_AppConfig_MysqlAppConfigDao extends Quack_Bo_AppConfig_BaseAppConfigDao implements
        Ddth_Dao_Mysql_IMysqlDao {

    protected function initSqlStatementFactory() {
        $this->setSqlStatementFile('Quack/Bo/AppConfig/sql_appconfig.mysql.properties');
        parent::initSqlStatementFactory();
    }

    protected function fetchResultAssoc($rs) {
        return mysql_fetch_array($rs, MYSQL_ASSOC);
    }

    protected function fetchResultArr($rs) {
        return mysql_fetch_array($rs, MYSQL_NUM);
    }
}
