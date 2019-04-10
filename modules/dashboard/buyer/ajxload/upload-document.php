<div class="form_wrap">
    <form action="" method="post" id="uplddc" enctype="multipart/form-data">
        <div class="information">Fields marked with <span class="red">*</span> are mandatory.</div>
        <ul class="clearfix">
            <li>
                <label>Department <span class="red">*</span></label>
                <?php 
                $sbObj    = new SubjectAdmin();
                $deptData = $sbObj-> getDepartmentList(1, 0, 99999);
                ?>
                <select name="docDept" id="docDept" required="required">
                    <option hidden>Select department type</option>
                    <?php foreach($deptData as $dept){
                        echo '<option value="'.$dept['id'].'">'.$dept['deptName'].'</option>';
                    }
                    ?>                    
                </select>
            </li>
            <li class="courseList"></li>
            <li class="degreeList"></li>
            <li class="srchSub"></li>
            <li>
                <label>Document Name <span class="red">*</span></label>
                <input type="text" required name="doc" placeholder="" />
                <div class="help_text">Write a document name</div>
            </li>
            <li>
                <label>Document Type <span class="red">*</span></label>
                <select name="docType" required="required">
                    <option hidden>Select document type</option>
                    <?php foreach($docCategoryArray as $docType){
                        echo '<option value="'.$docType.'">'.$docType.'</option>';
                    }
                    ?>                    
                </select>
            </li>
            <li>
                <label>Class / Semester</label>
                <input type="text" name="docClass" value="" placeholder="">
                <div class="help_text">Ex. B. Com. 1st Year</div>
            </li>
            <li>
                <label>Year </label>
                <select name="docYear">
                    <?php
                    for($docYear = 2005; $docYear<=(date('Y')+3); $docYear++) {
                        if($docYear==date('Y'))
                            echo '<option value="'.$docYear.'" selected>'.$docYear.'</option>';
                        else
                            echo '<option value="'.$docYear.'">'.$docYear.'</option>';
                    }
                    ?>
                </select>
            </li>
            <li>
                <label>College </label>
                <input type="text" name="docCollege" value="" placeholder="">
                <div class="help_text">Ex. Shri Ram College of Commerce</div>
            </li>
            
            <li>
                <label>Upload Document <span class="red">*</span></label>
                <div class="file_upload">
                    <label class="inputfile">
                        <em>Choose file</em>
                        <input type="file" class="file" accept=
".doc, .docx" name="docFile" style="display: none;">
                    </label>
                    <input type="text" readonly="" placeholder="No file choosen">
                </div>
                <div class="form_right">
                    <div class="help_text lr">(Your file size should be 2 MB Max. Upload .doc or .docx only)</div>
                </div>
            </li>
            
            <li>
                <label>Snippet <span class="red">*</span></label>
                <textarea name="docSnippet" placeholder="Please write a short description about the document..."></textarea>
            </li>
            
            <li>
                <div class="form_right">
                    <label class="checkbox">
                        <input type="checkbox" name="terms" /><em></em>
                        <span>I accept the <a href="<?php echo $SITE_LOC_PATH.'/terms-conditions/';?>" target="_blank">Terms and Conditions</a></span>
                    </label>
                </div>
            </li>
            <li>
                <div class="form_right">
                    <button type="submit" class="btn btn_orange upldsbmt"><i class="fa fa-floppy-o"></i> Save</button>
                </div>
            </li>
        </ul>
        <input type="hidden" name="ajax" value="1">
        <input type="hidden" name="SourceForm" value="UDoc">
    </form>
</div>