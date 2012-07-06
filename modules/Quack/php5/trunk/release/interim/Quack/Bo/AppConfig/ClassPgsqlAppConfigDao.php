<?php
class Quack_Bo_AppConfig_PgsqlAppConfigDao extends Quack_Bo_AppConfig_BaseAppConfigDao implements
        Ddth_Dao_Pgsql_IPgsqlDao {

    protected function fetchResultAssoc($rs) {
        return pg_fetch_array($rs, NULL, PGSQL_ASSOC);
    }

    protected function fetchResultArr($rs) {
        return pg_fetch_array($rs, NULL, PGSQL_NUM);
    }
}
