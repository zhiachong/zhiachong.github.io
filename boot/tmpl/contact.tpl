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

                    <div class="eleven alt columns">
                    <input id="cEmailError" style="display: none" value=""/>
                    <input id="cMessageError" style="display: none;" value=""/>
                    </div>
                <p style="margin-bottom: 20px;">We welcome your comments, questions and thoughts!
                    <br/>
                    <p class="welcome">
                    There are a number of questions that are frequently asked. Please check if your question
                    has already been answered in our F.A.Q. section as we compiled a comprehensive list of frequently asked questions and answers on there already.
                    <br/><br/>
                    Please fill out the form below to contact our Customer Support Department. We will respond to your
                    request as quickly as we can.
                    </p>
                    <br/></br/>
                </p>

                <!-- Contact Form -->
                <section id="contact">

                    <!-- Form -->
                    <form id="contactform" name="contactform" action="contact.php" method="post">

                        <fieldset>

                            <div style="width: 260px;">
                                <label for="name">Name:</label>
                                <input id="cName" class="text" style="" type="text" name="name" value="" placeholder="" />       
                            </div>

                            <div style="width: 260px;">
                                <label for="email">Email: <span>*</span></label>
                                <input id="cEmail" class="text" style="" type="text" name="email" value="" placeholder="" /> 
                            </div>

                            <div style="width: 540px;">
                                <label for="comments">Message: <span>*</span></label>
                <textarea id="cMessage" Style="" name="message" placeholder=""></textarea>           
                            </div>

                            <div style="width: 260px;">
                                <label for="urgency">Urgency: <span>*</span></label>
                                <select name="urgency">
                                    <option value="0">Low</option>
                                    <option value="1">Medium</option>
                                    <option value="2">High</option>
                                </select>
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
<input type="hidden" class="page" value="contact"/>
{include file="footer.tpl"}