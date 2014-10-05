 {include file="header.tpl"}
 <div class="page_title">
            <div class="container">
                <div class="sixteen columns">
                    Contact Us
                </div>
            </div>
        </div>


        <div class="container contacts">

            <div class="eleven alt columns">

                <h3 class="headline">Contact Form</h3><span style="margin-bottom: 20px;" class="line"></span>

                <div class="clearfix"></div>
                    <h3><font color="green">Your mail has been sent!</font></h3>
                    <p style="margin-bottom: 20px;">Your email has been successfully sent. Thank you and we will respond to your inquiry as soon as possible.
                </p>

                <!-- Contact Form -->
                <section id="contact">

                    <!-- Success Message -->
                    <mark id="message" style="display: none;"></mark>

                    <!-- Form -->
                    <form id="contactform" name="contactform" action="contact.php" method="post">

                        <fieldset>

                            <div style="width: 260px;">
                                <label accesskey="U" for="name">Name:</label>
                                <input id="cName" class="text" style="" type="text" name="name" value="" placeholder="" />       
                            </div>

                            <div style="width: 260px;">
                                <label accesskey="E" for="email">Email: <span>*</span></label>
                                <input id="cEmail" class="text" style="" type="text" name="email" value="" placeholder="" /> 
                            </div>

                            <div style="width: 540px;">
                                <label accesskey="C" for="comments">Message: <span>*</span></label>
                <textarea Class=" " Style="" name="message" placeholder=""></textarea>           
                            </div>

                        </fieldset>

                        <input type="hidden" value="contacts" name="action">
                        <input type="submit" value="Send Message" id="submit" class="button">

                        <div class="clearfix"></div>

                    </form>

                </section>
                <!-- Contact Form / End -->
                    </div>
            <!-- Container / End -->
            <div class="five columns">

                <!-- Information -->
                <div style="margin-top:0;" class="widget">
                    <h3 class="headline">Our Contacts</h3><span class="line"></span>
                    <br/>
                    <ul class="contact-informations">
                        <li><i class="icon-twitter"></i>
                            <p><a href="www.twitter.com">Twitter</a></p></li>
                        <li><i class="icon-facebook-sign"></i>
                            <p><a href="www.facebook.com">Facebook</a></p></li>
                        <li><i class="icon-credit-card"></i>
                            <p>business@inflexshares.com</p></li>
                        <li><i class="icon-envelope-alt"></i>
                            <p>contact@inflexshares.com</p></li>
                        <li><i class="icon-globe"></i>
                            <p>admin@inflexshares.com</p></li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
</div>

{include file="footer.tpl"}