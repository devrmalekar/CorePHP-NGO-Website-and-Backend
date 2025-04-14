<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 10/14/15
 * Time: 1:09 PM
 */
?>
<div class="volunter">
            <p class="text6">Fill The Form For Volunteer</p><br />
            <div id="envelope">
                <form action="/GetInvolved/Volunter/index.php" method="post" enctype="application/x-www-form-urlencoded">
                    <label>First Name</label>
                    <input name="fname" placeholder="Your Name" type="text" width="50px;">
                    <label>Last Name</label>
                    <input name="lname" placeholder="Your Name" type="text" width="50px;">
                    <label>Address</label>
                    <input name="contactaddr" placeholder="Your address" type="text">
                    <label>Email Id</label>
                    <input name="email" placeholder="yourname@gmail.com" type="text">
                    <label>Contact Number</label>
                    <input name="phone" placeholder="Phone Number" type="text">
                    <label>Why You Interested In Volunteering?</label>
                        <textarea  name="reason" placeholder="Message" rows="10"></textarea>
                    <input id="submit" type="submit" name="submit" value="Send Message">
                </form>
            </div>


        </div>
