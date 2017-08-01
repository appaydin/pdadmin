import store from '../Store'

const beforeEach = (to, from, next) => {
  const auth = to.meta.requireAuth

  store.dispatch('resetMessages')
  store.dispatch('checkUserToken')
    /**
     * Authenticated
     */
    .then(() => {
      // Normally Access
      if (typeof auth === 'undefined' || auth === null) {
        return next()
      }
      // Access Denied Authenticated
      if (!auth) { return }

      next()
    })

    /**
     * Not Authenticated
     */
    .catch(() => {
      // Normally Access
      if (typeof auth === 'undefined' || auth === null || !auth) {
        return next()
      }

      next({name: 'auth.login'})
    })
};

export default beforeEach