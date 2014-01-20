// callback.js

var mysqlConnection;
var errorCollector;

exports.setErrorCollector = function(val) {
	errorCollector = val;
}

exports.setMysqlConnection = function(val) {
	mysqlConnection = val;
};

exports.handlerSaveCallback = function (request, reply) {
	var post = {
		app : request.payload.app ? request.payload.app : null,
		idfa : request.payload.idfa ? request.payload.idfa : null,
		andi : request.payload.andi ? request.payload.andi : null,
		apid : request.payload.apid ? request.payload.apid : null,
		network_name : request.payload.network_name ? request.payload.network_name : null,
		campaign_name : request.payload.campaign_name ? request.payload.campaign_name : null,
		ins_dt : new Date(),
		ins_process_id : 'node.js'
	};

	var query = mysqlConnection.query('INSERT INTO installation_callback SET ?', post,
		function(err, results) {
			if (err) {
				// Save the error
				errorCollector.log(request, err);

				// Close the connection with successful response and send status 503 (server error)
				var errorMsg = 'Error saving callback to database';
			    reply(errorMsg).code(503);
			}
		}
	);

	// Close the connection with successful response
    reply({ 
		status: 'OK'
   	});
};