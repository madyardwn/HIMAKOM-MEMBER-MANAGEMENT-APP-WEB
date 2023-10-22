/*
    * This script is package/plugins from
    *
    * 
*/
import swal from 'sweetalert2';
window.Swal = swal;

import moment from 'moment';
window.moment = moment;

import TemplateCRUD from './templateCRUD';
window.TemplateCRUD = TemplateCRUD;

/*
    * This dark mode script is taken from
    *
    * 
*/
const themeStorageKey = 'theme-storage-key'
setTheme(sessionStorage.getItem(themeStorageKey) ? sessionStorage.getItem(themeStorageKey) : 'light');
function setTheme(theme) {
    sessionStorage.setItem(themeStorageKey, theme);
    document.body.setAttribute('data-bs-theme', theme);
}
$('.hide-theme-dark').click(function (event) {
    event.preventDefault();
    setTheme('dark');
});
$('.hide-theme-light').click(function (event) {
    event.preventDefault();
    setTheme('light');
});


/*
    * This password toggle script is taken from    
    *
    * 
*/
$('.link-secondary').click(function() {
    var passwordInput = $(this).closest('.input-group').find('.type-password');
    if (passwordInput.attr('type') === 'password') {
        passwordInput.attr('type', 'text');
    } else {
        passwordInput.attr('type', 'password');
    }
    return false;
});

/*
    * Active dropdown menu script is taken from
    *
    * 
*/
const currentUrl = window.location.href;
const activeDropdownItem = $('.nav-item.dropdown a.dropdown-item').filter(function () {
    // return $(this).attr('href') === currentUrl;

    // exclude effect to sidebar active link on dropdown top-right
    const topRightLink = ['profile', 'about', 'logout'];
    const currentUrlSplit = currentUrl.split('/');
    const currentUrlLastSegment = currentUrlSplit[currentUrlSplit.length - 1];
    return $(this).attr('href') === currentUrl && !topRightLink.includes(currentUrlLastSegment);
});

activeDropdownItem.addClass('active');
activeDropdownItem.parents('.dropdown-menu').addClass('show').attr('data-bs-popper', 'static');
activeDropdownItem.parents('.dropdown-menu').siblings('.dropdown-toggle').addClass('show').attr('aria-expanded', 'true');