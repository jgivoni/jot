var Tasks = {
	reorder: function(taskId, dropTaskId, callback) {
		$.post('/tasks/ajax/reorder/'+taskId, {
			dropTaskId: dropTaskId
		}, callback, 'json');
	},
	initList: function() {
		$("ul.tasks").sortable({
			axis: 'y',
			update: function(event, ui) {
				var sourceTaskId = ui.item.data('taskId');
				var destinationTaskId = ui.item.next().data('taskId');
				Tasks.reorder(sourceTaskId, destinationTaskId, function(response){
					$('ul.tasks').replaceWith($(response.taskList).filter('ul.tasks'));
					Tasks.initList();
				});
			}
		});
		$("ul.tasks li a").click(function(event){
			if ( event.which == 2 || event.metaKey ) { return true; }
			event.preventDefault();
			History.pushState(null, null, $(this).attr('href'));
			return false;
		});
	}
}
$(window).bind('statechange',function(){
	var url;
	url = History.getState().url;
	$.ajax(
		url, 
		{
			success: function(response) {
				$('.col2').html(response.content);
			}
		}
	);
});
