<?php

class PluginIgnore_ModuleComment_EntityComment extends PluginIgnore_Inherit_ModuleComment_EntityComment
{

    public function isBad()
    {
        
        if ($this->User_IsAuthorization() && Config::Get('plugin.ignore.comments')) {
            $oUserCurrent = $this->User_GetUserCurrent();
            $aIgnoredUser = $this->User_GetIgnoredUsersByUser($oUserCurrent->getId());
            if (in_array($this->getUserId(), $aIgnoredUser)) {
                return true;
            }
        }
        return parent::isBad();
    }

}