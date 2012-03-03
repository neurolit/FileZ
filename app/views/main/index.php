
<h2 class="new-file"><?php echo __('Upload a new file') ?></h2>
<section class="new-file fz-modal">
        <?php echo partial ('main/_upload_form.php') ?> 
</section>

<h2 id="uploaded-files-title"><?php echo __('Uploaded files') ?></h2>
<section id="uploaded-files">
  <ul id="files">
    <?php $odd = true; foreach ($files as $file): ?>
      <li class="file <?php echo $odd ? 'odd' : 'even'; $odd = ! $odd ?>" id="<?php echo 'file-'.$file->getHash() ?>">
        <?php echo partial ('main/_file_row.php', array ('file' => $file)) ?> 
      </li>
    <?php endforeach ?>
  </ul>
</section>

<div id="share-modal" class="fz-modal" style="display: none;">
    <p class="instruction"><?php echo __('Give this link to the person you want to share this file with') ?></p>
    <p id="share-link"><a href=""></a></p>
    <p class="instruction"><?php echo __('or share using:') ?></p>
    <ul id="share-destinations">
        <?php if (in_array ('email', $sharing_destinations)): ?>
          <li class="email"   ><a href="" data-url="%url%/email"><?php echo __('your email') ?></a></li>
        <?php endif; ?>
        <?php if (in_array ('facebook', $sharing_destinations)): ?>
        <li class="facebook"><a href="" target="_blank" data-url="http://www.facebook.com/sharer.php?u=%url%&t=%filename%"><?php echo __('Facebook') ?></a></li>
        <?php endif; ?>
        <?php if (in_array ('twitter', $sharing_destinations)): ?>
        <li class="twitter" ><a href="" target="_blank" data-url="http://twitter.com/home?status=%filename% %url%"><?php echo __('Twitter') ?></a></li>
        <?php endif; ?>
    </ul>
    <div class="cleartboth"></div>
</div>

<div id="email-modal" class="fz-modal" style="display: none;">
  <?php echo partial ('file/_mailForm.php') ?>
</div>

<script type="text/javascript">
    $(document).ready (function () {
      $('#input-start-from').datepicker ({minDate: new Date()});
      $('#upload-form').initFilez ({
        fileList:         'ul#files',
        progressBox:      '#upload-progress',
        loadingBox:       '#upload-loading',
        maxFileSize:      <?php echo $max_upload_size ?>,
        progressBar: {
          enable:        <?php echo ($use_progress_bar ? 'true':'false') ?>,
          upload_id_name: '<?php echo $upload_id_name ?>',
          barImage:     '<?php echo public_url_for ('resources/images/progressbg_green.gif') ?>',
          boxImage:     '<?php echo public_url_for ('resources/images/progressbar.gif') ?>',
          refreshRate:   <?php echo $refresh_rate ?>,
          progressUrl:  '<?php echo url_for ('upload/progress/') ?>'
        },
        messages: {
          confirmDelete: <?php echo  json_encode (__('Are you sure to delete this file ?')) ?>,
          unknownError: <?php echo  json_encode (__('Unknown error')) ?>,
          unknownErrorHappened: <?php echo  json_encode (__('An unknown error hapenned while uploading the file')) ?>,
          cancel: <?php echo  json_encode (__('Cancel')) ?>,
          emailMessage: <?php echo  json_encode (__('You can download the file I uploaded here')) ?>
        }
      });

      // Modal box generic configuration
      $(".fz-modal").dialog({
        bgiframe: true,
        autoOpen: false,
        resizable: false,
        width: '560px',
        modal: true
      });

      // Set title for each modal
      $('section.new-file').dialog ('option', 'title', <?php echo json_encode(__('Upload a new file')) ?>);

      // Replace upload form with one big button, and open a modal box on click
      $('h2.new-file').wrapInner ($('<a href="#" class="awesome large"></a>'));
      $('h2.new-file a').click (function (e) {
        $('section.new-file').dialog ('open');
        e.preventDefault();
      });
      
      // Show password box on checkbox click
      $('input.password').hide();
      $('#use-password, #option-use-password label').click (function () { // IE quirk fix
        if ($('#use-password').attr ('checked')) {
            $('input.password').show().focus();
        } else {
            $('input.password').val('').hide();
        }

      });
    });
</script>

