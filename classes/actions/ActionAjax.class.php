<?php

class PluginIgnore_ActionAjax extends PluginIgnore_Inherit_ActionAjax
{

    protected function RegisterEvent()
    {
        parent::RegisterEvent();

        $this->AddEventPreg('/^ignore$/i', 'EventIgnoreUser');
    }

    protected function EventIgnoreUser()
    {
        if (!$this->oUserCurrent) {
            $this->Message_AddErrorSingle($this->Lang_Get('need_authorization'), $this->Lang_Get('error'));
            return;
        }

        if (!$oUserIgnored = $this->User_GetUserById(getRequest('idUser'))) {
            $this->Message_AddErrorSingle($this->Lang_Get('user_not_found'), $this->Lang_Get('error'));
            return;
        }
        
        $aForbidIgnore = Config::Get('plugin.ignore.disallow_ignore');
        
        if (in_array($oUserIgnored->getId(), $aForbidIgnore)) {
            $this->Message_AddErrorSingle($this->Lang_Get('ignore_dissalow_this'), $this->Lang_Get('error'));
            return;
        } elseif ($oUserIgnored->getId() == $this->oUserCurrent->getId()) {
            $this->Message_AddErrorSingle($this->Lang_Get('ignore_dissalow_own'), $this->Lang_Get('error'));
            return;
        }

        if ($this->User_IsUserIgnoredByUser($this->oUserCurrent->getId(), $oUserIgnored->getId())) {
            if ($this->User_UnIgnoreUserByUser($this->oUserCurrent->getId(), $oUserIgnored->getId())) {
                $this->Message_AddNoticeSingle($this->Lang_Get('disignore_user_ok'), $this->Lang_Get('attention'));
                $this->Viewer_AssignAjax('sText', $this->Lang_Get('ignore_user'));
            } else {
                $this->Message_AddErrorSingle(
                        $this->Lang_Get('system_error'), $this->Lang_Get('error')
                );
            }
        } else {
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

