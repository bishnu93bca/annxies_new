<div class="post_form">
    <div class="sp_box inq_box clearfix">	
        <div class="subheading">
            Create  A New Group
        </div>
    </div>
    <form id="ngpfrm" method="post" action="">
        <ul class="clearfix">
            <li>
                <div class="group_img" style="background-image: url(<?php echo $STYLE_FILES_SRC.'/images/noimage.png'; ?>);">
                    
                    <a href="javascript:void(0);" class="img_browse"><i class="fa fa-camera"></i></a>
                </div>
                <div class="group_info">
                    <div class="input_field">
                        <span class="plabel">Group</span>
                        <div class="pf_right">
                            <input type="text" autocomplete="off" name="groupName" placeholder="Group Name" value="">
                        </div>
                    </div>
                    <div class="input_field">
                        <span class="plabel">About Group</span>
                        <div class="pf_right">
                            <textarea placeholder="Describe something about this group..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
            </li>
            <li>
                <div class="side_add">
                    
                </div>
                <div class="group_info">
                    <div class="input_field">
                        <span class="plabel">Group Member</span>
                        <div class="pf_right autosuggest">
                            <input type="text" autocomplete="off" id="srchmem" name="srchtxt" placeholder="Add to Group " value="">
                            <div class="selmem"></div>
                            <div class="autopop"></div>
                            <input type="hidden" name="ActType" value="SearchAnyFrn">
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
            </li>
        </ul>
        <div class="btn_pr">
            <button type="submit" class="btn">
                Save
            </button>

            <input type="hidden" class="sf" name="SourceForm" value="">
            <input type="hidden" name="ajax" value="1">
            <input type="hidden" class="ppl" name="people" value="">
        </div>
    </form>
</div>