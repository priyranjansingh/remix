
var lovers = null;
var jp = null;
var last_track = null;
var prev_track = null;
var current_track = null;

function jplayer(){
    var jThis = this;
	this.init = function(container){
		 jp = $(container);

		 jp.jPlayer({
            solution:   "html,flash", // Flash with an HTML5 fallback.
            swfPath: "jquery.jplayer.swf",
            supplied: "mp3",
            ready: function (event) {
				var $time = $(event.jPlayer.options.cssSelectorAncestor + " .jp-current-time");
            },
            play: function(){
                jThis.activate();
            },
            stop: function(){
        	},
            pause: function(){
                jThis.deactivate();
            },
            ended: function(obj) {
            },
        	timeupdate: function(){
        		//showTimeLeft();
        	},
            volume: 0.8
        });

		    // init slider
	    $( "#jp_volume .volume" ).slider({
            value: 80,
            range: "min",
            orientation: "horizontal",
            min: 1,
            slide: function (event, ui){
                jp.jPlayer('volume', ui.value / 100);
            },
            start: function(event, ui){
            },
            stop: function(event, ui){
			// end slide event
			// cookie
            }
        });

	    
    	// init observers 
    	// player

        $('#jp_controls').on('click', function(evt){
            var elm = evt.target;
			
            if ($(elm).closest('.jp-control').length > 0 && last_track){
                    if ($(elm).hasClass('jp-next')) {
                        jThis.playNext();
                    } 
                    else if ($(elm).hasClass('jp-prev')) {
                    	
                        jThis.playPrev();
                    } 
                    else {
                        if (current_track) {
                            // current_track.removeClass('active').addClass('pause');
                            $('.play.jp-control').toggleClass('active');
                            jp.jPlayer("pause");
                            
                        } else {
                            // last_track.removeClass('pause').addClass('active');
                            jThis.playTrack(last_track);

                        }
                    }
            } else{
                playTrack( $('#releases tbody tr:first') );
                $('#releases tbody tr:first').addClass('active');
            }
        });


    	// releases 
		$('#releases').on('click', function(evt){
			var elm = evt.target;

			if ( $(elm).closest('.play').length > 0 ) {
			    clickOnTrack ( $(elm).closest('.play') );
			}
		});



        $('#mute').on('click', function(evt){
			var elm = evt.target;
			if ($(elm).closest('.jp-vol').length > 0){
				$(elm).closest('#mute').toggleClass('muted');
				$('#mute').hasClass('muted') ? jp.jPlayer({"muted":true}) : jp.jPlayer({"muted":false});
            } else{
				
            }
		});	
	}

    // declare functions

	this.activate = function() {
		$("#play").removeClass('pause').addClass('active');

		var progress = $('.jp-audio');
		jp.jPlayer("option", "cssSelectorAncestor" , '.jp-audio');
	}
	this.deactivate = function() {
		$("#play").removeClass('active').addClass('pause');

	 	jp.jPlayer("pause");
        current_track = null;
	}

    this.playNext = function(){
        var next = last_track.next('tr.track');

        if (next.length > 0) {

        	var sample = next.attr('id');
        	jp.jPlayer("setMedia", {
	            mp3: '/demo/html/lovers/samples/'+ sample +'.LOFI.mp3' 
	        });

            last_track.removeClass('pause').removeClass('active');
            jThis.playTrack(next);
            next.addClass('active');

        } else {
			current_track = null;
        }
    }
    
    this.playPrev = function(){
        var prev = last_track.prev('tr.track');

        if (prev.length > 0) {
        	var sample = prev.attr('id');
        	jp.jPlayer("setMedia", {
	            mp3: '/demo/html/lovers/samples/'+ sample +'.LOFI.mp3' 
	        });
            last_track.removeClass('pause').removeClass('active');
            jThis.playTrack(prev);
            prev.addClass('active');
        } else {
        }
    }

    function showTimeLeft(){}

    this.playTrack = function(track){
        // var sample = track.attr('id');
        jp.jPlayer("setMedia", {
            mp3: track
        });

        current_track = track;
        last_track = track;


        // update track duration

        jp.jPlayer("play");
    }

    this.clickOnTrack = function(track){
        if ( current_track && current_track.attr('id') == track.attr('id')) {
            
	        jp.jPlayer("pause");
            track.removeClass('active').addClass('pause');
	    } else {
            if (last_track) {
                last_track.removeClass('pause').removeClass('active');
            }
            track.removeClass('pause').addClass('active');
            jThis.playTrack(track);

	    }
	}
}



function createMedia(){
	this.media = {
		player : null
	}

	 this.init = function(){
	 	this.media.player = new jplayer();
		this.media.player.init("#jpId");
	 }
}

    $(document).on("click",".play_btn",function(){
        var song = $(this).find('i').attr("data-song"),
            type = $(this).find('i').attr("data-type");
        $.ajax({
            url: base_url+"/home/verifysong",
            type: "POST",
            data: { song: song}
        }).done(function(data){
            data = $.parseJSON(data);
            if(type == "song"){
                this.media = {
                    player : null
                }

                this.media.player = new jplayer();
                this.media.player.init("#jpId");
                this.media.player.playTrack(data.url);
                $('.jp-title span.song-title').html(data.artist_name +" - "+data.song_name);
                $("#album_art img").attr('src',data.album_art);
                $('.play.jp-control').toggleClass('active');
            }
        });
    });

    


        var ino = $('#navigation');
        var footer = $('.footer');
        var $tElems = $('.inner a');
        var ct = $('.inner a').length;
        var al = {queue:true,duration:800,easing:"easeInOutQuad"};
        var al2 = {queue:true,duration:400,easing:"easeInOutQuad"};
        var bo = $('.body-overlay');
        var $mem = $('.member-box');
        var memlenght = $('.member-box').length;
        var $project = $('.box a');
        var projectlenght = $('.box a').length;    

    lovers = new createMedia();


    // ie fix of prop indexOf
    if (!Array.prototype.indexOf) {
        Array.prototype.indexOf = function(obj, start) {
             for (var i = (start || 0), j = this.length; i < j; i++) {
                 if (this[i] === obj) { return i; }
             }
             return -1;
        }
    }

(function($) {
	$(function() {
         $('.player').click( function(evt){
            var elm = evt.target;
            if ( $(elm).closest('#playlist').length ){
                $('#player_tracklist').fadeToggle();
            }
         });

	});
})(jQuery);	
