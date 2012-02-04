<?php

/**
 * @method oMapper ModuleUser_Mapper_User 
 */
class PluginIgnore_ModuleUser extends PluginIgnore_Inherit_ModuleUser
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
        $this->Cache_Delete("user_ignore_{$sUserId}");
        $this->Cache_Clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG,array('topic_update',"topic_update_user_{$sUserIgnoreId}"));
        if ($this->oMapper->IgnoreUserByUser($sUserId, $sUserIgnoreId) === false) {
            return false;
        }
        return true;
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
        $this->Cache_Delete("user_ignore_{$sUserId}");
        $this->Cache_Clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG,array('topic_update',"topic_update_user_{$sUserIgnoreId}"));
        return $this->oMapper->UnIgnoreUserByUser($sUserId, $sUserIgnoreId);
    }
    
    /**
     * Is user ignore user
     * 
     * @param type $sUserId
     * @param type $sUserIgnoredId
     * @return type 
     */
    public function IsUserIgnoredByUser($sUserId, $sUserIgnoredId)
    {
        $aIgnored = $this->GetIgnoredUsersByUser($sUserId);
        return in_array($sUserIgnoredId, $aIgnored);
    }

    /**
     * Get ignored user ids by user
     * 
     * @param string $sUserId
     * @return array
     */
    public function GetIgnoredUsersByUser($sUserId)
    {
        if (false === ($data = $this->Cache_Get("user_ignore_{$sUserId}"))) {
            if ($data = $this->oMapper->GetIgnoredUsersByUser($sUserId)) {
                $this->Cache_Set($data, "user_ignore_{$sUserId}", array(), 60 * 60 * 24 * 1);
            }
        }
        return $data;
    }

}
