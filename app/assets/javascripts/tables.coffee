# Included in pages that feature a sortable table
$(document).ready ->
  # Initialize the table sorter
  $('.tablesorter').tablesorter()
  # Change the cursor when mouseover on column titles
  $('.header').css('cursor', 'help')
  $('tbody').css('cursor', 'cell')
  true
