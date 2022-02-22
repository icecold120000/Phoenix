/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/project.scss';

// start the Stimulus application
import './bootstrap';

let projectId = document.querySelector('[data-project-id]').dataset.projectId;
let projectDescrip = document.querySelector('.my-project').dataset.projectDescrip;

console.log(projectId);
console.log(projectDescrip);