// Pass in a selector(Class name or ID) and an attribute/property name  you want to remove
function removeAttributes(elementSelector, attributes) {
  // all the elements with that class or ID is grabbed
  const elements = document.querySelectorAll(elementSelector);
   // Loop through the elements and remove the attributes selected 
  elements.forEach((element) => {
   attributes.forEach((attribute) => {
    element.removeAttribute(attribute);
   });
  });
 }
 // removes a classname from the dom. The element stays, but the class is removed from the element. 
 function removeClass(className) {
  const elements = document.querySelectorAll(`.${className}`);
 
  elements.forEach((element) => {
   element.classList.remove(className);
  });
 }
 
 
 
// Simple Author Box Plugin 
removeAttributes('.saboxplugin-wrap', ['itemtype', 'itemscope', 'itemprop']);
 removeAttributes('.saboxplugin-wrap .vcard', ['itemprop']);
 removeAttributes('.saboxplugin-wrap .vcard .fn', ['itemprop']);
 removeAttributes('.saboxplugin-desc div', ['itemprop']);
 removeClass('hentry');
 removeClass('hcard');
 removeClass('vcard');
 removeClass('fn');

// Beaver Builder 
 removeAttributes('header, a, div, #fl-main-content, .fl-photo-img, .fl-photo, .fl-post-title, meta, span, img, nav', ['itemprop','itemscope', 'itemtype']);
 