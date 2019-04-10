<?php
include('../../../../ext_include.php');
$obj = new adminCategory();
$data = $obj -> getCategoryByparentId($catId);
if($data)
{ 
    $mainCategory = $pId;
    if($page=='add'){
        echo '<p class="description-line1">Category</p><p class="description-line1">';
    }
    else
        echo 'Category';
    ?>
    <select name="parentId" id="parentId" style="width:150px;margin-right:10px;">
        <option value="0" data-parent="0">Select</option>
        <?php
        for($i=0; $i<sizeof($data); $i++)
        {
            if($data[$i]['c_id']!=$editid || !$editid)
            {
                if($data[$i]['c_id']==$mainCategory)
                    echo '<option value="'.$data[$i]['c_id'].'" data-parent="'.$data[$i]['parentId'].'" selected>'.$data[$i]['category'].'</option>';
                else
                    echo '<option value="'.$data[$i]['c_id'].'" data-parent="'.$data[$i]['parentId'].'">'.$data[$i]['category'].'</option>';

                $prntId = $data[$i]['c_id'];
                $nbsp = '';
                $selectedId = $parentId;
                $obj->recursiveCategory($prntId, $editid, $nbsp, $selectedId);
            }
        }	
        ?>
    </select>
    <?php 
    if($page=='add')
        echo '</p>';
}
?>