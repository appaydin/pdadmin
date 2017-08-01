import { Store as App } from '../../Application'
import { default as AuthPlugin } from '../Auth/Plugins'

/**
 * Extract Vuex Plugins
 */
const vuex = { App, AuthPlugin };
const keys = Object.keys(vuex)
const isFunction = function(obj) {
  return !!(obj && obj.constructor && obj.call && obj.apply);
};
const plugins = keys.reduce((acc, key) => {
  acc.push(vuex[key].plugins)
  return acc
}, []).filter(isFunction)

export default plugins