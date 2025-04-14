<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 10/9/15
 * Time: 11:09 AM
 */

  $countEvent =0; $countRow=0; $countSection=0; while($countEvent < count($allEventData)) {
    if($countRow %3 == 0) echo '<section id="section-'.$countSection++.'">';
    if ($countEvent == ($countRow++ * 2 )) { ?>
        <div class="row"> <?php
            while($countEvent < $countRow* 2) {
                if($countEvent >= count($allEventData)) { break; }
                ?>
                <div class="col-sm-6 col-md-3">
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

    <?php  if($countRow %3 == 0)  echo '</section>'; } }  ?>

