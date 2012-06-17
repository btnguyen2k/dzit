<?php
abstract class Quack_Bo_Profile_BaseProfileDao extends Quack_Bo_BaseDao implements
        Quack_Bo_Profile_IProfileDao {

    /**
     *
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;

    public function __construct() {
        $this->LOGGER = Ddth_Commons_Logging_LogFactory::getLog(__CLASS__);
        parent::__construct();
    }

    /**
     * (non-PHPdoc)
     *
     * @see Quack_Bo_Profile_IProfileDao::writeProfilingData()
     */
    public function writeProfilingData() {
        $entryList = Quack_Util_ProfileUtils::get();
        $id = Quack_Util_IdUtils::id64bin(rand(1, time()));
        $url = $_SERVER['REQUEST_URI'];
        $duration = 0;
        foreach ($entryList as $entry) {
            $duration += $entry[Quack_Util_ProfileUtils::KEY_DURATION];
        }
        // pre-open a connection so that subsequence operations will reuse it
        $conn = $this->getConnection(TRUE);

        $params = Array('profileId' => $id,
                'profileUrl' => $url,
                'profileDuration' => (float)$duration);
        $stm = $this->getSqlStatement('sql.' . __FUNCTION__);
        $this->execNonSelect($stm, $params);

        foreach ($entryList as $entry) {
            $this->writeProfilingDataDetail($id, NULL, $entry);
        }

        $this->closeConnection();
    }

    private function writeProfilingDataDetail($id, $parentId, $entry) {
        $idDetail = Quack_Util_IdUtils::id64bin(rand(1, time()));
        $name = isset($entry[Quack_Util_ProfileUtils::KEY_NAME]) ? $entry[Quack_Util_ProfileUtils::KEY_NAME] : '';
        $duration = isset($entry[Quack_Util_ProfileUtils::KEY_DURATION]) ? $entry[Quack_Util_ProfileUtils::KEY_DURATION] : 0.0;
        $params = Array('profileId' => $id,
                'profileDetailId' => $idDetail,
                'profileDetailParentId' => $parentId,
                'profileDetailName' => $name,
                'profileDetailDuration' => (float)$duration);
        $stm = $this->getSqlStatement('sql.' . __FUNCTION__);
        $this->execNonSelect($stm, $params);

        $children = is_array($entry[Quack_Util_ProfileUtils::KEY_CHILDREN]) ? $entry[Quack_Util_ProfileUtils::KEY_CHILDREN] : Array();
        foreach ($children as $child) {
            $this->writeProfilingDataDetail($id, $idDetail, $child);
        }
    }
}
