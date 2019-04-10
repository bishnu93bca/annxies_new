
<div class="h-box-100">
    <div class="h-heading">Email</div>


    <!-- table -->
    <div class="h-table">
       <?php echo $eObj->reademail($_SESSION['FUSERID'], 2, 0, 30);?>
    </div><!-- end row --> 
    <!-- end table -->

    <!-- pagination -->
    <div class="row">
        <div class="col-md-12 text-center">
            <nav>
                <ul class="pagination">
                    <?php //echo pagi(2);?>
                </ul>
            </nav>
        </div>
    </div><!-- end row -->
    <!-- end pagination -->

</div><!-- col-md-9 -->   