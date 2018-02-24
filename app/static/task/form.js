"use strict";
$(function() {
	$.widget("replanner.taskForm", {
		// default options
		options: {
		},
		// the constructor
		_create: function () {
			this.element.find('.input-block.parent select').chosen();
		}
	});

	// initialize widget
	$("form.task").taskForm();
});
