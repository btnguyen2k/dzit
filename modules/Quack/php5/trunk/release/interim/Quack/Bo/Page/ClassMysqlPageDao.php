<?php
class Quack_Bo_Page_MysqlPageDao extends Quack_Bo_Page_BasePageDao implements
        Ddth_Dao_Mysql_IMysqlDao {

    protected function fetchResultAssoc($rs) {
        return mysql_fetch_array($rs, MYSQL_ASSOC);
    }

    protected function fetchResultArr($rs) {
        return mysql_fetch_array($rs, MYSQL_NUM);
    }
}
