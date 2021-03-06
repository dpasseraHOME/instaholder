(function($) {

	var _settings;
	// array of img elements requiring a placeholder
	var _holderArr = [];

	$.fn.instaholder = function(options) {

		var settings = $.extend({
			'doLocal'	: false // hit Instagram API and sort results locally? true - local, false - server 
		}, options);

		_settings = settings;

		// handle img elements in dom
		$('img').each(function() {
			// determine if img requires placeholder
			if($(this).attr('src') == 'instaholder') {
				// set temporary fpo style
				$(this).css('background-color','gray');
				// add element to array
				_holderArr.push($(this));
			}
		});

		if(_holderArr.length > 0) {
			getImageUrls();
		}

	};

	// TODO: ajax request for instagram image urls
	function getImageUrls() {
		console.log('# getImageUrls');
		if(_settings.doLocal) {
			// get json directly from instagram api
			// not currently functional
			getUrlsFromServer();
		} else {
			getUrlsFromServer();
		}
	}

	// TODO: request image json from server
	function getUrlsFromServer() {
		var action = 'popular';
		var params = {};

		params = {
					action: action
		};

		$.ajax({
			type	: 'POST',
			url		: 'http://www.monkeydriver.com/instaholder/php/actions.php',
			data	: params,
			dataType: 'json',
			success	: on_serverResult,
			error	: on_serverError
		});
	}

	// TODO: handle server api response
	function on_serverResult(data) {
		//console.log(data[0].url);
		//console.log(data[1].url);
		var amtToReplace = _holderArr.length;

		for(var i=0; i<amtToReplace; i++) {
			_holderArr[i].attr('src', data[i].url);
		}

		// TODO: handle situation in which there are more images to replace than unique images
	}

	// TODO: handle server api error
	function on_serverError(xhr) {
		console.log('error : ');
	}

	// TODO: handle instagram api response
	function on_apiResult(data) {
		console.log(data);
	}

}) (jQuery);