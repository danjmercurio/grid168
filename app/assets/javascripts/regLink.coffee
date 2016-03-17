window.appendRegisterLink = ->
  div = $("div[data-role='appendTo']");
  div.length == 1 or throw new Error('Too few or too many DOM elements to append to. Just pick one.')
  div = div[0]
  anchor = document.createElement 'a'
  anchor.setAttribute('href', '/users/sign_up')
  anchor.innerHTML = 'register?'

  paragraph = document.createElement 'p'
  paragraph.innerText = 'Login failed. Perhaps you need to '
  paragraph.appendChild anchor
  $(paragraph).hide();
  div.appendChild paragraph
  $(paragraph).fadeIn(500)
