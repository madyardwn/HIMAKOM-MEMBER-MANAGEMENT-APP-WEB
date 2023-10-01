/*
    * This script is package/plugins from
    *
    * 
*/
import swal from 'sweetalert2';
window.Swal = swal;

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
    return $(this).attr('href') === currentUrl;
});

activeDropdownItem.addClass('active');
activeDropdownItem.parents('.dropdown-menu').addClass('show').attr('data-bs-popper', 'static');
activeDropdownItem.parents('.dropdown-menu').siblings('.dropdown-toggle').addClass('show').attr('aria-expanded', 'true');