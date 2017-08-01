import user from '../Auth/State'

export default {
  user,
  messages: {
    info: [],
    success: [],
    warning: [],
    error: [],
    validation: []
  },
  notification: {
    info: [],
    success: [],
    warning: [],
    error: [],
    validation: []
  },
  loading: false,
  head:{
    defaults:{},
    dynamic:[]
  }
}