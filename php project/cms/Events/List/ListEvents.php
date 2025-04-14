<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 10/9/15
 * Time: 11:09 AM
 */
?>
<div id="content">
    <?php if (count($allEventData) <=0) { ?>
        <p>Sorry! No Activities happened yet.</p>
        <?php  }
$countEvent =0; $countRow=0; $countSection=0; while($countEvent < count($allEventData)) {
    if($countRow %3 == 0) { if($countSection == 0) echo '<section id="section-'.$countSection++.'" class="active">'; else  echo '<section id="section-'.$countSection++.'" class="">';  }
    if ($countEvent == ($countRow++ * 3 )) { ?>
        <div class="row"> <?php
            while($countEvent < $countRow* 3) {
                if($countEvent >= count($allEventData)) { break; }
                ?>
                <div class="col-xs-6">
                    <div class="thumbnail">
                        <img src="<?php if(isset($allEventData[$countEvent]["img"]) && !empty($allEventData[$countEvent]["img"])) {
                            echo $allEventData[$countEvent]["img"];} else { ?>/assets/images/noimage.png<?php } ?>"
                             alt="Generic placeholder thumbnail">
                    </div>
                    <div class="caption">
                        <b><?php echo $allEventData[$countEvent]["EventTitle"]; ?></b>
                        <p> <form action="/Events/Details/" method="post" enctype="application/x-www-form-urlencoded">
                            <input type="hidden" name="eventId" value="<?php echo $allEventData[$countEvent]["id"]; ?>" />
                            <input type="submit" name="LearnMore" class="btn btn-primary" value="Learn More" />
                        </form></p>
                    </div>
                </div>
                <?php  $countEvent++;  } ?>
        </div>

        <?php  if($countRow %3 == 0)  echo '</section>'; } }   ?>
</div>
<?php if($countSection > 0) { ?>
    <div id="page-selection">
        <ul class="pagination bootpag">
            <li data-lp="1" class="first disabled"><a href="javascript:void(0);"><span aria-hidden="true">←</span></a></li>
            <li data-lp="1" class="prev disabled"><a href="javascript:void(0);">«</a></li>
            <?php for($i=1; $i <= $countSection; $i++){ ?>
                <li data-lp="<?php echo $i; ?>" class="<?php if($i==1) echo 'active'; else echo ''; ?>"><a href="javascript:void(0);"><?php echo $i; ?></a></li>
            <?php } ?>
            <li data-lp="6" class="next"><a href="javascript:void(0);">»</a></li>
            <li data-lp="50" class="last"><a href="javascript:void(0);"><span aria-hidden="true">→</span></a></li>
        </ul>
    </div>
<?php } ?>

