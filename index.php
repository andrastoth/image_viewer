
<html>
  <head>
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  	<title></title>
  	<script src="js/jquery-1.9.0.js" type="text/javascript"></script>
    <link type ="text/css" rel="stylesheet" href="css/reset.css" charset="utf-8" media="all">    
    <link type ="text/css" rel="stylesheet" href="css/simplegallery-1.1.0.css" charset="utf-8" media="all">
    <link type ="text/css" rel="stylesheet" href="css/codemirror.css" charset="utf-8" media="all">  
    <link type ="text/css" rel="stylesheet" href="css/monokai.css" charset="utf-8" media="all">     
  	<script src="js/simplegallery-1.1.0.js" type="text/javascript" charset="utf-8" ></script>
    <script src="js/codemirror.js" type="text/javascript" charset="utf-8" ></script>
    <script src="js/javascript.js" type="text/javascript" charset="utf-8" ></script>
	</head>
  <body style ="background:rgb(128,255,128);float:none;overflow:hidden" onload="create()">
    <div class = "wrapper">
        <div class = "header">
            <h1>simpleGallery Demonstration</h1>
            <a href = "https://github.com/andrastoth/image_viewer" type = "button" class = "button"  onclick = "window.open(this.href, '_top');">Download from Github</a>
            <input tysimplegallery-1.1.0pe = "button" value = "Documentation (coming soon)" class = "button" name = "viewDoc" >
        </div>
        <div class = "container">
          <div id = "Gallery_two" style = "opacity:0;float:left" class = "outsh bgcol"></div>
          <textarea style="text-allign:left;width: 50%;height: 50%; display:none; float:none;" id = "code">
          /*This is the pre release, Gallery v.1.1.0

            Resize on fly for thumbnails or preview.
            Multiple gallery on one Page.

            Horizontal creating from files, vertical creating from database.
            with these setings:*/
			  
&lt;div id = "Gallery_two" style = "opacity:0;float:left" class = "outsh bgcol"&gt;&lt;/div&gt;
&lt;div id = "Gallery_one" style = "opacity:0;float:none" class = "insh brd brdrad bgcol"&gt;&lt;/div&gt;
			  
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
			  // Default settings: 
			  defaults = {
					width: 160,
					height: 400,
					source: "file",
					folder: "images",
					previewHeight: "90%",
					previewWidth: "90%"
				  };
          </textarea>
          <div id = "Gallery_one" style = "opacity:0;float:none" class = "insh brd brdrad bgcol"></div>
        </div>
    </div>
    <script type="text/javascript" charset="utf-8">
    $('.container').height($(window).outerHeight(true) - ($(window).outerHeight(true) - $(window).height() + 5) - $('.header').height());
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
      $('.CodeMirror').css({'float': 'left' , 'width': '50%', 'height': '50%','text-align':'left'});
        });
      }
    </script>
  </body>
</html>
