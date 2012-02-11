{if $oUserCurrent->isAdministrator()}
    <a href="#" onclick="forbidIgnoreUser({$oUserProfile->getId()}, this); return false;">{if $bForbidIgnore}{$aLang.allow_ignore_user}{else}{$aLang.forbid_ignore_user}{/if}</a><br/>
{/if}

{if $oUserCurrent->getId() != $oUserProfile->getId() && !$bForbidIgnore}
    <a href="#" onclick="ignoreUser({$oUserProfile->getId()}, 'topics',this); return false;">{if $bIgnoredTopics}{$aLang.disignore_user_topics}{else}{$aLang.ignore_user_topics}{/if}</a><br/>
    <a href="#" onclick="ignoreUser({$oUserProfile->getId()}, 'comments',this); return false;">{if $bIgnoredComments}{$aLang.disignore_user_comments}{else}{$aLang.ignore_user_comments}{/if}</a><br/>
{/if}    

{literal}
<script>
    function forbidIgnoreUser(idUser, a) {
        ls.ajax(aRouter['ajax']+'forbid-ignore', {idUser: idUser}, function(result){
            if (!result) {
                ls.msg.error('Error','Please try again later');
            }
            if (result.bStateError) {
                ls.msg.error(result.sMsgTitle,result.sMsg);
            } else {
                jQuery(a).html(result.sText);
                ls.msg.notice(result.sMsgTitle,result.sMsg);
            }
        });
    }
    function ignoreUser(idUser, type, a) {
        ls.ajax(aRouter['ajax']+'ignore', {idUser: idUser, type:type}, function(result){
            if (!result) {
                ls.msg.error('Error','Please try again later');
            }
            if (result.bStateError) {
                ls.msg.error(result.sMsgTitle,result.sMsg);
            } else {
                jQuery(a).html(result.sText);
                ls.msg.notice(result.sMsgTitle,result.sMsg);
            }
        });
    }
</script>
{/literal}
