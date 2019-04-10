<div class="fav_details">
    <?php 
    $exmData = $eObj->myOnlineExams($_SESSION['FUSERID'], 1, 0, 30);

    if($exmData){
    ?>
    <div class="searchp_list score">
        <table>
            <tr>
                <th></th>
                <th colspan="2">Exam</th>
                <th colspan="2">Time</th>
                <th colspan="2">Answer</th>
                <th colspan="2">Result</th>
            </tr>
            <tr>
                <th>Date</th>
                <th>Course</th>
                <th>Level</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Correct Answer</th>
                <th>Wrong Answer</th>
                <th>Full Marks</th>
                <th>Your Score</th>
            </tr>
            <?php 
            foreach($exmData as $exam){
                ?>
                <tr>
                    <td><?php echo date('d/m/Y', strtotime($exam['startTime']));?></td>
                    <td><?php echo $exam['courseName'];?></td>
                    <td><?php echo $exam['quizLevel'];?></td>
                    
                    <td align="center"><?php echo date('h:i:s A', strtotime($exam['startTime']));?></td>
                    <td align="center"><?php echo date('h:i:s A', strtotime($exam['endTime']));?></td>
                    <td align="center"><?php echo $exam['correctAnswer'];?></td>
                    <td align="center"><?php echo $exam['wrongAnswer'];?></td>
                    <td align="center"><?php echo $exam['totalMarks'];?></td>
                    <td align="center"><?php echo $exam['marksObtained'];?></td>
                </tr>
                <?php
            }
            ?>
        </table>
    </div>
    
    <?php } else echo 'No result found.';?>
</div>