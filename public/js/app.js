/*global $*/
var postId = 0;
var postBodyElement = null;

$('.post').find('.inter').find('.dropdown-menu').find('#edit').on('click',function(event) {
  event.preventDefault();
  postBodyElement = event.target.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode; 
  var postBody = postBodyElement.childNodes[5].textContent;
  postId = postBodyElement.dataset['post'];
  $('#post-body').val(postBody);
  $('#edit-modal').modal();
});

$('#modal-save').on('click', function() {
  
  $.ajaxSetup(
  {
    headers:
    {
        'X-CSRF-Token': $('input[name="_token"]').val()
    }
  });
  
  $.ajax({
    method: 'POST',
    url: "/edit",
    data: { body: $('#post-body').val(), postid: postId, _token: 'csrf_token()' }
  })
  .done(function(msg) {
      $(postBodyElement.childNodes[5]).text(msg['new_body']);
  });
});

//profile tabs

$('#myTabs a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
});

$('#myTabs a:first').tab('show'); // Select first tab


//profile pic modals

function update() {
  
    event.preventDefault();
    $('#prof').modal();
  
}

function confirm(img) {
  
    event.preventDefault();
    document.getElementById("img-link").src = img['link'];
    document.getElementById("img-id").value = img['id'];
    $('#conf').modal();
  
}

$(function () {
  $('[data-toggle="popover"]').popover()
});

// REPOST




