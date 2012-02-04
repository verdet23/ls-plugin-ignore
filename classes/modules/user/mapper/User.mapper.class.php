<?php

/**
 * @method oDb DbSimple_Generic_Database 
 */
class PluginIgnore_ModuleUser_MapperUser extends PluginIgnore_Inherit_ModuleUser_MapperUser
{
    
    /**
     * Ignore user
     * 
     * @param string $sUserId
     * @param string $sUserIgnoreId
     * @return boolean
     */
    public function IgnoreUserByUser($sUserId, $sUserIgnoreId)
    {
        $sql = "INSERT INTO
                    " . Config::Get('db.table.user_ignore') . "
                (
                user_id,
                user_ignored_id
                )
		VALUES(?d,  ?d)
                ";
        $this->oDb->query($sql, $sUserId, $sUserIgnoreId);
        
    }
    
    /**
     * Unignore user
     * 
     * @param string $sUserId
     * @param string $sUserIgnoreId
     * @return boolean
     */
    public function UnIgnoreUserByUser($sUserId, $sUserIgnoreId)
    {
        $sql = "DELETE FROM
                    " . Config::Get('db.table.user_ignore') . "
                WHERE 
                    user_id = ?d
                AND    
                    user_ignored_id = ?d
                ";
        return $this->oDb->query($sql, $sUserId, $sUserIgnoreId);
    }
    
    /**
     * Get ignored user ids by user
     * 
     * @param string $sUserId
     * @return array
     */
    public function GetIgnoredUsersByUser($sUserId)
    {
        $sql = "SELECT
                    user_ignored_id
                FROM
                    " . Config::Get('db.table.user_ignore') . "
                WHERE
                    user_id = ?d
                ";
        $aResult = array();
        if ($aRows = $this->oDb->select($sql, $sUserId)) {
            foreach ($aRows as $aRow) {
                $aResult[] = $aRow['user_ignored_id'];
            }
        }
        return $aResult;
    }

}