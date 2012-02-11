<?php

class PluginIgnore_HookIgnore extends Hook
{

    public function RegisterHook()
    {
        $this->AddHook('template_profile_whois_item', 'ProfileView', __CLASS__);
    }

    /**
     * Add ignore button to user profile
     * 
     * @param array $aData
     * @return string
     */
    public function ProfileView($aData)
    {
        /* @var $oUserProfile ModuleUser_EntityUser */
        $oUserProfile = $aData['oUserProfile'];
        /* @var $oUserCurrent ModuleUser_EntityUser */
        $oUserCurrent = $this->User_GetUserCurrent();

        if ($oUserCurrent) {
            $aForbidIgnore = $this->User_GetForbidIgnoredUsers();
            if (in_array($oUserProfile->getId(), $aForbidIgnore)) {
                $this->Viewer_Assign('bForbidIgnore', true);
            } else if ($oUserCurrent->getId() != $oUserProfile->getId()) {
                
                $bIgnoredTopics = $this->User_IsUserIgnoredByUser($oUserCurrent->getId(), $oUserProfile->getId(), PluginIgnore_ModuleUser::TYPE_IGNORE_TOPICS);
                $bIgnoredComments = $this->User_IsUserIgnoredByUser($oUserCurrent->getId(), $oUserProfile->getId(), PluginIgnore_ModuleUser::TYPE_IGNORE_COMMENTS);
                
                $aUserBlacklist = $this->Talk_GetBlacklistByUserId($oUserCurrent->getId());
                if (isset($aUserBlacklist[$oUserProfile->getId()])) {
                    $bIgnoredTalk = true;
                } else {
                    $bIgnoredTalk = false;
                }
                $this->Viewer_Assign('bIgnoredTopics', $bIgnoredTopics);
                $this->Viewer_Assign('bIgnoredComments', $bIgnoredComments);
                $this->Viewer_Assign('bIgnoredTalk', $bIgnoredTalk);
            }
            return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__) . 'profile_ignore.tpl');
        }
    }

}

