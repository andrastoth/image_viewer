
<html>
  <head>
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  	<title></title>
  	<script src="js/jquery-1.9.0.js" type="text/javascript"></script>
    <link type ="text/css" rel="stylesheet" href="css/simpleGallery.css" charset="utf-8" media="all">
    <link type ="text/css" rel="stylesheet" href="css/codemirror.css" charset="utf-8" media="all">  
    <link type ="text/css" rel="stylesheet" href="css/monokai.css" charset="utf-8" media="all">     
  	<script src="js/simpleGallery.js" type="text/javascript" charset="utf-8" ></script>
    <script src="js/codemirror.js" type="text/javascript" charset="utf-8" ></script>
    <script src="js/javascript.js" type="text/javascript" charset="utf-8" ></script>
	</head>
  <body style ="background:rgb(128,255,128);float:none;overflow:hidden" onload="create()">
    <div id = "Gallery_one" style = "opacity:0;float:left" class = "insh brd brdrad bgcol"></div>
    <div id = "Gallery_two" style = "opacity:0;float:left" class = "outsh bgcol"></div>
	  <textarea style="width: 100%;height: 50%; display:none; float:none;" id = "code">
    /*This is the pre release, Gallery v.0.0

      Resize on fly for thumbnails or preview.
      Multiple gallery on one Page.

      Horizontal creating from files, vertical creating from database.
      with these setings:*/

      $('#Gallery_two').simpleGallery({
          folder: 'images',
          width: 900,
          height: 150,
        }, function() {
          $('#Gallery_two').animate({
            'opacity': '1'
          }, 3000)
        });

        $('#Gallery_one').simpleGallery({
          source: 'database',
          width: 150,
          height: 700,
		  previewHeight: "60%",
		  previewWidth: "60%"
        }, function() {
          $('#Gallery_one').animate({
            'opacity': '1'
          }, 3000)
        });
      }
    </textarea>
    <script type="text/javascript" charset="utf-8">

      function create() {
        $('#Gallery_two').simpleGallery({
          folder: 'images',
          width: 900,
          height: 150
        }, function() {
          $('#Gallery_two').animate({
            'opacity': '1'
          }, 3000)
        });
        $('#Gallery_one').simpleGallery({
          source: 'database',
          width: 150,
          height: 700,
		  previewHeight: "60%",
		  previewWidth: "60%"
        }, function() {
          $('#Gallery_one').animate({
            'opacity': '1'
          }, 3000);
          $('textarea').fadeIn();
      var editor = CodeMirror.fromTextArea(document.getElementById("code"),{readOnly: true});
      editor.setOption("theme", "monokai");
      $('.CodeMirror').css({'float': 'left' , 'width': '50%', 'height': '50%'});
        });
      }
    </script>
  </body>
</html>
