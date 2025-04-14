<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 10/30/15
 * Time: 10:24 AM
 */
?>
<div class="row">
    <div class="heading"><p class="text6">What We Did In Past</p></div>
    <nav>
        <ul class="yellow">
            <?php $countSection=0; $totalEvent=count($allEventData); for($i=0; $i<$totalEvent; ){ if($i % 4 == 0) {
                if ($i==0) { echo '<section id="section-'.$countSection++.'" class="eventList active">'; } else { echo '<section id="section-'.$countSection++.'" class="eventList">'; }} ?>
                <div class="left">
                    <li>
                        <div class="heading"><p class="text7"><?php echo $allEventData[$i]["EventTitle"]; ?></p></div>
                        <div class="eventthump">
                            <div class="thumbnail">
                                <a href=""><img class="thumbnailimg"  src="<?php if(isset($allEventData[$i]["img"]) && !empty($allEventData[$i]["img"])) {
                                        echo $allEventData[$i]["img"];} else { ?>/assets/images/noimage.png<?php } ?>"
                                                allign="left" alt="<?php echo $allEventData[$i]["EventTitle"]; ?>"></a>
                            </div>
                        </div>
                        <div class="eventdetails">
                            <div class="details" >
                                <p class="text7"><?php echo nl2br(substr($allEventData[$i]["EventDesc"], 0, 120)); ?></p></div>
                            <!--<p><a target="_blank" href="" class="readmore"><img src="/assets/images/03.png" alt=""></a></p>-->
                            <form action="/activities/Details/" method="post"><input type="hidden" name="eventId" value="<?php echo $allEventData[$i++]['id']; ?>" /><button type="submit"  style="background-image: url('/assets/images/03.png')"/> </form>
                        </div>
                    </li>
                </div>
                <?php if($i % 4 == 0) {  echo '</section>'; } } ?>
        </ul>
    </nav>

    <?php if($countSection > 0) { ?>
        <div id="page-selection">
            <ul class="pagination bootpag">
                <li data-lp="1" class="first disabled"><a href="javascript:void(0);"><span aria-hidden="true">←</span></a></li>
                <li data-lp="1" class="prev disabled"><a href="javascript:void(0);">«</a></li>
                <?php for($i=0; $i <= $countSection; $i++){ ?>
                    <li data-lp="<?php echo $i; ?>" class="<?php if($i==0) echo 'active'; else echo ''; ?>"><a href="javascript:void(0);"><?php echo $i; ?></a></li>
                <?php } ?>
                <li data-lp="6" class="next"><a href="javascript:void(0);">»</a></li>
                <li data-lp="50" class="last"><a href="javascript:void(0);"><span aria-hidden="true">→</span></a></li>
            </ul>
        </div>
    <?php } ?>
</div>