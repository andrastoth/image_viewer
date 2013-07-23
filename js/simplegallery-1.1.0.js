/*!
 * simpleGallery v1.1.0 jQuery plugin
 * http://atandrastoth.co.uk/webdesign/
 * Author : Tóth András
 * Copyright 2013 Tóth András
 * Released under the MIT license
 * Date: 27 Feb 13 2013
 */
(function($) {
  $.fn.extend({
    simpleGallery: function(options, callback) {
      var defaults = {
        width: 160,
        height: 400,
        source: "file",
        folder: "images",
        previewHeight: "90%",
        previewWidth: "90%"
      };
      var currentImg;
      var obj = $(this);
      var options = $.extend(defaults, options);
      var picholder = $('<div class = "picholder bgcol outsh" ><div class = "moveleft"><a>PREW</a></div><div class = "picdiv ">' + '</div><div class = "picInfo"></div><img class="close" src = "css/img/close.png"><div class = "moveright"><a>NEXT</a></div></div>').hide().appendTo("body");
      return this.each(function() {
        var o = options;
        var current = 0;
        picholder.css('height', o.previewHeight.match(/\d+/g)[0] + '%');
        picholder.css('top', (100 - Number(o.previewHeight.match(/\d+/g)[0])) / 2 + '%');
        picholder.css('width', o.previewWidth.match(/\d+/g)[0] + '%');
        picholder.css('left', (100 - Number(o.previewWidth.match(/\d+/g)[0])) / 2 + '%');
        if (o.height > o.width) {
          obj.addClass("galleryHolder");
          obj.append($('<div class = "scroller"></div>'));
          var scroller = obj.children(".scroller");
          obj.append('<div class = "down"><img src = "css/img/arrow_down.png"></div>');
          var down = obj.children(".down");
          obj.prepend('<div class = "up"><img src = "css/img/arrow_up.png"></div>');
          var up = obj.children(".up");
        } else {
          obj.addClass("galleryHolder");
          obj.append($('<div class = "scrollerHorizontal"></div>'));
          var scroller = obj.children(".scrollerHorizontal");
          obj.append('<div class = "downHorizontal"><img src = "css/img/arrow_right.png"></div>');
          var down = obj.children(".downHorizontal");
          obj.prepend('<div class = "upHorizontal"><img src = "css/img/arrow_left.png"></div>');
          var up = obj.children(".upHorizontal");
        }
        scroller.width(o.width);
        scroller.height(o.height);
        var ret = com(o.source, o.folder);
        if (o.height > o.width) {
          wh = o.width - 20;
          he = o.height - 20;
          prev = "preview";
        } else {
          wh = o.width - 20;
          he = o.height - 20;
          prev = "previewHorizontal";
        }
        $.each(ret, function(index) {
          file = ret[index];
          if (o.source == "file") retImage = $('<img name = "' + file.name + '" src = resizer.php?order=file&dir=' + o.folder + "&wh=" + wh + "&he=" + he + "&file=" + file.name + ' class = "' + prev + '">');
          else retImage = $('<img name = "' + file.name + '" dbid = "' + file.id + '" src = resizer.php?order=database&id=' + file.id + "&wh=" + wh + "&he=" + he + "&file=" + file.name + ' class = "' + prev + '">');
          scroller.append(retImage);
        });
        images = scroller.children("img");
        down.on("click", function() {
          if (o.height > o.width) movedown();
          else movedownHorizontal();
        });
        up.on("click", function() {
          if (o.height > o.width) moveup();
          else moveupHorizontal();
        });
        picholder.on("click", ".close", function() {
          picholder.fadeOut();
          overlay("remove");
        });
        images.on("click", function() {
          overlay("enable");
          currentImg = $(this);
          View($(this));
        });
        picholder.children(".moveleft").on("click", function() {
          picholder.children(".picdiv").children("img").animate({
            opacity: 0
          }, 300, 'swing', function() {
            View(currentImg.prev());
          });
        });
        picholder.children(".moveright").on("click", function() {
          picholder.children(".picdiv").children("img").animate({
            opacity: 0
          }, 300, 'swing', function() {
            View(currentImg.next());
          });
        });

        function View(item) {
          currentImg = item;
          if (currentImg.prev().length == 0) picholder.children(".moveleft").fadeOut();
          else picholder.children(".moveleft").fadeIn();
          if (currentImg.next().length == 0) picholder.children(".moveright").fadeOut();
          else picholder.children(".moveright").fadeIn();
          picholder.children(".picdiv").children("img").remove("img");
          var retimg = $('<img style = "height:100%;opacity:0;filter: Alpha(Opacity=0);">');
          var file = item.attr("name");
          var wh = $(window).width() * 0.7;
          var he = $(window).height() * 0.7;
          picholder.children(".picInfo").html("<a>" + file + " - " + "( " + (currentImg.index() + 1) + " / " + scroller.children("img").length + " )" + "</a>");
          if (o.source == "file") retimg.attr("src", "resizer.php?order=file&dir=" + o.folder + "&wh=" + wh + "&he=" + he + "&file=" + file);
          else {
            var id = item.attr("dbid");
            retimg.attr("src", "resizer.php?order=database&id=" + id + "&wh=" + wh + "&he=" + he + "&file=" + file);
          }
          picholder.children(".picdiv").append(retimg);
          retimg.load(function() {
            if (picholder.children(".picdiv").width() > retimg.width()) mostleft = picholder.position().left + (picholder.width() - retimg.width() - 20) / 2;
            else mostleft = picholder.position().left - (retimg.width() + 20 - picholder.width()) / 2;
            mostwidth = retimg.width() + 20;
            picholder.animate({
              left: mostleft,
              width: mostwidth
            }, 300, 'swing', function() {
              retimg.animate({
                opacity: 1
              }, 300, 'swing');
            });
          });
          picholder.fadeIn();
        }

        function movedown() {
          target = 0;
          $.each(scroller.children("img"), function(index) {
            if ($(this).position().top >= scroller.height()) {
              target = $(this).prev().position().top;
              return false;
            }
            if (index == scroller.children("img").length - 1) {
              target = scroller[0].scrollHeight - scroller.height();
            }
          });
          scroller.animate({
            scrollTop: scroller.scrollTop() + target
          }, 300, 'swing');
        }

        function moveup() {
          target = 0;
          $.each(scroller.children("img"), function(index) {
            if (Math.abs($(this).position().top) <= scroller.height()) {
              target = $(this).position().top;
              return false;
            }
          });
          scroller.animate({
            scrollTop: scroller.scrollTop() + target
          }, 300, 'swing');
        }

        function movedownHorizontal() {
          target = 0;
          $.each(scroller.children("img"), function(index) {
            if ($(this).position().left >= scroller.width()) {
              target = $(this).prev().position().left;
              return false;
            }
            if (index == scroller.children("img").length - 1) {
              target = scroller[0].scrollWidth - scroller.width();
            }
          });
          scroller.animate({
            scrollLeft: scroller.scrollLeft() + target
          }, 300, 'swing');
        }

        function moveupHorizontal() {
          target = 0;
          $.each(scroller.children("img"), function(index) {
            if (Math.abs($(this).position().left) <= scroller.width()) {
              target = $(this).position().left;
              return false;
            }
          });
          scroller.animate({
            scrollLeft: scroller.scrollLeft() + target
          }, 300, 'swing');
        }

        function overlay(init) {
          if (init == "enable") {
            var docHeight = $(document).height();
            $("body").append("<div id='overlay'></div>");
            $("#overlay").height(docHeight).fadeIn();
          } else {
            $("#overlay").fadeOut(function() {
              $("#overlay").remove();
            });
          }
        }

        function com(order, param) {
          returnvalue = [];
          $.ajax({
            url: "resizer.php",
            type: "POST",
            dataType: "json",
            async: false,
            data: {
              order: order,
              param: param
            },
            complete: function(xhr, textStatus) {},
            success: function(data, textStatus, xhr) {
              returnvalue = data;
            },
            error: function(xhr, textStatus, errorThrown) {}
          });
          return returnvalue;
        }
        if (typeof callback == "function") callback.call(this);
      });
    }
  });
})(jQuery);
