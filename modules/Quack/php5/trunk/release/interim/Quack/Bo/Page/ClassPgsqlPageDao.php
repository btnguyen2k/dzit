<?php
class Quack_Bo_Page_PgsqlPageDao extends Quack_Bo_Page_BasePageDao implements
        Ddth_Dao_Pgsql_IPgsqlDao {

    protected function fetchResultAssoc($rs) {
        return pg_fetch_array($rs, NULL, PGSQL_ASSOC);
    }

    protected function fetchResultArr($rs) {
        return pg_fetch_array($rs, NULL, PGSQL_NUM);
    }
}
