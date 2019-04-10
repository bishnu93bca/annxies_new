<script language="javascript">
function addRow(tableID) {
	var table = document.getElementById(tableID);
	var rowCount = table.rows.length;
	var row = table.insertRow(rowCount);
	var colCount = table.rows[0].cells.length;
	
	for(var i=0; i<colCount; i++) {
		var newcell = row.insertCell(i);
		newcell.innerHTML = table.rows[1].cells[i].innerHTML;		
	}
}
function deleteRow(tableID) {
	try {
        var table = document.getElementById(tableID);
        var rowCount = table.rows.length; 
        for(var i=0; i<rowCount; i++) {
            var row = table.rows[i];
            var chkbox = row.cells[0].childNodes[0];
            if(null != chkbox && true == chkbox.checked) {
                if(rowCount <= 1) {
                    alert("Cannot delete all the rows.");
                    break;
                }
                table.deleteRow(i);
                rowCount--;
                i--;
            }
        }
	} catch(e) {
		alert(e);
	}
}
$(function(){
	$('.attributetype').live('change', function(){
		var attributeType = $(this).val();
		if(attributeType=='radio' || attributeType=='checkbox')
		{
			$(this).next('.options').css('display','inline');
			$(this).next('.options').children(".default").remove();
			var rowNum = ($(this).closest('tr').index()-1);
			$(this).next('.options').html('<input type="text" name="attributeOptions['+rowNum+'][]" class="default" placeholder="Options" style="width:80px; margin-right:10px;" /><div class="option_controls"><a href="#" class="addoption">add new</a></div>');
		}
		else
			$(this).next('.options').css('display','none');
	});
	$('.addoption').live('click', function(e){
		e.preventDefault();
		var addoption = $(this);
		var rowNum = (addoption.closest('tr').index()-1);
		addoption.parent().before('<span class="default"><input type="text" name="attributeOptions['+rowNum+'][]" placeholder="Options" style="width:80px;" /><a href="#" class="removeoption">X</a> </span> ');
		
	});
	$('.removeoption').live('click', function(e){
		e.preventDefault();
		$(this).parent().remove();
	});	
});
</script>
<?php
$obj = new adminCategory();
if($c_id)
    $attributeData =  $obj->getAttributeByCategoryId(1, $c_id, 0, 999);
?>
<div class="form_holder">
    <table id="dataSizeTable" class="product" width="100%">        	
        <tr>
            <th style="width:25px;"></th>
            <th style="width:80px;">Attribute</th>
            <th align="left">Type</th>
            
        </tr>
        <?php 
        if(sizeof($attributeData)>0)
        {
            for($at=0;$at<sizeof($attributeData);$at++)
            {
                ?>
                <tr class="rowcount">
                    <td><input type="checkbox" name="chk"/>&nbsp;</td>
                    <td style="text-align:center;">
                        <input type="text" name="attributeNameArray[]" value="<?php echo $attributeData[$at]['attributeName'];?>"  maxlength="100" style="width:100px;" />
                        <input type="hidden" name="attributeIdArray[]" value="<?php echo $attributeData[$at]['attributeId'];?>" />
                    </td>
                    <td align="left">
                        <select name="attributeType[]" style="width:120px;" class="attributetype">
                            <option value="">--select--</option>
                            <option value="text" <?php if($attributeData[$at]['attributeType']=='text') echo 'selected';?>>Textfield</option>
                            <option value="radio" <?php if($attributeData[$at]['attributeType']=='radio') echo 'selected';?>>Radio Button</option>
                            <option value="checkbox" <?php if($attributeData[$at]['attributeType']=='checkbox') echo 'selected';?>>Checkbox</option>
                        </select>
                        <?php
                        if($attributeData[$at]['attributeOptions']!='')
                        {
                            $options = explode('@#@', $attributeData[$at]['attributeOptions']);
                            $style = 'style="display:inline"';
                        }
                        else
                            $style = 'style="display:none"';
                        ?>
                        <div class="options" <?php echo $style;?>>

                            <?php
                            if($attributeData[$at]['attributeOptions']!=''){
                                foreach($options as $val)
                                {
                                    if($val)
                                    {
                                        ?>
                                        <span class="default"><input type="text" name="attributeOptions[<?php echo $at;?>][]" value="<?php echo $val;?>" placeholder="Options" style="width:80px;" /><a href="#" class="removeoption">X</a> </span>
                                        <?php
                                    }
                                }
                            }
                            else
                            {
                                ?>
                                <input type="text" name="attributeOptions[<?php echo $at;?>][]" class="default" placeholder="Options" style="width:80px;" />
                                <?php	
                            }
                            ?>
                            <div class="option_controls">
                                <a href="#" class="addoption">add new</a>
                            </div>
                        </div>
                    </td>
                    
                </tr>
                <?php 
            }
        }
        else
        {
            ?>  
            <tr class="rowcount">
                <td><input type="checkbox" name="chk"/>&nbsp;</td>
                <td style="text-align:center;">
                <input type="text" name="attributeNameArray[]" value=""  maxlength="100" style="width:100px;" /></td>
                <td align="left">
                    <select name="attributeType[]" style="width:120px;" class="attributetype">
                        <option value="">--select--</option>
                        <option value="text">Textfield</option>
                        <option value="radio">Radio Button</option>
                        <option value="checkbox">Checkbox</option>
                    </select>
                    <div class="options">
                        <input type="text" name="attributeOptions[0][]" class="default" placeholder="Options" style="width:80px;" />
                        <div class="option_controls">
                            <a href="#" class="addoption">add new</a>
                        </div>
                    </div>
                </td>
                
            </tr> 
            <?php
        }
        ?>
    </table>
    <a href="javascript:void(0)" onclick="addRow('dataSizeTable')">Add Value</a> | 
    <a href="javascript:void(0)" onclick="deleteRow('dataSizeTable')">Delete Value (Tick checkbox to delete)</a>            
</div>    