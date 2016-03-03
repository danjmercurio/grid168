# Place all the behaviors and hooks related to the matching controller here.
# All this logic will automatically be available in application.js.
# You can use CoffeeScript in this file: http://jashkenas.github.com/coffee-script/
$ ->
	$('a[id^="link_user"]')
		.click ->
			old_text = $(this).text()
			is_hide = old_text == "Show"
			new_text = if is_hide then "Hide" else "Show"
			$(this).text(new_text)
				
			arr = this.id.split("_")
			if is_hide
				$('#user_container_' + arr[2])
					.show('blind')
			else
				$('#user_container_' + arr[2])
					.hide('blind')
				$('a[id^="user_' + arr[2] + '_link_programmer"]')
					.text('Show')
				$('div[id^="user_' + arr[2] + '_programmer_container"]')
					.hide('blind')
				
			return false
	
	$('a[id*="programmer"]')
		.click ->
			old_text = $(this).text()
			is_hide = old_text == "Show"
			new_text = if is_hide then "Hide" else "Show"
			$(this).text(new_text)
			
			arr = this.id.split("_")
			# id has format: user_1_link_programmer_1
			user_id = arr[1]
			programmer_id = arr[4]
			if is_hide
				$('#user_' + user_id + '_programmer_container_' + programmer_id)
					.show('blind')
			else
				$('#user_' + user_id + '_programmer_container_' + programmer_id)
					.hide('blind')
			return false
