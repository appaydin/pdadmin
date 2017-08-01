export default (http, store, router) => {
  http.interceptors.request.use(
    function (config) {
      /**
       * Start Loading
       */
      store.dispatch('startLoading')
      router.app.$Progress.start()
      router.app.$Progress.increase(20)

      /**
       * Remove Notification
       */
      store.dispatch('resetMessages')

      return config;
    },
    function (error) {
      return Promise.reject(error);
    }
  )

  http.interceptors.response.use(
    function (response) {
      /**
       * Alert & Notification
       */
      if (response.data.messages) {
        let keys = Object.keys(response.data.messages);
        keys.forEach(function (key) {
          store.dispatch('setMessage', {type: key, msg: response.data.messages[key]})
        })
      }

      /**
       * Redirect
       */
      if (response.data.redirect) {
        let redirect = response.data.redirect.replace(CONST_API_PREFIX, '');
        router.push({path: redirect})
      }

      /**
       * Set Head
       */
      if (response.data.head){
        store.dispatch('setHead', response.data.head)
      }

      /**
       * Stop Loading
       */
      store.dispatch('stopLoading')
      router.app.$Progress.finish()

      return response;
    },
    function (error) {
      const {response} = error
      /**
       * If token is either expired, not provided or invalid
       * then redirect to login. On server side the error
       */
      if ([401, 400].indexOf(response.status) > -1) {
        router.push({name: 'auth.login'})
      }

      /**
       * Redirect
       */
      if (response.data.redirect) {
        let redirect = response.data.redirect.replace(CONST_API_PREFIX, '');
        router.push({path: redirect})
      }

      /**
       * Error messages are sent in arrays
       */
      if (response.status != 404 || CONST_DEV_MODE) {
        if (response.data.messages.error) {
          store.dispatch('setMessage', {type: 'error', msg: response.data.messages.error})
        }
        if (response.data.messages.validation) {
          store.dispatch('setMessage', {type: 'validation', msg: response.data.messages.validation})
        }
      }

      /**
       * Stop Loading
       */
      store.dispatch('stopLoading')
      router.app.$Progress.fail()

      return Promise.reject(error)
    }
  )
}