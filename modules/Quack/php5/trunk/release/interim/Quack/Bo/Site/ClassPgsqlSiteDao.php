<?php
class Quack_Bo_Site_PgsqlSiteDao extends Quack_Bo_Site_BaseSiteDao implements
        Ddth_Dao_Pgsql_IPgsqlDao {

    protected function fetchResultAssoc($rs) {
        return pg_fetch_array($rs, NULL, PGSQL_ASSOC);
    }

    protected function fetchResultArr($rs) {
        return pg_fetch_array($rs, NULL, PGSQL_NUM);
    }
}
