import AuthMutation from '../Auth/Mutation'
import * as type from './Types'

/**
 * Mutations
 */
const mutation = {
  /**
   * Messages Alert & Notification
   * @param state
   * @param payload
   */
  [type.SET_MESSAGE](state, payload) {
    state.messages[payload.type].push(payload.msg)
    state.notification[payload.type].push(payload.msg)
  },
  [type.RESET_MESSAGE](state) {
    state.messages['info'] = []
    state.messages['success'] = []
    state.messages['warning'] = []
    state.messages['error'] = []
    state.messages['validation'] = []

    state.notification['info'] = []
    state.notification['success'] = []
    state.notification['warning'] = []
    state.notification['error'] = []
    state.notification['validation'] = []
  },
  [type.DELETE_MESSAGE](state, payload) {
    let elementIndex = state.messages[payload.type].indexOf(payload.msg)
    if (elementIndex > -1) {
      state.messages[payload.type].splice(elementIndex, 1)
    }
  },
  [type.DELETE_NOTIFICATION](state, payload) {
    let elementIndex = state.notification[payload.type].indexOf(payload.msg)
    if (elementIndex > -1) {
      state.notification[payload.type].splice(elementIndex, 1)
    }
  },

  /**
   * Progress Bar
   * @param state
   * @param payload
   */
  [type.SET_LOADING](state, payload) {
    state.loading = payload
  },

  /**
   * Head Editor
   * @param state
   * @param payload
   */
  [type.SET_HEAD](state, payload){
    state.head.dynamic = payload
  },
  [type.SET_HEAD_DEFAULT](state, payload){
    state.head.defaults = payload
  }
}

/**
 * Extract Auth Mutations
 */
for (var key in AuthMutation) {
  mutation[key] = AuthMutation[key]
}

export default mutation