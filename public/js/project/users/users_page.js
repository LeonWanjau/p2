/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/project/users/users_page.js":
/*!**************************************************!*\
  !*** ./resources/js/project/users/users_page.js ***!
  \**************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("/*\r\nconst targetNode=document.getElementById('list');\r\n\r\nconst config={attributes:true,childList:true,subtree:true};\r\n\r\nconst callback=function(mutationsList,observer){\r\n    for(let mutation of mutationsList){\r\n        if(mutation.type==='attributes'){\r\n            //console.log('The '+mutation.attributeName+' attribute was modified');\r\n            //console.log(mutation.target.children[1].childNodes[0]);\r\n            if(mutation.target.children[1].childNodes[0].textContent==\"View Teachers\"){\r\n                console.log('view teachers affected')\r\n            }\r\n        }else if(mutation.type==='childList'){\r\n            console.log('child modified')\r\n        }\r\n    }\r\n};\r\n\r\nconst observer=new MutationObserver(callback);\r\n\r\nobserver.observe(targetNode,config);\r\n\r\nconsole.log('hello');\r\nconsole.log(targetNode);\r\n*/\n//Show and hide sidebar lists\nvar sidebar_subheadings = document.querySelectorAll('.heading--sidebar');\nsidebar_subheadings.forEach(function (subheading) {\n  subheading.addEventListener('click', function (e) {\n    if (e.target.innerText.trim() == \"Teachers\") {\n      //console.log(e.target.nextElementSibling);\n      if (e.target.nextElementSibling != null && e.target.nextElementSibling.classList.contains('mdc-list-group')) {\n        if (e.target.nextElementSibling.classList.contains('display-none')) {\n          e.target.nextElementSibling.classList.remove('display-none');\n        } else {\n          e.target.nextElementSibling.classList.add('display-none');\n        }\n      }\n    }\n  });\n}); //Edit Teacher Accounts\n\n/*\r\nvar view_teachers_table=document.querySelector('#view_teachers_table');\r\nvar view_teachers_modal=document.querySelector('#view_teachers_modal');\r\nvar view_teachers_modal_close_button=view_teachers_modal.querySelector('.mdc-icon-button');\r\n\r\nview_teachers_table.addEventListener('click',function(e){\r\n    if(e.target.tagName=='TD'){\r\n        view_teachers_modal.classList.add('display-block');\r\n\r\n        let row=e.target.parentElement;\r\n\r\n        let first_name_field=view_teachers_modal.querySelector(\"[name='f_name']\");\r\n        let first_name_label=first_name_field.nextElementSibling;\r\n        first_name_label.classList.add('mdc-floating-label--float-above');\r\n        first_name_field.value=row.children[1].innerText;\r\n        let first_name_validator=first_name_field.parentElement.nextElementSibling;\r\n        if(first_name_validator!=null){\r\n            first_name_validator.remove();\r\n        }\r\n\r\n        let second_name_field=view_teachers_modal.querySelector(\"[name='l_name']\");\r\n        let second_name_label=second_name_field.nextElementSibling;\r\n        second_name_label.classList.add('mdc-floating-label--float-above');\r\n        second_name_field.value=row.children[2].innerText;\r\n        let second_name_validator=second_name_field.parentElement.nextElementSibling;\r\n        if(second_name_validator!=null){\r\n            second_name_validator.remove();\r\n        }\r\n\r\n        let email_field=view_teachers_modal.querySelector(\"[name='email']\");\r\n        let email_label=email_field.nextElementSibling;\r\n        email_label.classList.add('mdc-floating-label--float-above');\r\n        email_field.value=row.children[3].innerText;\r\n        let email_validator=email_field.parentElement.nextElementSibling;\r\n        if(email_validator!=null){\r\n            email_validator.remove();\r\n        }\r\n\r\n        let id_field=view_teachers_modal.querySelector(\"[name='id']\");\r\n        id_field.value=row.children[0].innerText;\r\n    }\r\n})\r\n\r\nview_teachers_modal_close_button.addEventListener('click',function(e){\r\n    e.preventDefault();\r\n    view_teachers_modal.classList.remove('display-block');\r\n})\r\n*/\n\n//# sourceURL=webpack:///./resources/js/project/users/users_page.js?");

/***/ }),

/***/ 0:
/*!********************************************************!*\
  !*** multi ./resources/js/project/users/users_page.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("module.exports = __webpack_require__(/*! ./resources/js/project/users/users_page.js */\"./resources/js/project/users/users_page.js\");\n\n\n//# sourceURL=webpack:///multi_./resources/js/project/users/users_page.js?");

/***/ })

/******/ });