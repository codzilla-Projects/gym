jQuery(document).ready(function($) {
  $('.first_video_link').click(function(e) {
    e.preventDefault();
    var custom_uploader = wp.media({
      title: 'Video Choose',
      button: {
        text: 'Choose Video'
      },
      multiple: false,
      library: {
        type: [ 'video' ]
      }
    })
    .on('select', function() {
      var attachment = custom_uploader.state().get('selection').first().toJSON();
      $('.first_video_id').val(attachment.url);
    })
    .open();
  });   
  $('.first_form_link').click(function(e) {
    e.preventDefault();
    var custom_uploader = wp.media({
      title: 'Form Choose',
      button: {
        text: 'Choose Form'
      },
      multiple: false,
    })
    .on('select', function() {
      var attachment = custom_uploader.state().get('selection').first().toJSON();
      $('.first_form_id').val(attachment.url);
    })
    .open();
  });  

  $('.first_img_upload').click(function(e) {
    e.preventDefault();
    var custom_uploader = wp.media({
      title: 'Image Choose',
      button: {
        text: 'Upload Image'
      },
      multiple: false  // Set this to true to allow multiple files to be  selected
    })
    .on('select', function() {
      var attachment = custom_uploader.state().get('selection').first().toJSON();
      $('.first_img').attr('src', attachment.url);
      $('.first_img_url').val(attachment.url);
      $('.first_img_id').val(attachment.id);

    })
    .open();
  });  
  $('.second_img_upload').click(function(e) {
    e.preventDefault();
    var custom_uploader = wp.media({
      title: 'Image Choose',
      button: {
        text: 'Upload Image'
      },
      multiple: false  // Set this to true to allow multiple files to be  selected
    })
    .on('select', function() {
      var attachment = custom_uploader.state().get('selection').first().toJSON();
      $('.second_img').attr('src', attachment.url);
      $('.second_img_url').val(attachment.url);
      $('.second_img_id').val(attachment.id);
    })
    .open();
  });
  $('.third_img_upload').click(function(e) {
    e.preventDefault();
    var custom_uploader = wp.media({
      title: 'Image Choose',
      button: {
        text: 'Upload Image'
      },
      multiple: false  // Set this to true to allow multiple files to be  selected
    })
    .on('select', function() {
      var attachment = custom_uploader.state().get('selection').first().toJSON();
      $('.third_img').attr('src', attachment.url);
      $('.third_img_url').val(attachment.url);
      $('.third_img_id').val(attachment.id);
    })
    .open();
  });   
  $('.fourth_img_upload').click(function(e) {
    e.preventDefault();
    var custom_uploader = wp.media({
      title: 'Image Choose',
      button: {
        text: 'Upload Image'
      },
      multiple: false  // Set this to true to allow multiple files to be  selected
    })
    .on('select', function() {
      var attachment = custom_uploader.state().get('selection').first().toJSON();
      $('.fourth_img').attr('src', attachment.url);
      $('.fourth_img_url').val(attachment.url);
      $('.fourth_img_id').val(attachment.id);
    })
    .open();
  });  
  $('.fifth_img_upload').click(function(e) {
    e.preventDefault();
    var custom_uploader = wp.media({
      title: 'Image Choose',
      button: {
        text: 'Upload Image'
      },
      multiple: false  // Set this to true to allow multiple files to be  selected
    })
    .on('select', function() {
      var attachment = custom_uploader.state().get('selection').first().toJSON();
      $('.fifth_img').attr('src', attachment.url);
      $('.fifth_img_url').val(attachment.url);
      $('.fifth_img_id').val(attachment.id);
    })
    .open();
  });    
  $('.sixth_img_upload').click(function(e) {
    e.preventDefault();
    var custom_uploader = wp.media({
      title: 'Image Choose',
      button: {
        text: 'Upload Image'
      },
      multiple: false  // Set this to true to allow multiple files to be  selected
    })
    .on('select', function() {
      var attachment = custom_uploader.state().get('selection').first().toJSON();
      $('.sixth_img').attr('src', attachment.url);
      $('.sixth_img_url').val(attachment.url);
      $('.sixth_img_id').val(attachment.id);
    })
    .open();
  });   
  $('.seventh_img_upload').click(function(e) {
    e.preventDefault();
    var custom_uploader = wp.media({
      title: 'Image Choose',
      button: {
        text: 'Upload Image'
      },
      multiple: false  // Set this to true to allow multiple files to be  selected
    })
    .on('select', function() {
      var attachment = custom_uploader.state().get('selection').first().toJSON();
      $('.seventh_img').attr('src', attachment.url);
      $('.seventh_img_url').val(attachment.url);
      $('.seventh_img_id').val(attachment.id);
    })
    .open();
  }); 
});