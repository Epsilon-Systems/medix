/**
 * @package iSq Popup
 * @version 0.1
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2019 JoomlaDevs. All Rights Reserved.
 * @author JoomlaDevs https://www.joomladevs.com
 *
 */
 function setPopupCookie(cname, cvalue, exdays) {
  var d = new Date();
 
  d.setTime(d.getTime() + (parseInt(exdays)));   
  var expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue+" "+expires + ";" + expires + ";path=/";
}

function getPopupCookie(cname) {
  var name = cname + "=";
  var ca = document.cookie.split(';');
  for(var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}