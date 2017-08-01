/**
 * ============
 * Vuex Store
 * ============
 *
 * The store of the application
 *
 * http://vuex.vuejs.org/en/index.html
 */
import Vue from 'vue'
import Vuex from 'vuex'

import State from './State'
import Mutation from './Mutation'
import Actions from './Actions'
import * as Getters from '../Auth/Getters'

import Modules from './Modules'
import Plugins from './Plugins'

Vue.use(Vuex)

export default new Vuex.Store({
  state     : State,
  mutations : Mutation,
  actions   : Actions,
  getters   : Getters,
  modules   : Modules,
  plugins   : Plugins,
  strict    : process.env.NODE_ENV !== 'production',
})