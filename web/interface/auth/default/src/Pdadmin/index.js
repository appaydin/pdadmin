/**
 * ============
 * Vue
 * ============
 *
 * Vue.js is a library for building interactive web interfaces.
 * It provides data-reactive components with a simple and flexible API.
 *
 * http://rc.vuejs.org/guide/
 */
import Vue from 'vue'

Vue.config.devtools = process.env.NODE_ENV !== 'production';
Vue.config.silent   = process.env.NODE_ENV !== 'production';


/**
 * ============
 * Vue Router
 * ============
 *
 * The official Router for Vue.js. It deeply integrates with Vue.js core
 * to make building Single Page Applications with Vue.js a breeze.
 *
 * http://router.vuejs.org/en/index.html
 */
import Router from './Router'


/**
 * ============
 * Vuex Store
 * ============
 *
 * The store of the application
 *
 * http://vuex.vuejs.org/en/index.html
 */
import Store from './Store'
Store.dispatch('setHeadDefault', CONST_HEAD)

/**
 * ============
 * Axios
 * ============
 *
 * Promise based HTTP client for the browser and node.js.
 * Because Vue Resource has been retired, Axios will now been used
 * to perform AJAX-requests.
 *
 * https://github.com/mzabriskie/axios
 */
import Axios from './Http';
Vue.use(Axios, { Store, Router })


/**
 * ============
 * pdAdmin Mixins
 * ============
 */
import Global from './Mixins/Global'
Vue.use(Global)


/**
 * ============
 * pdAdmin Components
 * ============
 */
import Alert from './Components/Messages/Alert.vue'
import Notification from './Components/Messages/Notification.vue'
import Progress from './Components/Progress'

Vue.component('Alert', Alert)
Vue.component('Notification', Notification)
Vue.use(Progress, {
  transition: {
    speed: '0.3s',
    opacity: '0.2s'
  },
  thickness: '2px'
})


// Export
export { Vue, Router, Store }


