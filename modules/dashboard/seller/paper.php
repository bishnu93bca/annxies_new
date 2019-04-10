
<div class="h-box-100">
    <div class="h-heading">Paper</div>

    <div class="h-table">
        <?php echo $eObj->readpaperemail($_SESSION['FUSERID'], 2, 0, 30);?>
    </div>

    <!-- pagination -->
    <div class="row">
        <div class="col-md-12 text-center">
            <nav>
                <ul class="pagination">
                    <?php //echo pagi(3);?>
                </ul>
            </nav>
        </div>
    </div>
</div><!-- col-md-9 -->  