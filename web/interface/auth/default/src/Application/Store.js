//import { Store as Auth } from './Auth'

/**
 * Add Module
 */
const vuex = {
  //Auth
};
const keys = Object.keys(vuex)

/**
 * Extract Vuex Modules
 */
const modules = keys.reduce((acc, key) => {
  acc[key] = vuex[key].module
  return acc
}, {})

/**
 * Extract Vuex Plugins
 */
const isFunction = function(obj) {
  return !!(obj && obj.constructor && obj.call && obj.apply);
};
const plugins = keys.reduce((acc, key) => {
  acc.push(vuex[key].plugins)
  return acc
}, []).filter(isFunction)


// Export
export default { modules, plugins }