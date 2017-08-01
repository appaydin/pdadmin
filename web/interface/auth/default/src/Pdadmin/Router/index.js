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
import Vue from 'vue'
import Router from 'vue-router';
import DynRouter from './DynRouter'
import BeforeEach from './BeforeEach'
import {Routes} from '../../Application'

Vue.use(Router);

// Router
const router = new Router({
  mode: 'history',
  routes: Routes,
});

// Add Dynamic Router
router.addRoutes([{
  path: '/*',
  component: DynRouter
}])

// Router Before Each
router.beforeEach(BeforeEach)

export default router