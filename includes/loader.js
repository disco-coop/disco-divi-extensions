// External Dependencies
import $ from 'jquery';

// Internal Dependencies
import modules from './modules';
import fields from './fields';
import utils from './utils';

$(window).on('et_builder_api_ready', (event, API) => {
  API.registerModules(modules);
  API.registerModalFields(fields);
});



