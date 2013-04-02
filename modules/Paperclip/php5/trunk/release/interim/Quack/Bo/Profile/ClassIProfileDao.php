<?php
interface Quack_Bo_Profile_IProfileDao extends Ddth_Dao_IDao {

    /**
     * Writes profiling data to storage.
     */
    public function writeProfilingData();
}
