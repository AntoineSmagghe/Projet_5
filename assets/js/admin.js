/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/admin.scss';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

import Requests from "./component/Requests";
global.Requests = Requests;

import AddField from "./component/AddField";
global.AddField = AddField;

import PopupStop from "./component/PopupStop";
global.PopupStop = PopupStop;

import MovingElt from "./component/MovingElt";
global.MovingElt = MovingElt;

import SelectRadio from "./component/SelectRadio";
global.SelectRadio = SelectRadio;