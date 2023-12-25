$(document).ready(function () {
  $("#getTransaksi").click(function () {
    var noktp = $("#noktp").val();

    $.ajax({
      type: "POST",
      url: "get_transaksi.php",
      data: { noktp: noktp },
      success: function (response) {
        $("#transaksiResult").html(response);
      },
    });
  });
});


function showRiwayatTransaksi(noktp) {
  var inner = "transaksiResult";
  var url = "get_transaksi.php?noktp=" + noktp;
  if (noktp == "") {
    document.getElementById(inner).innerHTML = "";
  } else {
    callAjax(url, inner);
  }
}

function getXMLHTTPRequest() {
  if (window.XMLHttpRequest) {
    // code for modern browsers
    return new XMLHttpRequest();
  } else {
    // code for old IE browsers
    return new ActiveXObject("Microsoft.XMLHTTP");
  }
}

function callAjax(url, inner) {
  // TODO 4: Lengkapilah fungsi callAjax()
  var xmlhttp = getXMLHTTPRequest();
  xmlhttp.open("GET", url, true);
  xmlhttp.onreadystatechange = function () {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      document.getElementById(inner).innerHTML = xmlhttp.responseText;
    }
    return false;
  };
  xmlhttp.send(null);
}

function showBooks(bookTitle) {
  var inner = "detail_books";
  var url = "get_books.php?title=" + bookTitle;
  if (bookTitle == "") {
    document.getElementById(inner).innerHTML = "";
  } else {
    callAjax(url, inner);
  }
}

function showBooksForAndre(bookTitle) {
  var inner = "detail_books";
  var url = "get_booksAndre.php?title=" + bookTitle;
  if (bookTitle == "") {
    document.getElementById(inner).innerHTML = "";
  } else {
    callAjax(url, inner);
  }
}

$(document).ready(function() {
  $('#email').on('input blur', function() {
      var email = $('#email').val();
      $.ajax({
          type: 'POST',
          url: 'check_email.php',
          data: { email: email },
          success: function(response) {
              $('#notification').html(response);
          }
      });
  });
});
