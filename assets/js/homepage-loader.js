// setting up header video
var tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    var player;

    function onYouTubeIframeAPIReady() {
        console.log('onYouTubeIframeAPIReady');
        videoId = document.getElementById('kd-main-youtube-video').dataset.src;
        player = new YT.Player('kd-main-youtube-video', {
            videoId: videoId,
            playerVars: {
                'autoplay': 1,
                'loop' : 1,
                'start' : 1,
                'rel' : 0,
                'mute' : 1
              },
            events: {
                'onReady': onPlayerReady,
                'onStateChange': onPlayerStateChange
            }
        });
    }

    function onPlayerReady(event) {
        console.log("hey Im ready");
        event.target.playVideo();
        //do whatever you want here. Like, player.playVideo();
    }

    function onPlayerStateChange() {
        console.log("my state changed");
    }

    let videoStarted = 0

    window.addEventListener('load',()=>{
        let playBtn = document.getElementById('kd-play-video');
        let pauseBtn = document.getElementById('kd-pause-video');
        let muteBtn = document.querySelector('#mute')
        let unmuteBtn = document.querySelector('#unmute')

        // play video
        playBtn.addEventListener('click' , ()=>{
            console.log(player)
            player.playVideo();
            playBtn.style.display = 'none';
            pauseBtn.style.display = 'block';
        })

        // pause video
        pauseBtn.addEventListener('click' , ()=>{
            console.log(player)
            player.pauseVideo();
            pauseBtn.style.display = 'none';
            playBtn.style.display = 'block';
        })

        muteBtn.addEventListener('click', () => {
            player.mute()
            muteBtn.style.display = 'none'
            unmuteBtn.style.display = 'block'
        })

        unmuteBtn.addEventListener('click', () => {
            player.unMute()
        muteBtn.style.display = 'block'
        unmuteBtn.style.display = 'none'
        })

        document.getElementById('kd-full-screen-video').addEventListener('click',()=>{
            let videoElement = document.getElementById('kd-main-youtube-video')
            videoElement.requestFullscreen()
        })
    })



    window.addEventListener('load',()=>{

        const getCategoryCont = (categoryId , category_name) => {
            console.log(category_name)
            return new Promise(resolve => {
                let data = {
                            'action': 'get_category_content',
                            'category_id': categoryId,
                            'category_name': category_name
                        };

                        jQuery.post(ajax_url, data , function (respond){
                            resolve (respond)
                        })
                    })
          }

        const initCats = async ()=>{
            let categoryWrappers = Array.from(document.getElementsByClassName('kd-single-category-services'))

            for (const categoryWrapper of categoryWrappers) {
                    // console.log(await getCategoryCont(categoryWrapper.dataset.catid ))
                    let categoryContent = await getCategoryCont(categoryWrapper.dataset.catid , categoryWrapper.dataset.categoryname);
                    console.log(categoryContent)
                    categoryWrapper.innerHTML = categoryContent;
            }

            console.log('all done');
            // initiate owl carousel
            var owl = jQuery(".owl-carousel");

            owl.owlCarousel({
                margin: 10,
                loop: true,
                nav: true,
                mouseDrag: true,
                responsiveClass: true,
                responsiveRefreshRate: 200,
                responsive: {
                    0: {
                        items: 2
                    },
                    600: {
                        items: 3
                    },
                    1024: {
                        items: 4
                    },
                    1366: {
                        items: 6
                    },
                    2080: {
                        items: 7
                    }
                }
            });
        }
        
        initCats();
    
});
