import Vue from 'vue'

export const getCookie = name => {
  var matches = document.cookie.match(new RegExp(
    "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
  ));
  return matches ? decodeURIComponent(matches[1]) : undefined;
}

export const select = (element) => {
  if (document.selection) {
    let range = document.body.createTextRange();
    range.moveToElementText(element);
    range.select();
  } else if (window.getSelection) {
    let range = document.createRange();
    range.selectNode(element);
    window.getSelection().addRange(range);
  }
}
