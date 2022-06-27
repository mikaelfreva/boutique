(self["webpackChunk"] = self["webpackChunk"] || []).push([["app"],{

/***/ "./assets/app.js":
/*!***********************!*\
  !*** ./assets/app.js ***!
  \***********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _assets_style_app_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../assets/style/app.scss */ "./assets/style/app.scss");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var bootstrap__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! bootstrap */ "./node_modules/bootstrap/dist/js/bootstrap.esm.js");
/* harmony import */ var _public_assets_js_script_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../public/assets/js/script.js */ "./public/assets/js/script.js");
/* harmony import */ var _public_assets_js_script_js__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_public_assets_js_script_js__WEBPACK_IMPORTED_MODULE_3__);
/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
// any CSS you import will output into a single css file (app.css in this case)

 // start the Stimulus application




/***/ }),

/***/ "./public/assets/js/script.js":
/*!************************************!*\
  !*** ./public/assets/js/script.js ***!
  \************************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

/* provided dependency */ var $ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");
console.log('ok');

function placeFooter() {
  if ($(document.body).height() < $(window).height()) {
    $("footer").css({
      position: "fixed",
      bottom: "0px"
    });
  } else {
    $("footer").css({
      position: ""
    });
  }
}

placeFooter();

/***/ }),

/***/ "./assets/style/app.scss":
/*!*******************************!*\
  !*** ./assets/style/app.scss ***!
  \*******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["vendors-node_modules_bootstrap_dist_js_bootstrap_esm_js-node_modules_jquery_dist_jquery_js"], () => (__webpack_exec__("./assets/app.js")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiYXBwLmpzIiwibWFwcGluZ3MiOiI7Ozs7Ozs7Ozs7Ozs7Ozs7QUFBQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFFQTtBQUNBO0NBS0E7O0FBQ0E7Ozs7Ozs7Ozs7OztBQ2RBQyxPQUFPLENBQUNDLEdBQVIsQ0FBWSxJQUFaOztBQUlBLFNBQVNDLFdBQVQsR0FBdUI7RUFDbkIsSUFBSUgsQ0FBQyxDQUFDSSxRQUFRLENBQUNDLElBQVYsQ0FBRCxDQUFpQkMsTUFBakIsS0FBNEJOLENBQUMsQ0FBQ08sTUFBRCxDQUFELENBQVVELE1BQVYsRUFBaEMsRUFBcUQ7SUFDakROLENBQUMsQ0FBQyxRQUFELENBQUQsQ0FBWVEsR0FBWixDQUFnQjtNQUFDQyxRQUFRLEVBQUUsT0FBWDtNQUFvQkMsTUFBTSxFQUFDO0lBQTNCLENBQWhCO0VBQ0gsQ0FGRCxNQUVPO0lBQ0hWLENBQUMsQ0FBQyxRQUFELENBQUQsQ0FBWVEsR0FBWixDQUFnQjtNQUFDQyxRQUFRLEVBQUU7SUFBWCxDQUFoQjtFQUNIO0FBQ0o7O0FBRUROLFdBQVc7Ozs7Ozs7Ozs7OztBQ1pYIiwic291cmNlcyI6WyJ3ZWJwYWNrOi8vLy4vYXNzZXRzL2FwcC5qcyIsIndlYnBhY2s6Ly8vLi9wdWJsaWMvYXNzZXRzL2pzL3NjcmlwdC5qcyIsIndlYnBhY2s6Ly8vLi9hc3NldHMvc3R5bGUvYXBwLnNjc3M/MzJiOCJdLCJzb3VyY2VzQ29udGVudCI6WyIvKlxuICogV2VsY29tZSB0byB5b3VyIGFwcCdzIG1haW4gSmF2YVNjcmlwdCBmaWxlIVxuICpcbiAqIFdlIHJlY29tbWVuZCBpbmNsdWRpbmcgdGhlIGJ1aWx0IHZlcnNpb24gb2YgdGhpcyBKYXZhU2NyaXB0IGZpbGVcbiAqIChhbmQgaXRzIENTUyBmaWxlKSBpbiB5b3VyIGJhc2UgbGF5b3V0IChiYXNlLmh0bWwudHdpZykuXG4gKi9cblxuLy8gYW55IENTUyB5b3UgaW1wb3J0IHdpbGwgb3V0cHV0IGludG8gYSBzaW5nbGUgY3NzIGZpbGUgKGFwcC5jc3MgaW4gdGhpcyBjYXNlKVxuaW1wb3J0ICcuLi9hc3NldHMvc3R5bGUvYXBwLnNjc3MnO1xuXG5cbmltcG9ydCAkIGZyb20gJ2pxdWVyeSc7XG5cbi8vIHN0YXJ0IHRoZSBTdGltdWx1cyBhcHBsaWNhdGlvblxuaW1wb3J0ICdib290c3RyYXAnO1xuXG5pbXBvcnQgJy9wdWJsaWMvYXNzZXRzL2pzL3NjcmlwdC5qcyc7XG4iLCJjb25zb2xlLmxvZygnb2snKTtcblxuXG4gICAgXG5mdW5jdGlvbiBwbGFjZUZvb3RlcigpIHtcbiAgICBpZiggJChkb2N1bWVudC5ib2R5KS5oZWlnaHQoKSA8ICQod2luZG93KS5oZWlnaHQoKSApIHtcbiAgICAgICAgJChcImZvb3RlclwiKS5jc3Moe3Bvc2l0aW9uOiBcImZpeGVkXCIsIGJvdHRvbTpcIjBweFwifSk7XG4gICAgfSBlbHNlIHtcbiAgICAgICAgJChcImZvb3RlclwiKS5jc3Moe3Bvc2l0aW9uOiBcIlwifSk7XG4gICAgfVxufVxuXG5wbGFjZUZvb3RlcigpOyIsIi8vIGV4dHJhY3RlZCBieSBtaW5pLWNzcy1leHRyYWN0LXBsdWdpblxuZXhwb3J0IHt9OyJdLCJuYW1lcyI6WyIkIiwiY29uc29sZSIsImxvZyIsInBsYWNlRm9vdGVyIiwiZG9jdW1lbnQiLCJib2R5IiwiaGVpZ2h0Iiwid2luZG93IiwiY3NzIiwicG9zaXRpb24iLCJib3R0b20iXSwic291cmNlUm9vdCI6IiJ9