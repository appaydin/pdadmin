const children = [
  {
    name: 'auth.login',
    path: 'login',
    component: require('./Page/Login.vue'),
    meta: {requireAuth: false}
  },
  {
    name: 'auth.register',
    path: 'register',
    component: require('./Page/Register.vue'),
    meta: {requireAuth: false}
  },
  {
    name: 'auth.forgot',
    path: 'forgot',
    component: require('./Page/Forgot.vue'),
    meta: {requireAuth: false}
  },
  {
    name: 'auth.resetting',
    path: 'resetting',
    component: require('./Page/Resetting.vue'),
    meta: {requireAuth: false}
  },
  {
    name: 'auth.logout',
    path: 'logout',
    component: require('./Page/Logout.vue'),
    meta: {requireAuth: true}
  }
]

export default [{
  children,
  name: 'auth',
  path: '/auth',
  component: require('./Page/Main.vue'),
  redirect: {name: 'auth.login'},
}]