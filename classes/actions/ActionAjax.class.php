<?php

class PluginIgnore_ActionAjax extends PluginIgnore_Inherit_ActionAjax
{

    protected function RegisterEvent()
    {
        parent::RegisterEvent();

        $this->AddEventPreg('/^ignore$/i', 'EventIgnoreUser');
    }

    /**
     * Ignore|disignore user
     */
    protected function EventIgnoreUser()
    {
        // check auth
        if (!$this->oUserCurrent) {
            $this->Message_AddErrorSingle($this->Lang_Get('need_authorization'), $this->Lang_Get('error'));
            return;
        }

        // search for ignored user
        if (!$oUserIgnored = $this->User_GetUserById(getRequest('idUser'))) {
            $this->Message_AddErrorSingle($this->Lang_Get('user_not_found'), $this->Lang_Get('error'));
            return;
        }
        
        // is user try to ignore self @maybe allow?
        if ($oUserIgnored->getId() == $this->oUserCurrent->getId()) {
            $this->Message_AddErrorSingle($this->Lang_Get('ignore_dissalow_own'), $this->Lang_Get('error'));
            return;
        }

        if ($this->User_IsUserIgnoredByUser($this->oUserCurrent->getId(), $oUserIgnored->getId())) {
            // remove user from ignore list
            if ($this->User_UnIgnoreUserByUser($this->oUserCurrent->getId(), $oUserIgnored->getId())) {
                $this->Message_AddNoticeSingle($this->Lang_Get('disignore_user_ok'), $this->Lang_Get('attention'));
                $this->Viewer_AssignAjax('sText', $this->Lang_Get('ignore_user'));
            } else {
                $this->Message_AddErrorSingle(
                        $this->Lang_Get('system_error'), $this->Lang_Get('error')
                );
            }
        } else {
            $aForbidIgnore = Config::Get('plugin.ignore.disallow_ignore');
            //check ignored user in forbid ignored list
            if (in_array($oUserIgnored->getId(), $aForbidIgnore)) {
                $this->Message_AddErrorSingle($this->Lang_Get('ignore_dissalow_this'), $this->Lang_Get('error'));
                return;
            }
            
            //add user to ignore list
            if ($this->User_IgnoreUserByUser($this->oUserCurrent->getId(), $oUserIgnored->getId())) {
                $this->Message_AddNoticeSingle($this->Lang_Get('ignore_user_ok'), $this->Lang_Get('attention'));
                $this->Viewer_AssignAjax('sText', $this->Lang_Get('disignore_user'));
            } else {
                $this->Message_AddErrorSingle(
                        $this->Lang_Get('system_error'), $this->Lang_Get('error')
                );
            }
        }
    }

}

