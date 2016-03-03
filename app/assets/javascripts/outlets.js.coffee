# Place all the behaviors and hooks related to the matching controller here.
# All this logic will automatically be available in application.js.
# You can use CoffeeScript in this file: http://jashkenas.github.com/coffee-script/
$ ->
	selected = $("select#outlet_outlet_type option:selected").val()
	if selected != "1"
		$('#sub_channel_container').html("")
		$('#add_link').html("")
	else
		# broadcast type
		$('#add_link').html('<a href="#">Add sub channel</a>')
		$('#add_link > a').bind('click', ->
			count = $('#sub_channel_container').children().length
			$('#count_sub_channel').val((count + 1).toString())
			render = '<div class="sub_channel">' + 
				'<div class="col1">' +
					'<label for="sub_channel_name">Name</label>' +
					'<input type="text" size="30" name="sub_channel[name_' + count + ']" style="width: 175px"/><br/>' +
				'</div>' +
				'<div class="col2">' +
					'<label for="sub_channel_type">Type</label>' +
					'<select name="sub_channel[sub_channel_type_id_' + count + ']">' +
						'<option value="1">DT1</option>' + 
						'<option value="2">DT2</option>' +
						'<option value="3">DT3</option>' +
						'<option value="4">DT4</option>' +
						'<option value="5">DT5</option>' +
					'</select>' +
				'</div>' +
				'<div class="col3">' +
					'<label for="sub_channel[subs]">Subscribers</label>' +
					'<input type="text" size="30" name="sub_channel[subs_' + count + ']" style="width: 175px"/>' +
				'</div>' +
				'<div class="action">' +
					'<a href="#" class="remove_sub_channel">Remove</a>' +
				'</div>' +
				'<div class="clr">&nbsp</div>' +
			'</div>'
			$('#sub_channel_container').append(render)
			$('.remove_sub_channel').click ->
				p = $(this).parent('div')
				p.parent('div').hide()
				p.parent('div').remove()
				return false
			return false
		)

	$('#outlet_outlet_type').change ->
		val_selected = $("select#outlet_outlet_type option:selected").val()
		if val_selected != "1"
			$('#sub_channel_container').html("")
			$('#add_link').html("")
		else
			# broadcast type
			$('#add_link').html('<a href="#">Add sub channel</a>')
			$('#add_link > a').bind('click', ->
				count = $('#sub_channel_container').children().length
				$('#count_sub_channel').val((count + 1).toString())
				render = '<div class="sub_channel">' + 
					'<div class="col1">' +
						'<label for="sub_channel_name">Name</label>' +
						'<input type="text" size="30" name="sub_channel[name_' + count + ']" style="width: 175px"/><br/>' +
					'</div>' +
					'<div class="col2">' +
						'<label for="sub_channel_type">Type</label>' +
						'<select name="sub_channel[sub_channel_type_id_' + count + ']">' +
							'<option value="1">DT1</option>' + 
							'<option value="2">DT2</option>' +
							'<option value="3">DT3</option>' +
							'<option value="4">DT4</option>' +
							'<option value="5">DT5</option>' +
						'</select>' +
					'</div>' +
					'<div class="col3">' +
						'<label for="sub_channel[subs]">Subscribers</label>' +
						'<input type="text" size="30" name="sub_channel[subs_' + count + ']" style="width: 175px"/>' +
					'</div>' +
					'<div class="action">' +
						'<a href="#" class="remove_sub_channel">Remove</a>' +
					'</div>' +
					'<div class="clr">&nbsp</div>' +
				'</div>'
				$('#sub_channel_container').append(render)
				$('.remove_sub_channel').click ->
					p = $(this).parent('div')
					p.parent('div').hide()
					p.parent('div').remove()
					return false
				return false
			)

	$('.submit_outlet').click ->
		valid = true
		$('.sub_channel input:text').each ->
			if $(this).val() == ""
				valid = false
		subs = $('input[name^="sub_channel[subs"]').val()
		subs = subs.replace(/,/g, "")
		if !isInteger(subs)
			alert "You must enter number in subscribers field."
			return false
		else
			if !valid
				alert "You must enter text in sub channel fields"
				return false
