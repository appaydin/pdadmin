import * as type from './MutationType'
import {Http} from '../Http'

export default {
  /**
   * Attempt Login
   * @param dispatch
   * @param payload
   */
  attemptLogin({dispatch}, payload) {
    return Http.post('auth/login', payload)
      .then((resp) => {
        dispatch('setUser', resp.data.profile)
        dispatch('setToken', resp.data.token)
      })
      .catch(() => {

      })
  },

  /**
   * Attempt Logout
   * @param dispatch
   * @returns {Promise.<*>}
   */
  attemptLogout({dispatch}) {
    return Promise.all([
      dispatch('setToken', null),
      dispatch('setUser', null)
    ])
  },

  /**
   * Refresh User Token & Profile Data
   * @param dispatch
   * @param state
   * @returns {*}
   */
  checkUserToken({dispatch, state}) {
    if (state.user.token) {
      return Promise.resolve(state.user.token)
    }

    // Recover Token from localStorage
    let token = localStorage.getItem('pd_token')
    if (token === 'undefined' || token === 'null') {
      return Promise.reject('NO_TOKEN')
    }

    return dispatch('setToken', token)
      .then(() => {
        dispatch('loadUserProfile')
      })
  },

  /**
   * Load User Profile Data
   * @param dispatch
   */
  loadUserProfile({dispatch}) {
    Http.get('profile')
      .then((resp) => {
        dispatch('setUser', resp.data)
      })
      .catch(() => {
        Promise.reject('FAILED_LOAD_USER')
      })
  },

  /**
   * Set User Data
   * @param commit
   * @param user
   * @returns {Promise.<T>}
   */
  setUser({commit}, user) {
    commit(type.SET_USER, user)
    return Promise.resolve(user)
  },

  /**
   * Set User Token
   * @param commit
   * @param token
   * @returns {Promise.<T>}
   */
  setToken({commit}, token){
    commit(type.SET_TOKEN, token)
    return Promise.resolve(token)
  }
}