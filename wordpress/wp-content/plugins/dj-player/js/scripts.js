jQuery(document).ready(function($) {
	djpr_musicbar();

	$('.djrp-list').find('.djpr-list-song:nth-child(1)').addClass('active');
	djpr_songplay($('.djrp-list').find('.djpr-list-song:nth-child(1)'), 'onlyload');
	$('.djpr-download-bttn a').attr('href', $('.djrp-list').find('.djpr-list-song:nth-child(1)').data('url'));

	$('.djrp-list').on('click', '.djpr-list-song', function(){
		$('.djrp-list').find('.djpr-list-song').removeClass('active');
		$(this).addClass('active');

		if(!$(this).hasClass('playing')){
			djpr_songplay($(this));
		}else{
			djpr_songpause($(this));
		}
	});

	$('.djrp-list').slimScroll({
		height: '490px',
		railOpacity: 1,
		railVisible: true,
		size: '10px',
		scrollTo : '0px',
		animate: true,
		wheelStep: 20,
		alwaysVisible: true,
		borderRadius: '0px',
		railBorderRadius : '0px'
	});

	$('.djpr-playbttn').click(function(){
		$(this).toggleClass("play");

		if(!$(this).hasClass('play')){
			var djpr_audioGet = $('.djpr-play-audio audio').get(0);
			djpr_audioGet.pause();
			$('.djrp-list').find('.djpr-list-song').removeClass('playing');
		}else{
			if( $('.djrp-list').find('.djpr-list-song.active').length == 0 ){
				djpr_songplay($('.djrp-list').find('.djpr-list-song:nth-child(1)'));
				$('.djrp-list').find('.djpr-list-song:nth-child(1)').addClass('active');
			}else{
				djpr_songplay($('.djrp-list').find('.djpr-list-song.active'));
			}
		}
	});

	djpr_volume();

	function djpr_volume() {
		var djpr_volumeSlider = $('.djpr-volume .djpr-volume-bar');
		var djpr_audioGet = $('.djpr-play-audio audio').get(0);
		djpr_volumeSlider.slider({
			orientation: "horizontal",
			value : 100,
			step  : 1,
			range : 'min',
			min   : 0,
			max   : 100,
			change : function(){
				var value = djpr_volumeSlider.slider("value");
				djpr_audioGet.volume = (value / 100);
				if (value == 0){
					djpr_volumeSlider.parent().find('.djpr-volume-controls').removeClass('middle');
					djpr_volumeSlider.parent().find('.djpr-volume-controls').addClass('null');
				}

				if (value > 0 && value <= 50){
					djpr_volumeSlider.parent().find('.djpr-volume-controls').addClass('middle');
					djpr_volumeSlider.parent().find('.djpr-volume-controls').removeClass('null');
				}

				if (value > 50){
					djpr_volumeSlider.parent().find('.djpr-volume-controls').removeClass('middle');
					djpr_volumeSlider.parent().find('.djpr-volume-controls').removeClass('null');
				}
			}
		});

		$('.djpr-volume-controls').click(function(){
			$(this).toggleClass('act');
			$('.djpr-volume-controls').toggleClass('null');
			if($(this).hasClass('act')){
				djpr_audioGet.animate({volume: 0}, 300);
				$('.djpr-volume .djpr-volume-bar').slider("value", '0');
			} else {
				djpr_audioGet.animate({volume: 1}, 300);
				$('.djpr-volume .djpr-volume-bar').slider("value", '100');
			}
		})
	}

	function djpr_audioReady(){
		return $.when.apply($, $('.djpr-play-audio audio').map(function(){
			var ready = new $.Deferred();
			$(this).one('canplay', ready.resolve);
			return ready.promise();
		}));
	}

	function djpr_musicbar() {
		$('.djpr-progressbar').slider({
			orientation: "horizontal",
      		range: "min",
		});

		$('<div class="clickarea"></div>').appendTo('.djpr-progressbar').css({
			'height': '17px',
			'position': 'absolute',
			'top': '-6px',
			'width': '100%',
			'z-index': '50',
		});

		$('<div class="clickarea"></div>').appendTo('.djpr-volume-bar').css({
			'height': '20px',
			'position': 'absolute',
			'top': '-7px',
			'left' : '-7px',
			'width': '115%',
			'z-index': '50',
		});

		$('.djpr-prev').click(function(){
			if($('.djrp-list').find('.djpr-list-song.active').length == 0 || $('.djrp-list').find('.djpr-list-song.active').index() == 0){
				var djpr_lstLength = $('.djrp-list').find('.djpr-list-song').length;
				$('.djrp-list').find('.djpr-list-song:nth-child('+djpr_lstLength+')').click();
			}else if($('.djrp-list').find('.djpr-list-song.active').length != 0 && $('.djrp-list').find('.djpr-list-song.active').index() != 0){
				var djpr_activeInd = $('.djrp-list').find('.djpr-list-song.active').index();
				$('.djrp-list').find('.djpr-list-song:nth-child('+ djpr_activeInd +')').click();
			}
		});

		$('.djpr-next').click(function(){
			if($('.djrp-list').find('.djpr-list-song.active').length == 0 || $('.djrp-list').find('.djpr-list-song.active').index() == $('.djrp-list').find('.djpr-list-song').length - 1){
				$('.djrp-list').find('.djpr-list-song:nth-child(1)').click();
			}else{
				var djpr_activeInd = $('.djrp-list').find('.djpr-list-song.active').index();
				djpr_activeInd += 2;
				$('.djrp-list').find('.djpr-list-song:nth-child('+ djpr_activeInd +')').click();
			}
		});
	}

	function djpr_songplay(elem, type = '') {
		var djpr_thisSong = elem;
		var djpr_songUrl = elem.data('url');
		var djpr_audioGet = $('.djpr-play-audio audio').get(0);

		if($('.djpr-play-audio audio').attr('src') == '' || djpr_songUrl != $('.djpr-play-audio audio').attr('src')){
			$('.djpr-play-audio').removeClass('loaded');
			$('.djpr-play-audio audio').attr('src', djpr_songUrl);
			setTimeout(function(){
				$('.djpr-song-info .name').text($('.djrp-list .djpr-list-song.active .title').text());
			}, 100);
			djpr_audioGet.load();
			djpr_audioReady().then(function(){
				var djpr_mainDuration = djpr_audioGet.duration;
				var djpr_rem = parseInt(djpr_mainDuration, 10),
				djpr_mins = Math.floor(djpr_rem/60,10),
				djpr_secs = djpr_rem - djpr_mins*60;
				$('.djpr-duration').text((djpr_mins > 9 ? djpr_mins : '0' + djpr_mins) + ':' + (djpr_secs > 9 ? djpr_secs : '0' + djpr_secs));

				$('.djpr-play-audio').addClass('loaded');

				djpr_audioGet.play();

				if(type == 'onlyload'){
					djpr_audioGet.pause();
				}
			});
		}

		if(type != 'onlyload'){
			if($('.djpr-play-audio').hasClass('loaded')){
				djpr_audioGet.play();
			}
			$('.djpr-playbttn').addClass('play');
			$('.djrp-list').find('.djpr-list-song').removeClass('playing');
			djpr_thisSong.addClass('playing');
		}

		$('.djpr-rewind-previous').click(function(){
			djpr_audioGet.currentTime = parseInt(djpr_audioGet.currentTime, 10);
			djpr_audioGet.currentTime += parseInt($(this).find('p').text());
		});

		$('.djpr-rewind-next').click(function(){
			djpr_audioGet.currentTime = parseInt(djpr_audioGet.currentTime, 10);
			djpr_audioGet.currentTime += parseInt($(this).find('p').text());
		});

		$($('.djpr-play-audio audio')).unbind('timeupdate', function(){
			djpr_bind();
		});

		$($('.djpr-play-audio audio')).bind('timeupdate', function(){
			djpr_bind();
		});
	}

	function djpr_songpause(elem) {
		var djpr_audioGet = $('.djpr-play-audio audio').get(0);
		elem.removeClass('playing');
		djpr_audioGet.pause();
		$('.djpr-playbttn').removeClass('play');
	}

	function djpr_bind() {
		var djpr_audioCurrent = $('.djpr-play-audio audio');
		var djpr_audioCurrentGet = $('.djpr-play-audio audio').get(0);

		var djpr_currentrem = parseInt(djpr_audioCurrentGet.currentTime, 10),
		djpr_currentmins = Math.floor(djpr_currentrem/60,10),
		djpr_currentsecs = djpr_currentrem - djpr_currentmins*60;
		
		$('.djpr-current-time').text((djpr_currentmins > 9 ? djpr_currentmins : '0' + djpr_currentmins) + ':' + (djpr_currentsecs > 9 ? djpr_currentsecs : '0' + djpr_currentsecs));

		$('.djpr-progressbar').slider({
			max: djpr_audioCurrentGet.duration,
			value: djpr_audioCurrentGet.currentTime,
			slide: function(e,ui) {
				djpr_audioCurrentGet.currentTime = ui.value;
			},
			stop:function(e,ui) {
				djpr_audioCurrentGet.currentTime = ui.value;
			}
		});
	}



	// Track List

	$('.djpr-mobilelist-container .djpr-mobilelist').click(function(){
		$('.djpr-player').toggleClass('playlist');
	});


	$('.djpr-download-bttn').click(function(){
		var djpr_audioCurrentLink = $('.djpr-play-audio audio').attr('src');
		$(this).find('a').attr('href', djpr_audioCurrentLink);
	});
});