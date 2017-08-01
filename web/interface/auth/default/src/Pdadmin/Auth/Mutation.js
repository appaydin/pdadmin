import * as type from './MutationType'

export default {
  [type.SET_TOKEN](state, value){
    state.user.token = value
  },
  [type.SET_USER](state, value) {
    state.user.profile = value
  }
}