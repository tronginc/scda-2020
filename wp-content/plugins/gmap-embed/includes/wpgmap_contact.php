<div class="srm_gmap_contact_area">
    <h3>Having problem? or you have any suggestion, please inform us!</h3>
    <form id="srm_gmap_contact" action="<?php echo admin_url(); ?>admin.php?page=wpgmapembed&message=4" method="post">
        <table class="" style="width: 90%">
            <tbody>
            <tr>
                <th width="25%">
                    <label for="srm_gmap_name">Name</label>
                </th>
                <td width="80%">
                    <input type="text" class="wp_gmap_contact_field" name="srm_gmap_name" id="srm_gmap_name"
                           required=""/></td>
            </tr>
            <tr>
                <th>
                    <label for="srm_gmap_email">Email</label>
                </th>
                <td>
                    <input type="email" class="wp_gmap_contact_field" name="srm_gmap_email"
                           value="<?php echo sanitize_email( get_bloginfo( 'admin_email' ) ); ?>"
                           id="srm_gmap_email" required=""
                           placeholder="example@mail.com">
                    <span style="color:red">Please provide a valid email for further communication</span>
                </td>
            </tr>
            <tr>
                <th>
                    <label for="srm_gmap_website">Website</label>
                </th>
                <td>
                    <input type="text" class="wp_gmap_contact_field" name="srm_gmap_website"
                           value="<?php echo get_bloginfo( 'url' ); ?>"
                           id="srm_gmap_website"
                           placeholder="<?php echo esc_url('http://example.com');?>"></td>
            </tr>
            <tr>
                <th>
                    <label for="srm_gmap_category">Topic</label>
                </th>
                <td>
                    <select name="srm_gmap_category" class="wp_gmap_contact_field" id="srm_gmap_category">
                        <option value="plugins_options">Plugin Settings Related</option>
                        <option value="functionality_request">Suggest new functionality</option>
                        <option value="bug">API key issue</option>
                        <option value="bug">Report a bug</option>
                        <option value="other">Other Issue</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>
                    <label for="srm_gmap_subject">Subject</label>
                </th>
                <td>
                    <input type="text" name="srm_gmap_subject" class="wp_gmap_contact_field" value=""
                           id="srm_gmap_subject" required=""></td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="srm_gmap_message">Message</label>
                </th>
                <td>
                    <textarea name="srm_gmap_message" class="wp_gmap_contact_field" id="srm_gmap_message"
                              placeholder="Hello Saidur Rahman" required=""
                              rows="3" cols="50"></textarea>
                </td>
            </tr>
            <tr>
                <th></th>
                <th>
                    <input type="hidden" name="srm_gmap_contact_submit">
                    <button class="button button-primary button-hero" style="float: left;" type="submit">
                        <i class="fa fa-upload"></i>
                        Send email
                    </button>
                </th>
            </tr>
            </tbody>
        </table>
    </form>
</div>

<div class="srm_gmap_instructions">
    <h3>Frequently asked questions</h3>
	<?php
	require_once( plugin_dir_path( __FILE__ ) . 'wpgmap_faqs.php' );
	?>
</div>

<div class="srm_gmap_video_area">
    <iframe width="100%" height="520" src="<?php echo esc_url( 'https://www.youtube.com/embed/h8fLhYZb5_4' ); ?>"
            frameborder="0"
            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

</div>

