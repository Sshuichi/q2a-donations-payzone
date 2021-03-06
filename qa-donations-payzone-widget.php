<?php
class qa_donations_payzone_widget {

    function init_queries($tableslc) {
        $tablename=qa_db_add_table_prefix('donators');

        if(!in_array($tablename, $tableslc)) {
            //require_once QA_INCLUDE_DIR.'qa-app-users.php';
            //require_once QA_INCLUDE_DIR.'qa-db-maxima.php';
            return 'CREATE TABLE IF NOT EXISTS `'.$tablename.'` (
          `date` date NOT NULL,
          `userid` int(10) unsigned NOT NULL,
          `phone` varchar(25) NOT NULL,
          `code` varchar(50) NOT NULL,
          `status` varchar(50) NOT NULL,
          `amount` int(11) NOT NULL DEFAULT \'0\',
          KEY `userid` (`userid`),
          KEY `date` (`date`)
        )
        ';
    }
    }

    function allow_template($template)
    {
        return true;
    }
    function allow_region($region)
    {
        return true;
    }
    function output_widget($region, $place, $themeobject, $template, $request, $qa_content)
    {
        $baseUrl = qa_opt('site_url');
        echo '
            <script type="text/javascript">
            var baseUrl = "'.$baseUrl.'";
                $(document).ready(function(){
                 $("#fader").on("input change", function() {
                    $("#donation-value").text(this.value);
                    $("#donation-form").attr("action",baseUrl+"donation/"+this.value+"/");
                 });
                })

            </script>
            <form method="get" id="donation-form" action="'.$baseUrl.'donation/350">
            <label for="fader"><h2 align="center">إدعم موقع محكمتي</h2></label>
            <ul class="qa-q-item-tag-list">
					    <li class="qa-q-item-tag-item">
                            <a href="'.$baseUrl.'donation/100" class="donation-link" >100 درهم</a>
                        </li>
					    <li class="qa-q-item-tag-item">
                            <a href="'.$baseUrl.'donation/200" class="donation-link" >200 درهم</a>
                        </li>
                        <li class="qa-q-item-tag-item">
                            <a href="'.$baseUrl.'donation/300" class="donation-link" >300 درهم</a>
                        </li>
					    <li class="qa-q-item-tag-item">
                            <a href="'.$baseUrl.'donation/500" class="donation-link" >500 درهم</a>
                        </li>
					    <li class="qa-q-item-tag-item">
                            <a href="'.$baseUrl.'donation/1000" class="donation-link" >1000 درهم</a>
                        </li>
					    <li class="qa-q-item-tag-item">
                            <a href="'.$baseUrl.'donation/2000" class="donation-link" >2000 درهم</a>
                        </li>
                    </ul>
                    <div class="separator">
      <span class="choose">
        أو إختر مبلغا يناسبك <!--Padding is optional-->
      </span>
    </div>
                    <input type="range" value="350" min="100" max="2000" step="50" id="fader">
                    <span id="donation"><b id="donation-value">350</b> درهم</span>
                    <input type="submit" class="qa-ask-link qa-a-count-zero" value="إدعم">
            </form>';
    }

    function admin_form(&$qa_content)
    {

        // Process form input

        $ok = null;

        if (qa_clicked('payzone_save')) {
            qa_opt('payzone_merchant_id', qa_post_text('payzone_merchant_id'));
            qa_opt('payzone_merchant_password', qa_post_text('payzone_merchant_password'));

            $ok = qa_lang('admin/options_saved');
        }


        // Create the form for display


        $fields = array();

        $fields[] = array(
            'label' => 'Merchant id',
            'tags' => 'NAME="payzone_merchant_id"',
            'value' => qa_opt('payzone_merchant_id'),
            'type' => 'text');

        $fields[]= array(
                'label' => 'Merchant password',
                'tags' => 'NAME="payzone_merchant_password"',
                'value' => qa_opt('payzone_merchant_password'),
                'type' => 'text',
        );

        return array(
            'ok' => ($ok && !isset($error)) ? $ok : null,

            'fields' => $fields,

            'buttons' => array(
                array(
                    'label' => qa_lang_html('main/save_button'),
                    'tags' => 'NAME="payzone_save"',
                ),
            ),
        );
    }
}