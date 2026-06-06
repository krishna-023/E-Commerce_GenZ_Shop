

//Common plugins
if (document.querySelectorAll("[toast-list]"))
  document.writeln("<script src='build/libs/toastify-js/src/toastify.js'></script>");

if (document.querySelectorAll("[data-provider]"))
  document.writeln("<script src='build/libs/flatpickr/flatpickr.min.js'></script>");

if (document.querySelectorAll('[data-choices]'))
  document.writeln("<script src='build/libs/choices.js/public/assets/scripts/choices.min.js'></script>");
