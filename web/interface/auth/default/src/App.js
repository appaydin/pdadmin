import { Vue, Router, Store } from './Pdadmin'
import KeenUI from 'keen-ui';

Vue.use(KeenUI);

new Vue({
  el: '#app',
  name: 'Auth',
  router: Router,
  store: Store,
  render: h => h(require('./App.vue'))
})
