import * as type from './MutationType'
import {setAuthToken} from '../Http'

const plugins = (store) => {
  store.subscribe((mutation, {user}) => {
    if (type.SET_TOKEN === mutation.type) {
      /**
       * Set the Axios Authorization header with the token
       */
      setAuthToken(user.token)

      /**
       * Sets the token to the local storage
       * for auto-login purpose
       */
      localStorage.setItem('pd_token', user.token)
    }
  })
}

export default {plugins}