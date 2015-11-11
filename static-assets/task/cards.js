var Cards = {
	reorder: function(taskId, dropTaskId, callback) {
		$.post('/tasks/ajax/reorder/' + taskId, {
			dropTaskId: dropTaskId
		}, callback, 'json');
	},
	initList: function() {
		$("div.cards").sortable({
			update: function(event, ui) {
				var sourceTaskId = ui.item.data('taskId');
				var destinationTaskId = ui.item.next().data('taskId');
				Tasks.reorder(sourceTaskId, destinationTaskId, function(response) {
					$('div.cards').replaceWith($(response.taskList).filter('div.cards'));
					Cards.initList();
				});
			}
		});
		$("div.cards .card").click(function(event) {
			var anchor = $(this).find('a.view');
			if (event.which === 2 || event.metaKey) {
				return true;
			}
			event.preventDefault();
			History.pushState({view: 'cards'}, anchor.text(), anchor.attr('href'));
			return false;
		});
	}
};

$(window).bind('statechange', function() {
	var url;
	url = History.getState().url;
	$.ajax(
			url,
			{
				success: function(response) {
					$('.col2').html(response);
				},
				error: function() {
					console.log('error');
				}
			}
	);
});

$(function() {
	$('.card h2').on('taphold', function() {
		$(this).addClass('editing');
	});
});
