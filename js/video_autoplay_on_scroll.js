var video, video2,
    info = $('.info'),
    fraction = 0.8;
    function checkScroll() {
      var videos = $('video');
      var i, len;
      var setVisibilityToPlay = 0.75;
      for (i = 0; i < videos.length; i++) {
       video2 = document.getElementById('video'+i);
       video = $("#video"+i)
          var win = $(window);
   
    var viewport = {
        top : win.scrollTop(),
        left : win.scrollLeft()
    };
    viewport.right = viewport.left + win.width();
    viewport.bottom = viewport.top + win.height();
   
    var bounds = video.offset();
    bounds.right = (bounds.left + video.outerWidth()) * setVisibilityToPlay;
    bounds.bottom = (bounds.top + video.outerHeight()) * setVisibilityToPlay;
    var a = !(viewport.right < bounds.left / setVisibilityToPlay || viewport.left > bounds.right || viewport.bottom < bounds.top / setVisibilityToPlay || viewport.top > bounds.bottom);
       console.log(a + " " +i);
       if(a) {
        video2.play();
        console.log(video2.src + " Play");
       }
       else {
          video2.pause();
          console.log(video2.src + " Pause");
        }
    }
    }
window.addEventListener('scroll', checkScroll, false);
window.addEventListener('resize', checkScroll, false);

//one time at the beginning, in case it starts in view
checkScroll();

//as soon as we know the video dimensions