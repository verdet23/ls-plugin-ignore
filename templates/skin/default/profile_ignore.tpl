<a id="ignore_user" href="#" onclick="ignoreUser({$oUserProfile->getId()}, this); return false;">{if $bIsIgnored}{$aLang.disignore_user}{else}{$aLang.ignore_user}{/if}</a>
{literal}
<script>
    function ignoreUser(idUser, a) {
        ls.ajax(aRouter['ajax']+'ignore', {idUser: idUser}, function(result){
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
