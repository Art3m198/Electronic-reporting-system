$(document).ready(function(){
	$('#Table').Tabledit({
		deleteButton: false,
		editButton: false,   		
		columns: {
		  identifier: [0, 'id'],                    
		  editable: [[7, 'estimation']]
		},
		hideIdentifier: false,
		url: 'live_edit.php'		
	});
});