<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
class Dzit_Demo_Bo_MysqlSimpleBlogDao extends Ddth_Dao_AbstractConnDao implements Dzit_Demo_Bo_ISimpleBlogDao, Ddth_Dao_Mysql_IMysqlDao {

    const TBL_POST = 'simpleblog_post';
    const COL_POST_ID = 'pid';
    const COL_POST_TITLE = 'ptitle';
    const COL_POST_BODY = 'pbody';
    const COL_POST_CREATED_TIME = 'pcreated';
    const COL_POST_MODIFIED_TIME = 'pmodified';

    /**
     * @see Ddth_Dao_AbstractConnDao::getConnection()
     */
    public function getConnection($startTransaction=FALSE) {
        $conn = parent::getConnection($startTransaction);
        $mysqlConn = $conn->getMysqlConnection();
        mysql_query("SET NAMES 'UTF-8'", $mysqlConn);
        return $conn;
    }

    /**
     * @see Dzit_Demo_Bo_ISimpleBlogDao::getLatestPosts()
     */
    public function getLatestPosts($num) {
        if ($num < 1) {
            $num = 1;
        } else {
            $num += 0;
        }
        $sql = 'SELECT * FROM ' . self::TBL_POST . ' ORDER BY ' . self::COL_POST_CREATED_TIME . " DESC LIMIT $num";
        /**
         * @var Ddth_Dao_Mysql_MysqlConnection
         */
        $conn = $this->getConnection(TRUE);
        $exception = NULL;
        $result = Array();
        try {
            $mysqlConn = $conn->getMysqlConnection();
            $queryResult = mysql_query($sql, $mysqlConn);
            if (!$queryResult) {
                throw new Exception('Error: [' . mysql_errno($mysqlConn) . ']' . mysql_error($mysqlConn) . "\nSQL:\n$sql");
            }
            while (($row = mysql_fetch_assoc($queryResult)) !== FALSE) {
                $post = new Dzit_Demo_Bo_Post();
                $post->setBody($row[self::COL_POST_BODY]);
                $post->setCreatedTime($row[self::COL_POST_CREATED_TIME]);
                $post->setId($row[self::COL_POST_ID]);
                $post->setModifiedTime($row[self::COL_POST_MODIFIED_TIME]);
                $post->setTitle($row[self::COL_POST_TITLE]);
                $result[] = $post;
            }
            mysql_free_result($queryResult);
        } catch (Exception $e) {
            $exception = $e;
        }
        $this->closeConnection($conn, $exception !== NULL);
        if ($exception !== NULL) {
            throw $exception;
        }
        return $result;
    }

    /**
     * @see Dzit_Demo_Bo_ISimpleBlogDao::createPost()
     */
    public function createPost($post) {
        $conn = $this->getConnection(TRUE);
        $exception = NULL;
        try {
            $mysqlConn = $conn->getMysqlConnection();
            $sql = 'INSERT INTO ' . self::TBL_POST . ' (';
            $sql .= self::COL_POST_TITLE . ',';
            $sql .= self::COL_POST_BODY . ',';
            $sql .= self::COL_POST_CREATED_TIME . ') VALUES (';
            $sql .= "'" . mysql_real_escape_string($post->getTitle(), $mysqlConn) . "',";
            $sql .= "'" . mysql_real_escape_string($post->getBody(), $mysqlConn) . "',";
            $sql .= 'NOW())';
            mysql_query($sql, $mysqlConn);
        } catch (Exception $e) {
            $exception = $e;
        }
        $this->closeConnection($conn, $exception !== NULL);
        if ($exception !== NULL) {
            throw $exception;
        }
        $posts = $this->getLatestPosts(1);
        return $posts[0];
    }
}
