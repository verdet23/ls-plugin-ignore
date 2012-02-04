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
        $oUserProfile = $aData['oUserProfile'];
        $aForbidIgnore = Config::Get('plugin.ignore.disallow_ignore');
        $oUserCurrent = $this->User_GetUserCurrent();
        if ($oUserCurrent && !in_array($oUserProfile->getId(), $aForbidIgnore) && $oUserCurrent->getId() != $oUserProfile->getId()) {
            $bIsIgnored = $this->User_IsUserIgnoredByUser($oUserCurrent->getId(), $oUserProfile->getId());
            $this->Viewer_Assign('bIsIgnored', $bIsIgnored);
            return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__) . 'profile_ignore.tpl');
        }
    }

}

