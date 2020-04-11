/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/public.scss';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

import MenuHidden from "./component/MenuHidden";
global.MenuHidden = MenuHidden;

import Modal from "./component/Modal";
global.Modal = Modal;

import OpenMiniMenu from "./component/OpenMiniMenu";
global.OpenMiniMenu = OpenMiniMenu;

import Flash from "./component/Flash";
global.Flash = Flash;

import AddFlashMessage from "./component/AddFlashMessage";
global.AddFlashMessage = AddFlashMessage;